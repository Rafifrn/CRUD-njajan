<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Njajan — Tenant UMKM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="font-sans bg-amber-50">
    <!-- Navigation -->
    <nav class="bg-coffee-bean text-amber-50 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold">NJAJAN</a>

                <button id="mobile-menu-button" class="md:hidden focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <div class="hidden md:flex space-x-6 items-center">
                    <a href="{{ route('home') }}" class="hover:text-amber-300 transition">Home</a>
                    <a href="{{ route('order') }}" class="hover:text-amber-300 transition">Order</a>
                    <a href="{{ route('pesanan') }}" class="hover:text-amber-300 transition">Pesanan</a>
                    <a href="{{ route('history') }}" class="hover:text-amber-300 transition">History</a>
                    <div class="relative">
                        <button id="userDropdownToggle" class="flex items-center space-x-2 text-amber-50 focus:outline-none">
                            <span>{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white border rounded shadow-md z-10">
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-2 space-y-1">
                <a href="{{ route('home') }}" class="block py-2 hover:text-amber-300">Home</a>
                <a href="{{ route('order') }}" class="block py-2 hover:text-amber-300">Order</a>
                <a href="{{ route('pesanan') }}" class="block py-2 hover:text-amber-300">Pesanan</a>
                <a href="{{ route('history') }}" class="block py-2 hover:text-amber-300">History</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block py-2 hover:text-amber-300">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="min-h-screen bg-amber-50">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Tenant UMKM</h1>
            <p class="text-gray-600 mb-8">Pilih tenant favoritmu, atau langsung jelajahi semua menu di halaman Order.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($tenants as $tenant)
                    <a href="{{ route('order') }}?tenant={{ $tenant->slug }}"
                       class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg hover:border-gray-300 transition-all duration-300 group">
                        <div class="h-36 bg-[#212529] flex items-center justify-center">
                            @if ($tenant->logo)
                                <img src="{{ $tenant->logo }}" alt="{{ $tenant->name }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <span class="text-5xl">🏪</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-800 group-hover:text-gray-900">{{ $tenant->name }}</h3>
                            <p class="text-sm text-gray-600 line-clamp-2 mb-3">{{ $tenant->description }}</p>
                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                <span class="px-2 py-1 bg-gray-100 rounded-full">{{ $tenant->makanans_count }} makanan</span>
                                <span class="px-2 py-1 bg-gray-100 rounded-full">{{ $tenant->minumen_count }} minuman</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-16 text-gray-500">
                        <p class="text-5xl mb-4">🏪</p>
                        <p>Belum ada tenant yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        const toggleBtn = document.getElementById('userDropdownToggle');
        const menu = document.getElementById('userDropdownMenu');
        toggleBtn.addEventListener('click', () => menu.classList.toggle('hidden'));
        window.addEventListener('click', function(e) {
            if (!toggleBtn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
