<div class="hero">
    <div class="overlay">
        <div class="scan-card">
            <h2 class="title">Scan QR Code</h2>
            <p class="subtitle">Kendaraan Keluar</p>

            <div id="reader"></div>

            <form id="formKeluar" method="POST" action="/parkir/keluar">
                @csrf
                <input type="hidden" name="qr_code" id="qr_code">
            </form>

            <!-- input manual -->
            <form action="/parkir/keluar" method="POST" class="manual-form">
                @csrf
                <input type="text" name="qr_code" placeholder="Input QR manual">
                <button type="submit">Proses</button>
            </form>

        </div>
    </div>
</div>

<style>
/* BACKGROUND */
.hero {
    height: 100vh;
    background: url('/images/bg.jpg') center/cover no-repeat;
}

/* OVERLAY GELAP TRANSPARAN */
.overlay {
    height: 100%;
    background: rgba(10, 25, 60, 0.7); /* 🔥 warna seperti gambar */
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CARD GLASS */
.scan-card {
    backdrop-filter: blur(10px);
    background: rgba(255,255,255,0.05);
    padding: 30px;
    border-radius: 20px;
    width: 350px;
    color: white;
    text-align: center;
    box-shadow: 0 20px 50px rgba(0,0,0,0.4);
}

/* TEXT */
.title {
    font-size: 1.6rem;
    font-weight: bold;
}

.subtitle {
    font-size: 0.9rem;
    color: #ccc;
    margin-bottom: 20px;
}

/* QR */
#reader {
    width: 100% !important;
    border-radius: 15px;
    overflow: hidden;
    margin-bottom: 20px;
}

/* INPUT */
.manual-form {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.manual-form input {
    flex: 1;
    padding: 8px;
    border-radius: 8px;
    border: none;
    outline: none;
}

.manual-form button {
    padding: 8px 12px;
    border-radius: 8px;
    border: none;
    background: #3b82f6;
    color: white;
    cursor: pointer;
}

.manual-form button:hover {
    background: #2563eb;
}

/* BUTTON CETAK (🔥 MIRIP GAMBAR) */
.btn-cetak {
    display: block;
    padding: 12px;
    border-radius: 12px;
    background: linear-gradient(135deg, #4facfe, #2563eb);
    color: white;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
    box-shadow: 0 5px 20px rgba(37,99,235,0.5);
}

.btn-cetak:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 30px rgba(37,99,235,0.7);
}
</style>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
function onScanSuccess(decodedText) {
    document.getElementById('qr_code').value = decodedText;
    document.getElementById('formKeluar').submit();
}

let html5QrcodeScanner = new Html5QrcodeScanner("reader", {
    fps: 10,
    qrbox: 250
});

html5QrcodeScanner.render(onScanSuccess);
</script>f