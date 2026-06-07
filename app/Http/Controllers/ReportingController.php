<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportingController extends Controller
{
    /**
     * =========================================================
     * CONSTRUCTOR
     * =========================================================
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Unauthorized access');
            }
            return $next($request);
        });
    }

    /**
     * =========================================================
     * HALAMAN LAPORAN
     * =========================================================
     */
    public function index(Request $request)
    {
        $query = Parkir::with(['kendaraan', 'user'])->where('status', 'keluar');

        // Filter Tanggal Awal
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('waktu_masuk', '>=', $request->tanggal_awal);
        }

        // Filter Tanggal Akhir
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('waktu_masuk', '<=', $request->tanggal_akhir);
        }

        // Filter Jenis Kendaraan
        if ($request->filled('jenis_kendaraan') && $request->jenis_kendaraan !== 'semua') {
            $query->whereHas('kendaraan', function ($q) use ($request) {
                $q->where('jenis_kendaraan', $request->jenis_kendaraan);
            });
        }

        // Filter Status Member
        if ($request->filled('status_member') && $request->status_member !== 'semua') {
            if ($request->status_member === 'member') {
                $query->where('status_member', true);
            } else {
                $query->where('status_member', false);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('kendaraan', function ($q) use ($search) {
                $q->where('plat_nomor', 'like', "%$search%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'waktu_masuk');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['waktu_masuk', 'waktu_keluar', 'biaya'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        // Ambil data laporan
        $laporan = $query->paginate(15);

        // Hitung ringkasan
        $ringkasan = $this->hitungRingkasan($request);

        // User list untuk filter petugas (jika diperlukan)
        $petugas = User::where('role', 'petugas')->get();

        return view('reporting.index', compact('laporan', 'ringkasan', 'petugas'));
    }

    /**
     * =========================================================
     * HITUNG RINGKASAN DATA
     * =========================================================
     */
    private function hitungRingkasan($request)
    {
        $query = Parkir::with('kendaraan')->where('status', 'keluar');

        // Filter Tanggal Awal
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('waktu_masuk', '>=', $request->tanggal_awal);
        }

        // Filter Tanggal Akhir
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('waktu_masuk', '<=', $request->tanggal_akhir);
        }

        // Filter Jenis Kendaraan
        if ($request->filled('jenis_kendaraan') && $request->jenis_kendaraan !== 'semua') {
            $query->whereHas('kendaraan', function ($q) use ($request) {
                $q->where('jenis_kendaraan', $request->jenis_kendaraan);
            });
        }

        // Filter Status Member
        if ($request->filled('status_member') && $request->status_member !== 'semua') {
            if ($request->status_member === 'member') {
                $query->where('status_member', true);
            } else {
                $query->where('status_member', false);
            }
        }

        $data = $query->get();

        return [
            'total_kendaraan' => $data->count(),
            'total_pendapatan' => $data->sum('biaya'),
            'total_member' => $data->where('status_member', true)->count(),
            'total_non_member' => $data->where('status_member', false)->count(),
        ];
    }

    /**
     * =========================================================
     * DOWNLOAD PDF
     * =========================================================
     */
    public function downloadPdf(Request $request)
    {
        $query = Parkir::with(['kendaraan', 'user'])->where('status', 'keluar');

        // Filter Tanggal Awal
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('waktu_masuk', '>=', $request->tanggal_awal);
        }

        // Filter Tanggal Akhir
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('waktu_masuk', '<=', $request->tanggal_akhir);
        }

        // Filter Jenis Kendaraan
        if ($request->filled('jenis_kendaraan') && $request->jenis_kendaraan !== 'semua') {
            $query->whereHas('kendaraan', function ($q) use ($request) {
                $q->where('jenis_kendaraan', $request->jenis_kendaraan);
            });
        }

        // Filter Status Member
        if ($request->filled('status_member') && $request->status_member !== 'semua') {
            if ($request->status_member === 'member') {
                $query->where('status_member', true);
            } else {
                $query->where('status_member', false);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('kendaraan', function ($q) use ($search) {
                $q->where('plat_nomor', 'like', "%$search%");
            });
        }

        $laporan = $query->get();
        $ringkasan = $this->hitungRingkasan($request);
        $tanggal_cetak = Carbon::now()->format('d/m/Y H:i');
        $tanggal_awal = $request->tanggal_awal ?? '-';
        $tanggal_akhir = $request->tanggal_akhir ?? '-';

        $pdf = Pdf::loadView('reporting.pdf', compact('laporan', 'ringkasan', 'tanggal_cetak', 'tanggal_awal', 'tanggal_akhir'));
        
        return $pdf->download('Laporan-Parkir-' . Carbon::now()->format('d-m-Y-His') . '.pdf');
    }
}
