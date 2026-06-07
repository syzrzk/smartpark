<!DOCTYPE html>
<html>
<head>
    <title>Struk Parkir</title>

    <style>
        body {
            font-family: 'Courier New', monospace;
            background: #f5f5f5;
        }

        .box {
            width: 340px;
            margin: 40px auto;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 12px;
            color: gray;
        }

        .line {
            border-top: 1px dashed #999;
            margin: 12px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin: 4px 0;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            color: #16a34a;
        }

        .footer {
            font-size: 12px;
            color: gray;
            margin-top: 10px;
        }

        /* BUTTON */
        .btn-area {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            margin: 5px;
        }

        .btn-download {
            background: #3b82f6;
            color: white;
        }

        .btn-download:hover {
            background: #2563eb;
        }

        .btn-back {
            background: #6b7280;
            color: white;
        }

        .btn-back:hover {
            background: #4b5563;
        }
    </style>
</head>

<body>

@php
    use Carbon\Carbon;

    $durasi = 0;

    if ($parkir->waktu_keluar) {
        $durasi = max(1,
            ceil(Carbon::parse($parkir->waktu_masuk)
            ->diffInMinutes($parkir->waktu_keluar) / 60)
        );
    }
@endphp

<div class="box">

    <div class="title">🚗 SMARTPARK</div>
    <div class="subtitle">Parkir Otomatis Modern</div>

    <div class="line"></div>

    <div class="row">
        <span>ID Tiket</span>
        <span>#{{ $parkir->id }}</span>
    </div>

    <div class="row">
        <span>Jenis</span>
        <span>{{ $parkir->kendaraan->jenis_kendaraan ?? '-' }}</span>
    </div>

    <div class="row">
        <span>Masuk</span>
        <span>
            {{ Carbon::parse($parkir->waktu_masuk)->format('d/m/Y H:i') }}
        </span>
    </div>

    <div class="row">
        <span>Keluar</span>
        <span>
            {{ $parkir->waktu_keluar 
                ? Carbon::parse($parkir->waktu_keluar)->format('d/m/Y H:i') 
                : '-' }}
        </span>
    </div>

    <div class="row">
        <span>Durasi</span>
        <span>
            {{ $parkir->waktu_keluar ? $durasi . ' Jam' : '-' }}
        </span>
    </div>

    <div class="line"></div>

    <div class="row">
        <span>Tarif / Jam</span>
        <span>
           Rp {{ number_format($tarif->harga_per_jam ?? 0) }}
        </span>
    </div>

    <div class="line"></div>

    <div class="total">
        @if($parkir->status_member)
            TOTAL: 💚 GRATIS (MEMBER)
        @else
            TOTAL: Rp {{ number_format($parkir->biaya ?? 0) }}
        @endif
    </div>

    <div class="line"></div>

    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ $parkir->qr_code }}">

    <div class="footer">
        Terima kasih <br>
        Simpan struk ini sebagai bukti
    </div>

</div>

<!-- 🔥 BUTTON -->
<div class="btn-area">

    <a href="{{ route('dashboard') }}" class="btn btn-back">
        ⬅ Kembali ke Dashboard
    </a>

    <a href="{{ route('struk.download', $parkir->id) }}" class="btn btn-download">
        ⬇ Download PDF
    </a>

</div>

</body>
</html>