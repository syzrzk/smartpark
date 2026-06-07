@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 page-wrapper-custom">
    
    {{-- HEADER --}}
    <div class="d-flex flex-column align-items-start mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-slate-800 dark:text-white mb-1">
                Data Member
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mb-0">
                Kelola member parkir aktif dan VIP
            </p>
        </div>

        {{-- BUTTON TAMBAH DI SEBELAH KIRI --}}
        <a href="{{ route('members.create') }}"
           class="btn btn-primary px-4 py-2.5 shadow-sm btn-add-member"
           style="
                border-radius:12px;
                background:linear-gradient(135deg,#2563eb,#3b82f6);
                border:none;
                font-weight: 600;
                transition: all 0.2s;
           ">
            <i class="fas fa-plus-circle me-2"></i>
            Tambah Member
        </a>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm d-flex align-items-center"
         style="border-radius:14px; background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.25);">
        <i class="fas fa-check-circle me-2 fs-5"></i>
        <div>{{ session('success') }}</div>
    </div>
    @endif

    {{-- CARD TABLE --}}
    <div class="card border-0 shadow-lg overflow-hidden card-table-custom"
         style="
            background:#1e293b;
            border-radius:22px;
         ">

        {{-- TOP BAR --}}
        <div class="px-4 py-3.5"
             style="
                background:linear-gradient(90deg,#0f172a,#1e293b);
                border-bottom:1px solid rgba(255,255,255,0.05);
             ">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div style="
                        width:40px;
                        height:40px;
                        border-radius:12px;
                        background:rgba(37,99,235,0.15);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        color:#60a5fa;
                        font-size: 18px;
                    ">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div>
                        <div class="text-white fw-bold" style="font-size: 15px;">
                            Member Parkir
                        </div>
                        <small class="text-slate-400">
                            Total {{ $members->count() }} member
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 text-white table-custom">
                    <thead style="background:#0f172a;">
                        <tr class="text-slate-400 border-0" style="font-size: 13px; font-weight: 600;">
                            <th class="px-4 py-3.5 text-center" style="width: 60px;">#</th>
                            <th class="py-3.5 text-center" style="width: 150px;">Aksi</th>
                            <th class="py-3.5">Nama</th>
                            <th class="py-3.5">Plat Nomor</th>
                            <th class="py-3.5">Kendaraan</th>
                            <th class="py-3.5">Tipe Member</th>
                            <th class="py-3.5">Expired Date</th>
                            <th class="py-3.5 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($members as $member)
                        <tr class="table-row-custom" style="border-bottom: 1px solid rgba(255,255,255,0.03); transition: all 0.2s;">
                            
                            {{-- NO --}}
                            <td class="px-4 fw-semibold text-slate-400 text-center">
                                {{ $loop->iteration }}
                            </td>

                            {{-- AKSI (DI SEBELAH KIRI) --}}
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    {{-- LIHAT ID CARD --}}
                                    <button type="button"
                                            class="btn btn-sm btn-action btn-id-card"
                                            data-bs-toggle="modal"
                                            data-bs-target="#idCardModal{{ $member->id }}"
                                            title="Lihat ID Card"
                                            style="background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 10px; padding: 6px 10px;">
                                        <i class="fas fa-id-card"></i>
                                    </button>

                                    {{-- EDIT --}}
                                    <a href="{{ route('members.edit', $member->id) }}"
                                       class="btn btn-sm btn-action btn-edit"
                                       title="Edit Member"
                                       style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.25); border-radius: 10px; padding: 6px 10px;">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('members.destroy', $member->id) }}"
                                          method="POST"
                                          class="d-inline mb-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-action btn-delete"
                                                title="Hapus Member"
                                                style="background: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 10px; padding: 6px 10px;"
                                                onclick="return confirm('Hapus member ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                            {{-- NAMA --}}
                            <td>
                                <div class="d-flex align-items-center gap-3" style="min-width:220px;">
                                    {{-- AVATAR --}}
                                    @php
                                        $isVip = strtolower($member->tipe) === 'vip';
                                        $avatarBg = $isVip 
                                            ? 'linear-gradient(135deg,#d97706,#f59e0b)' 
                                            : 'linear-gradient(135deg,#2563eb,#3b82f6)';
                                    @endphp
                                    <div style="
                                        width:42px;
                                        height:42px;
                                        border-radius:12px;
                                        background: {!! $avatarBg !!};
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        font-weight:700;
                                        color:white;
                                        font-size:18px;
                                        flex-shrink:0;
                                        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
                                    ">
                                        {{ strtoupper(substr($member->nama,0,1)) }}
                                    </div>

                                    {{-- TEXT --}}
                                    <div>
                                         <div class="fw-bold" style="font-size:15px; letter-spacing: 0.2px; color: #000000 !important;">
                                             {{ $member->nama }}
                                         </div>
                                        <small class="text-slate-600" style="font-size: 11px;">
                                            ID: MBR-{{ str_pad($member->id, 5, '0', STR_PAD_LEFT) }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            {{-- PLAT --}}
                            <td>
                                <span class="badge font-monospace"
                                      style="
                                        background:#0f172a;
                                        color:#e2e8f0;
                                        padding:8px 12px;
                                        border-radius:8px;
                                        font-size:13px;
                                        border: 1px solid rgba(255,255,255,0.06);
                                        letter-spacing: 0.5px;
                                      ">
                                    {{ strtoupper($member->plat_nomor) }}
                                </span>
                            </td>

                            {{-- KENDARAAN --}}
                            <td>
                                @if($member->jenis_kendaraan == 'motor')
                                    <span class="badge d-inline-flex align-items-center gap-1.5"
                                          style="background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.25); padding: 6px 12px; border-radius: 8px; font-weight: 500;">
                                        <i class="fas fa-motorcycle"></i>
                                        Motor
                                    </span>
                                @else
                                    <span class="badge d-inline-flex align-items-center gap-1.5"
                                          style="background: rgba(99, 102, 241, 0.15); color: #a5b4fc; border: 1px solid rgba(99, 102, 241, 0.25); padding: 6px 12px; border-radius: 8px; font-weight: 500;">
                                        <i class="fas fa-car"></i>
                                        Mobil
                                    </span>
                                @endif
                            </td>

                            {{-- TIPE --}}
                            <td>
                                @if($isVip)
                                    <span class="badge d-inline-flex align-items-center gap-1"
                                          style="background: rgba(234, 179, 8, 0.15); color: #fbbf24; border: 1px solid rgba(234, 179, 8, 0.3); padding: 6px 12px; border-radius: 8px; font-weight: 600; letter-spacing: 0.5px;">
                                        <i class="fas fa-crown me-1" style="font-size: 10px;"></i> VIP
                                    </span>
                                @else
                                    <span class="badge d-inline-flex align-items-center gap-1"
                                          style="background: rgba(37, 99, 235, 0.15); color: #60a5fa; border: 1px solid rgba(37, 99, 235, 0.25); padding: 6px 12px; border-radius: 8px; font-weight: 500;">
                                        Bulanan
                                    </span>
                                @endif
                            </td>

                            {{-- EXPIRED --}}
                            <td class="text-slate-300 font-monospace" style="font-size: 13px;">
                                {{ \Carbon\Carbon::parse($member->expired_at)->format('d M Y') }}
                            </td>

                            {{-- STATUS --}}
                            <td class="text-center">
                                @if($member->isActuallyActive())
                                    <span class="badge"
                                          style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.25); padding: 6px 12px; border-radius: 8px; font-weight: 600;">
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge"
                                          style="background: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.25); padding: 6px 12px; border-radius: 8px; font-weight: 600;">
                                        Expired
                                    </span>
                                @endif
                            </td>

                        </tr>
                        @empty

                        {{-- EMPTY --}}
                        <tr>
                            <td colspan="8" class="text-center py-5">
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
                                <h5 class="text-white fw-bold">Belum Ada Member</h5>
                                <p class="text-slate-400 mb-0">
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

{{-- MODALS SECTION --}}
@foreach($members as $member)
    @php
        $isVip = strtolower($member->tipe) === 'vip';
        $qrColor = $isVip ? 'd97706' : '000000';
        $themeColor = $isVip ? '#fbbf24' : '#60a5fa';
        $bgGradient = $isVip 
            ? 'linear-gradient(135deg, #1e1b4b 0%, #311042 50%, #0f051d 100%)' 
            : 'linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0b0f19 100%)';
        $borderColor = $isVip ? 'rgba(234, 179, 8, 0.3)' : 'rgba(59, 130, 246, 0.3)';
        $shadowColor = $isVip ? 'rgba(234, 179, 8, 0.15)' : 'rgba(37, 99, 235, 0.15)';
    @endphp
    
    <div class="modal fade" id="idCardModal{{ $member->id }}" tabindex="-1" aria-labelledby="idCardModalLabel{{ $member->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-lg" style="background: #111827; border-radius: 24px; overflow: hidden;">
                
                {{-- Modal Header --}}
                <div class="modal-header border-0 px-4 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title text-white fw-bold" id="idCardModalLabel{{ $member->id }}">
                        <i class="fas fa-id-card me-2 text-primary"></i> Preview ID Card
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                {{-- Modal Body --}}
                <div class="modal-body p-4 d-flex justify-content-center align-items-center">
                    
                    {{-- ID Card Layout (Scaled down slightly to fit modal) --}}
                    <div class="member-id-card" style="background: {!! $bgGradient !!}; border: 1.5px solid {!! $borderColor !!}; box-shadow: 0 15px 30px {!! $shadowColor !!};">
                        {{-- Decorative shapes --}}
                        <div class="card-glow" style="background: {!! $isVip ? 'rgba(234, 179, 8, 0.08)' : 'rgba(59, 130, 246, 0.08)' !!};"></div>
                        <div class="card-chip-pattern"></div>
                        
                        {{-- Card Header --}}
                        <div class="card-header-section d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="card-logo-icon" style="background: {!! $isVip ? 'rgba(234, 179, 8, 0.2)' : 'rgba(59, 130, 246, 0.2)' !!}; color: {!! $themeColor !!}; width:32px; height:32px; font-size:14px; border-radius:8px;">
                                    <i class="fas fa-parking"></i>
                                </div>
                                <div>
                                    <div class="card-title-main" style="font-size: 14px;">SmartPark</div>
                                    <div class="card-title-sub" style="font-size: 8px;">PARKING SYSTEM</div>
                                </div>
                            </div>
                            <div>
                                <span class="card-badge {{ $isVip ? 'badge-vip' : 'badge-regular' }}" style="font-size: 8px; padding: 4px 8px;">
                                    {{ strtoupper($member->tipe) }}
                                </span>
                            </div>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body-section row align-items-center g-0">
                            <div class="col-8">
                                {{-- Member Info --}}
                                <div class="mb-2">
                                    <div class="label-card" style="font-size: 7px;">NAMA MEMBER</div>
                                    <div class="value-card-name" style="font-size: 14px; max-width: 180px; color: #ffffff !important; font-weight: bold;">{{ $member->nama }}</div>
                                </div>
                                
                                <div class="row g-1">
                                    <div class="col-6">
                                        <div class="label-card" style="font-size: 7px;">PLAT NOMOR</div>
                                        <div class="value-card-plat" style="font-size: 12px;">{{ strtoupper($member->plat_nomor) }}</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="label-card" style="font-size: 7px;">KENDARAAN</div>
                                        <div class="value-card" style="font-size: 10px;">
                                            <i class="fas {{ $member->jenis_kendaraan == 'motor' ? 'fa-motorcycle' : 'fa-car' }} me-1"></i>
                                            {{ ucfirst($member->jenis_kendaraan) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <div class="label-card" style="font-size: 7px;">EXPIRED DATE</div>
                                    <div class="value-card-date text-warning" style="font-size: 10px;">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($member->expired_at)->format('d M Y') }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 text-center d-flex flex-column align-items-center justify-content-center">
                                {{-- Member QR Code --}}
                                <div class="qr-container bg-white p-1.5 mb-1 rounded-2">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=85x85&data=MEMBER-{{ $member->plat_nomor }}&color={{ $qrColor }}&bgcolor=ffffff" alt="Member QR Code" class="img-fluid rounded-1" style="max-width: 85px;">
                                </div>
                                <div class="qr-label" style="color: {!! $themeColor !!}; font-size: 7px;">SCAN TO EXIT</div>
                            </div>
                        </div>

                        {{-- Card Footer --}}
                        <div class="card-footer-section d-flex justify-content-between align-items-center mt-3 pt-2 border-top border-white border-opacity-10">
                            <div class="card-footer-text" style="font-size: 7px;">SECURE ACCESS CARD</div>
                            <div class="card-footer-id" style="font-size: 8px;">ID: MBR-{{ str_pad($member->id, 5, '0', STR_PAD_LEFT) }}</div>
                        </div>
                    </div>

                </div>
                
                {{-- Modal Footer --}}
                <div class="modal-footer border-0 px-4 pb-4 pt-0 d-flex gap-2">
                    <button type="button" class="btn btn-secondary px-4 py-2" style="border-radius:12px;" data-bs-dismiss="modal">Tutup</button>
                    <a href="{{ route('members.show', $member->id) }}" target="_blank" class="btn btn-primary px-4 py-2 flex-grow-1" style="border-radius:12px; background:linear-gradient(135deg,#2563eb,#3b82f6); border:none; font-weight: 600;">
                        <i class="fas fa-print me-2"></i> Cetak / Halaman Penuh
                    </a>
                </div>

            </div>
        </div>
    </div>
@endforeach

<style>
    /* CSS Animations and Custom styles */
    .table-row-custom:hover {
        background: rgba(255, 255, 255, 0.02) !important;
    }
    
    .btn-action {
        transition: all 0.2s;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    
    .btn-add-member:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
    }

    /* ID Card internal CSS matching modal size */
    .member-id-card {
        width: 390px;
        height: 230px;
        border-radius: 16px;
        padding: 16px 20px;
        position: relative;
        overflow: hidden;
        color: #f8fafc;
        font-family: 'Inter', sans-serif;
        box-sizing: border-box;
    }

    .card-glow {
        position: absolute;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        top: -40px;
        left: -40px;
        filter: blur(40px);
        pointer-events: none;
    }

    .card-chip-pattern {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 30px;
        height: 30px;
        background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 0);
        background-size: 6px 6px;
        pointer-events: none;
    }

    .card-logo-icon {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-title-main {
        font-weight: 800;
        letter-spacing: 0.5px;
        line-height: 1.1;
    }

    .card-title-sub {
        color: #94a3b8;
        letter-spacing: 1.2px;
        font-weight: 600;
    }

    .card-badge {
        font-weight: 700;
        border-radius: 20px;
        letter-spacing: 0.5px;
    }

    .badge-vip {
        background: rgba(234, 179, 8, 0.15);
        color: #fbbf24;
        border: 1px solid rgba(234, 179, 8, 0.3);
    }

    .badge-regular {
        background: rgba(37, 99, 235, 0.15);
        color: #60a5fa;
        border: 1px solid rgba(37, 99, 235, 0.3);
    }

    .label-card {
        font-weight: 600;
        color: #94a3b8;
        letter-spacing: 0.8px;
        margin-bottom: 1px;
    }

    .value-card-name {
        font-weight: 700;
        letter-spacing: 0.2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .value-card-plat {
        font-weight: 800;
        font-family: monospace;
        letter-spacing: 0.5px;
    }

    .value-card {
        font-weight: 600;
    }

    .value-card-date {
        font-weight: 600;
    }

    .qr-container {
        display: inline-block;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .qr-label {
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .card-footer-text {
        color: #64748b;
        letter-spacing: 0.8px;
        font-weight: 600;
    }

    .card-footer-id {
        font-family: monospace;
        color: #94a3b8;
    }
</style>
@endsection