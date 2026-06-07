<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran Parkir</title>

    {{-- MIDTRANS SNAP --}}
    <script
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
    </script>

    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            text-align: center;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .card {
            background: white;
            color: black;
            padding: 35px;
            border-radius: 24px;
            width: 360px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h3 {
            margin-top: 0;
            margin-bottom: 20px;
            color: #0f172a;
        }

        h1 {
            color: #16a34a;
            margin: 20px 0;
            font-size: 38px;
        }

        .info {
            font-size: 14px;
            margin-bottom: 12px;
            color: #334155;
        }

        .member-box {
            background: #dcfce7;
            color: #166534;
            padding: 14px;
            border-radius: 14px;
            margin-bottom: 18px;
            font-weight: bold;
            border: 1px solid #86efac;
        }

        button {
            padding: 14px;
            width: 100%;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border: none;
            color: white;
            border-radius: 14px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: 600;
            margin-top: 10px;
        }

        button:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 18px rgba(37,99,235,0.4);
        }

        .divider {
            height: 1px;
            background: #e2e8f0;
            margin: 20px 0;
        }

    </style>
</head>

<body>

<div class="wrapper">

    <div class="card">

        <h3>💳 Pembayaran Parkir</h3>

        {{-- MEMBER --}}
        @if(isset($member) && $member)

        <div class="member-box">
            ✅ MEMBER AKTIF - GRATIS PARKIR
        </div>

        @endif

        <div class="info">
            ID Tiket:
            <b>#{{ $parkir->id }}</b>
        </div>

        <div class="info">
            Durasi:
            <b>{{ $durasi }} Jam</b>
        </div>

        @if($parkir->kendaraan)

        <div class="info">
            Plat Nomor:
            <b>{{ $parkir->kendaraan->plat_nomor }}</b>
        </div>

        <div class="info">
            Kendaraan:
            <b>{{ ucfirst($parkir->kendaraan->jenis_kendaraan) }}</b>
        </div>

        @endif

        <div class="divider"></div>

        <h1>
            @if($parkir->status_member)
                💚 GRATIS (MEMBER)
            @else
                Rp {{ number_format($biaya, 0, ',', '.') }}
            @endif
        </h1>

        {{-- BUTTON BAYAR --}}
        <button id="pay-button">
            💳 Bayar Sekarang
        </button>

        {{-- CASH PAYMENT BUTTON --}}
        <form action="{{ route('parkir.bayarCash', $parkir->id) }}" method="POST" style="margin-top:10px;">
            @csrf
            <button type="submit" style="background: linear-gradient(135deg, #10b981, #059669);">
                💵 Bayar Cash
            </button>
        </form>

    </div>

</div>

<script
src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>

document.getElementById('pay-button')
.addEventListener('click', function (e) {

    e.preventDefault();

    snap.pay('{{ $snapToken }}', {

        onSuccess: function(result) {

            window.location.href =
            "{{ route('bayar.sukses', $parkir->id) }}";
       },
        onPending: function(result) {

            console.log(result);

            alert("Menunggu pembayaran...");
        },

        onError: function(result) {

            console.log(result);

            alert("Pembayaran gagal!");
        },

        onClose: function() {

            alert("Popup ditutup");
        }

    });

});

</script>
