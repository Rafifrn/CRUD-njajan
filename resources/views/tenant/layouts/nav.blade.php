<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Njajan — Panel Tenant</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @livewireStyles
</head>
<body class="font-sans bg-slate-50">
    <nav class="bg-coffee-bean text-amber-50 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <a href="/tenant/orders" class="text-2xl font-bold">NJAJAN</a>
                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-mauve-bark">{{ Auth::user()->tenant->name ?? 'Tenant' }}</span>
                </div>
                <button id="mobile-menu-button" class="md:hidden focus:outline-none"><i class="fas fa-bars text-xl"></i></button>
                <div class="hidden md:flex space-x-6 items-center">
                    <a href="{{ route('tenant.orders.page') }}" class="hover:text-amber-300 transition">Pesanan</a>
                    <a href="{{ route('tenant.products') }}" class="hover:text-amber-300 transition">Produk</a>
                    <div class="relative">
                        <button id="userDropdownToggle" class="flex items-center space-x-2 text-amber-50 focus:outline-none">
                            <span>{{ Auth::user()->name }}</span><i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded shadow-md z-10">
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-2 space-y-1">
                <a href="{{ route('tenant.orders.page') }}" class="block py-2 hover:text-amber-300">Pesanan</a>
                <a href="{{ route('tenant.products') }}" class="block py-2 hover:text-amber-300">Produk</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block py-2 hover:text-amber-300">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    @livewireScripts
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
        const toggleBtn = document.getElementById('userDropdownToggle');
        const menu = document.getElementById('userDropdownMenu');
        toggleBtn.addEventListener('click', () => menu.classList.toggle('hidden'));
        window.addEventListener('click', function(e) {
            if (!toggleBtn.contains(e.target) && !menu.contains(e.target)) menu.classList.add('hidden');
        });
    </script>
</body>
</html>
