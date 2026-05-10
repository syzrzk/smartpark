<x-app-layout>
    <x-slot name="header">Dashboard Monitoring Parkir</x-slot>

    <style>
        /* ── STAT CARDS ── */
        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 18px 20px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border: 1px solid #f1f5f9;
            transition: transform 0.2s, box-shadow 0.2s, background 0.3s, border-color 0.3s;
            position: relative;
            overflow: hidden;
        }
        .dark .stat-card {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.10);
        }
        .stat-card .icon-wrap {
            width: 44px; height: 44px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .dark .icon-wrap { opacity: 0.8; }
        .stat-card .stat-label {
            font-size: 11px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.6px; color: #94a3b8; margin-bottom: 4px;
        }
        .dark .stat-card .stat-label { color: #64748b; }
        .stat-card .stat-value {
            font-size: 26px; font-weight: 700; color: #1e293b; line-height: 1.1;
        }
        .dark .stat-card .stat-value { color: #f8fafc; }
        .stat-card .stat-sub {
            font-size: 11px; color: #94a3b8; margin-top: 4px;
        }
        .dark .stat-card .stat-sub { color: #64748b; }
        .stat-card .stat-badge {
            position: absolute; top: 14px; right: 14px;
            font-size: 10px; font-weight: 600; padding: 3px 8px;
            border-radius: 20px;
        }
        .stat-card::after {
            content: '';
            position: absolute; bottom: 0; left: 0; right: 0;
            height: 3px; border-radius: 0 0 14px 14px;
        }
        .card-blue::after   { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .card-green::after  { background: linear-gradient(90deg, #10b981, #34d399); }
        .card-amber::after  { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
        .card-purple::after { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }
        .card-rose::after   { background: linear-gradient(90deg, #ef4444, #f87171); }
        .card-teal::after   { background: linear-gradient(90deg, #0d9488, #14b8a6); }

        /* ── CHART PANELS ── */
        .chart-panel {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border: 1px solid #f1f5f9;
            height: 100%;
            transition: background 0.3s, border-color 0.3s;
        }
        .dark .chart-panel {
            background: #1e293b; border-color: #334155;
        }
        .chart-panel .panel-title {
            font-size: 13px; font-weight: 700; color: #1e293b;
            margin-bottom: 4px; display: flex; align-items: center; gap: 8px;
        }
        .dark .chart-panel .panel-title { color: #f8fafc; }
        .chart-panel .panel-sub {
            font-size: 11px; color: #94a3b8; margin-bottom: 16px;
        }

        /* ── RECENT TABLE ── */
        .recent-panel {
            background: white;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border: 1px solid #f1f5f9;
            overflow: hidden;
            transition: background 0.3s, border-color 0.3s;
        }
        .dark .recent-panel { background: #1e293b; border-color: #334155; }
        .recent-panel .panel-header {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            display: flex; align-items: center; justify-content: space-between;
        }
        .dark .recent-panel .panel-header { border-bottom-color: #334155; }
        .dark .recent-panel .panel-header h6 { color: #f8fafc !important; }
        .recent-table td, .recent-table th {
            padding: 10px 16px; font-size: 12px; vertical-align: middle;
            color: #334155;
        }
        .dark .recent-table td { color: #cbd5e1; }
        .recent-table th {
            background: #f8fafc; font-weight: 600; color: #64748b;
            text-transform: uppercase; letter-spacing: 0.5px; font-size: 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        .dark .recent-table th { background: #0f172a; border-bottom-color: #334155; color: #94a3b8; }
        .recent-table tr:hover td { background: #f8fafc; }
        .dark .recent-table tr:hover td { background: #334155; }
        .dark .recent-table td { border-bottom: 1px solid #334155; }

        /* ── MONTH SELECTOR ── */
        .month-selector {
            background: #f1f5f9; border: none; border-radius: 8px;
            padding: 5px 10px; font-size: 12px; color: #475569;
            cursor: pointer; outline: none;
        }
        .dark .month-selector { background: #334155; color: #cbd5e1; }
    </style>

    <div class="container-fluid">

        {{-- ═══════ ROW 1: STAT CARDS ═══════ --}}
        <div class="row g-3 mb-4">

            {{-- Sedang Parkir --}}
            <div class="col-xl-2 col-md-4 col-6">
                <div class="stat-card card-blue">
                    <div class="stat-badge bg-blue-100 text-blue-600">Live</div>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="icon-wrap" style="background:#eff6ff;">
                            <i class="fas fa-parking" style="color:#3b82f6;"></i>
                        </div>
                    </div>
                    <div class="stat-label">Sedang Parkir</div>
                    <div class="stat-value" id="totalMasuk">{{ $totalMasuk }}</div>
                    <div class="stat-sub">kendaraan aktif</div>
                </div>
            </div>

            {{-- Masuk Hari Ini --}}
            <div class="col-xl-2 col-md-4 col-6">
                <div class="stat-card card-teal">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="icon-wrap" style="background:#f0fdfa;">
                            <i class="fas fa-sign-in-alt" style="color:#0d9488;"></i>
                        </div>
                    </div>
                    <div class="stat-label">Masuk Hari Ini</div>
                    <div class="stat-value">{{ $masukHariIni }}</div>
                    <div class="stat-sub">{{ now()->format('d M Y') }}</div>
                </div>
            </div>

            {{-- Motor Parkir --}}
            <div class="col-xl-2 col-md-4 col-6">
                <div class="stat-card card-amber">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="icon-wrap" style="background:#fffbeb;">
                            <i class="fas fa-motorcycle" style="color:#f59e0b;"></i>
                        </div>
                    </div>
                    <div class="stat-label">Motor Aktif</div>
                    <div class="stat-value" id="motorParkir">{{ $motorParkir }}</div>
                    <div class="stat-sub">dari {{ $totalMotor }} total</div>
                </div>
            </div>

            {{-- Mobil Parkir --}}
            <div class="col-xl-2 col-md-4 col-6">
                <div class="stat-card card-purple">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="icon-wrap" style="background:#f5f3ff;">
                            <i class="fas fa-car" style="color:#8b5cf6;"></i>
                        </div>
                    </div>
                    <div class="stat-label">Mobil Aktif</div>
                    <div class="stat-value" id="mobilParkir">{{ $mobilParkir }}</div>
                    <div class="stat-sub">dari {{ $totalMobil }} total</div>
                </div>
            </div>

            {{-- Pendapatan Hari Ini --}}
            <div class="col-xl-2 col-md-4 col-6">
                <div class="stat-card card-green">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="icon-wrap" style="background:#f0fdf4;">
                            <i class="fas fa-money-bill-wave" style="color:#10b981;"></i>
                        </div>
                    </div>
                    <div class="stat-label">Pendapatan Hari Ini</div>
                    <div class="stat-value" id="pendapatanHariIni" style="font-size:18px;">
                        Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
                    </div>
                    <div class="stat-sub">sudah terbayar</div>
                </div>
            </div>

            {{-- Pendapatan Bulan Ini --}}
            <div class="col-xl-2 col-md-4 col-6">
                <div class="stat-card card-rose">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="icon-wrap" style="background:#fff1f2;">
                            <i class="fas fa-chart-line" style="color:#ef4444;"></i>
                        </div>
                    </div>
                    <div class="stat-label">Pendapatan Bulan Ini</div>
                    <div class="stat-value" style="font-size:18px;">
                        Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                    </div>
                    <div class="stat-sub">{{ now()->format('F Y') }}</div>
                </div>
            </div>

        </div>

        {{-- ═══════ ROW 2: CHART LINE + DONUT ═══════ --}}
        <div class="row g-3 mb-4">

            {{-- Line Chart: Pendapatan 30 Hari --}}
            <div class="col-xl-8 col-md-7">
                <div class="chart-panel">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="panel-title">
                                <i class="fas fa-chart-area" style="color:#3b82f6; font-size:14px;"></i>
                                Pendapatan 30 Hari Terakhir
                            </div>
                            <div class="panel-sub">Tren pendapatan harian — auto refresh setiap 5 menit</div>
                        </div>
                    </div>
                    <canvas id="chartHarian" height="100"></canvas>
                </div>
            </div>

            {{-- Donut: Tipe Kendaraan --}}
            <div class="col-xl-4 col-md-5">
                <div class="chart-panel">
                    <div class="panel-title">
                        <i class="fas fa-chart-pie" style="color:#8b5cf6; font-size:14px;"></i>
                        Komposisi Kendaraan
                    </div>
                    <div class="panel-sub">Distribusi motor vs mobil (semua waktu)</div>
                    <div style="position:relative; max-height:220px;">
                        <canvas id="chartDonut"></canvas>
                    </div>
                    <div class="d-flex justify-content-center gap-4 mt-3">
                        <div class="text-center">
                            <div class="fw-bold" style="color:#f59e0b; font-size:18px;">{{ $totalMotor }}</div>
                            <div style="font-size:11px; color:#94a3b8;">Motor</div>
                        </div>
                        <div style="width:1px; background:#f1f5f9;"></div>
                        <div class="text-center">
                            <div class="fw-bold" style="color:#8b5cf6; font-size:18px;">{{ $totalMobil }}</div>
                            <div style="font-size:11px; color:#94a3b8;">Mobil</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ═══════ ROW 3: BAR CHART + RECENT TABLE ═══════ --}}
        <div class="row g-3">

            {{-- Bar Chart: Pendapatan Bulanan --}}
            <div class="col-xl-7 col-md-6">
                <div class="chart-panel">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <div>
                            <div class="panel-title">
                                <i class="fas fa-chart-bar" style="color:#10b981; font-size:14px;"></i>
                                Pendapatan Bulanan {{ now()->year }}
                            </div>
                            <div class="panel-sub">Total pendapatan per bulan tahun ini</div>
                        </div>
                    </div>
                    <canvas id="chartBulanan" height="110"></canvas>
                </div>
            </div>

            {{-- Recent Transactions --}}
            <div class="col-xl-5 col-md-6">
                <div class="recent-panel" style="height:100%;">
                    <div class="panel-header">
                        <div>
                            <div style="font-size:13px; font-weight:700; color:#1e293b;">Transaksi Terakhir</div>
                            <div style="font-size:11px; color:#94a3b8;">5 pembayaran terbaru</div>
                        </div>
                        <a href="{{ route('parkir.index') }}" style="font-size:12px; color:#3b82f6; text-decoration:none; font-weight:600;">
                            Lihat semua
                        </a>
                    </div>
                    <table class="table recent-table mb-0">
                        <thead>
                            <tr>
                                <th>Plat</th>
                                <th>Jenis</th>
                                <th>Durasi</th>
                                <th>Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksiTerakhir as $t)
                            <tr>
                                <td class="fw-semibold" style="color:#1e293b;">
                                    {{ optional($t->kendaraan)->plat_nomor ?? '-' }}
                                </td>
                                <td>
                                    @if(optional($t->kendaraan)->jenis_kendaraan == 'motor')
                                        <span class="badge rounded-pill" style="background:#fef3c7; color:#92400e; font-size:10px;">Motor</span>
                                    @else
                                        <span class="badge rounded-pill" style="background:#ede9fe; color:#5b21b6; font-size:10px;">Mobil</span>
                                    @endif
                                </td>
                                <td style="color:#64748b;">
                                    @if($t->waktu_masuk && $t->waktu_keluar)
                                        {{ max(1, ceil(\Carbon\Carbon::parse($t->waktu_masuk)->diffInMinutes($t->waktu_keluar)/60)) }} jam
                                    @else - @endif
                                </td>
                                <td class="fw-semibold" style="color:#10b981;">
                                    Rp {{ number_format($t->biaya, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4" style="color:#94a3b8; font-size:12px;">
                                    Belum ada transaksi
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    {{-- ═══════ CHART.JS ═══════ --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
    Chart.defaults.font.family = "'Inter', 'Segoe UI', sans-serif";
    Chart.defaults.color = '#94a3b8';

    // ── 1. LINE: Pendapatan 30 Hari ─────────────────────────
    const labels30  = {!! json_encode($labels30) !!};
    const values30  = {!! json_encode($values30) !!};

    new Chart(document.getElementById('chartHarian'), {
        type: 'line',
        data: {
            labels: labels30,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: values30,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59,130,246,0.08)',
                borderWidth: 2.5,
                pointRadius: 3,
                pointBackgroundColor: '#3b82f6',
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + parseInt(ctx.raw).toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { maxTicksLimit: 10, font: { size: 10 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { size: 10 },
                        callback: v => 'Rp ' + (v/1000).toFixed(0) + 'K'
                    }
                }
            }
        }
    });

    // ── 2. DONUT: Tipe Kendaraan ────────────────────────────
    new Chart(document.getElementById('chartDonut'), {
        type: 'doughnut',
        data: {
            labels: ['Motor', 'Mobil'],
            datasets: [{
                data: [{{ $totalMotor }}, {{ $totalMobil }}],
                backgroundColor: ['#f59e0b', '#8b5cf6'],
                borderWidth: 0,
                hoverOffset: 8,
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 12, padding: 16, font: { size: 11 } }
                }
            }
        }
    });

    // ── 3. BAR: Pendapatan Bulanan ──────────────────────────
    const labelsBulan  = {!! json_encode($labelsBulan) !!};
    const valuesBulan  = {!! json_encode($valuesBulan) !!};
    const currentMonth = {{ now()->month }};

    new Chart(document.getElementById('chartBulanan'), {
        type: 'bar',
        data: {
            labels: labelsBulan,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: valuesBulan,
                backgroundColor: labelsBulan.map((_, i) =>
                    i + 1 === currentMonth ? '#10b981' : 'rgba(16,185,129,0.25)'
                ),
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => 'Rp ' + parseInt(ctx.raw).toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { size: 10 },
                        callback: v => 'Rp ' + (v/1000).toFixed(0) + 'K'
                    }
                }
            }
        }
    });

    // ── AUTO REFRESH (live cards tiap 10 detik) ─────────────
    function refreshLive() {
        fetch('/api/dashboard')
            .then(r => r.json())
            .then(data => {
                document.getElementById('totalMasuk').textContent   = data.totalKendaraan;
                document.getElementById('motorParkir').textContent  = data.motor;
                document.getElementById('mobilParkir').textContent  = data.mobil;
                document.getElementById('pendapatanHariIni').textContent =
                    'Rp ' + parseInt(data.totalPendapatan).toLocaleString('id-ID');
            })
            .catch(() => {});
    }
    setInterval(refreshLive, 10000);
    </script>

</x-app-layout>