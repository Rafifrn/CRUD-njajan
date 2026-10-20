<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head')
    <title>Njajan — Admin</title>
    @livewireStyles
</head>
<body class="min-h-screen">
    @include('partials.navbar', ['brandUrl' => route('admin.dashboard'), 'badge' => 'ADMIN', 'links' => [
        ['Dashboard', 'admin.dashboard', 'admin.dashboard'], ['Tenant', 'admin.tenants', 'admin.tenants'],
        ['Pesanan', 'admin.orders', 'admin.orders*'], ['User', 'admin.users', 'admin.users'],
    ]])
    <main class="container mx-auto px-4 py-8 md:py-10">@yield('content')</main>
    @livewireScripts
</body>
</html>
