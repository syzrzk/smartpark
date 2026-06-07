<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Member QR - SmartPark</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #0a0f1e 0%, #0f1f3d 50%, #0a1628 100%); min-height: 100vh; font-family: 'Inter', sans-serif; display:flex; justify-content:center; align-items:center; padding:20px; margin:0; }
        .form-card { width:100%; max-width:520px; background: rgba(15,23,42,0.94); border:1px solid rgba(255,255,255,0.08); border-radius:24px; padding:28px; box-shadow:0 25px 60px rgba(0,0,0,0.55); color:#e2e8f0; }
        .brand-title { font-size:22px; font-weight:800; color:#f8fafc; margin-bottom:6px; }
        .brand-sub { font-size:13px; color:#94a3b8; margin-bottom:20px; }
        .info-strip { display:flex; align-items:flex-start; gap:10px; background:rgba(30,41,59,0.8); border:1px solid rgba(148,163,184,0.15); border-radius:14px; padding:14px; margin-bottom:18px; }
        .info-strip i { color:#38bdf8; font-size:16px; margin-top:3px; }
        .info-strip p { margin:0; font-size:13px; color:#cbd5e1; line-height:1.5; }
        .scanner-panel { background:#020617; border:1px solid rgba(255,255,255,0.08); border-radius:18px; overflow:hidden; margin-bottom:18px; }
        #qr-reader { width:100%; min-height:320px; }
        .status-bar { display:flex; justify-content:space-between; align-items:center; gap:10px; padding:10px 14px; background:rgba(15,23,42,0.9); border:1px solid rgba(148,163,184,0.12); border-radius:14px; margin-bottom:18px; font-size:13px; color:#cbd5e1; }
        .btn-submit { width:100%; padding:14px; background: linear-gradient(135deg, #10b981, #059669); border:none; border-radius:12px; color:white; font-weight:700; cursor:pointer; transition:all .2s; }
        .btn-submit:hover { transform: translateY(-1px); }
        .link-back { display:block; text-align:center; margin-top:12px; color:#94a3b8; text-decoration:none; font-size:13px; }
        .link-back:hover { color:#60a5fa; }
    </style>
</head>
<body>
    <div class="form-card">
        <div class="brand-title">Scan Member QR</div>
        <div class="brand-sub">Scan member card terpisah untuk masuk otomatis dan langsung dapat tiket.</div>

        <div class="info-strip">
            <i class="fas fa-qrcode"></i>
            <p>Pastikan QR MEMBER terlihat jelas di depan kamera. Setelah terdeteksi, sistem akan menyimpan data kendaraan dan menampilkan tiket parkir.</p>
        </div>

        <div class="scanner-panel">
            <div id="qr-reader"></div>
        </div>

        <div class="status-bar">
            <div>
                <strong>Status:</strong> <span id="scanStatus">Menunggu QR member...</span>
            </div>
            <div id="scanHint">Izinkan akses kamera jika diminta.</div>
        </div>

        <form action="{{ route('parkir.masuk') }}" method="POST" id="memberForm">
            @csrf
            <input type="hidden" name="member_qr_code" id="memberQrCode" value="">
        </form>

        <button class="btn-submit" id="btnBackHome" type="button">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Halaman Masuk
        </button>
        <a href="/dashboard" class="link-back">Kembali ke Dashboard</a>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js"></script>
    <script>
        const statusText = document.getElementById('scanStatus');
        const scanHint = document.getElementById('scanHint');
        const memberQrCodeInput = document.getElementById('memberQrCode');
        const memberForm = document.getElementById('memberForm');
        const qrReader = document.getElementById('qr-reader');
        const btnBackHome = document.getElementById('btnBackHome');

        function setStatus(message, isError = false) {
            statusText.textContent = message;
            statusText.style.color = isError ? '#f87171' : '#90cdf4';
        }

        btnBackHome.addEventListener('click', function() {
            window.location.href = '{{ route('masuk.form') }}';
        });

        const html5QrCode = new Html5Qrcode('qr-reader');
        // Tingkatkan fps, qrbox, dan disableFlip untuk deteksi lebih baik
        const config = { 
            fps: 30, 
            qrbox: { width: 350, height: 350 }, 
            aspectRatio: 1.0, 
            disableFlip: true,
            experimentalFeatures: {
                useBarcoderWorker: true
            }
        };

        let scanAttempts = 0;
        const maxScanAttempts = 100;
        let hasDetected = false;

        function startScan() {
            html5QrCode.start(
                { facingMode: 'environment' },
                config,
                (decodedText, decodedResult) => {
                    scanAttempts++;
                    
                    // Log setiap deteksi untuk debugging
                    console.log(`[Scan #${scanAttempts}] QR terdeteksi: ${decodedText}`);
                    
                    // Cek apakah QR dimulai dengan MEMBER-
                    if (decodedText && decodedText.startsWith('MEMBER-')) {
                        if (!hasDetected) {
                            hasDetected = true;
                            setStatus('✓ QR member terdeteksi! Memproses...', false);
                            memberQrCodeInput.value = decodedText.trim();
                            
                            html5QrCode.stop().then(() => {
                                console.log('Scanner dihentikan, form dikirim');
                                memberForm.submit();
                            }).catch(err => {
                                console.warn('Gagal hentikan scanner, submit form anyway:', err);
                                memberForm.submit();
                            });
                        }
                    }
                },
                (errorMessage) => {
                    // Log error minimal, jangan terlalu sering
                    if (scanAttempts % 50 === 0) {
                        console.debug(`[Scan attempt ${scanAttempts}] Tidak ada QR terdeteksi`);
                    }
                }
            ).catch(err => {
                setStatus('Gagal mengakses kamera. Periksa izin browser.', true);
                scanHint.textContent = 'Refresh halaman dan izinkan kamera.';
                console.error('Kamera error:', err);
            });
        }

        // Tunggu sebentar sebelum mulai scan agar kamera siap
        setTimeout(() => {
            setStatus('Menunggu QR member...', 'loading');
            startScan();
        }, 1000);
    </script>
</body>
</html>
