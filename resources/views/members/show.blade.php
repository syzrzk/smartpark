@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 page-container">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <div>
            <h2 class="fw-bold text-white mb-1">ID Card Member</h2>
            <p class="text-secondary mb-0">Cetak atau bagikan kartu member parkir</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('members.index') }}" class="btn btn-secondary px-4 py-2" style="border-radius:12px;">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary px-4 py-2" style="border-radius:12px; background:linear-gradient(135deg,#2563eb,#3b82f6); border:none;">
                <i class="fas fa-print me-2"></i> Cetak Kartul
            </button>
        </div>
    </div>

    {{-- Card Container --}}
    <div class="d-flex justify-content-center align-items-center py-5">
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

        <div class="member-card-wrapper">
            <div class="member-id-card" style="background: {!! $bgGradient !!}; border: 1.5px solid {!! $borderColor !!}; box-shadow: 0 25px 50px -12px {!! $shadowColor !!};">
                {{-- Decorative Shapes --}}
                <div class="card-glow" style="background: {!! $isVip ? 'rgba(234, 179, 8, 0.08)' : 'rgba(59, 130, 246, 0.08)' !!};"></div>
                <div class="card-chip-pattern"></div>
                
                {{-- Card Header --}}
                <div class="card-header-section d-flex justify-content-between align-items-start mb-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="card-logo-icon" style="background: {!! $isVip ? 'rgba(234, 179, 8, 0.2)' : 'rgba(59, 130, 246, 0.2)' !!}; color: {!! $themeColor !!};">
                            <i class="fas fa-parking"></i>
                        </div>
                        <div>
                            <div class="card-title-main">SmartPark</div>
                            <div class="card-title-sub">PARKING SYSTEM</div>
                        </div>
                    </div>
                    <div>
                        <span class="card-badge {{ $isVip ? 'badge-vip' : 'badge-regular' }}">
                            {{ strtoupper($member->tipe) }}
                        </span>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="card-body-section row align-items-center">
                    <div class="col-8">
                        {{-- Member Info --}}
                        <div class="mb-3">
                            <div class="label-card">NAMA MEMBER</div>
                            <div class="value-card-name">{{ $member->nama }}</div>
                        </div>
                        
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="label-card">PLAT NOMOR</div>
                                <div class="value-card-plat">{{ strtoupper($member->plat_nomor) }}</div>
                            </div>
                            <div class="col-6">
                                <div class="label-card">KENDARAAN</div>
                                <div class="value-card">
                                    <i class="fas {{ $member->jenis_kendaraan == 'motor' ? 'fa-motorcycle' : 'fa-car' }} me-1"></i>
                                    {{ ucfirst($member->jenis_kendaraan) }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="label-card">EXPIRED DATE</div>
                            <div class="value-card-date text-warning">
                                <i class="far fa-calendar-alt me-1"></i>
                                {{ \Carbon\Carbon::parse($member->expired_at)->format('d M Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-4 text-center d-flex flex-column align-items-center justify-content-center">
                        {{-- Member QR Code --}}
                        <div class="qr-container bg-white p-2 mb-2 rounded-3 shadow-sm border border-secondary border-opacity-10">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=110x110&data=MEMBER-{{ $member->plat_nomor }}&color={{ $qrColor }}&bgcolor=ffffff" alt="Member QR Code" class="img-fluid rounded-1">
                        </div>
                        <div class="qr-label" style="color: {!! $themeColor !!};">SCAN TO EXIT</div>
                    </div>
                </div>

                {{-- Card Footer --}}
                <div class="card-footer-section d-flex justify-content-between align-items-center mt-4 pt-3 border-top border-white border-opacity-10">
                    <div class="card-footer-text">SECURE ACCESS CARD</div>
                    <div class="card-footer-id">ID: MBR-{{ str_pad($member->id, 5, '0', STR_PAD_LEFT) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Premium Styling for ID Card */
    .member-card-wrapper {
        perspective: 1000px;
    }
    
    .member-id-card {
        width: 450px;
        height: 270px;
        border-radius: 18px;
        padding: 24px;
        position: relative;
        overflow: hidden;
        color: #f8fafc;
        font-family: 'Inter', sans-serif;
        box-sizing: border-box;
    }

    .card-glow {
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        top: -50px;
        left: -50px;
        filter: blur(50px);
        pointer-events: none;
    }

    .card-chip-pattern {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        background-image: radial-gradient(rgba(255,255,255,0.05) 1px, transparent 0);
        background-size: 8px 8px;
        pointer-events: none;
    }

    .card-logo-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .card-title-main {
        font-size: 16px;
        font-weight: 800;
        letter-spacing: 0.5px;
        line-height: 1.1;
    }

    .card-title-sub {
        font-size: 9px;
        color: #64748b;
        letter-spacing: 1.5px;
        font-weight: 600;
    }

    .card-badge {
        font-size: 9px;
        font-weight: 700;
        padding: 5px 10px;
        border-radius: 20px;
        letter-spacing: 1px;
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
        font-size: 8px;
        font-weight: 600;
        color: #94a3b8;
        letter-spacing: 1px;
        margin-bottom: 2px;
        text-transform: uppercase;
    }

    .value-card-name {
        font-size: 16px;
        font-weight: 700;
        letter-spacing: 0.2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .value-card-plat {
        font-size: 14px;
        font-weight: 800;
        font-family: monospace;
        letter-spacing: 0.5px;
    }

    .value-card {
        font-size: 12px;
        font-weight: 600;
    }

    .value-card-date {
        font-size: 11px;
        font-weight: 600;
    }

    .qr-container {
        display: inline-block;
        padding: 6px;
        background: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .qr-label {
        font-size: 8px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .card-footer-text {
        font-size: 8px;
        color: #475569;
        letter-spacing: 1px;
        font-weight: 600;
    }

    .card-footer-id {
        font-size: 9px;
        font-family: monospace;
        color: #94a3b8;
    }

    /* Print styling */
    @media print {
        body {
            background: white !important;
            color: black !important;
        }
        .no-print, header, aside, .sidebar-wrapper, .top-header, main.page-content {
            display: none !important;
        }
        main {
            padding: 0 !important;
            margin: 0 !important;
        }
        .page-container {
            padding: 0 !important;
        }
        .member-id-card {
            box-shadow: none !important;
            border: 1px solid #000 !important;
            background: #000 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    }
</style>
@endsection
