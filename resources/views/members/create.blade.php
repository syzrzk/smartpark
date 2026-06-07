@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="mb-4">

        <h2 class="fw-bold text-white mb-1">
            Tambah Member
        </h2>

        <p class="text-secondary mb-0">
            Tambahkan member parkir baru
        </p>

    </div>

    {{-- CARD --}}
    <div class="card border-0 shadow-lg"
         style="
            background:#1e293b;
            border-radius:22px;
            max-width:850px;
         ">

        <div class="card-body p-4">

            {{-- FORM --}}
            <form action="{{ route('member.store') }}"
                  method="POST">

                @csrf

                <div class="row g-4">

                    {{-- NAMA --}}
                    <div class="col-md-6">

                        <label class="form-label text-white">
                            Nama Member
                        </label>

                        <input type="text"
                               name="nama"
                               class="form-control"
                               placeholder="Masukkan nama member"
                               required
                               style="
                                    background:#0f172a;
                                    border:1px solid rgba(255,255,255,0.08);
                                    color:white;
                                    height:50px;
                                    border-radius:14px;
                               ">

                    </div>

                    {{-- PLAT --}}
                    <div class="col-md-6">

                        <label class="form-label text-white">
                            Plat Nomor
                        </label>

                        <input type="text"
                               name="plat_nomor"
                               class="form-control"
                               placeholder="Contoh: B 1234 ABC"
                               required
                               style="
                                    background:#0f172a;
                                    border:1px solid rgba(255,255,255,0.08);
                                    color:white;
                                    height:50px;
                                    border-radius:14px;
                               ">

                    </div>

                    {{-- JENIS --}}
                    <div class="col-md-6">

                        <label class="form-label text-white">
                            Jenis Kendaraan
                        </label>

                        <select name="jenis_kendaraan"
                                class="form-select"
                                style="
                                    background:#0f172a;
                                    border:1px solid rgba(255,255,255,0.08);
                                    color:white;
                                    height:50px;
                                    border-radius:14px;
                                ">

                            <option value="motor">
                                Motor
                            </option>

                            <option value="mobil">
                                Mobil
                            </option>

                        </select>

                    </div>

                    {{-- TIPE --}}
                    <div class="col-md-6">

                        <label class="form-label text-white">
                            Tipe Member
                        </label>

                        <select name="tipe"
                                class="form-select"
                                style="
                                    background:#0f172a;
                                    border:1px solid rgba(255,255,255,0.08);
                                    color:white;
                                    height:50px;
                                    border-radius:14px;
                                ">

                            <option value="bulanan">
                                Bulanan
                            </option>

                            <option value="vip">
                                VIP
                            </option>

                        </select>

                    </div>

                    {{-- EXPIRED --}}
                    <div class="col-md-6">

                        <label class="form-label text-white">
                            Tanggal Expired
                        </label>

                        <input type="date"
                               name="expired_at"
                               class="form-control"
                               required
                               style="
                                    background:#0f172a;
                                    border:1px solid rgba(255,255,255,0.08);
                                    color:white;
                                    height:50px;
                                    border-radius:14px;
                               ">

                    </div>

                </div>

                {{-- BUTTON --}}
                <div class="mt-5 d-flex gap-3">

                    <button type="submit"
                            class="btn btn-primary px-4 py-2"
                            style="
                                border-radius:14px;
                                background:linear-gradient(135deg,#2563eb,#3b82f6);
                                border:none;
                            ">

                        <i class="fas fa-credit-card me-2"></i>
                        Lanjut Pembayaran

                    </button>

                    <a href="{{ route('members.index') }}"
                       class="btn btn-secondary px-4 py-2"
                       style="border-radius:14px;">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection