<div class="full-center">
    <div class="ticket-card">
        <h3 class="ticket-title">Tiket Parkir</h3>

        <div class="qr-container">
            <div class="qr-wrapper">
                {!! QrCode::size(180)->generate($parkir->qr_code) !!}
            </div>
        </div>

        <p class="qr-text">{{ $parkir->qr_code }}</p>
    </div>
</div>

<style>
.full-center {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f5f5f5;
}

.ticket-card {
    width: 320px;
    border-radius: 20px;
    background-color: #1a1a1a;
    box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #ffffff;
    padding: 25px;
    text-align: center;
}

.ticket-title {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 20px;
}

/* INI BAGIAN PENTING */
.qr-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 15px;
}

.qr-wrapper {
    background-color: #ffffff;
    padding: 15px;
    border-radius: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.qr-text {
    font-size: 0.85rem;
    color: #cccccc;
    word-break: break-all;
}
</style>