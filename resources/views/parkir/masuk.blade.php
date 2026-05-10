<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kendaraan Masuk - SmartPark</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: linear-gradient(135deg, #0a0f1e 0%, #0f1f3d 50%, #0a1628 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            position: relative;
            /* PENTING: izinkan scroll agar card tidak terpotong */
            overflow-y: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px 12px;
        }

        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: radial-gradient(circle, rgba(59,130,246,.12) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none; z-index: 0;
        }

        .orb { position: fixed; border-radius: 50%; filter: blur(80px); pointer-events: none; z-index: 0; }
        .orb-1 { width:350px; height:350px; background:#3b82f6; opacity:.10; top:-80px; left:-80px; }
        .orb-2 { width:250px; height:250px; background:#6366f1; opacity:.08; bottom:-60px; right:-60px; }

        /* ── CARD ── */
        .form-card {
            position: relative; z-index: 10;
            width: 100%; max-width: 440px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 20px;
            padding: 24px 24px;
            box-shadow: 0 25px 60px rgba(0,0,0,.5), inset 0 1px 0 rgba(255,255,255,.06);
        }

        /* ── BRAND ── */
        .brand-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 10px;
            box-shadow: 0 8px 24px rgba(16,185,129,.35);
        }

        .brand-icon i { font-size: 18px; }

        .brand-title { font-size: 17px; font-weight: 700; color: #f1f5f9; text-align: center; letter-spacing: -.3px; }
        .brand-sub   { font-size: 11px; color: #475569; text-align: center; margin-top: 2px; margin-bottom: 16px; }

        /* ── CLOCK ── */
        .clock-row {
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 10px; padding: 8px 12px;
            margin-bottom: 16px;
            font-size: 11px;
        }
        .clock-row .ctime { font-weight: 700; color: #cbd5e1; font-variant-numeric: tabular-nums; }
        .clock-row .cdate { color: #475569; }

        /* ── SECTION LABEL ── */
        .sec-label {
            font-size: 10px; font-weight: 600; color: #475569;
            text-transform: uppercase; letter-spacing: .7px;
            margin-bottom: 6px;
        }

        /* ── VEHICLE SELECTOR ── */
        .vehicle-opts { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 14px; }

        .vehicle-opt input[type="radio"] { display: none; }

        .vehicle-opt label {
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; gap: 4px;
            padding: 10px 8px;
            background: rgba(255,255,255,.04);
            border: 1.5px solid rgba(255,255,255,.08);
            border-radius: 12px; cursor: pointer;
            transition: all .2s; color: #64748b;
            font-size: 12px; font-weight: 500;
        }

        .vehicle-opt label .icon-box {
            width: 32px; height: 32px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; background: rgba(255,255,255,.06);
            transition: all .2s;
        }

        .vehicle-opt label:hover { border-color: rgba(255,255,255,.16); background: rgba(255,255,255,.07); color: #e2e8f0; }

        .vehicle-opt input[value="motor"]:checked + label { border-color: #f59e0b; background: rgba(245,158,11,.10); color: #fbbf24; }
        .vehicle-opt input[value="motor"]:checked + label .icon-box { background: rgba(245,158,11,.2); color: #f59e0b; }
        .vehicle-opt input[value="mobil"]:checked + label { border-color: #8b5cf6; background: rgba(139,92,246,.10); color: #a78bfa; }
        .vehicle-opt input[value="mobil"]:checked + label .icon-box { background: rgba(139,92,246,.2); color: #8b5cf6; }

        /* ── INPUT ── */
        .form-input {
            width: 100%;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 10px;
            padding: 10px 14px 10px 36px;
            color: #f1f5f9; font-size: 12px;
            font-family: 'Inter', sans-serif;
            outline: none; transition: all .2s;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .form-input::placeholder { color: #334155; text-transform: none; }

        .form-input:focus {
            border-color: #10b981;
            background: rgba(16,185,129,.06);
            box-shadow: 0 0 0 3px rgba(16,185,129,.12);
        }

        .input-wrap { position: relative; margin-bottom: 12px; }
        .input-wrap .input-icon {
            position: absolute; left: 12px; top: 50%;
            transform: translateY(-50%); color: #334155; font-size: 12px; pointer-events: none;
        }

        .input-hint { font-size: 10px; color: #475569; margin-top: -8px; margin-bottom: 14px; }

        /* ── INFO STRIP ── */
        .info-strip {
            background: rgba(16,185,129,.08); border: 1px solid rgba(16,185,129,.2);
            border-radius: 8px; padding: 8px 12px;
            display: flex; align-items: flex-start; gap: 8px;
            margin-bottom: 16px;
        }
        .info-strip i { color: #10b981; font-size: 12px; flex-shrink: 0; margin-top: 1px; }
        .info-strip p { font-size: 10px; color: #6ee7b7; margin: 0; line-height: 1.4; }

        /* ── BUTTONS ── */
        .btn-submit {
            width: 100%; padding: 11px;
            background: linear-gradient(135deg, #10b981, #059669);
            border: none; border-radius: 10px;
            color: white; font-size: 13px; font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer; transition: all .2s;
            box-shadow: 0 4px 15px rgba(16,185,129,.3);
            margin-bottom: 8px;
        }
        .btn-submit:hover { background: linear-gradient(135deg,#059669,#047857); transform: translateY(-1px); }

        .divider { display: flex; align-items: center; gap: 8px; margin: 8px 0; color: #1e293b; font-size: 10px; }
        .divider::before, .divider::after { content:''; flex:1; height:1px; background: rgba(255,255,255,.07); }

        .btn-outline {
            width: 100%; padding: 9px;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 10px; color: #64748b;
            font-size: 12px; font-weight: 500;
            font-family: 'Inter', sans-serif;
            cursor: pointer; transition: all .2s;
            text-decoration: none; display: block; text-align: center;
            margin-bottom: 8px;
        }
        .btn-outline:hover { background: rgba(255,255,255,.08); color: #94a3b8; border-color: rgba(255,255,255,.15); }

        .link-back {
            display: block; text-align: center;
            font-size: 11px; color: #475569;
            text-decoration: none; transition: color .2s;
        }
        .link-back:hover { color: #60a5fa; }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div class="form-card">

    {{-- Brand --}}
    <div class="brand-icon">
        <i class="fas fa-sign-in-alt" style="color:white; font-size:20px;"></i>
    </div>
    <div class="brand-title">Kendaraan Masuk</div>
    <div class="brand-sub">Isi data kendaraan dan generate tiket parkir</div>

    {{-- Jam --}}
    <div class="clock-row">
        <span class="cdate" id="dateNow">--/--/----</span>
        <span class="ctime" id="clockNow">--:--:--</span>
    </div>

    {{-- Info strip --}}
    <div class="info-strip">
        <i class="fas fa-info-circle"></i>
        <p>Tiket QR akan digenerate otomatis. Simpan tiket untuk proses pembayaran saat keluar parkir.</p>
    </div>

    <form action="{{ route('parkir.masuk') }}" method="POST">
        @csrf

        {{-- Plat Nomor --}}
        <div class="sec-label"><i class="fas fa-hashtag me-1"></i>Plat Nomor Kendaraan</div>
        <div class="input-wrap">
            <i class="fas fa-car input-icon"></i>
            <input type="text"
                   name="plat_nomor"
                   class="form-input"
                   placeholder="Contoh: B 1234 ABC"
                   maxlength="15"
                   autocomplete="off"
                   id="platInput">
        </div>
        <p class="input-hint"><i class="fas fa-info-circle me-1"></i>Kosongkan jika tidak diketahui — akan diisi otomatis.</p>

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

        <button type="submit" class="btn-submit">
            <i class="fas fa-ticket-alt me-2"></i> Generate Tiket Parkir
        </button>

    </form>

    <div class="divider">atau</div>

    <a href="{{ route('parkir.scan') }}" class="btn-outline">
        <i class="fas fa-qrcode me-2"></i> Scan QR Kendaraan Keluar
    </a>

    <a href="/dashboard" class="link-back">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
    </a>

</div>

<script>
    // Auto-uppercase plat
    const platInput = document.getElementById('platInput');
    platInput.addEventListener('input', function() {
        const pos = this.selectionStart;
        this.value = this.value.toUpperCase();
        this.setSelectionRange(pos, pos);
    });

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