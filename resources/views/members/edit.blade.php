@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h2 class="fw-bold mb-1" style="color: #000000 !important;">
            Edit Member
        </h2>
        <p class="mb-0" style="color: #000000 !important; opacity: 0.7;">
            Perbarui data member parkir aktif
        </p>
    </div>

    {{-- CARD --}}
    <div class="card border-0 shadow-lg"
         style="
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: 22px;
            max-width: 850px;
            border: 1px solid rgba(255,255,255,0.05);
         ">

        <div class="card-body p-4">

            {{-- FORM --}}
            <form action="{{ route('members.update', $member->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row g-4">

                    {{-- NAMA --}}
                    <div class="col-md-6">
                        <label class="form-label text-white fw-semibold mb-2">
                            <i class="fas fa-user me-1 text-primary"></i> Nama Member
                        </label>
                        <input type="text"
                               name="nama"
                               class="form-control form-input-custom"
                               placeholder="Masukkan nama member"
                               value="{{ old('nama', $member->nama) }}"
                               required>
                    </div>

                    {{-- PLAT --}}
                    <div class="col-md-6">
                        <label class="form-label text-white fw-semibold mb-2">
                            <i class="fas fa-hashtag me-1 text-primary"></i> Plat Nomor
                        </label>
                        <input type="text"
                               name="plat_nomor"
                               class="form-control form-input-custom text-uppercase"
                               placeholder="Contoh: B 1234 ABC"
                               value="{{ old('plat_nomor', $member->plat_nomor) }}"
                               required>
                    </div>

                    {{-- JENIS --}}
                    <div class="col-md-6">
                        <label class="form-label text-white fw-semibold mb-2">
                            <i class="fas fa-car-side me-1 text-primary"></i> Jenis Kendaraan
                        </label>
                        <select name="jenis_kendaraan"
                                class="form-select form-input-custom">
                            <option value="motor" {{ $member->jenis_kendaraan == 'motor' ? 'selected' : '' }}>
                                Motor
                            </option>
                            <option value="mobil" {{ $member->jenis_kendaraan == 'mobil' ? 'selected' : '' }}>
                                Mobil
                            </option>
                        </select>
                    </div>

                    {{-- TIPE --}}
                    <div class="col-md-6">
                        <label class="form-label text-white fw-semibold mb-2">
                            <i class="fas fa-crown me-1 text-primary"></i> Tipe Member
                        </label>
                        <select name="tipe"
                                class="form-select form-input-custom">
                            <option value="bulanan" {{ $member->tipe == 'bulanan' ? 'selected' : '' }}>
                                Bulanan
                            </option>
                            <option value="vip" {{ $member->tipe == 'vip' ? 'selected' : '' }}>
                                VIP
                            </option>
                        </select>
                    </div>

                    {{-- EXPIRED --}}
                    <div class="col-md-6">
                        <label class="form-label text-white fw-semibold mb-2">
                            <i class="far fa-calendar-alt me-1 text-primary"></i> Tanggal Expired
                        </label>
                        <input type="date"
                               name="expired_at"
                               class="form-control form-input-custom"
                               value="{{ old('expired_at', \Carbon\Carbon::parse($member->expired_at)->format('Y-m-d')) }}"
                               required>
                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="mt-5 d-flex gap-3">
                    <button type="submit"
                            class="btn btn-primary px-4 py-2.5 btn-submit-custom">
                        <i class="fas fa-save me-2"></i>
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('members.index') }}"
                       class="btn btn-secondary px-4 py-2.5"
                       style="border-radius:14px; font-weight: 500;">
                        Kembali
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>

<style>
    .form-input-custom {
        background: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        color: white !important;
        height: 50px;
        border-radius: 14px !important;
        padding: 10px 16px !important;
        transition: all 0.2s !important;
    }
    
    .form-input-custom:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15) !important;
        background: #0b0f19 !important;
    }

    .form-input-custom::placeholder {
        color: #475569 !important;
    }

    .btn-submit-custom {
        border-radius: 14px;
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        border: none;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-submit-custom:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        background: linear-gradient(135deg, #1d4ed8, #2563eb);
    }
</style>
@endsection
