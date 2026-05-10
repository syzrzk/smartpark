<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today      = Carbon::today();
        $thisMonth  = Carbon::now()->month;
        $thisYear   = Carbon::now()->year;

        // ── STAT CARDS ──────────────────────────────────────
        // Kendaraan sedang parkir (belum keluar)
        $totalMasuk = Parkir::where('status', 'masuk')->count();

        // Kendaraan masuk HARI INI
        $masukHariIni = Parkir::whereDate('waktu_masuk', $today)->count();

        // Motor & Mobil yang sedang parkir
        $motorParkir = Parkir::where('status', 'masuk')
            ->whereHas('kendaraan', fn($q) => $q->where('jenis_kendaraan', 'motor'))->count();
        $mobilParkir = Parkir::where('status', 'masuk')
            ->whereHas('kendaraan', fn($q) => $q->where('jenis_kendaraan', 'mobil'))->count();

        // Pendapatan hari ini
        $pendapatanHariIni = Parkir::where('status', 'keluar')
            ->whereDate('waktu_keluar', $today)
            ->sum('biaya');

        // Pendapatan bulan ini
        $pendapatanBulanIni = Parkir::where('status', 'keluar')
            ->whereMonth('waktu_keluar', $thisMonth)
            ->whereYear('waktu_keluar', $thisYear)
            ->sum('biaya');

        // ── CHART 1: Pendapatan 30 hari terakhir (line) ──────
        $pendapatanHarian = Parkir::where('status', 'keluar')
            ->where('waktu_keluar', '>=', Carbon::now()->subDays(29)->startOfDay())
            ->select(
                DB::raw('DATE(waktu_keluar) as tanggal'),
                DB::raw('SUM(biaya) as total')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->keyBy('tanggal');

        // Isi 30 hari lengkap (termasuk hari tanpa transaksi = 0)
        $labels30   = [];
        $values30   = [];
        for ($i = 29; $i >= 0; $i--) {
            $tgl = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels30[] = Carbon::now()->subDays($i)->format('d/m');
            $values30[] = isset($pendapatanHarian[$tgl]) ? (int)$pendapatanHarian[$tgl]->total : 0;
        }

        // ── CHART 2: Pendapatan per bulan tahun ini (bar) ────
        $pendapatanBulanan = Parkir::where('status', 'keluar')
            ->whereYear('waktu_keluar', $thisYear)
            ->select(
                DB::raw('MONTH(waktu_keluar) as bulan'),
                DB::raw('SUM(biaya) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->keyBy('bulan');

        $namaBulan  = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $labelsBulan = [];
        $valuesBulan = [];
        for ($m = 1; $m <= 12; $m++) {
            $labelsBulan[] = $namaBulan[$m - 1];
            $valuesBulan[] = isset($pendapatanBulanan[$m]) ? (int)$pendapatanBulanan[$m]->total : 0;
        }

        // ── CHART 3: Tipe kendaraan donut (semua waktu) ──────
        $totalMotor = Parkir::whereHas('kendaraan', fn($q) => $q->where('jenis_kendaraan', 'motor'))->count();
        $totalMobil = Parkir::whereHas('kendaraan', fn($q) => $q->where('jenis_kendaraan', 'mobil'))->count();

        // ── 5 Transaksi Terakhir ──────────────────────────────
        $transaksiTerakhir = Parkir::with('kendaraan')
            ->where('status', 'keluar')
            ->latest('waktu_keluar')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalMasuk',
            'masukHariIni',
            'motorParkir',
            'mobilParkir',
            'pendapatanHariIni',
            'pendapatanBulanIni',
            'labels30',
            'values30',
            'labelsBulan',
            'valuesBulan',
            'totalMotor',
            'totalMobil',
            'transaksiTerakhir'
        ));
    }
}