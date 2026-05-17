<x-app-layout>
    <style>
        .user-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.04);
            border: 1px solid #f1f5f9;
            overflow: hidden;
            transition: background 0.3s, border-color 0.3s;
        }
        .dark .user-card { background: #1e293b; border-color: #334155; }
        
        .user-card-header {
            background: linear-gradient(to right, #ffffff, #f8fafc);
            border-bottom: 1px solid #f1f5f9;
            padding: 24px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dark .user-card-header { background: linear-gradient(to right, #1e293b, #0f172a); border-bottom-color: #334155; }

        .header-title-box {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-icon {
            width: 48px; height: 48px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 20px;
            box-shadow: 0 8px 16px rgba(37,99,235,0.25);
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
            background: linear-gradient(135deg, #10b981, #059669);
            color: white; border-radius: 10px; font-size: 13px; font-weight: 600;
            text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s; box-shadow: 0 4px 12px rgba(16,185,129,0.2);
        }
        .btn-add:hover {
            transform: translateY(-2px); box-shadow: 0 6px 16px rgba(16,185,129,0.3);
            color: white;
        }

        /* Table */
        .user-table { width: 100%; border-collapse: collapse; }
        .user-table th {
            padding: 16px 28px; background: #f8fafc; font-size: 11px;
            font-weight: 600; color: #64748b; text-transform: uppercase;
            letter-spacing: 0.8px; border-bottom: 1px solid #e2e8f0;
        }
        .dark .user-table th { background: #0f172a; color: #94a3b8; border-bottom-color: #334155; }
        .user-table td {
            padding: 16px 28px; border-bottom: 1px solid #f1f5f9;
            vertical-align: middle; transition: background 0.2s;
        }
        .dark .user-table td { border-bottom-color: #334155; }
        .user-table tr:hover td { background: #f8fafc; }
        .dark .user-table tr:hover td { background: #334155; }
        .user-table tr:last-child td { border-bottom: none; }

        /* Profile Cell */
        .profile-cell { display: flex; align-items: center; gap: 14px; }
        .avatar-box {
            position: relative; width: 44px; height: 44px; border-radius: 50%;
            border: 2px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            flex-shrink: 0;
        }
        .dark .avatar-box { border-color: #1e293b; }
        .avatar-img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        .avatar-placeholder {
            width: 100%; height: 100%; border-radius: 50%; display: flex;
            align-items: center; justify-content: center; color: white;
            font-weight: 700; font-size: 15px;
        }
        .bg-admin { background: linear-gradient(135deg, #8b5cf6, #6366f1); }
        .bg-petugas { background: linear-gradient(135deg, #3b82f6, #0ea5e9); }
        
        .status-dot {
            position: absolute; bottom: 0; right: 0; width: 12px; height: 12px;
            background: #10b981; border: 2px solid white; border-radius: 50%;
        }
        .dark .status-dot { border-color: #1e293b; }

        .user-name { font-size: 14px; font-weight: 600; color: #1e293b; }
        .dark .user-name { color: #f8fafc; }
        .user-date { font-size: 11px; color: #94a3b8; margin-top: 2px; }

        .email-cell { font-size: 13px; color: #475569; display: flex; align-items: center; gap: 8px; }
        .dark .email-cell { color: #cbd5e1; }

        /* Badges */
        .role-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 600;
        }
        .badge-admin { background: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; }
        .dark .badge-admin { background: rgba(126,34,206,0.2); color: #d8b4fe; border-color: rgba(126,34,206,0.5); }
        .badge-petugas { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
        .dark .badge-petugas { background: rgba(3,105,161,0.2); color: #7dd3fc; border-color: rgba(3,105,161,0.5); }

        /* Actions */
      .action-btns{
    display:flex;
    align-items:center;
    justify-content:flex-start;
    gap:6px;
    flex-wrap:nowrap;
    min-width:140px;
}

.action-btns .btn{
    padding:6px 10px;
    font-size:13px;
    border-radius:10px;
    white-space:nowrap;
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
  .user-table td:first-child,
.user-table th:first-child{
    width: 180px !important;
    text-align: left !important;
}

.user-table td{
    text-align:left !important;
}
    </style>

    <x-slot name="header">Manajemen Data Petugas</x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle text-green-500 text-lg"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="user-card">
                <div class="user-card-header" style="justify-content: space-between;">
                    <a href="{{ route('user.create') }}" class="btn-add">
                        <i class="fas fa-user-plus"></i> Tambah Petugas
                    </a>
                    <div class="header-title-box">
                        <div class="header-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div class="header-text">
                            <h3>Daftar Pengguna Sistem</h3>
                            <p>Kelola hak akses dan profil petugas parkir serta administrator.</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th style="text-align:left;">Tindakan</th>
                                <th style="text-align:left;">Profil Petugas</th>
                                <th style="text-align:left;">Kontak & Email</th>
                                <th style="text-align:left;">Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                            <tr>
                                <td style="width:170px; text-align:left !important;">
    <div style="
        display:flex;
        justify-content:flex-start;
        align-items:center;
        gap:10px;
        width:100%;
    ">

        <!-- Tombol Edit -->
        <a href="{{ route('user.edit', $u->id) }}"
           class="btn-icon btn-edit"
           title="Edit Data">
            <i class="fas fa-pen"></i>
        </a>

        <!-- Tombol Delete -->
        <form action="{{ route('user.destroy', $u->id) }}"
              method="POST"
              style="margin:0;"
              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="btn-icon btn-delete"
                    title="Hapus Data">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>

    </div>
</td>
                                <td>
                                    <div class="profile-cell">
                                        <div class="avatar-box">
                                            @if($u->foto)
                                                <img class="avatar-img" src="{{ Storage::url($u->foto) }}" alt="{{ $u->name }}">
                                            @else
                                                <div class="avatar-placeholder {{ $u->role == 'admin' ? 'bg-admin' : 'bg-petugas' }}">
                                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div class="status-dot"></div>
                                        </div>
                                        <div>
                                            <div class="user-name">{{ $u->name }}</div>
                                            <div class="user-date">Bergabung: {{ $u->created_at->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="email-cell">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                        {{ $u->email }}
                                    </div>
                                </td>
                                <td>
                                    @if($u->role == 'admin')
                                        <div class="role-badge badge-admin">
                                            <i class="fas fa-crown"></i> Administrator
                                        </div>
                                    @else
                                        <div class="role-badge badge-petugas">
                                            <i class="fas fa-id-badge"></i> Petugas
                                        </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                            @if($users->isEmpty())
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <div class="empty-icon"><i class="fas fa-users-slash"></i></div>
                                        <div class="empty-title">Belum Ada Data Petugas</div>
                                        <div class="empty-sub">Silakan tambahkan petugas baru untuk mulai mengelola sistem.</div>
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
