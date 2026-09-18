<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Gagal - Njajan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream-canvas min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-md border border-warm-gray/20 p-10 max-w-md w-full text-center">
        
        <h1 class="text-3xl font-normal text-forest-shadow mb-3">Pembayaran Gagal</h1>
        <p class="text-warm-gray mb-2">Kode pembayaran: <span class="font-bold text-forest-shadow">{{ $payment->group_code }}</span></p>
        <p class="text-warm-gray mb-8">
            Pesanan kamu tersimpan dengan status <span class="font-bold text-forest-shadow">belum dibayar</span>.
            Kamu bisa mencoba membayar kembali dari halaman Pesanan.
        </p>
        <a href="{{ route('pesanan') }}" class="inline-block px-6 py-3 rounded-full bg-lime-glow hover:bg-lime-glow/90 text-deep-forest font-bold transition-colors">
            Ke Halaman Pesanan
        </a>
    </div>
</body>
</html>
