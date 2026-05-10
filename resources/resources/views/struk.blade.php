<style>
body {
    font-family: 'Courier New', monospace;
    background: #f5f5f5;
}

/* BOX STRUK */
.box {
    width: 320px;
    margin: auto;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    text-align: center;
}

/* TEXT */
.title {
    font-size: 20px;
    font-weight: bold;
    letter-spacing: 2px;
}

.subtitle {
    font-size: 12px;
    color: gray;
}

.line {
    border-top: 1px dashed #999;
    margin: 12px 0;
}

.text-left {
    text-align: left;
    font-size: 14px;
}

.text-right {
    float: right;
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

/* 🔥 BUTTON */
.btn-area {
    text-align: center;
    margin-top: 20px;
}

.btn-cetak {
    display: inline-block;
    padding: 10px 15px;
    background: #3b82f6;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    margin: 5px;
}

.btn-cetak:hover {
    background: #2563eb;
}
</style>

<div class="box">

    <div class="title">SMARTPARK</div>
    <div class="subtitle">Parkir Otomatis Modern</div>

    <div class="line"></div>

    <div class="text-left">
        ID Tiket <span class="text-right">#{{ $parkir->id }}</span><br>
        Jenis <span class="text-right">
            {{ $parkir->kendaraan->jenis_kendaraan ?? '-' }}
        </span><br>

        Masuk <span class="text-right">
            {{ \Carbon\Carbon::parse($parkir->waktu_masuk)->format('d/m/Y H:i') }}
        </span><br>

        Keluar <span class="text-right">
            {{ $parkir->waktu_keluar 
                ? \Carbon\Carbon::parse($parkir->waktu_keluar)->format('d/m/Y H:i') 
                : '-' }}
        </span><br>

        Durasi <span class="text-right">
            @if($parkir->waktu_keluar)
                {{ \Carbon\Carbon::parse($parkir->waktu_masuk)->diffInHours($parkir->waktu_keluar) }} Jam
            @else
                -
            @endif
        </span>
    </div>

    <div class="line"></div>

    <div class="text-left">
        Tarif/Jam 
        <span class="text-right">
            Rp {{ number_format($tarif->harga_per_jam ?? 0) }}
        </span>
    </div>

    <div class="line"></div>

    <div class="total">
        TOTAL: Rp {{ number_format($parkir->biaya ?? 0) }}
    </div>

    <div class="line"></div>

    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ $parkir->qr_code }}">

    <div class="footer">
        Terima kasih <br>
        Simpan struk ini sebagai bukti
    </div>

</div>

<!-- 🔥 TOMBOL DI LUAR BOX -->
<div class="btn-area">
 <a href="{{ route('struk.download', $parkir->id) }}" class="btn-cetak">
    ⬇ Download PDF
</a>

</div>