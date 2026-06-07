<script
src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>

const btn = document.getElementById('pay-button');

btn.addEventListener('click', function () {

    snap.pay('{{ $snapToken }}', {

        onSuccess: function(result) {

            alert("Pembayaran berhasil!");

            window.location.href =
            "{{ route('bayar.sukses', $parkir->id) }}";
        },

        onPending: function(result) {

            alert("Pembayaran QRIS berhasil!");

            window.location.href =
            "{{ route('bayar.sukses', $parkir->id) }}";
        },

        onError: function(result) {

            alert("Pembayaran gagal");
        },

        onClose: function() {

            alert("Popup pembayaran ditutup");
        }

    });

});

</script>