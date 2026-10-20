<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
    <title>@yield('title', 'Njajan — UMKM')</title>
    @yield('styles')
</head>
<body class="min-h-screen">
    @include('partials.navbar', ['links' => [
        ['Beranda', 'home', 'home'], ['Pesan', 'order', 'order'], ['Pesanan', 'pesanan', 'pesanan'], ['Riwayat', 'history', 'history'],
    ]])
    <main class="container mx-auto px-4 py-8 md:py-10">@yield('content')</main>
    @yield('scripts')
</body>
</html>
