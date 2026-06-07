<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use App\Models\Tarif;
use App\Models\Member;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Midtrans\Config;
use Midtrans\Snap;

class ParkirController extends Controller
{
    /**
     * =========================================================
     * TAMPILKAN DATA PARKIR
     * =========================================================
     */
    public function index(Request $request)
    {
        $query = Parkir::with('kendaraan')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis')) {
            $query->whereHas('kendaraan', function ($q) use ($request) {
                $q->where('jenis_kendaraan', $request->jenis);
            });
        }

        if ($request->filled('search')) {
            $query->whereHas('kendaraan', function ($q) use ($request) {
                $q->where('plat_nomor', 'like', '%' . $request->search . '%');
            });
        }

        $parkirs = $query->paginate(10)->withQueryString();

        return view('parkir.index', compact('parkirs'));
    }

    /**
     * =========================================================
     * HAPUS DATA
     * =========================================================
     */
    public function destroy($id)
    {
        $parkir = Parkir::findOrFail($id);

        $parkir->delete();

        return redirect()->route('parkir.index')
            ->with('success', 'Data parkir berhasil dihapus');
    }

    /**
     * =========================================================
     * HITUNG BIAYA
     * =========================================================
     */
    private function hitungBiaya($jenis, $durasi)
    {
        $jenis = strtolower(trim($jenis));

        $tarif = Tarif::whereRaw(
            'LOWER(jenis_kendaraan) = ?',
            [$jenis]
        )->first();

        if (!$tarif) {
            return 0;
        }

        if ($durasi <= $tarif->jam_awal) {
            return $tarif->tarif_awal;
        }

        return $tarif->tarif_awal +
            (($durasi - $tarif->jam_awal)
            * $tarif->harga_per_jam);
    }

    /**
     * =========================================================
     * KENDARAAN MASUK
     * =========================================================
     */
    public function masuk(Request $request)
    {
        $memberQrCode = trim($request->input('member_qr_code', ''));
        $fotoPath = null;

        if ($request->filled('foto_masuk_data')) {
            $imageData = $request->input('foto_masuk_data');
            if (str_contains($imageData, ',')) {
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
            }
            $imageData  = base64_decode($imageData);
            $folderPath = public_path('uploads/parkir');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }
            $filename  = 'masuk_' . time() . '_' . uniqid() . '.jpg';
            $fotoPath  = 'uploads/parkir/' . $filename;
            file_put_contents(public_path($fotoPath), $imageData);
        }

        $kendaraanData = [
            'jenis_kendaraan' => 'unknown',
            'plat_nomor'      => 'PENDING-' . time(),
        ];

        $parkirData = [
            'waktu_masuk'  => now(),
            'qr_code'      => uniqid(),
            'status'       => 'masuk',
            'foto_masuk'   => $fotoPath,
            'status_member' => false,
        ];

        if ($memberQrCode && str_starts_with($memberQrCode, 'MEMBER-')) {
            $memberPlat = strtoupper(trim(substr($memberQrCode, 7)));
            $member = Member::where('plat_nomor', $memberPlat)->first();

            // Sync member status based on expired_at date
            if ($member) {
                $member->syncStatus();
            }

            // Check if member is actually active
            $member = Member::where('plat_nomor', $memberPlat)
                ->whereDate('expired_at', '>=', now())
                ->where('is_active', true)
                ->first();

            if ($member) {
                $kendaraanData = [
                    'jenis_kendaraan' => $member->jenis_kendaraan,
                    'plat_nomor'      => $memberPlat,
                ];
                $parkirData['status_member'] = true;
            }
        }

        $kendaraan = Kendaraan::create($kendaraanData);

        $parkir = Parkir::create(array_merge(
            ['kendaraan_id' => $kendaraan->id],
            $parkirData
        ));

        return redirect()->route('tiket', $parkir->id);
    }

    /**
     * =========================================================
     * HALAMAN TIKET
     * =========================================================
     */
    public function tiket($id)
    {
        $parkir = Parkir::with('kendaraan')->find($id);

        if (!$parkir) {
            return "Data parkir tidak ditemukan!";
        }

        return view('parkir.tiket', compact('parkir'));
    }

    /**
     * =========================================================
     * KELUAR VIA QR
     * =========================================================
     */
    public function keluar(Request $request)
    {
        $qrCode = trim($request->qr_code);

        // Jika memindai ID Card Member, proses langsung gratis
        if (str_starts_with($qrCode, 'MEMBER-')) {
            $plat = strtoupper(substr($qrCode, 7));
            
            // Sync member status based on expired_at date
            $memberRecord = Member::where('plat_nomor', $plat)->first();
            if ($memberRecord) {
                $memberRecord->syncStatus();
            }

            $parkir = Parkir::where('status', 'masuk')
                ->whereHas('kendaraan', function ($q) use ($plat) {
                    $q->where('plat_nomor', $plat);
                })
                ->with('kendaraan')
                ->latest()
                ->first();

            if (!$parkir) {
                return redirect()->route('parkir.scan')
                    ->with('error', 'Kendaraan member tidak ditemukan atau sudah keluar');
            }

            // Proses keluar langsung untuk member
            $waktuKeluar = now();
            $durasi = max(1, ceil(Carbon::parse($parkir->waktu_masuk)->diffInMinutes($waktuKeluar) / 60));
            $parkir->waktu_keluar  = $waktuKeluar;
            $parkir->durasi_jam    = $durasi;
            $parkir->biaya         = 0;
            $parkir->status        = 'keluar';
            $parkir->status_member = true;
            $parkir->save();

            return redirect()->route('bayar.sukses', $parkir->id);
        }

        // Tiket reguler — cari parkir via QR lalu arahkan ke verifikasi
        $parkir = Parkir::where('qr_code', $qrCode)
            ->with('kendaraan')
            ->first();

        if (!$parkir) {
            return redirect()->route('parkir.scan')
                ->with('error', 'QR code tidak ditemukan');
        }

        if ($parkir->status == 'keluar') {
            return redirect()->route('parkir.scan')
                ->with('error', 'Kendaraan sudah keluar');
        }

        // Arahkan ke halaman verifikasi plat nomor
        return redirect()->route('parkir.verifikasi', $parkir->id);
    }

    /**
     * =========================================================
     * VERIFIKASI PLAT NOMOR KELUAR
     * =========================================================
     */
    public function showVerifikasi($id)
    {
        $parkir = Parkir::with('kendaraan')->findOrFail($id);

        if ($parkir->status == 'keluar') {
            return redirect()->route('parkir.scan')
                ->with('error', 'Kendaraan sudah keluar');
        }

        return view('parkir.verifikasi', compact('parkir'));
    }

    /**
     * =========================================================
     * PROSES VERIFIKASI & CHECKOUT
     * =========================================================
     */
    public function prosesVerifikasi(Request $request, $id)
    {
        $request->validate([
            'plat_nomor'      => 'required|string',
            'jenis_kendaraan' => 'required|in:motor,mobil',
        ]);

        $parkir = Parkir::with('kendaraan')->findOrFail($id);

        if ($parkir->status == 'keluar') {
            return redirect()->route('parkir.scan')
                ->with('error', 'Kendaraan sudah keluar');
        }

        $platKeluar = strtoupper(trim($request->plat_nomor));
        $jenis      = $request->jenis_kendaraan;

        // Update data kendaraan dengan plat nomor dan jenis kendaraan yang sebenarnya
        $parkir->kendaraan->update([
            'plat_nomor'      => $platKeluar,
            'jenis_kendaraan' => $jenis,
        ]);

        $waktuKeluar = now();
        $durasi = max(1, ceil(
            Carbon::parse($parkir->waktu_masuk)->diffInMinutes($waktuKeluar) / 60
        ));

        // Cek member aktif
        $member = Member::where('plat_nomor', $platKeluar)
            ->whereDate('expired_at', '>=', now())
            ->first();

        if ($member) {
            $biaya = 0;
            $parkir->status_member = true;
        } else {
            $biaya = $this->hitungBiaya($jenis, $durasi);
            $parkir->status_member = false;
        }

        $parkir->waktu_keluar = $waktuKeluar;
        $parkir->durasi_jam   = $durasi;
        $parkir->biaya        = $biaya;
        $parkir->status       = 'keluar';
        $parkir->save();

        // Jika member, langsung sukses
        if ($biaya <= 0) {
            return redirect()->route('bayar.sukses', $parkir->id);
        }

        Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized  = true;
        Config::$is3ds        = true;

        $params = [
            'transaction_details' => [
                'order_id'     => 'PARKIR-' . $parkir->id . '-' . time(),
                'gross_amount' => $biaya,
            ],
            'callbacks' => [
                'finish' => route('bayar.sukses', $parkir->id),
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('parkir.bayar', compact(
            'parkir',
            'durasi',
            'biaya',
            'member',
            'snapToken'
        ));
    }

    /**
     * =========================================================
    /**
 * =========================================================
 * KELUAR VIA PLAT
 * =========================================================
 */
public function keluarByPlat(Request $request)
{
    $plat = strtoupper(trim($request->plat_nomor));

    /*
    |--------------------------------------------------------------------------
    | VALIDASI PLAT
    |--------------------------------------------------------------------------
    */

    if (empty($plat)) {

        return redirect()->route('parkir.scan')
            ->with('error', 'Plat nomor kosong');
    }

    /*
    |--------------------------------------------------------------------------
    | CARI DATA PARKIR
    |--------------------------------------------------------------------------
    */

    $parkir = Parkir::where('status', 'masuk')

        ->whereHas('kendaraan', function ($q) use ($plat) {

            $q->where('plat_nomor', $plat);
        })

        ->with('kendaraan')

        ->latest()

        ->first();

    if (!$parkir) {

        return redirect()->route('parkir.scan')
            ->with('error', 'Kendaraan tidak ditemukan');
    }

    /*
    |--------------------------------------------------------------------------
    | HITUNG DURASI
    |--------------------------------------------------------------------------
    */

    $waktuKeluar = now();

    $durasi = max(
        1,
        ceil(
            Carbon::parse($parkir->waktu_masuk)
                ->diffInMinutes($waktuKeluar) / 60
        )
    );

    /*
    |--------------------------------------------------------------------------
    | JENIS KENDARAAN
    |--------------------------------------------------------------------------
    */

    $jenis = optional($parkir->kendaraan)
        ->jenis_kendaraan;

    if (!$jenis) {

        return redirect()->route('parkir.scan')
            ->with('error', 'Jenis kendaraan tidak ditemukan');
    }

    /*
    |--------------------------------------------------------------------------
    | CEK MEMBER
    |--------------------------------------------------------------------------
    */

    $member = Member::where('plat_nomor', $plat)

        ->whereDate('expired_at', '>=', now())

        ->first();

    /*
    |--------------------------------------------------------------------------
    | HITUNG BIAYA
    |--------------------------------------------------------------------------
    */

    if ($member) {

        // GRATIS MEMBER

        $biaya = 0;

        $parkir->status_member = true;

    } else {

        // TARIF NORMAL

        $biaya = $this->hitungBiaya($jenis, $durasi);

        $parkir->status_member = false;
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA PARKIR
    |--------------------------------------------------------------------------
    */

    $parkir->waktu_keluar = $waktuKeluar;

    $parkir->durasi_jam = $durasi;

    $parkir->biaya = $biaya;

    $parkir->status = 'keluar';

    $parkir->save();

    /*
    |--------------------------------------------------------------------------
    | JIKA MEMBER GRATIS
    |--------------------------------------------------------------------------
    */

    if ($biaya <= 0) {

        return redirect()
            ->route('bayar.sukses', $parkir->id);
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIG MIDTRANS
    |--------------------------------------------------------------------------
    */

    Config::$serverKey = env('MIDTRANS_SERVER_KEY');

    Config::$isProduction = false;

    Config::$isSanitized = true;

    Config::$is3ds = true;

    /*
    |--------------------------------------------------------------------------
    | PARAMETER MIDTRANS
    |--------------------------------------------------------------------------
    */

    $params = [

        'transaction_details' => [

            'order_id' =>
                'PARKIR-' . $parkir->id . '-' . time(),

            'gross_amount' => $biaya,
        ],

        'callbacks' => [

            'finish' =>
                route('bayar.sukses', $parkir->id)
        ]

    ];

    /*
    |--------------------------------------------------------------------------
    | GENERATE SNAP TOKEN
    |--------------------------------------------------------------------------
    */

    $snapToken = Snap::getSnapToken($params);

    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN HALAMAN PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    return view('parkir.bayar', compact(
        'parkir',
        'durasi',
        'biaya',
        'member',
        'snapToken'
    ));
}

    /**
     * =========================================================
     * BAYAR PARKIR
     * =========================================================
     */
    public function bayar($id)
    {
        $parkir = Parkir::with('kendaraan')->find($id);

        if (!$parkir) {
            return "Data tidak ditemukan";
        }

        $durasi = max(
            1,
            ceil(
                Carbon::parse($parkir->waktu_masuk)
                    ->diffInMinutes(now()) / 60
            )
        );

        $jenis = $parkir->kendaraan->jenis_kendaraan;

        if ($parkir->status_member) {

            $biaya = 0;

        } else {

            $biaya = $this->hitungBiaya($jenis, $durasi);
        }

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'PARKIR-' . $parkir->id . '-' . time(),
                'gross_amount' => $biaya,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('parkir.bayar', compact(
            'parkir',
            'durasi',
            'biaya',
            'snapToken'
        ));
    }

    /**
     * =========================================================
     * HALAMAN STRUK
     * =========================================================
     */
    public function struk($id)
    {
        $parkir = Parkir::with('kendaraan')->find($id);

        $tarif = Tarif::where(
            'jenis_kendaraan',
            $parkir->kendaraan->jenis_kendaraan
        )->first();

        return view('struk', compact('parkir', 'tarif'));
    }

    /**
     * =========================================================
     * DOWNLOAD PDF
     * =========================================================
     */
    public function downloadStruk($id)
    {
        $parkir = Parkir::with('kendaraan')->find($id);

        if (!$parkir) {
            return "Data tidak ditemukan";
        }

        $tarif = Tarif::where(
            'jenis_kendaraan',
            $parkir->kendaraan->jenis_kendaraan
        )->first();

        $durasi = 0;
        $biaya = 0;

        if ($parkir->waktu_keluar) {

            $durasi = max(
                1,
                ceil(
                    Carbon::parse($parkir->waktu_masuk)
                        ->diffInMinutes($parkir->waktu_keluar) / 60
                )
            );

            $biaya = $parkir->biaya ??
                $this->hitungBiaya(
                    $parkir->kendaraan->jenis_kendaraan,
                    $durasi
                );
        }

        $pdf = Pdf::loadView(
            'struk_pdf',
            compact('parkir', 'tarif', 'durasi', 'biaya')
        );

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header(
                'Content-Disposition',
                'attachment; filename="struk-' . $parkir->id . '.pdf"'
            );
    }

    /**
     * =========================================================
     * HALAMAN SUKSES
     * =========================================================
     */
    public function sukses($id)
    {
        $parkir = Parkir::find($id);

        return view('parkir.sukses', compact('parkir'));
    }

    /**
     * =========================================================
     * DAFTAR MEMBER
     * =========================================================
     */
    public function member(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'plat_nomor' => 'required',
            'jenis_kendaraan' => 'required',
        ]);

        $plat = strtoupper(trim($request->plat_nomor));

        $cekMember = Member::where('plat_nomor', $plat)
            ->whereDate('expired_at', '>=', now())
            ->first();

        if ($cekMember) {

            return redirect()->back()
                ->with('error', 'Kendaraan sudah menjadi member');
        }

        session([
            'member_nama' => $request->nama,
            'member_plat' => $plat,
            'member_jenis' => $request->jenis_kendaraan,
        ]);

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $hargaMember = 50000;

        $params = [
            'transaction_details' => [
                'order_id' => 'MEMBER-' . time(),
                'gross_amount' => $hargaMember,
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('member.bayar', [
            'snapToken' => $snapToken,
            'hargaMember' => $hargaMember,
            'nama' => $request->nama,
            'plat' => $plat,
            'jenis' => $request->jenis_kendaraan,
        ]);
    }

    /**
     * =========================================================
     * MEMBER SUKSES
     * =========================================================
     */
    public function memberSukses()
    {
        $nama = session('member_nama');
        $plat = session('member_plat');
        $jenis = session('member_jenis');

        Member::create([
            'nama' => $nama,
            'plat_nomor' => $plat,
            'jenis_kendaraan' => $jenis,
            'is_active' => true,
            'expired_at' => now()->addMonth(),
        ]);

        session()->forget([
            'member_nama',
            'member_plat',
            'member_jenis',
        ]);

        return redirect()->route('member.index')
            ->with('success', 'Member berhasil dibuat');
    }
}