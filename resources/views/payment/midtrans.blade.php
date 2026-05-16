<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bayar Pesanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @if($isProduction)
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    @endif
</head>
<body>
    <h1>Bayar Pesanan {{ $order->order_code }}</h1>
    <p>Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>

    <button id="pay-button">Bayar Sekarang</button>

    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function () {
                    window.location.href = '{{ route('payment.success') }}';
                },
                onPending: function () {
                    alert('Pembayaran masih pending. Silakan selesaikan pembayaran.');
                },
                onError: function () {
                    window.location.href = '{{ route('payment.failed') }}';
                },
                onClose: function () {
                    alert('Kamu menutup popup pembayaran.');
                }
            });
        });
    </script>
</body>
</html>