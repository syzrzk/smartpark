<x-app-layout>
    <style>
        .tarif-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.04);
            border: 1px solid #f1f5f9;
            overflow: hidden;
            transition: background 0.3s, border-color 0.3s;
        }
        .dark .tarif-card { background: #1e293b; border-color: #334155; }
        
        .tarif-card-header {
            background: linear-gradient(to right, #ffffff, #f8fafc);
            border-bottom: 1px solid #f1f5f9;
            padding: 24px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.3s, border-color 0.3s;
        }
        .dark .tarif-card-header { background: linear-gradient(to right, #1e293b, #0f172a); border-bottom-color: #334155; }

        .header-title-box {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 20px;
            box-shadow: 0 8px 16px rgba(245,158,11,0.25);
        }

        .header-text h3 {
            font-size: 18px; font-weight: 700; color: #1e293b; margin: 0;
            letter-spacing: -0.3px;
        }
        .dark .header-text h3 { color: #f8fafc; }
        .header-text p {
            font-size: 12px; color: #64748b; margin: 2px 0 0 0;
        }

        .btn-add {
            padding: 10px 20px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white; border-radius: 10px; font-size: 13px; font-weight: 600;
            text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s; box-shadow: 0 4px 12px rgba(59,130,246,0.2);
        }
        .btn-add:hover {
            transform: translateY(-2px); box-shadow: 0 6px 16px rgba(59,130,246,0.3);
            color: white;
        }

        /* Table */
        .tarif-table { width: 100%; border-collapse: collapse; }
        .tarif-table th {
            padding: 16px 28px; background: #f8fafc; font-size: 11px;
            font-weight: 600; color: #64748b; text-transform: uppercase;
            letter-spacing: 0.8px; border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }
        .dark .tarif-table th { background: #0f172a; color: #94a3b8; border-bottom-color: #334155; }
        .tarif-table td {
            padding: 16px 28px; border-bottom: 1px solid #f1f5f9;
            vertical-align: middle; transition: background 0.2s;
            font-size: 14px; color: #334155;
        }
        .dark .tarif-table td { border-bottom-color: #334155; color: #cbd5e1; }
        .tarif-table tr:hover td { background: #f8fafc; }
        .dark .tarif-table tr:hover td { background: #334155; }
        .tarif-table tr:last-child td { border-bottom: none; }

        /* Vehicle Badge */
        .vehicle-badge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 6px 14px; border-radius: 20px; font-weight: 600; font-size: 13px;
        }
        .badge-motor { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
        .dark .badge-motor { background: rgba(217,119,6,0.15); color: #fbbf24; border-color: rgba(217,119,6,0.4); }
        .badge-mobil { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .dark .badge-mobil { background: rgba(37,99,235,0.15); color: #60a5fa; border-color: rgba(37,99,235,0.4); }

        .price-text { font-size: 15px; font-weight: 700; color: #10b981; }
        .dark .price-text { color: #34d399; }
        .price-sub { font-size: 12px; color: #64748b; font-weight: 500; }

        /* Actions */
        .action-btns { 
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 10px;
    flex-wrap: nowrap;
}
        .btn-icon {
            width: 34px; height: 34px; border-radius: 10px; display: flex;
            align-items: center; justify-content: center; font-size: 13px;
            transition: all 0.2s; border: none; cursor: pointer;
        }
        .btn-edit { background: #eff6ff; color: #3b82f6; text-decoration: none; }
        .dark .btn-edit { background: rgba(59,130,246,0.1); color: #60a5fa; }
        .btn-edit:hover { background: #dbeafe; color: #2563eb; transform: translateY(-1px); }
        .dark .btn-edit:hover { background: rgba(59,130,246,0.2); color: #93c5fd; }
        
        .btn-delete { background: #fef2f2; color: #ef4444; }
        .dark .btn-delete { background: rgba(239,68,68,0.1); color: #f87171; }
        .btn-delete:hover { background: #fee2e2; color: #dc2626; transform: translateY(-1px); }
        .dark .btn-delete:hover { background: rgba(239,68,68,0.2); color: #fca5a5; }

        /* Alert */
        .alert-success {
            background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 12px;
            padding: 14px 20px; color: #065f46; font-size: 13px; font-weight: 500;
            display: flex; align-items: center; gap: 10px; margin-bottom: 24px;
        }
        .dark .alert-success { background: rgba(16,185,129,0.1); border-color: rgba(16,185,129,0.2); color: #34d399; }

        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-icon { font-size: 48px; color: #cbd5e1; margin-bottom: 16px; }
        .dark .empty-icon { color: #475569; }
        .empty-title { font-size: 16px; font-weight: 600; color: #475569; margin-bottom: 4px; }
        .dark .empty-title { color: #cbd5e1; }
        .empty-sub { font-size: 13px; color: #94a3b8; }
    </style>

    <x-slot name="header">Manajemen Tarif Parkir</x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="tarif-card">
                <div class="tarif-card-header" style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="flex: 1; display: flex; justify-content: flex-start;">
                        <a href="{{ route('tarif.create') }}" class="btn-add">
                            <i class="fas fa-plus"></i> Tambah Tarif
                        </a>
                    </div>
                    <div class="header-title-box" style="flex: 2; justify-content: center; text-align: left;">
                        <div class="header-icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="header-text">
                            <h3>Pengaturan Tarif Berdasarkan Kendaraan</h3>
                            <p>Kelola tarif awal dan tarif per jam untuk setiap jenis kendaraan.</p>
                        </div>
                    </div>
                    <div style="flex: 1;"></div>
                </div>

                <div class="overflow-x-auto">
                    <table class="tarif-table">
                        <thead>
                            <tr>
                                <th style="text-align:left;">Tindakan</th>
                                <th>Jenis Kendaraan</th>
                                <th>Tarif Dasar</th>
                                <th>Tarif Tambahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tarifs as $t)
                            <tr>
                                <td style="text-align:left;">
    <div class="action-btns">

        <!-- Tombol Edit -->
        <a href="{{ route('tarif.edit', $t->id) }}"
           class="btn-icon btn-edit"
           title="Edit Tarif">
            <i class="fas fa-pen"></i>
        </a>

        <!-- Tombol Delete -->
        <form action="{{ route('tarif.destroy', $t->id) }}"
              method="POST"
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus tarif ini secara permanen?')"
              class="m-0">
            @csrf
            @method('DELETE')

            <button type="submit"
                    class="btn-icon btn-delete"
                    title="Hapus Tarif">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>

    </div>
</td>
                                <td>
                                    @if(strtolower($t->jenis_kendaraan) == 'motor')
                                        <div class="vehicle-badge badge-motor">
                                            <i class="fas fa-motorcycle"></i> Motor
                                        </div>
                                    @else
                                        <div class="vehicle-badge badge-mobil">
                                            <i class="fas fa-car"></i> Mobil
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="price-text">Rp {{ number_format($t->tarif_awal, 0, ',', '.') }}</div>
                                    <div class="price-sub">Untuk {{ $t->jam_awal }} Jam Pertama</div>
                                </td>
                                <td>
                                    <div class="price-text" style="color:#3b82f6;">+ Rp {{ number_format($t->harga_per_jam, 0, ',', '.') }}</div>
                                    <div class="price-sub">Per Jam Berikutnya</div>
                                </td>
                            </tr>
                            @endforeach

                            @if($tarifs->isEmpty())
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <div class="empty-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                                        <div class="empty-title">Belum Ada Pengaturan Tarif</div>
                                        <div class="empty-sub">Silakan tambahkan data tarif baru agar sistem dapat menghitung biaya parkir.</div>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
