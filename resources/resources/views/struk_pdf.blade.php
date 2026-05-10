<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Parkir</title>
    <style>
        body {
            font-family: monospace;
            font-size: 12px;
        }
        .center {
            text-align: center;
        }
        .line {
            border-top: 1px dashed black;
            margin: 10px 0;
        }
    </style>
</head>
<body>

<div class="center">
    <h3>SMARTPARK</h3>
    <p>Parkir Otomatis</p>
</div>

<div class="line"></div>

<p>ID Tiket: {{ $parkir->id }}</p>
<p>Jenis: {{ $parkir->kendaraan->jenis_kendaraan ?? '-' }}</p>

<p>Masuk: {{ \Carbon\Carbon::parse($parkir->waktu_masuk)->format('d/m/Y H:i') }}</p>
<p>Keluar: 
    {{ $parkir->waktu_keluar 
        ? \Carbon\Carbon::parse($parkir->waktu_keluar)->format('d/m/Y H:i') 
        : '-' }}
</p>

<div class="line"></div>

<p>Durasi: {{ $durasi }} Jam</p>
<p>Tarif/Jam: Rp {{ number_format($tarif->harga_per_jam ?? 0) }}</p>

<div class="line"></div>

<h3 class="center">
    TOTAL: Rp {{ number_format($biaya) }}
</h3>

<div class="line"></div>

<p class="center">Terima kasih</p>

</body>
</html>