@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold text-white mb-1">
                Data Member
            </h2>

            <p class="text-secondary mb-0">
                Kelola member parkir aktif dan VIP
            </p>

        </div>

        {{-- BUTTON TAMBAH --}}
        <a href="{{ route('members.create') }}"
           class="btn btn-primary px-4 py-2 shadow-sm"
           style="
                border-radius:12px;
                background:linear-gradient(135deg,#2563eb,#3b82f6);
                border:none;
           ">

            <i class="fas fa-plus-circle me-2"></i>
            Tambah Member

        </a>

    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))

    <div class="alert alert-success border-0 shadow-sm"
         style="border-radius:14px;">

        <i class="fas fa-check-circle me-2"></i>

        {{ session('success') }}

    </div>

    @endif

    {{-- CARD TABLE --}}
    <div class="card border-0 shadow-lg overflow-hidden"
         style="
            background:#1e293b;
            border-radius:22px;
         ">

        {{-- TOP BAR --}}
        <div class="px-4 py-3"
             style="
                background:linear-gradient(90deg,#0f172a,#1e293b);
                border-bottom:1px solid rgba(255,255,255,0.05);
             ">

            <div class="d-flex align-items-center justify-content-between">

                <div class="d-flex align-items-center gap-2">

                    <div style="
                        width:38px;
                        height:38px;
                        border-radius:12px;
                        background:rgba(37,99,235,0.15);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        color:#60a5fa;
                    ">

                        <i class="fas fa-id-card"></i>

                    </div>

                    <div>

                        <div class="text-white fw-semibold">
                            Member Parkir
                        </div>

                        <small class="text-secondary">
                            Total {{ $members->count() }} member
                        </small>

                    </div>

                </div>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table align-middle mb-0 text-white">

                    <thead style="background:#0f172a;">

                        <tr class="text-secondary">

                            <th class="px-4 py-3">
                                #
                            </th>

                            <th class="py-3">
                                Nama
                            </th>

                            <th class="py-3">
                                Plat Nomor
                            </th>

                            <th class="py-3">
                                Kendaraan
                            </th>

                            <th class="py-3">
                                Tipe
                            </th>

                            <th class="py-3">
                                Expired
                            </th>

                            <th class="py-3 text-center">
                                Status
                            </th>

                            <th class="py-3 text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($members as $member)

                        <tr style="border-color:rgba(255,255,255,0.05);">

                            {{-- NO --}}
                            <td class="px-4 fw-semibold text-secondary">

                                {{ $loop->iteration }}

                            </td>

                            {{-- NAMA --}}
                            <td>

                                <div class="d-flex align-items-center gap-3"
                                     style="min-width:240px;">

                                    {{-- AVATAR --}}
                                    <div style="
                                        width:42px;
                                        height:42px;
                                        border-radius:12px;
                                        background:linear-gradient(135deg,#2563eb,#3b82f6);
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        font-weight:700;
                                        color:white;
                                        font-size:18px;
                                        flex-shrink:0;
                                    ">

                                        {{ strtoupper(substr($member->nama,0,1)) }}

                                    </div>

                                    {{-- TEXT --}}
                                    <div>

                                        <div class="fw-bold"
                                             style="color:#0f172a; font-size:15px;">

                                            {{ $member->nama }}

                                        </div>

                                        <small style="color:#64748b;">

                                            Member Parkir

                                        </small>

                                    </div>

                                </div>

                            </td>

                            {{-- PLAT --}}
                            <td>

                                <span class="badge"
                                      style="
                                        background:#0f172a;
                                        color:#e2e8f0;
                                        padding:10px 14px;
                                        border-radius:10px;
                                        font-size:13px;
                                      ">

                                    {{ strtoupper($member->plat_nomor) }}

                                </span>

                            </td>

                            {{-- KENDARAAN --}}
                            <td>

                                @if($member->jenis_kendaraan == 'motor')

                                    <span class="badge bg-warning text-dark px-3 py-2">

                                        <i class="fas fa-motorcycle me-1"></i>

                                        Motor

                                    </span>

                                @else

                                    <span class="badge bg-info text-dark px-3 py-2">

                                        <i class="fas fa-car me-1"></i>

                                        Mobil

                                    </span>

                                @endif

                            </td>

                            {{-- TIPE --}}
                            <td>

                                @if($member->tipe == 'vip')

                                    <span class="badge bg-warning text-dark px-3 py-2">

                                        VIP

                                    </span>

                                @else

                                    <span class="badge bg-primary px-3 py-2">

                                        Bulanan

                                    </span>

                                @endif

                            </td>

                            {{-- EXPIRED --}}
                            <td class="text-secondary">

                                {{ \Carbon\Carbon::parse($member->expired_at)->format('d M Y') }}

                            </td>

                            {{-- STATUS --}}
                            <td class="text-center">

                                @if($member->is_active)

                                    <span class="badge bg-success px-3 py-2">

                                        Aktif

                                    </span>

                                @else

                                    <span class="badge bg-danger px-3 py-2">

                                        Expired

                                    </span>

                                @endif

                            </td>

                            {{-- AKSI --}}
                            <td>

                                <div class="d-flex justify-content-center gap-2">

                                    {{-- EDIT --}}
                                    <a href="{{ route('members.edit', $member->id) }}"
                                       class="btn btn-sm btn-warning"
                                       style="border-radius:10px;">

                                        <i class="fas fa-edit"></i>

                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('members.destroy', $member->id) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                style="border-radius:10px;"
                                                onclick="return confirm('Hapus member ini?')">

                                            <i class="fas fa-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        {{-- EMPTY --}}
                        <tr>

                            <td colspan="8"
                                class="text-center py-5">

                                <div class="mb-3">

                                    <div style="
                                        width:80px;
                                        height:80px;
                                        border-radius:24px;
                                        background:rgba(255,255,255,0.05);
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        margin:auto;
                                        color:#475569;
                                        font-size:32px;
                                    ">

                                        <i class="fas fa-users"></i>

                                    </div>

                                </div>

                                <h5 class="text-white">

                                    Belum Ada Member

                                </h5>

                                <p class="text-secondary mb-0">

                                    Tambahkan member baru untuk mulai menggunakan fitur member parkir.

                                </p>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection