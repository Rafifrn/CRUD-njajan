<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
    <title>@yield('title', 'Njajan — UMKM')</title>
    @yield('styles')
</head>
<body class="min-h-screen">
    @include('partials.navbar', ['links' => [
        ['Beranda', 'home', 'home'], ['Menu', 'order', 'order'], ['Pesanan Saya', 'pesanan', 'pesanan'], ['Riwayat', 'history', 'history'],
    ]])
    <main class="container mx-auto px-4 py-8 md:py-10" @yield('live')>@yield('content')</main>
    <script>
    // pages that set @section('live') re-fetch themselves and swap <main> only when something changed
    (() => {
        const main = document.querySelector('main[data-live]');
        if (!main) return;
        setInterval(async () => {
            if (document.hidden) return;
            try {
                const html = await (await fetch(location.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })).text();
                const next = new DOMParser().parseFromString(html, 'text/html').querySelector('main');
                if (next && next.innerHTML !== main.innerHTML) main.innerHTML = next.innerHTML;
            } catch (e) { /* offline: try again next tick */ }
        }, 8000);
    })();
    </script>
    @yield('scripts')
</body>
</html>
