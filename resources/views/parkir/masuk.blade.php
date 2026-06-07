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
        .orb-1 { width:350px; height:350px; background:#10b981; opacity:.08; top:-80px; left:-80px; }
        .orb-2 { width:250px; height:250px; background:#6366f1; opacity:.07; bottom:-60px; right:-60px; }

        /* ── CARD ── */
        .form-card {
            position: relative; z-index: 10;
            width: 100%; max-width: 500px;
            background: rgba(15, 23, 42, 0.90);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 24px;
            padding: 28px 28px;
            box-shadow: 0 25px 60px rgba(0,0,0,.55), inset 0 1px 0 rgba(255,255,255,.06);
        }

        /* ── BRAND ── */
        .brand-icon {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 12px;
            box-shadow: 0 8px 24px rgba(16,185,129,.35);
        }
        .brand-title { font-size: 20px; font-weight: 800; color: #f1f5f9; text-align: center; }
        .brand-sub   { font-size: 12px; color: #64748b; text-align: center; margin-top: 3px; margin-bottom: 20px; }

        /* ── CLOCK ── */
        .clock-row {
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 10px; padding: 8px 14px;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .clock-row .ctime { font-weight: 700; color: #10b981; font-variant-numeric: tabular-nums; letter-spacing: 0.5px; }
        .clock-row .cdate { color: #64748b; }

        /* ── CAMERA ── */
        .camera-section {
            position: relative;
            background: #000;
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 16px;
            border: 2px solid rgba(16, 185, 129, 0.25);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.05);
        }

        #videoFeed {
            width: 100%;
            display: block;
            max-height: 280px;
            object-fit: cover;
            border-radius: 14px;
        }

        #photoPreview {
            width: 100%;
            display: none;
            max-height: 280px;
            object-fit: cover;
            border-radius: 14px;
        }

        .camera-label {
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.6);
            color: #10b981;
            font-size: 10px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
            letter-spacing: 1px;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(16, 185, 129, 0.3);
            white-space: nowrap;
        }

        .camera-corner {
            position: absolute;
            width: 20px; height: 20px;
            border-color: #10b981;
            border-style: solid;
            opacity: 0.6;
        }
        .camera-corner.tl { top: 8px; left: 8px; border-width: 2px 0 0 2px; border-radius: 4px 0 0 0; }
        .camera-corner.tr { top: 8px; right: 8px; border-width: 2px 2px 0 0; border-radius: 0 4px 0 0; }
        .camera-corner.bl { bottom: 8px; left: 8px; border-width: 0 0 2px 2px; border-radius: 0 0 0 4px; }
        .camera-corner.br { bottom: 8px; right: 8px; border-width: 0 2px 2px 0; border-radius: 0 0 4px 0; }

        /* ── CAMERA STATUS ── */
        .cam-status {
            display: flex; align-items: center; gap: 8px;
            padding: 10px 14px;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 10px;
            font-size: 12px;
            color: #94a3b8;
            margin-bottom: 16px;
        }
        .cam-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #f59e0b;
            animation: blink 1.4s ease-in-out infinite;
            flex-shrink: 0;
        }
        .cam-dot.active { background: #10b981; animation: none; }
        .cam-dot.error  { background: #ef4444; animation: none; }
        @keyframes blink { 0%,100%{opacity:1;} 50%{opacity:0.3;} }

        /* ── BUTTON ── */
        .btn-submit {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #10b981, #059669);
            border: none; border-radius: 12px;
            color: white; font-size: 15px; font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer; transition: all .2s;
            box-shadow: 0 6px 20px rgba(16,185,129,.35);
            margin-bottom: 10px;
            position: relative;
            overflow: hidden;
        }
        .btn-submit::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.08), transparent);
            pointer-events: none;
        }
        .btn-submit:hover { background: linear-gradient(135deg,#059669,#047857); transform: translateY(-2px); box-shadow: 0 10px 25px rgba(16,185,129,.4); }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

        .btn-outline {
            width: 100%; padding: 10px;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 10px; color: #64748b;
            font-size: 12px; font-weight: 500;
            font-family: 'Inter', sans-serif;
            cursor: pointer; transition: all .2s;
            text-decoration: none; display: block; text-align: center;
            margin-bottom: 8px;
        }
        .btn-outline:hover { background: rgba(255,255,255,.08); color: #94a3b8; }

        .link-back {
            display: block; text-align: center;
            font-size: 11px; color: #475569;
            text-decoration: none; transition: color .2s;
        }
        .link-back:hover { color: #60a5fa; }

        /* ── INFO BOX ── */
        .info-strip {
            background: rgba(16,185,129,.08); border: 1px solid rgba(16,185,129,.2);
            border-radius: 10px; padding: 10px 14px;
            display: flex; align-items: flex-start; gap: 8px;
            margin-bottom: 16px;
        }
        .info-strip i { color: #10b981; font-size: 13px; flex-shrink: 0; margin-top: 1px; }
        .info-strip p { font-size: 11px; color: #6ee7b7; margin: 0; line-height: 1.5; }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div class="form-card">

    {{-- Brand --}}
    <div class="brand-icon">
        <i class="fas fa-sign-in-alt" style="color:white; font-size:22px;"></i>
    </div>
    <div class="brand-title">Kendaraan Masuk</div>
    <div class="brand-sub">Ambil foto kendaraan dan generate tiket parkir</div>

    {{-- Jam --}}
    <div class="clock-row">
        <span class="cdate" id="dateNow">--/--/----</span>
        <span class="ctime" id="clockNow">--:--:--</span>
    </div>

    {{-- Info --}}
    <div class="info-strip">
        <i class="fas fa-camera"></i>
        <p>Posisikan kendaraan di depan kamera, lalu tekan <strong>Generate Tiket Parkir</strong>. Foto akan tersimpan otomatis sebagai bukti masuk.</p>
    </div>

    {{-- Camera Status --}}
    <div class="cam-status">
        <div class="cam-dot" id="camDot"></div>
        <span id="camStatusText">Menginisialisasi kamera...</span>
    </div>

    {{-- Camera Preview --}}
    <div class="camera-section">
        <video id="videoFeed" autoplay playsinline muted></video>
        <img id="photoPreview" alt="Foto kendaraan masuk">
        <div class="camera-corner tl"></div>
        <div class="camera-corner tr"></div>
        <div class="camera-corner bl"></div>
        <div class="camera-corner br"></div>
        <div class="camera-label" id="cameraLabel">
            <i class="fas fa-video me-1"></i> LIVE
        </div>
    </div>

    {{-- Hidden canvas for capturing --}}
    <canvas id="snapCanvas" style="display:none;"></canvas>

    <!-- Load html5-qrcode library - MORE ROBUST QR detection -->
    {{-- Form to submit --}}
    <form action="{{ route('parkir.masuk') }}" method="POST" id="masukForm">
        @csrf
        <input type="hidden" name="foto_masuk_data" id="fotoMasukData">
        <input type="hidden" name="member_qr_code" id="memberQrCode" value="">

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="info-strip" style="background: rgba(239,68,68,0.08); border-color: rgba(239,68,68,0.2);">
                <i class="fas fa-exclamation-triangle" style="color:#ef4444"></i>
                <div>
                    <strong>Terjadi kesalahan:</strong>
                    <ul style="margin:6px 0 0 18px; color:#ffdede;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Jenis Kendaraan (wajib untuk proses tiket reguler) --}}
        <div style="margin-bottom:12px;">
            <label for="jenis_kendaraan" style="display:block; font-size:13px; color:#cbd5e1; margin-bottom:6px;">Jenis Kendaraan</label>
            <select name="jenis_kendaraan" id="jenis_kendaraan" style="width:100%; padding:10px 12px; border-radius:10px; background:rgba(255,255,255,0.03); color:#e2e8f0; border:1px solid rgba(255,255,255,0.06);">
                <option value="motor">Motor</option>
                <option value="mobil">Mobil</option>
            </select>
        </div>

        <a href="{{ route('parkir.masuk.member') }}" class="btn-submit text-decoration-none text-white d-flex justify-content-center align-items-center" style="margin-bottom:10px;">
            <i class="fas fa-id-card me-2"></i> Scan Member QR
        </a>

        <button type="button" class="btn-submit" id="btnGenerate">
            <i class="fas fa-ticket-alt me-2"></i> Generate Tiket Parkir
        </button>
    </form>

    <div class="d-grid gap-2">
        <a href="{{ route('parkir.scan') }}" class="btn-outline">
            <i class="fas fa-qrcode me-2"></i> Scan QR Kendaraan Keluar
        </a>

        <a href="/dashboard" class="link-back">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>

</div>

<script>
    // ── Clock ──────────────────────────────────────────
    function updateClock() {
        const n = new Date();
        const p = v => String(v).padStart(2, '0');
        document.getElementById('clockNow').textContent = `${p(n.getHours())}:${p(n.getMinutes())}:${p(n.getSeconds())}`;
        document.getElementById('dateNow').textContent  = `${p(n.getDate())}/${p(n.getMonth()+1)}/${n.getFullYear()}`;
    }
    updateClock();
    setInterval(updateClock, 1000);

    // ── Camera ─────────────────────────────────────────
    const video      = document.getElementById('videoFeed');
    const canvas     = document.getElementById('snapCanvas');
    const preview    = document.getElementById('photoPreview');
    const camDot     = document.getElementById('camDot');
    const camStatus  = document.getElementById('camStatusText');
    const cameraLabel = document.getElementById('cameraLabel');
    const btnGenerate = document.getElementById('btnGenerate');
    const form        = document.getElementById('masukForm');
    let stream        = null;
    let cameraReady   = false;

    function setCamStatus(text, type) {
        camStatus.textContent = text;
        camDot.className = 'cam-dot' + (type === 'active' ? ' active' : type === 'error' ? ' error' : '');
    }

    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'environment', width: { ideal: 1280 }, height: { ideal: 720 } },
                audio: false
            });
            video.srcObject = stream;
            video.onloadedmetadata = async () => {
                try {
                    await video.play();
                } catch (err) {
                    console.warn('Video play error:', err);
                }
                cameraReady = true;
                setCamStatus('Kamera aktif — siap mengambil foto', 'active');
                cameraLabel.innerHTML = '<i class="fas fa-circle text-danger me-1" style="font-size:8px;animation:blink 1s infinite;"></i> LIVE';
            };
        } catch (err) {
            console.error('Kamera error:', err);
            setCamStatus('Kamera tidak dapat diakses. Foto akan dilewati.', 'error');
            cameraLabel.innerHTML = '<i class="fas fa-video-slash me-1"></i> OFFLINE';
            cameraReady = false;
        }
    }

    startCamera();

    function capturePhoto() {
        if (!cameraReady || !stream) {
            return;
        }
        canvas.width  = video.videoWidth  || 640;
        canvas.height = video.videoHeight || 480;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        const dataUrl = canvas.toDataURL('image/jpeg', 0.85);
        document.getElementById('fotoMasukData').value = dataUrl;
        preview.src = dataUrl;
        preview.style.display = 'block';
        video.style.display = 'none';
        cameraLabel.innerHTML = '<i class="fas fa-camera-retro me-1"></i> FOTO DIAMBIL';
        stream.getTracks().forEach(t => t.stop());
    }

    btnGenerate.addEventListener('click', function() {
        btnGenerate.disabled = true;
        btnGenerate.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
        capturePhoto();
        setTimeout(() => form.submit(), 500);
    });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>