<x-app-layout>
    <x-slot name="header">
        Data Kendaraan Masuk
    </x-slot>

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

    <style>
        .badge-masuk  { background: linear-gradient(135deg, #10b981, #34d399); }
        .badge-keluar { background: linear-gradient(135deg, #ef4444, #f87171); }

        .table-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            overflow: hidden;
            transition: background 0.3s, border-color 0.3s;
        }

        .dark .table-card {
            background: #1e293b;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .table-card .card-header-custom {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .dark .table-card .card-header-custom {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            border-bottom: 1px solid #334155;
        }

        .table thead th {
            background: #f8fafc;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
            padding: 12px 14px;
            text-align: center;
            white-space: nowrap;
        }
        .dark .table thead th, .dark table.dataTable thead th {
            background: #0f172a !important; 
            color: #94a3b8 !important; 
            border-bottom-color: #334155 !important;
        }

        .table tbody tr:hover {
            background: #f0f9ff;
            transition: background 0.2s;
        }
        .dark .table tbody tr:hover { background: #334155; }

        .table tbody td {
            padding: 11px 14px;
            vertical-align: middle;
            font-size: 13px;
            color: #334155;
            text-align: center;
            white-space: nowrap;
            border-color: #f1f5f9;
            background-color: transparent !important;
            box-shadow: none !important;
        }
        .dark .table tbody td, .dark table.dataTable tbody tr {
            background-color: transparent !important;
            color: #cbd5e1 !important; 
            border-color: #334155 !important;
            box-shadow: none !important;
        }

        /* Pagination DataTables Dark Mode Support */
        .dark .dataTables_wrapper .dataTables_length, .dark .dataTables_wrapper .dataTables_filter, .dark .dataTables_wrapper .dataTables_info, .dark .dataTables_wrapper .dataTables_processing, .dark .dataTables_wrapper .dataTables_paginate {
            color: #cbd5e1;
        }
        .dark .page-item.disabled .page-link { background: #1e293b; border-color: #334155; color: #64748b; }
        .dark .page-item .page-link { background: #0f172a; border-color: #334155; color: #cbd5e1; }
        .dark .page-item.active .page-link { background: #3b82f6; border-color: #3b82f6; color: white; }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        .action-btn {
          white-space: nowrap;
        }

        td:nth-child(2) {
        min-width: 220px;
        }
        .btn-detail  { background: #dbeafe; color: #1d4ed8; }
        .btn-detail:hover { background: #bfdbfe; color: #1d4ed8; }

        .btn-struk   { background: #d1fae5; color: #065f46; }
        .btn-struk:hover { background: #a7f3d0; color: #065f46; }

        .btn-hapus   { background: #fee2e2; color: #991b1b; }
        .btn-hapus:hover { background: #fecaca; color: #991b1b; }

        .text-plat { color: #1e293b; }
        .dark .text-plat { color: #f8fafc; }

        .badge-motor { background: #fef3c7; color: #92400e; }
        .dark .badge-motor { background: rgba(245, 158, 11, 0.2); color: #fef3c7; }

        .badge-mobil { background: #ede9fe; color: #5b21b6; }
        .dark .badge-mobil { background: rgba(139, 92, 246, 0.2); color: #ede9fe; }

        .text-biaya { color: #059669; }
        .dark .text-biaya { color: #10b981; }

        .dark .text-muted { color: #94a3b8 !important; }
        .dark i.text-muted { color: #cbd5e1 !important; }

        .filter-chip {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.3s, border-color 0.3s;
        }
        .dark .filter-chip {
            background: #0f172a;
            border-color: #334155;
        }

        .filter-chip input, .filter-chip select {
            background: transparent;
            border: none;
            outline: none;
            font-size: 13px;
            color: #334155;
            width: 120px;
        }
        .dark .filter-chip input, .dark .filter-chip select {
            color: #f8fafc;
        }
        .dark .filter-chip input::placeholder {
            color: #64748b;
        }
        .filter-chip select option {
            color: #334155;
        }
        .dark .filter-chip select option {
            background: #0f172a;
            color: #f8fafc;
        }

        .jenis-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            margin-right: 6px;
        }

        .icon-motor { background: #fef3c7; }
        .icon-mobil { background: #dbeafe; }

        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length {
            display: none; /* hide default search, using custom */
        }

        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            padding: 14px 20px;
        }
    </style>

    <div class="container-fluid">

        {{-- Alert Success --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Tabel Card --}}
        <div class="table-card">

            {{-- Header --}}
            <div class="card-header-custom" style="display: flex; justify-content: space-between; align-items: center;">
                <div style="flex: 1; display: flex; justify-content: flex-start;">
                    <a href="{{ route('masuk.form') }}" class="btn btn-light btn-sm fw-semibold">
                        <i class="fas fa-plus me-1"></i> Tambah Kendaraan
                    </a>
                </div>
                <div style="flex: 2; display: flex; flex-direction: column; align-items: center; text-align: center;">
                    <h5 class="text-white fw-bold mb-1"><i class="fas fa-car me-2"></i>Data Kendaraan Masuk</h5>
                    <small class="text-white opacity-75">Kelola semua data kendaraan yang terdaftar di sistem parkir</small>
                </div>
                <div style="flex: 1;"></div>
            </div>

            {{-- Filter Bar --}}
            <div class="px-4 py-3 border-bottom d-flex flex-wrap align-items-center gap-3">
                <form method="GET" action="{{ route('parkir.index') }}" id="filterForm" class="d-flex flex-wrap gap-3 align-items-center w-100">

                    {{-- Search --}}
                    <div class="filter-chip flex-grow-1" style="min-width: 200px;">
                        <i class="fas fa-search text-muted"></i>
                        <input type="text" name="search" placeholder="Cari plat nomor..."
                            value="{{ request('search') }}" class="w-100">
                    </div>

                    {{-- Filter Status --}}
                    <div class="filter-chip">
                        <i class="fas fa-filter text-muted"></i>
                        <select name="status" onchange="document.getElementById('filterForm').submit()">
                            <option value="">Semua Status</option>
                            <option value="masuk"  {{ request('status') == 'masuk'  ? 'selected' : '' }}>Masuk</option>
                            <option value="keluar" {{ request('status') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                    </div>

                    {{-- Filter Jenis --}}
                    <div class="filter-chip">
                        <i class="fas fa-motorcycle text-muted"></i>
                        <select name="jenis" onchange="document.getElementById('filterForm').submit()">
                            <option value="">Semua Jenis</option>
                            <option value="motor" {{ request('jenis') == 'motor' ? 'selected' : '' }}>Motor</option>
                            <option value="mobil" {{ request('jenis') == 'mobil' ? 'selected' : '' }}>Mobil</option>
                        </select>
                    </div>

                    {{-- Search Submit --}}
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>

                    {{-- Reset --}}
                    @if(request()->anyFilled(['search','status','jenis']))
                    <a href="{{ route('parkir.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-times me-1"></i> Reset
                    </a>
                    @endif

                </form>
            </div>

            {{-- Table --}}
            <div class="p-0">
                <table id="tabelKendaraan" class="table table-hover mb-0 w-100">
                    <thead>
                        <tr>
                            <th style="width:44px;">#</th>
                            <th style="width:160px;">Aksi</th>
                            <th>Plat Nomor</th>
                            <th>Jenis</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Durasi</th>
                            <th>Biaya</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($parkirs as $i => $p)
                        <tr>
                            <td class="text-muted fw-medium">{{ $parkirs->firstItem() + $i }}</td>
                            <td>
                               <div class="d-flex align-items-center justify-content-start gap-2 flex-nowrap">
                                    <!-- Tombol Tiket -->
                                    <a href="{{ route('tiket', $p->id) }}"
                                       class="action-btn btn-detail"
                                       title="Tiket">
                                        <i class="fas fa-eye"></i>
                                        Tiket
                                    </a>

                                    <!-- Tombol Struk -->
                                    @if($p->status == 'keluar')
                                    <a href="{{ route('struk', $p->id) }}"
                                       class="action-btn btn-struk"
                                       title="Struk">
                                        <i class="fas fa-receipt"></i>
                                        Struk
                                    </a>
                                    @endif

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('parkir.destroy', $p->id) }}"
                                          method="POST"
                                          onsubmit="return confirmHapus(this, '{{ optional($p->kendaraan)->plat_nomor }}')"
                                          class="m-0">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="action-btn btn-hapus"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-plat" style="letter-spacing:0.5px;">
                                    {{ optional($p->kendaraan)->plat_nomor ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @php $jenis = optional($p->kendaraan)->jenis_kendaraan ?? '-'; @endphp
                                @if($jenis == 'motor')
                                    <span class="badge rounded-pill badge-motor d-inline-flex align-items-center gap-1"
                                          style="font-size:11px; padding:5px 10px;">
                                        <i class="fas fa-motorcycle"></i> Motor
                                    </span>
                                @elseif($jenis == 'mobil')
                                    <span class="badge rounded-pill badge-mobil d-inline-flex align-items-center gap-1"
                                          style="font-size:11px; padding:5px 10px;">
                                        <i class="fas fa-car"></i> Mobil
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span style="font-size:12px;">
                                    <i class="far fa-clock text-muted me-1"></i>
                                    {{ $p->waktu_masuk ? \Carbon\Carbon::parse($p->waktu_masuk)->format('d/m/Y H:i') : '-' }}
                                </span>
                            </td>
                            <td>
                                <span style="font-size:12px;">
                                    @if($p->waktu_keluar)
                                        <i class="far fa-clock text-muted me-1"></i>
                                        {{ \Carbon\Carbon::parse($p->waktu_keluar)->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </span>
                            </td>
                            <td>
                                @if($p->waktu_masuk && $p->waktu_keluar)
                                    @php $durasi = max(1, ceil(\Carbon\Carbon::parse($p->waktu_masuk)->diffInMinutes($p->waktu_keluar) / 60)); @endphp
                                    <span class="badge bg-secondary rounded-pill">{{ $durasi }} jam</span>
                                @elseif($p->waktu_masuk)
                                    @php $durasi = max(1, ceil(\Carbon\Carbon::parse($p->waktu_masuk)->diffInMinutes(now()) / 60)); @endphp
                                    <span class="badge bg-warning text-dark rounded-pill">{{ $durasi }} jam</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($p->biaya)
                                    <span class="fw-semibold text-biaya">
                                        Rp {{ number_format($p->biaya, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-muted fst-italic" style="font-size:12px;">Belum bayar</span>
                                @endif
                            </td>
                            <td>
                                @if($p->status == 'masuk')
                                    <span class="badge badge-masuk text-white rounded-pill px-3 py-1">
                                        <i class="fas fa-circle me-1" style="font-size:7px;"></i> Masuk
                                    </span>
                                @else
                                    <span class="badge badge-keluar text-white rounded-pill px-3 py-1">
                                        <i class="fas fa-circle me-1" style="font-size:7px;"></i> Keluar
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center gap-2">
                                    <div style="width:56px;height:56px;border-radius:14px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;">
                                        <i class="fas fa-car-side" style="font-size:24px;color:#94a3b8;"></i>
                                    </div>
                                    <p class="text-muted mb-0 fw-semibold mt-1" style="font-size:13px;">Tidak ada data kendaraan</p>
                                    <small class="text-muted" style="font-size:11px;">Data akan muncul setelah ada kendaraan yang masuk</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($parkirs->hasPages())
            <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                <small class="text-muted">
                    Menampilkan {{ $parkirs->firstItem() }}–{{ $parkirs->lastItem() }}
                    dari <strong>{{ $parkirs->total() }}</strong> data
                </small>
                <div>
                    {{ $parkirs->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div class="modal fade" id="modalHapus" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
            <div class="modal-content border-0 rounded-4 shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3" style="width:60px;height:60px;border-radius:16px;background:#fee2e2;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                        <i class="fas fa-trash" style="font-size:24px;color:#ef4444;"></i>
                    </div>
                    <h5 class="fw-bold">Hapus Data?</h5>
                    <p class="text-muted mb-1">Kamu akan menghapus data kendaraan dengan plat</p>
                    <p class="fw-bold fs-5 mb-3" id="platToDelete">-</p>
                    <p class="text-danger small mb-4">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        Tindakan ini tidak bisa dibatalkan!
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-outline-secondary px-4 rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-danger px-4 rounded-3 fw-semibold" id="btnKonfirmasiHapus">
                            <i class="fas fa-trash me-1"></i> Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        let targetForm = null;

        function confirmHapus(form, plat) {
            targetForm = form;
            document.getElementById('platToDelete').textContent = plat || 'ini';
            const modal = new bootstrap.Modal(document.getElementById('modalHapus'));
            modal.show();
            return false;
        }

        document.getElementById('btnKonfirmasiHapus').addEventListener('click', function () {
            if (targetForm) targetForm.submit();
        });

        // Enter to submit search
        document.querySelector('input[name="search"]').addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                document.getElementById('filterForm').submit();
            }
        });
    </script>

</x-app-layout>
