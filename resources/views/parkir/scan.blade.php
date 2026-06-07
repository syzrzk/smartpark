<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Keluar - SmartPark</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        *{box-sizing:border-box;margin:0;padding:0;}
        body{background:linear-gradient(135deg,#0a0f1e 0%,#0f1f3d 50%,#0a1628 100%);min-height:100vh;font-family:'Inter',sans-serif;position:relative;overflow-x:hidden;}
        body::before{content:'';position:fixed;inset:0;background-image:radial-gradient(circle,rgba(59,130,246,.10) 1px,transparent 1px);background-size:40px 40px;pointer-events:none;z-index:0;}
        .orb{position:fixed;border-radius:50%;filter:blur(90px);pointer-events:none;z-index:0;}
        .orb-1{width:350px;height:350px;background:#6366f1;opacity:.08;top:-80px;right:-60px;}
        .orb-2{width:280px;height:280px;background:#ef4444;opacity:.07;bottom:-60px;left:-60px;}
        .page-wrap{position:relative;z-index:10;max-width:520px;margin:0 auto;padding:20px 14px;display:flex;flex-direction:column;gap:14px;}
        .top-bar{display:flex;align-items:center;justify-content:space-between;}
        .brand-row{display:flex;align-items:center;gap:10px;}
        .brand-icon-sm{width:38px;height:38px;border-radius:11px;background:linear-gradient(135deg,#ef4444,#dc2626);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(239,68,68,.35);}
        .brand-text-sm{font-size:15px;font-weight:700;color:#f1f5f9;}
        .brand-sub-sm{font-size:10px;color:#475569;}
        .btn-back-top{display:flex;align-items:center;gap:6px;padding:8px 14px;border-radius:10px;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.08);color:#64748b;font-size:12px;font-weight:500;text-decoration:none;transition:all .2s;}
        .btn-back-top:hover{background:rgba(255,255,255,.09);color:#94a3b8;}
        .clock-bar{display:flex;justify-content:space-between;align-items:center;padding:10px 16px;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.06);border-radius:12px;font-size:12px;}
        .clock-bar .ctime{font-weight:700;color:#cbd5e1;font-variant-numeric:tabular-nums;}
        .clock-bar .cdate{color:#475569;}

        /* Alert */
        .alert-err{background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.25);border-radius:10px;padding:11px 14px;font-size:13px;color:#fca5a5;display:flex;align-items:center;gap:8px;}

        /* TABS */
        .tab-bar{display:grid;grid-template-columns:1fr 1fr 1fr;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);border-radius:14px;padding:4px;gap:4px;}
        .tab-btn{padding:9px 4px;border:none;border-radius:10px;background:transparent;color:#475569;font-size:12px;font-weight:600;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:6px;font-family:'Inter',sans-serif;}
        .tab-btn.active{background:rgba(239,68,68,.15);color:#fca5a5;border:1px solid rgba(239,68,68,.25);}
        .tab-btn:hover:not(.active){background:rgba(255,255,255,.06);color:#94a3b8;}

        /* Panel */
        .tab-panel{display:none;}
        .tab-panel.active{display:block;}

        /* Card shared */
        .panel-card{background:rgba(15,23,42,.82);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,.08);border-radius:20px;overflow:hidden;box-shadow:0 20px 50px rgba(0,0,0,.45);}
        .panel-header{padding:18px 20px 14px;border-bottom:1px solid rgba(255,255,255,.06);text-align:center;}
        .panel-header .title{font-size:16px;font-weight:700;color:#f1f5f9;margin-bottom:3px;}
        .panel-header .subtitle{font-size:12px;color:#475569;}
        .panel-body{padding:20px;}

        /* QR Scanner */
        #reader{width:100%!important;}
        #reader video{width:100%!important;max-height:280px;object-fit:cover;}
        .scanner-footer{padding:12px 18px;border-top:1px solid rgba(255,255,255,.06);}
        .status-row{display:flex;align-items:center;gap:10px;padding:10px 14px;border-radius:10px;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.07);}
        .status-dot{width:8px;height:8px;border-radius:50%;flex-shrink:0;}
        .dot-waiting{background:#f59e0b;animation:pulse 1.4s ease-in-out infinite;}
        .dot-success{background:#10b981;}
        .dot-error{background:#ef4444;}
        @keyframes pulse{0%,100%{opacity:1;transform:scale(1);}50%{opacity:.5;transform:scale(.8);}}
        .status-text{font-size:13px;font-weight:500;color:#94a3b8;}

        /* Manual QR input (inside QR tab) */
        .manual-qr-wrap{padding:12px 18px;border-top:1px solid rgba(255,255,255,.06);}
        .sec-label{font-size:10px;font-weight:600;color:#334155;text-transform:uppercase;letter-spacing:.7px;margin-bottom:8px;}
        .input-row{display:flex;gap:8px;}

        /* Plat & Upload inputs */
        .form-input{width:100%;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:10px;padding:12px 14px;color:#f1f5f9;font-size:13px;font-family:'Inter',sans-serif;outline:none;transition:all .2s;margin-bottom:12px;}
        .form-input::placeholder{color:#334155;}
        .form-input:focus{border-color:#ef4444;background:rgba(239,68,68,.06);box-shadow:0 0 0 3px rgba(239,68,68,.12);}
        .form-input-upper{text-transform:uppercase;}

        .upload-zone{border:1.5px dashed rgba(255,255,255,.12);border-radius:12px;padding:20px;text-align:center;cursor:pointer;transition:all .2s;background:rgba(255,255,255,.03);margin-bottom:12px;position:relative;}
        .upload-zone:hover{border-color:rgba(239,68,68,.4);background:rgba(239,68,68,.05);}
        .upload-zone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;}
        .upload-zone .uz-icon{font-size:28px;color:#334155;margin-bottom:8px;}
        .upload-zone .uz-label{font-size:12px;font-weight:600;color:#475569;}
        .upload-zone .uz-sub{font-size:11px;color:#334155;margin-top:3px;}
        .upload-preview{display:none;width:100%;border-radius:10px;max-height:180px;object-fit:contain;margin-bottom:12px;border:1px solid rgba(255,255,255,.1);}

        .btn-red{width:100%;padding:13px;background:linear-gradient(135deg,#ef4444,#dc2626);border:none;border-radius:12px;color:white;font-size:14px;font-weight:600;font-family:'Inter',sans-serif;cursor:pointer;transition:all .2s;box-shadow:0 4px 15px rgba(239,68,68,.3);}
        .btn-red:hover{background:linear-gradient(135deg,#dc2626,#b91c1c);transform:translateY(-1px);}
        .btn-icon{width:42px;min-width:42px;padding:12px;background:rgba(239,68,68,.15);border:1px solid rgba(239,68,68,.25);border-radius:10px;color:#fca5a5;cursor:pointer;font-size:14px;transition:all .2s;font-family:'Inter',sans-serif;}
        .btn-icon:hover{background:rgba(239,68,68,.25);}

        .link-bottom{text-align:center;font-size:12px;color:#334155;text-decoration:none;transition:color .2s;display:block;}
        .link-bottom:hover{color:#60a5fa;}

        /* Hide html5-qrcode cruft */
        #reader__header_message,#reader__status_span,#reader__filescan_input,#reader__dashboard_section_swaplink,#reader__dashboard{display:none!important;}
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
                <i class="fas fa-sign-out-alt" style="color:white;font-size:16px;"></i>
            </div>
            <div>
                <div class="brand-text-sm">Kendaraan Keluar</div>
                <div class="brand-sub-sm">SmartPark &bull; Proses Pembayaran</div>
            </div>
        </div>
        <a href="/dashboard" class="btn-back-top">
            <i class="fas fa-arrow-left"></i> Dashboard
        </a>
    </div>

    {{-- Jam --}}
    <div class="clock-bar">
        <span class="cdate" id="dateNow">--/--/----</span>
        <span class="ctime" id="clockNow">--:--:--</span>
    </div>

    {{-- Alert error dari session --}}
    @if(session('error'))
    <div class="alert-err">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
    </div>
    @endif

    {{-- TAB BAR --}}
    <div class="tab-bar">
        <button class="tab-btn active">
            <i class="fas fa-qrcode"></i> Scan QR
        </button>
    </div>

    {{-- ═══ TAB 1: QR SCAN ═══ --}}
    <div id="tab-qr" class="tab-panel active">
        <div class="panel-card">
            <div class="panel-header">
                <div class="title"><i class="fas fa-qrcode me-2" style="color:#ef4444;"></i>Scan QR Tiket</div>
                <div class="subtitle">Arahkan kamera ke QR code pada tiket parkir</div>
            </div>
            <div id="reader"></div>
            <div class="scanner-footer">
                <div class="status-row">
                    <div class="status-dot dot-waiting" id="statusDot"></div>
                    <span class="status-text" id="statusText">Meminta akses & memuat kamera...</span>
                </div>
            </div>
            {{-- Manual QR --}}
            <div class="manual-qr-wrap">
                <div class="sec-label"><i class="fas fa-keyboard me-1"></i>Input manual kode QR</div>
                <div class="input-row">
                    <input type="text" id="manualQr" class="form-input mb-0" placeholder="Tempel atau ketik kode QR...">
                    <button class="btn-icon" onclick="submitQr(document.getElementById('manualQr').value)">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Link masuk --}}
    <a href="{{ route('masuk.form') }}" class="link-bottom">
        <i class="fas fa-sign-in-alt me-1"></i> Form Kendaraan Masuk
    </a>

</div>

{{-- Hidden form QR --}}
<form id="formKeluar" action="/parkir/keluar" method="POST">
    @csrf
    <input type="hidden" name="qr_code" id="qr_code">
</form>

<script>
// ── Clock ──────────────────────────────────────────
function updateClock() {
    const n = new Date();
    const pad = v => String(v).padStart(2,'0');
    document.getElementById('clockNow').textContent = `${pad(n.getHours())}:${pad(n.getMinutes())}:${pad(n.getSeconds())}`;
    document.getElementById('dateNow').textContent  = `${pad(n.getDate())}/${pad(n.getMonth()+1)}/${n.getFullYear()}`;
}
updateClock(); setInterval(updateClock, 1000);

// ── Tabs ──────────────────────────────────────────

// ── QR Submit ─────────────────────────────────────
let sudahScan = false;

function setStatus(text, type) {
    document.getElementById('statusDot').className = 'status-dot dot-' + type;
    document.getElementById('statusText').textContent = text;
}

function beep() {
    try {
        const ctx = new AudioContext();
        const osc = ctx.createOscillator();
        const g   = ctx.createGain();
        osc.connect(g); g.connect(ctx.destination);
        osc.frequency.value = 880; osc.type = 'sine';
        g.gain.setValueAtTime(0.3, ctx.currentTime);
        g.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.3);
        osc.start(); osc.stop(ctx.currentTime + 0.3);
    } catch(e) {}
}

function submitQr(code) {
    code = (code || '').trim();
    if (!code || sudahScan) return;
    sudahScan = true;
    beep();
    setStatus('QR terdeteksi — memproses...', 'success');
    document.getElementById('qr_code').value = code;
    document.getElementById('formKeluar').submit();
}

document.getElementById('manualQr').addEventListener('keydown', e => {
    if (e.key === 'Enter') submitQr(document.getElementById('manualQr').value);
});

// Auto-start camera directly
const html5QrCode = new Html5Qrcode("reader");
const config = { fps: 10, qrbox: { width: 220, height: 220 } };

// Start camera automatically (delayed to not block page load)
document.addEventListener("DOMContentLoaded", () => {
    setTimeout(() => {
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                // Use environment camera if available, otherwise first camera
                html5QrCode.start(
                    { facingMode: "environment" }, 
                    config,
                    (decodedText) => {
                        submitQr(decodedText);
                    },
                    (errorMessage) => {}
                ).then(() => {
                    setStatus("Kamera siap! Arahkan ke QR Code", "success");
                }).catch(err => {
                    console.log("Gagal memulai kamera:", err);
                    setStatus("Kamera terblokir/tidak dapat diakses", "error");
                });
            } else {
                setStatus("Kamera tidak ditemukan di perangkat", "error");
            }
        }).catch(err => {
            console.log("Error getCameras", err);
            setStatus("Izin kamera ditolak atau bermasalah", "error");
        });
    }, 500);
});

// Stop camera when switching tabs away from QR
function switchTab(name, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
    
    // Auto pause/resume camera
    if(name !== 'qr' && html5QrCode.isScanning) {
        html5QrCode.pause();
    } else if (name === 'qr' && html5QrCode.isScanning) {
        html5QrCode.resume();
    }
}

// ── Foto Preview & Auto Scan (Dipercepat) ───────────────────────────
function previewFoto(input) {
    const file = input.files[0];
    if (!file) return;
    if (file.size > 5 * 1024 * 1024) {
        alert('File terlalu besar. Maksimal 5MB.');
        input.value = '';
        return;
    }

    const img = document.getElementById('fotoPreview');
    const statusDiv = document.getElementById('fotoScanStatus');
    
    statusDiv.style.display = 'block';
    statusDiv.innerHTML = '<i class="fas fa-spinner fa-spin me-2 text-blue-500"></i> Memindai gambar dengan cepat...';
    
    const reader = new FileReader();
    reader.onload = e => {
        img.src = e.target.result;
        img.style.display = 'block';
        document.getElementById('uzContent').innerHTML =
            '<div style="font-size:11px;color:#10b981;font-weight:600;"><i class="fas fa-check-circle me-1"></i>' + file.name + '</div>';
            
        // Gunakan canvas & jsQR untuk scanning instan tanpa bentrok dengan kamera
        img.onload = () => {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d', { willReadFrequently: true });
            
            // Resize jika gambar terlalu besar agar scanning lebih cepat
            const MAX_WIDTH = 800;
            let width = img.width;
            let height = img.height;
            if (width > MAX_WIDTH) {
                height = Math.round((height * MAX_WIDTH) / width);
                width = MAX_WIDTH;
            }
            canvas.width = width;
            canvas.height = height;
            ctx.drawImage(img, 0, 0, width, height);
            
            try {
                const imageData = ctx.getImageData(0, 0, width, height);
                // jsQR ada berkat script tag di bawah
                if (typeof jsQR !== 'undefined') {
                    const code = jsQR(imageData.data, imageData.width, imageData.height, {
                        inversionAttempts: "dontInvert",
                    });
                    
                    if (code && code.data) {
                        statusDiv.innerHTML = '<i class="fas fa-check-circle me-2 text-green-500"></i> QR Code terbaca! Memproses...';
                        setTimeout(() => submitQr(code.data), 300);
                    } else {
                        throw new Error("QR not found");
                    }
                } else {
                    throw new Error("jsQR library not loaded");
                }
            } catch (err) {
                console.error("Scan error:", err);
                statusDiv.innerHTML = '<i class="fas fa-times-circle me-2 text-red-500"></i> Gagal! Tidak ada QR Code valid yang ditemukan di gambar ini.';
                input.value = ''; // Reset input
            }
        };
    };
    reader.readAsDataURL(file);
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>