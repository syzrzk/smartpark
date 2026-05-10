<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Kendaraan;

class ParkirController extends Controller
{
    /**
     * Tampilkan daftar semua kendaraan yang masuk.
     */
    public function index(Request $request)
    {
        $query = Parkir::with('kendaraan')->latest();

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan jenis kendaraan
        if ($request->filled('jenis')) {
            $query->whereHas('kendaraan', fn($q) => $q->where('jenis_kendaraan', $request->jenis));
        }

        // Pencarian plat nomor
        if ($request->filled('search')) {
            $query->whereHas('kendaraan', fn($q) => $q->where('plat_nomor', 'like', '%'.$request->search.'%'));
        }

        $parkirs = $query->paginate(10)->withQueryString();

        return view('parkir.index', compact('parkirs'));
    }

    /**
     * Hapus data parkir.
     */
    public function destroy($id)
    {
        $parkir = Parkir::findOrFail($id);
        $parkir->delete();

        return redirect()->route('parkir.index')->with('success', 'Data parkir berhasil dihapus.');
    }

    /**
     * Hitung biaya parkir berdasarkan jenis kendaraan dan durasi.
     * Aturan:
     * Motor: 3 Jam pertama Rp3.000, selanjutnya Rp1.000/jam
     * Mobil: 3 Jam pertama Rp6.000, selanjutnya Rp2.000/jam
     */
    private function hitungBiaya($jenis, $durasi)
    {
        $jenis = strtolower($jenis);
        $tarif = Tarif::query()->where('jenis_kendaraan', $jenis)->first();

        if (!$tarif) {
            return 0; // Jika tidak ada tarif, gratis
        }

        if ($durasi <= $tarif->jam_awal) {
            return $tarif->tarif_awal;
        } else {
            return $tarif->tarif_awal + (($durasi - $tarif->jam_awal) * $tarif->harga_per_jam);
        }
    }

    public function masuk(Request $request)
    {
        $plat = strtoupper(trim($request->plat_nomor ?? ''));
        if (empty($plat)) {
            $plat = 'AUTO-' . rand(1000, 9999);
        }

        $kendaraan = Kendaraan::create([
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'plat_nomor'      => $plat,
        ]);

        $parkir = Parkir::create([
            'kendaraan_id' => $kendaraan->id,
            'waktu_masuk'  => now(),
            'qr_code'      => uniqid(),
            'status'       => 'masuk',
        ]);

        return redirect('/tiket/' . $parkir->id);
    }

    public function tiket($id)
    {
        $parkir = Parkir::find($id);

        if (!$parkir) {
            return "Data parkir tidak ditemukan!";
        }

        return view('parkir.tiket', compact('parkir'));
    }

    public function keluar(Request $request)
    {
        $parkir = Parkir::query()->where('qr_code', $request->qr_code)->first();

        if (!$parkir) {
            return redirect()->route('parkir.scan')
                ->with('error', 'QR code tidak ditemukan. Coba dengan plat nomor.');
        }

        if ($parkir->status === 'keluar') {
            return redirect()->route('parkir.scan')
                ->with('error', 'Kendaraan dengan QR ini sudah keluar sebelumnya.');
        }

        $waktuKeluar = now();
        $durasi = max(1, ceil(
            \Carbon\Carbon::parse($parkir->waktu_masuk)->diffInMinutes($waktuKeluar) / 60
        ));

        $jenis = optional($parkir->kendaraan)->jenis_kendaraan;
        if (!$jenis) {
            return redirect()->route('parkir.scan')->with('error', 'Jenis kendaraan tidak ditemukan.');
        }

        $biaya = $this->hitungBiaya($jenis, $durasi);
        return view('parkir.bayar', compact('parkir', 'durasi', 'biaya'));
    }

    /**
     * Keluar berdasarkan plat nomor (manual / upload gambar)
     */
    public function keluarByPlat(Request $request)
    {
        $plat = strtoupper(trim($request->plat_nomor));

        if (empty($plat)) {
            return redirect()->route('parkir.scan')->with('error', 'Plat nomor tidak boleh kosong.');
        }

        // Cari kendaraan yang sedang parkir (status masuk) dengan plat tersebut
        $parkir = Parkir::where('status', 'masuk')
            ->whereHas('kendaraan', fn($q) => $q->where('plat_nomor', $plat))
            ->with('kendaraan')
            ->latest()
            ->first();

        if (!$parkir) {
            return redirect()->route('parkir.scan')
                ->with('error', "Kendaraan dengan plat \"$plat\" tidak ditemukan atau sudah keluar.");
        }

        $waktuKeluar = now();
        $durasi = max(1, ceil(
            \Carbon\Carbon::parse($parkir->waktu_masuk)->diffInMinutes($waktuKeluar) / 60
        ));

        $jenis = optional($parkir->kendaraan)->jenis_kendaraan;
        if (!$jenis) {
            return redirect()->route('parkir.scan')->with('error', 'Jenis kendaraan tidak ditemukan.');
        }

        $biaya = $this->hitungBiaya($jenis, $durasi);
        return view('parkir.bayar', compact('parkir', 'durasi', 'biaya'));
    }

    public function bayar($id)
    {
        $parkir = Parkir::with('kendaraan')->find($id);

        if (!$parkir) {
            return "Data tidak ditemukan";
        }

        $waktuKeluar = now();

        // 🔥 durasi dibulatkan
        $durasi = max(1, ceil(
            \Carbon\Carbon::parse($parkir->waktu_masuk)
            ->diffInMinutes($waktuKeluar) / 60
        ));

        $jenis = $parkir->kendaraan->jenis_kendaraan;
        $biaya = $this->hitungBiaya($jenis, $durasi);

        // 🔥 SIMPAN SETELAH BAYAR
        $parkir->update([
            'waktu_keluar' => $waktuKeluar,
            'biaya' => $biaya,
            'status' => 'keluar'
        ]);

        // 🔥 KE HALAMAN SUKSES
        return redirect()->route('bayar.sukses', $parkir->id);
    }

    public function struk($id)
    {
        $parkir = Parkir::with('kendaraan')->find($id);
        $tarif = Tarif::query()->where('jenis_kendaraan', $parkir->kendaraan->jenis_kendaraan)->first();

        return view('struk', compact('parkir', 'tarif'));
    }

    public function downloadStruk($id)
    {
        $parkir = Parkir::with('kendaraan')->find($id);

        if (!$parkir) {
            return "Data tidak ditemukan";
        }

        $tarif = Tarif::query()->where('jenis_kendaraan', $parkir->kendaraan->jenis_kendaraan)->first();

        $durasi = 0;
        $biaya = 0;

        if ($parkir->waktu_keluar) {
            $durasi = max(1, ceil(
                \Carbon\Carbon::parse($parkir->waktu_masuk)
                ->diffInMinutes($parkir->waktu_keluar) / 60
            ));
            
            // Gunakan biaya yang tersimpan, atau hitung ulang jika belum ada
            $biaya = $parkir->biaya ?? $this->hitungBiaya($parkir->kendaraan->jenis_kendaraan, $durasi);
        }

        $pdf = Pdf::loadView('struk_pdf', compact('parkir','tarif','durasi','biaya'));

        return response($pdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="struk-'.$parkir->id.'.pdf"');
    }

    public function sukses($id)
    {
        $parkir = Parkir::find($id);
        return view('parkir.sukses', compact('parkir'));
    }
}