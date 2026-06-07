<!DOCTYPE html>
<html>
<head>

    <title>Pembayaran Member</title>

    <script
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
    </script>

</head>

<body style="
    background:#0f172a;
    color:white;
    font-family:Arial;
    text-align:center;
    padding-top:100px;
">

    <h1>Pembayaran Member</h1>

    <h2>
        Rp {{ number_format($harga,0,',','.') }}
    </h2>

    <button id="pay-button"
            style="
                padding:15px 30px;
                border:none;
                border-radius:12px;
                background:#2563eb;
                color:white;
                font-size:18px;
                cursor:pointer;
            ">

        Bayar Sekarang

    </button>

<script>

document.getElementById('pay-button')
.addEventListener('click', function () {

    snap.pay('{{ $snapToken }}', {

        onSuccess: function(result) {

            alert("Pembayaran berhasil");

            window.location.href =
            "/member/sukses/{{ $member->id }}";
        },

        onPending: function(result) {

            alert("Menunggu pembayaran");
        },

        onError: function(result) {

            alert("Pembayaran gagal");
        }

    });

});

</script>

</body>
</html>