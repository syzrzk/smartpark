<x-app-layout>
    <x-slot name="header">
        {{ isset($tarif) ? 'Edit Tarif Parkir' : 'Tambah Tarif Parkir Baru' }}
    </x-slot>

    <style>
        .form-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            overflow: hidden;
            transition: all 0.3s;
            max-width: 650px;
            margin: 0 auto;
        }

        .dark .form-card {
            background: #1e293b;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }

        .card-header-custom {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            padding: 20px 24px;
            color: white;
        }

        .dark .card-header-custom {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            border-bottom: 1px solid #334155;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
            display: block;
        }

        .dark .form-group label {
            color: #cbd5e1;
        }

        .form-control-custom {
            width: 100%;
            padding: 12px 16px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            color: #1e293b;
            font-size: 14px;
            transition: all 0.2s;
        }

        .dark .form-control-custom {
            background: #0f172a;
            border-color: #334155;
            color: #f8fafc;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: white;
        }

        .dark .form-control-custom:focus {
            background: #1e293b;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .form-text-custom {
            font-size: 11px;
            color: #64748b;
            margin-top: 6px;
        }

        .dark .form-text-custom {
            color: #94a3b8;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom .prefix {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-weight: 600;
            font-size: 14px;
        }

        .dark .input-group-custom .prefix {
            color: #94a3b8;
        }

        .input-group-custom input {
            padding-left: 45px;
        }
        
        .btn-action {
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-save {
            background: #10b981;
            color: white;
        }

        .btn-save:hover {
            background: #059669;
        }

        .btn-cancel {
            background: #f1f5f9;
            color: #475569;
        }

        .dark .btn-cancel {
            background: #334155;
            color: #cbd5e1;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
        }

        .dark .btn-cancel:hover {
            background: #475569;
        }
    </style>

    <div class="container-fluid pb-5">
        <div class="form-card">
            <div class="card-header-custom">
                <h5 class="fw-bold mb-1" style="font-size: 18px;">
                    <i class="fas {{ isset($tarif) ? 'fa-edit' : 'fa-plus-circle' }} me-2"></i>
                    {{ isset($tarif) ? 'Edit Pengaturan Tarif' : 'Tambah Pengaturan Tarif' }}
                </h5>
                <p class="mb-0 opacity-75" style="font-size: 13px;">Silakan isi formulir di bawah ini dengan detail tarif yang sesuai.</p>
            </div>
            
            <div class="p-4 p-md-5">
                @if ($errors->any())
                    <div style="background:#fee2e2; border-left:4px solid #ef4444; color:#991b1b; padding:12px 16px; border-radius:6px; margin-bottom:24px; font-size:13px;">
                        <ul style="margin:0; padding-left:16px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ isset($tarif) ? route('tarif.update', $tarif->id) : route('tarif.store') }}" method="POST">
                    @csrf
                    @if(isset($tarif))
                        @method('PUT')
                    @endif

                    <div class="row g-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="jenis_kendaraan"><i class="fas fa-car-side me-1 text-primary"></i> Jenis Kendaraan</label>
                                <input type="text" name="jenis_kendaraan" id="jenis_kendaraan" value="{{ old('jenis_kendaraan', $tarif->jenis_kendaraan ?? '') }}" placeholder="Contoh: motor atau mobil" class="form-control-custom" style="text-transform: lowercase;" required>
                                <div class="form-text-custom"><i class="fas fa-info-circle"></i> Pastikan penulisannya konsisten (contoh: motor). Teks otomatis dikonversi ke huruf kecil.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tarif_awal"><i class="fas fa-money-bill-wave me-1 text-success"></i> Tarif Dasar (Awal)</label>
                                <div class="input-group-custom">
                                    <span class="prefix">Rp</span>
                                    <input type="number" name="tarif_awal" id="tarif_awal" value="{{ old('tarif_awal', $tarif->tarif_awal ?? '0') }}" class="form-control-custom" required>
                                </div>
                                <div class="form-text-custom">Nominal harga untuk durasi jam pertama.</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jam_awal"><i class="fas fa-stopwatch me-1 text-warning"></i> Berlaku Untuk (Jam)</label>
                                <div class="input-group-custom">
                                    <input type="number" name="jam_awal" id="jam_awal" value="{{ old('jam_awal', $tarif->jam_awal ?? '1') }}" min="1" class="form-control-custom" style="padding-left:16px; padding-right:45px;" required>
                                    <span class="prefix" style="left:auto; right:16px;">Jam</span>
                                </div>
                                <div class="form-text-custom">Durasi untuk tarif dasar (misal: 1 jam pertama).</div>
                            </div>
                        </div>

                        <div class="col-12 border-top pt-4 mt-4" style="border-color: rgba(0,0,0,0.05) !important;">
                            <div class="form-group">
                                <label for="harga_per_jam"><i class="fas fa-plus-circle me-1 text-danger"></i> Tarif Tambahan (Per Jam)</label>
                                <div class="input-group-custom">
                                    <span class="prefix">Rp</span>
                                    <input type="number" name="harga_per_jam" id="harga_per_jam" value="{{ old('harga_per_jam', $tarif->harga_per_jam ?? '0') }}" class="form-control-custom" required>
                                </div>
                                <div class="form-text-custom">Biaya yang ditambahkan <strong>setiap 1 jam berikutnya</strong> jika melebihi batas jam awal.</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5 pt-3">
                        <a href="{{ route('tarif.index') }}" class="btn-action btn-cancel">
                            Batal
                        </a>
                        <button type="submit" class="btn-action btn-save">
                            <i class="fas fa-save"></i> {{ isset($tarif) ? 'Simpan Perubahan' : 'Simpan Pengaturan' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
