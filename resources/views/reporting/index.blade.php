<x-app-layout>
    <x-slot name="header">
        Laporan Parkir
    </x-slot>

    <style>
        .card-custom {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border: 1px solid #e5e7eb;
        }

        .dark .card-custom {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        .stat-box {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 12px;
            padding: 16px;
            border-left: 4px solid #0284c7;
        }

        .dark .stat-box {
            background: rgba(2, 132, 199, 0.1);
            border-left-color: #06b6d4;
        }

        .stat-label {
            font-size: 12px;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .dark .stat-label {
            color: #94a3b8;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #0c4a6e;
        }

        .dark .stat-value {
            color: #06b6d4;
        }

        .filter-section {
            background: white;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 24px;
            border: 1px solid #e5e7eb;
        }

        .dark .filter-section {
            background: #1e293b;
            border-color: #334155;
        }

        .table-container {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .dark .table-container {
            background: #1e293b;
            border-color: #334155;
        }

        .table-responsive-custom {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            min-width: 1100px;
        }

        .table thead th {
            background: #f8fafc;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
            padding: 14px 10px;
            text-align: center;
            white-space: nowrap;
        }

        .dark .table thead th {
            background: #0f172a;
            color: #94a3b8;
            border-bottom-color: #334155;
        }

        .table tbody td {
            padding: 12px 10px;
            vertical-align: middle;
            font-size: 13px;
            color: #334155;
            text-align: center;
            word-wrap: break-word;
            overflow-wrap: break-word;
            border-color: #f1f5f9;
        }

        .dark .table tbody td {
            color: #cbd5e1;
            border-color: #334155;
        }

        .table tbody tr:hover {
            background: #f0f9ff;
        }

        .dark .table tbody tr:hover {
            background: #334155;
        }

        .btn-export {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-export:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-filter {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-filter:hover {
            background: #059669;
        }

        .btn-reset {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-reset:hover {
            background: #4b5563;
        }

        .form-control-custom {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            background: white;
            color: #1f2937;
        }

        .dark .form-control-custom {
            background: #0f172a;
            border-color: #334155;
            color: #e2e8f0;
        }

        .badge-member {
            background: #dcfce7;
            color: #166534;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }

        .dark .badge-member {
            background: rgba(34, 197, 94, 0.2);
            color: #86efac;
        }

        .badge-non-member {
            background: #fee2e2;
            color: #991b1b;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }

        .dark .badge-non-member {
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
        }

        .badge-motor {
            background: #fef3c7;
            color: #92400e;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }

        .dark .badge-motor {
            background: rgba(245, 158, 11, 0.2);
            color: #fef3c7;
        }

        .badge-mobil {
            background: #ede9fe;
            color: #5b21b6;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }

        .dark .badge-mobil {
            background: rgba(139, 92, 246, 0.2);
            color: #ede9fe;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        @media (max-width: 768px) {
            .header-section {
                flex-direction: column;
                align-items: flex-start;
            }

            .stat-box {
                flex: 1;
                min-width: 150px;
            }
        }
    </style>

    {{-- Header dengan Deskripsi --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">📄 Laporan Parkir</h1>
        <p class="text-slate-600 dark:text-slate-400">Data transaksi parkir dan pendapatan dari sistem SmartPark</p>
    </div>

    {{-- Ringkasan Data --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="stat-box">
            <div class="stat-label">Total Kendaraan</div>
            <div class="stat-value">{{ $ringkasan['total_kendaraan'] }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value">Rp {{ number_format($ringkasan['total_pendapatan'], 0, ',', '.') }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Total Member</div>
            <div class="stat-value">{{ $ringkasan['total_member'] }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Total Non Member</div>
            <div class="stat-value">{{ $ringkasan['total_non_member'] }}</div>
        </div>
    </div>

    {{-- Filter Section --}}
    <form method="GET" action="{{ route('reporting.index') }}" class="filter-section">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            {{-- Tanggal Awal --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tanggal Awal</label>
                <input type="date" name="tanggal_awal" class="form-control-custom" value="{{ request('tanggal_awal') }}">
            </div>

            {{-- Tanggal Akhir --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" class="form-control-custom" value="{{ request('tanggal_akhir') }}">
            </div>

            {{-- Jenis Kendaraan --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Jenis Kendaraan</label>
                <select name="jenis_kendaraan" class="form-control-custom">
                    <option value="semua" {{ request('jenis_kendaraan') == 'semua' ? 'selected' : '' }}>Semua Kendaraan</option>
                    <option value="motor" {{ request('jenis_kendaraan') == 'motor' ? 'selected' : '' }}>Motor</option>
                    <option value="mobil" {{ request('jenis_kendaraan') == 'mobil' ? 'selected' : '' }}>Mobil</option>
                </select>
            </div>

            {{-- Status Member --}}
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Status Member</label>
                <select name="status_member" class="form-control-custom">
                    <option value="semua" {{ request('status_member') == 'semua' ? 'selected' : '' }}>Semua</option>
                    <option value="member" {{ request('status_member') == 'member' ? 'selected' : '' }}>Member</option>
                    <option value="non_member" {{ request('status_member') == 'non_member' ? 'selected' : '' }}>Non Member</option>
                </select>
            </div>
        </div>

        {{-- Search & Buttons --}}
        <div class="flex gap-3 flex-wrap items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Cari Plat Nomor</label>
                <input type="text" name="search" class="form-control-custom" placeholder="Contoh: B 1234 ABC" value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn-filter">
                <i class="fas fa-search"></i> Filter
            </button>
            @if(request()->anyFilled(['tanggal_awal', 'tanggal_akhir', 'jenis_kendaraan', 'status_member', 'search']))
            <a href="{{ route('reporting.index') }}" class="btn-reset">
                <i class="fas fa-times"></i> Reset
            </a>
            @endif
        </div>
    </form>

    {{-- Export Buttons --}}
    <div class="flex gap-3 mb-6 flex-wrap justify-end">
        <form method="GET" action="{{ route('reporting.download-pdf') }}" style="display: inline;">
            @foreach(request()->query() as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <button type="submit" class="btn-export">
                <i class="fas fa-file-pdf"></i> Download PDF
            </button>
        </form>
        <button onclick="window.print()" class="btn-export" style="background: #8b5cf6;">
            <i class="fas fa-print"></i> Print
        </button>
    </div>

    {{-- Tabel Laporan --}}
    <div class="table-container">
        <div class="table-responsive-custom">
            <table class="table table-hover mb-0 w-100">
                <thead>
                    <tr>
                        <th style="width:50px; min-width:50px;">#</th>
                        <th style="width:130px; min-width:130px;">Plat Nomor</th>
                        <th style="width:100px; min-width:100px;">Jenis</th>
                        <th style="width:160px; min-width:160px;">Waktu Masuk</th>
                        <th style="width:160px; min-width:160px;">Waktu Keluar</th>
                        <th style="width:90px; min-width:90px;">Durasi</th>
                        <th style="width:100px; min-width:100px;">Status</th>
                        <th style="width:130px; min-width:130px;">Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $i => $item)
                    <tr>
                        <td class="text-slate-600 dark:text-slate-400 fw-medium">{{ $laporan->firstItem() + $i }}</td>
                        <td>
                            <span class="fw-bold" style="letter-spacing:0.5px; color:#1e293b;">
                                {{ optional($item->kendaraan)->plat_nomor ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @if(optional($item->kendaraan)->jenis_kendaraan == 'motor')
                                <span class="badge-motor"><i class="fas fa-motorcycle me-1"></i>Motor</span>
                            @elseif(optional($item->kendaraan)->jenis_kendaraan == 'mobil')
                                <span class="badge-mobil"><i class="fas fa-car me-1"></i>Mobil</span>
                            @else
                                <span class="text-slate-500">-</span>
                            @endif
                        </td>
                        <td style="font-size:12px;">
                            {{ $item->waktu_masuk ? \Carbon\Carbon::parse($item->waktu_masuk)->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td style="font-size:12px;">
                            {{ $item->waktu_keluar ? \Carbon\Carbon::parse($item->waktu_keluar)->format('d/m/Y H:i') : '-' }}
                        </td>
                        <td>
                            @if($item->waktu_masuk && $item->waktu_keluar)
                                @php $durasi = max(1, ceil(\Carbon\Carbon::parse($item->waktu_masuk)->diffInMinutes($item->waktu_keluar) / 60)); @endphp
                                <span class="badge bg-secondary rounded-pill">{{ $durasi }} jam</span>
                            @else
                                <span class="text-slate-500">-</span>
                            @endif
                        </td>
                        <td>
                            @if($item->status_member)
                                <span class="badge-member">✓ Member</span>
                            @else
                                <span class="badge-non-member">Non Member</span>
                            @endif
                        </td>
                        <td class="fw-semibold" style="color:#10b981;">
                            @if($item->status_member)
                                <span style="color:#059669;"><i class="fas fa-crown me-1"></i>GRATIS</span>
                            @elseif($item->biaya)
                                Rp {{ number_format($item->biaya, 0, ',', '.') }}
                            @else
                                <span class="text-slate-500">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div style="display:flex; flex-direction:column; align-items:center; gap:12px;">
                                <div style="width:56px;height:56px;border-radius:12px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;">
                                    <i class="fas fa-folder-open" style="font-size:24px;color:#94a3b8;"></i>
                                </div>
                                <p style="font-weight:500; color:#64748b; margin:0;">Tidak ada data laporan</p>
                                <small style="color:#94a3b8;">Coba ubah filter atau tanggal untuk melihat laporan</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($laporan->hasPages())
        <div style="padding: 16px; border-top: 1px solid #e5e7eb; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
            <small style="color:#64748b;">
                Menampilkan {{ $laporan->firstItem() }}–{{ $laporan->lastItem() }} dari <strong>{{ $laporan->total() }}</strong> data
            </small>
            <div>
                {{ $laporan->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>

    {{-- Print Styles --}}
    <style media="print">
        body {
            background: white;
        }
        .filter-section, .btn-export, .stat-box {
            display: none !important;
        }
        .table-container {
            box-shadow: none;
            border: none;
        }
    </style>

</x-app-layout>
