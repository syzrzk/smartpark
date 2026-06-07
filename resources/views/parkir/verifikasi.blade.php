<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kendaraan Keluar - SmartPark</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: linear-gradient(135deg, #0a0f1e 0%, #0f1f3d 50%, #0a1628 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow-y: auto;
            padding: 20px 12px;
        }

        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: radial-gradient(circle, rgba(245,158,11,.08) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none; z-index: 0;
        }

        .orb { position: fixed; border-radius: 50%; filter: blur(90px); pointer-events: none; z-index: 0; }
        .orb-1 { width:350px; height:350px; background:#f59e0b; opacity:.06; top:-80px; right:-60px; }
        .orb-2 { width:280px; height:280px; background:#ef4444; opacity:.06; bottom:-60px; left:-60px; }

        .page-wrap {
            position: relative; z-index: 10;
            max-width: 640px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* ── TOP BAR ── */
        .top-bar {
            display: flex; align-items: center; justify-content: space-between;
        }
        .brand-row { display: flex; align-items: center; gap: 10px; }
        .brand-icon-sm {
            width: 42px; height: 42px; border-radius: 12px;
            background: linear-gradient(135deg,#f59e0b,#d97706);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 14px rgba(245,158,11,.35);
        }
        .brand-text-sm { font-size: 15px; font-weight: 700; color: #f1f5f9; }
        .brand-sub-sm  { font-size: 10px; color: #475569; }
        .btn-back-top {
            display: flex; align-items: center; gap: 6px;
            padding: 8px 14px; border-radius: 10px;
            background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.08);
            color: #64748b; font-size: 12px; font-weight: 500;
            text-decoration: none; transition: all .2s;
        }
        .btn-back-top:hover { background: rgba(255,255,255,.09); color: #94a3b8; }

        /* ── CLOCK ── */
        .clock-bar {
            display: flex; justify-content: space-between; align-items: center;
            padding: 10px 16px; background: rgba(255,255,255,.03);
            border: 1px solid rgba(255,255,255,.06); border-radius: 12px; font-size: 12px;
        }
        .clock-bar .ctime { font-weight: 700; color: #f59e0b; font-variant-numeric: tabular-nums; }
        .clock-bar .cdate { color: #475569; }

        /* ── SECTION CARD ── */
        .section-card {
            background: rgba(15,23,42,.85);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,.45);
        }

        .section-header {
            padding: 16px 20px;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .section-header .title { font-size: 15px; font-weight: 700; color: #f1f5f9; }
        .section-header .subtitle { font-size: 11px; color: #475569; margin-top: 2px; }

        /* ── PHOTO ── */
        .foto-wrap {
            position: relative;
            padding: 16px;
        }
        .foto-container {
            position: relative;
            border-radius: 14px;
            overflow: hidden;
            border: 2px solid rgba(245,158,11,0.2);
        }
        .foto-container img {
            width: 100%;
            max-height: 320px;
            object-fit: cover;
            display: block;
        }
        .no-foto {
            width: 100%;
            height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,.03);
            color: #475569;
            gap: 8px;
        }
        .no-foto i { font-size: 40px; }
        .no-foto span { font-size: 13px; }

        .foto-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(245, 158, 11, 0.9);
            color: #000;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            letter-spacing: 0.5px;
            backdrop-filter: blur(4px);
        }

        .waktu-masuk-badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(0,0,0,0.7);
            color: #f59e0b;
            font-size: 11px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 8px;
            font-variant-numeric: tabular-nums;
        }

        /* ── FORM ── */
        .form-section { padding: 20px; }
        .sec-label {
            font-size: 10px; font-weight: 600; color: #475569;
            text-transform: uppercase; letter-spacing: .7px; margin-bottom: 8px;
        }
        .form-input {
            width: 100%;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 12px;
            padding: 12px 16px;
            color: #f1f5f9; font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none; transition: all .2s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 14px;
        }
        .form-input::placeholder { color: #334155; text-transform: none; }
        .form-input:focus {
            border-color: #f59e0b;
            background: rgba(245,158,11,.07);
            box-shadow: 0 0 0 3px rgba(245,158,11,.12);
        }

        /* ── VEHICLE SELECT ── */
        .vehicle-opts { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 18px; }
        .vehicle-opt input[type="radio"] { display: none; }
        .vehicle-opt label {
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; gap: 4px; padding: 12px 8px;
            background: rgba(255,255,255,.04);
            border: 1.5px solid rgba(255,255,255,.08);
            border-radius: 12px; cursor: pointer; transition: all .2s;
            color: #64748b; font-size: 12px; font-weight: 500;
        }
        .vehicle-opt label .icon-box {
            width: 34px; height: 34px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; background: rgba(255,255,255,.06); transition: all .2s;
        }
        .vehicle-opt label:hover { border-color: rgba(255,255,255,.16); color: #e2e8f0; }
        .vehicle-opt input[value="motor"]:checked + label { border-color: #f59e0b; background: rgba(245,158,11,.10); color: #fbbf24; }
        .vehicle-opt input[value="motor"]:checked + label .icon-box { background: rgba(245,158,11,.2); color: #f59e0b; }
        .vehicle-opt input[value="mobil"]:checked + label { border-color: #8b5cf6; background: rgba(139,92,246,.10); color: #a78bfa; }
        .vehicle-opt input[value="mobil"]:checked + label .icon-box { background: rgba(139,92,246,.2); color: #8b5cf6; }

        /* ── TIKET INFO ── */
        .tiket-info {
            display: flex; gap: 10px; flex-wrap: wrap;
            padding: 0 16px 16px;
        }
        .tiket-info .info-item {
            flex: 1; min-width: 100px;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 10px; padding: 10px 12px;
        }
        .tiket-info .info-label { font-size: 9px; color: #475569; font-weight: 600; letter-spacing: 0.8px; text-transform: uppercase; }
        .tiket-info .info-value { font-size: 14px; color: #f1f5f9; font-weight: 700; margin-top: 2px; }

        /* ── BUTTON ── */
        .btn-verify {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            border: none; border-radius: 12px;
            color: white; font-size: 15px; font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer; transition: all .2s;
            box-shadow: 0 6px 20px rgba(245,158,11,.35);
        }
        .btn-verify:hover { background: linear-gradient(135deg,#d97706,#b45309); transform: translateY(-2px); box-shadow: 0 10px 25px rgba(245,158,11,.4); }

        /* ── ALERT ── */
        .alert-box {
            background: rgba(239,68,68,.12); border: 1px solid rgba(239,68,68,.25);
            border-radius: 10px; padding: 12px 16px; font-size: 13px; color: #fca5a5;
            display: flex; align-items: center; gap: 8px;
        }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div class="page-wrap">

    {{-- Top Bar --}}
    <div class="top-bar">
        <div class="brand-row">
            <div class="brand-icon-sm">
                <i class="fas fa-search" style="color:white;font-size:16px;"></i>
            </div>
            <div>
                <div class="brand-text-sm">Verifikasi Keluar</div>
                <div class="brand-sub-sm">SmartPark • Input Plat Nomor Kendaraan</div>
            </div>
        </div>
        <a href="{{ route('parkir.scan') }}" class="btn-back-top">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Jam --}}
    <div class="clock-bar">
        <span class="cdate" id="dateNow">--/--/----</span>
        <span class="ctime" id="clockNow">--:--:--</span>
    </div>

    {{-- Error --}}
    @if(session('error'))
    <div class="alert-box">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert-box">
        <i class="fas fa-exclamation-circle"></i>
        {{ $errors->first() }}
    </div>
    @endif

    {{-- Foto Kendaraan Masuk --}}
    <div class="section-card">
        <div class="section-header">
            <div class="title"><i class="fas fa-camera me-2" style="color:#f59e0b;"></i>Foto Kendaraan Saat Masuk</div>
            <div class="subtitle">Cocokkan kendaraan fisik dengan foto di bawah ini</div>
        </div>

        <div class="foto-wrap">
            <div class="foto-container">
                @if($parkir->foto_masuk && file_exists(public_path($parkir->foto_masuk)))
                    <img src="{{ asset($parkir->foto_masuk) }}" alt="Foto kendaraan masuk">
                    <div class="foto-badge"><i class="fas fa-camera me-1"></i> FOTO MASUK</div>
                    <div class="waktu-masuk-badge">
                        <i class="fas fa-clock me-1"></i>
                        {{ \Carbon\Carbon::parse($parkir->waktu_masuk)->format('H:i • d M Y') }}
                    </div>
                @else
                    <div class="no-foto">
                        <i class="fas fa-image"></i>
                        <span>Foto tidak tersedia</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Tiket Info --}}
        <div class="tiket-info">
            <div class="info-item">
                <div class="info-label">ID Tiket</div>
                <div class="info-value">#{{ str_pad($parkir->id, 5, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Waktu Masuk</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($parkir->waktu_masuk)->format('H:i') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Durasi (sementara)</div>
                <div class="info-value">
                    {{ max(1, ceil(\Carbon\Carbon::parse($parkir->waktu_masuk)->diffInMinutes(now()) / 60)) }} Jam
                </div>
            </div>
        </div>
    </div>

    {{-- Form Input Plat Nomor --}}
    <div class="section-card">
        <div class="section-header">
            <div class="title"><i class="fas fa-hashtag me-2" style="color:#f59e0b;"></i>Input Data Kendaraan Keluar</div>
            <div class="subtitle">Pastikan plat nomor sesuai dengan kendaraan fisik yang keluar</div>
        </div>

        <div class="form-section">
            <form action="{{ route('parkir.prosesVerifikasi', $parkir->id) }}" method="POST">
                @csrf

                {{-- Plat Nomor --}}
                <div class="sec-label"><i class="fas fa-hashtag me-1"></i>Plat Nomor Kendaraan</div>
                <input type="text"
                       name="plat_nomor"
                       class="form-input"
                       placeholder="Contoh: B 1234 ABC"
                       maxlength="15"
                       required
                       autocomplete="off"
                       value="{{ old('plat_nomor') }}"
                       id="platInput">

                {{-- Jenis Kendaraan --}}
                <div class="sec-label"><i class="fas fa-car-side me-1"></i>Jenis Kendaraan</div>
                <div class="vehicle-opts">
                    <div class="vehicle-opt">
                        <input type="radio" name="jenis_kendaraan" id="motor" value="motor" checked>
                        <label for="motor">
                            <div class="icon-box"><i class="fas fa-motorcycle"></i></div>
                            Motor
                        </label>
                    </div>
                    <div class="vehicle-opt">
                        <input type="radio" name="jenis_kendaraan" id="mobil" value="mobil">
                        <label for="mobil">
                            <div class="icon-box"><i class="fas fa-car"></i></div>
                            Mobil
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-verify">
                    <i class="fas fa-check-circle me-2"></i> Verifikasi & Proses Keluar
                </button>
            </form>
        </div>
    </div>

</div>

<script>
    // Auto-uppercase plat
    const platInput = document.getElementById('platInput');
    platInput.addEventListener('input', function() {
        const pos = this.selectionStart;
        this.value = this.value.toUpperCase();
        this.setSelectionRange(pos, pos);
    });
    platInput.focus();

    // Clock
    function updateClock() {
        const n = new Date();
        const p = v => String(v).padStart(2, '0');
        document.getElementById('clockNow').textContent = `${p(n.getHours())}:${p(n.getMinutes())}:${p(n.getSeconds())}`;
        document.getElementById('dateNow').textContent  = `${p(n.getDate())}/${p(n.getMonth()+1)}/${n.getFullYear()}`;
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
