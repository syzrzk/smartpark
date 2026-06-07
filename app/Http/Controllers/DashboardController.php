<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use App\Models\Member;
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

        /*
        |--------------------------------------------------------------------------
        | STAT CARDS
        |--------------------------------------------------------------------------
        */

        // Kendaraan sedang parkir
        $totalMasuk = Parkir::where('status', 'masuk')->count();

        // Kendaraan masuk hari ini
        $masukHariIni = Parkir::whereDate('waktu_masuk', $today)->count();

        // Motor parkir
        $motorParkir = Parkir::where('status', 'masuk')
            ->whereHas('kendaraan', fn($q) =>
                $q->where('jenis_kendaraan', 'motor'))
            ->count();

        // Mobil parkir
        $mobilParkir = Parkir::where('status', 'masuk')
            ->whereHas('kendaraan', fn($q) =>
                $q->where('jenis_kendaraan', 'mobil'))
            ->count();

        // Pendapatan hari ini
        $pendapatanHariIni = Parkir::where('status', 'keluar')
            ->whereDate('waktu_keluar', $today)
            ->sum('biaya');

        // Pendapatan bulan ini
        $pendapatanBulanIni = Parkir::where('status', 'keluar')
            ->whereMonth('waktu_keluar', $thisMonth)
            ->whereYear('waktu_keluar', $thisYear)
            ->sum('biaya');

        /*
        |--------------------------------------------------------------------------
        | MEMBER STATS
        |--------------------------------------------------------------------------
        */

        // Total member aktif
        $totalMemberAktif = Member::where('is_active', true)
            ->whereDate('expired_at', '>=', now())
            ->count();

        // Member expired
        $totalMemberExpired = Member::whereDate('expired_at', '<', now())
            ->count();

        // VIP member
        $totalVip = Member::where('tipe', 'vip')
            ->where('is_active', true)
            ->count();

        /*
        |--------------------------------------------------------------------------
        | CHART 1 - Pendapatan 30 Hari
        |--------------------------------------------------------------------------
        */

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

        $labels30 = [];
        $values30 = [];

        for ($i = 29; $i >= 0; $i--) {

            $tgl = Carbon::now()->subDays($i)->format('Y-m-d');

            $labels30[] = Carbon::now()
                ->subDays($i)
                ->format('d/m');

            $values30[] = isset($pendapatanHarian[$tgl])
                ? (int)$pendapatanHarian[$tgl]->total
                : 0;
        }

        /*
        |--------------------------------------------------------------------------
        | CHART 2 - Pendapatan Bulanan
        |--------------------------------------------------------------------------
        */

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

        $namaBulan = [
            'Jan','Feb','Mar','Apr','Mei','Jun',
            'Jul','Agu','Sep','Okt','Nov','Des'
        ];

        $labelsBulan = [];
        $valuesBulan = [];

        for ($m = 1; $m <= 12; $m++) {

            $labelsBulan[] = $namaBulan[$m - 1];

            $valuesBulan[] = isset($pendapatanBulanan[$m])
                ? (int)$pendapatanBulanan[$m]->total
                : 0;
        }

        /*
        |--------------------------------------------------------------------------
        | CHART 3 - Donut Kendaraan
        |--------------------------------------------------------------------------
        */

        $totalMotor = Parkir::whereHas('kendaraan', fn($q) =>
            $q->where('jenis_kendaraan', 'motor'))
            ->count();

        $totalMobil = Parkir::whereHas('kendaraan', fn($q) =>
            $q->where('jenis_kendaraan', 'mobil'))
            ->count();

        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI TERAKHIR
        |--------------------------------------------------------------------------
        */

        $transaksiTerakhir = Parkir::with('kendaraan')
            ->where('status', 'keluar')
            ->latest('waktu_keluar')
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(
            'totalMasuk',
            'masukHariIni',
            'motorParkir',
            'mobilParkir',
            'pendapatanHariIni',
            'pendapatanBulanIni',

            // member stats
            'totalMemberAktif',
            'totalMemberExpired',
            'totalVip',

            // charts
            'labels30',
            'values30',
            'labelsBulan',
            'valuesBulan',

            // donut
            'totalMotor',
            'totalMobil',

            // transaksi
            'transaksiTerakhir'
        ));
    }
}