<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
    <title>Njajan — Panel Tenant</title>
    @livewireStyles
</head>
<body class="min-h-screen">
    @include('partials.navbar', ['brandUrl' => route('tenant.orders.page'), 'badge' => Auth::user()->tenant->name ?? 'Tenant', 'links' => [
        ['Pesanan', 'tenant.orders.page', 'tenant.orders*'], ['Produk', 'tenant.products', 'tenant.products'],
    ]])
    <main class="container mx-auto px-4 py-8 md:py-10">@yield('content')</main>
    @livewireScripts
</body>
</html>
