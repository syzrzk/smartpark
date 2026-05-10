<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="YOUR_CLIENT_KEY"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">

<div class="container text-center mt-5">

    <div class="card p-4 shadow bg-black">
        <h3>💳 Pembayaran Parkir</h3>

        <h1 class="text-success">Rp {{ $biaya }}</h1>

        <button id="pay-button" class="btn btn-success btn-lg mt-3">
            Bayar Sekarang
        </button>
    </div>

</div>

<script>
document.getElementById('pay-button').onclick = function () {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function(result){
            alert("Pembayaran sukses!");
            window.location.href = "/struk/{{ $parkir->id }}";
        },
        onPending: function(result){
            alert("Menunggu pembayaran...");
        },
        onError: function(result){
            alert("Pembayaran gagal!");
        }
    });
};
</script>

</body>
</html>