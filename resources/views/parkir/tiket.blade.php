<!DOCTYPE html>
<html>
<head>
    <title>Tiket Parkir</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
        }

        .full-center {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .ticket-card {
            width: 330px;
            border-radius: 20px;
            background-color: #1e293b;
            box-shadow: 0 20px 40px rgba(0,0,0,0.6);
            padding: 25px;
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }

        .ticket-title {
            font-size: 1.6rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .sub {
            font-size: 12px;
            color: #94a3b8;
            margin-bottom: 15px;
        }

        .qr-container {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }

        .qr-wrapper {
            background: white;
            padding: 12px;
            border-radius: 15px;
        }

        .qr-text {
            font-size: 12px;
            color: #cbd5f5;
            margin-bottom: 15px;
            word-break: break-all;
        }

        .info {
            text-align: left;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .info div {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }

        .btn-group {
            margin-top: 15px;
        }

        .btn {
            display: block;
            padding: 10px;
            border-radius: 10px;
            text-decoration: none;
            margin: 5px 0;
            font-size: 14px;
        }

        .btn-scan {
            background: #22c55e;
            color: white;
        }

        .btn-scan:hover {
            background: #16a34a;
        }

        .btn-download {
            background: #3b82f6;
            color: white;
            font-weight: 600;
        }

        .btn-download:hover {
            background: #2563eb;
        }

        .btn-back {
            background: #64748b;
            color: white;
        }

        .btn-back:hover {
            background: #475569;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

<div class="full-center">

    <div class="ticket-card">

        <div class="ticket-title">🎫 Tiket Parkir</div>
        <div class="sub">Scan QR saat keluar</div>

        <!-- QR -->
        <div class="qr-container">
            <div class="qr-wrapper">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $parkir->qr_code }}">
            </div>
        </div>

        <div class="qr-text">{{ $parkir->qr_code }}</div>

        <!-- INFO -->
        <div class="info">
            <div>
                <span>ID</span>
                <span>#{{ $parkir->id }}</span>
            </div>

            @if($parkir->status_member)
            <div>
                <span>Member</span>
                <span style="color:#22c55e;font-weight:700;">Aktif</span>
            </div>
            @endif

            @if($parkir->kendaraan && !in_array($parkir->kendaraan->jenis_kendaraan, ['unknown', 'Unknown', '']))
            <div>
                <span>Jenis</span>
                <span>{{ $parkir->kendaraan->jenis_kendaraan }}</span>
            </div>
            @endif

            @if($parkir->kendaraan && $parkir->kendaraan->plat_nomor && !str_contains($parkir->kendaraan->plat_nomor, 'PENDING-'))
            <div>
                <span>Plat</span>
                <span>{{ strtoupper($parkir->kendaraan->plat_nomor) }}</span>
            </div>
            @endif

            <div>
                <span>Masuk</span>
                <span>{{ \Carbon\Carbon::parse($parkir->waktu_masuk)->format('H:i') }}</span>
            </div>

        </div>

        <!-- BUTTON -->
        <div class="btn-group">
            
            <button onclick="downloadQR()" class="btn btn-download" style="width:100%; border:none; cursor:pointer;">
                <i class="fa fa-download"></i> Download QR
            </button>

            <a href="{{ route('parkir.scan') }}" class="btn btn-scan">
                <i class="fa fa-qrcode"></i> Scan QR Keluar
            </a>

            <a href="{{ route('dashboard') }}" class="btn btn-back">
                <i class="fa fa-arrow-left"></i> Kembali ke Dashboard
            </a>

        </div>

    </div>

</div>

<script>
function downloadQR() {
    const url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $parkir->qr_code }}";
    fetch(url)
        .then(response => response.blob())
        .then(blob => {
            const blobUrl = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = blobUrl;
            a.download = "QR_Parkir_{{ $parkir->qr_code }}.png";
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(blobUrl);
        })
        .catch(err => {
            alert('Gagal mendownload QR Code. Silakan coba lagi.');
            console.error(err);
        });
}
</script>

</body>
</html>