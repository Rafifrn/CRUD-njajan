<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - Njajan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream-canvas min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-md border border-warm-gray/20 p-10 max-w-md w-full text-center">
        
        <h1 class="text-3xl font-normal text-forest-shadow mb-3">Pembayaran Berhasil!</h1>
        <p class="text-warm-gray mb-2">Kode pembayaran: <span class="font-bold text-forest-shadow">{{ $payment->group_code }}</span></p>
        <p class="text-warm-gray mb-8">
            Total: <span class="font-bold text-deep-forest text-xl">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span>
        </p>

        <div class="text-left bg-sage-mist/30 rounded-lg p-5 mb-8 space-y-3">
            @foreach ($payment->orders as $order)
                <div class="flex justify-between text-sm">
                    <span class="text-forest-shadow font-medium">{{ $order->tenant->name ?? '-' }} ({{ $order->kode }})</span>
                    <span class="font-bold text-deep-forest">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            @endforeach
            <p class="text-xs text-warm-gray pt-3 border-t border-warm-gray/20">
                Pesanan kamu sudah diteruskan ke masing-masing tenant. Pantau statusnya di halaman Pesanan.
            </p>
        </div>

        <div class="flex gap-3 justify-center">
            <a href="{{ route('struk', $payment->group_code) }}" class="px-6 py-3 rounded-full bg-lime-glow hover:bg-lime-glow/90 text-deep-forest font-bold transition-colors">
                Lihat Struk
            </a>
            <a href="{{ route('pesanan') }}" class="px-6 py-3 rounded-full bg-sage-mist hover:bg-sage-mist/80 text-deep-forest font-bold transition-colors">
                Pesanan Saya
            </a>
        </div>
    </div>
</body>
</html>
