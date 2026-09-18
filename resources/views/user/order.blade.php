<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Njajan — Order</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .cart-slide-in { animation: slideIn .3s ease-out; }
        @keyframes slideIn { from { transform: translateX(100%); } to { transform: translateX(0); } }
    </style>
</head>
<body class="bg-amber-50">
    <!-- Navigation -->
    <nav class="bg-coffee-bean text-amber-50 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold tracking-wide">NJAJAN</a>

                <button id="mobile-menu-button" class="md:hidden focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('home') }}" class="hover:text-amber-300 transition font-medium">Home</a>
                    <a href="{{ route('order') }}" class="hover:text-amber-300 transition font-medium">Order</a>
                    <a href="{{ route('pesanan') }}" class="hover:text-amber-300 transition font-medium">Pesanan</a>
                    <a href="{{ route('history') }}" class="hover:text-amber-300 transition font-medium">History</a>
                    <div class="relative">
                        <button id="userDropdownToggle" class="flex items-center space-x-2 focus:outline-none hover:text-amber-300 transition">
                            <span class="font-medium">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200/20 rounded-lg shadow-lg z-10">
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 text-gray-800 hover:bg-amber-50 transition rounded-lg">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-2 space-y-2">
                <a href="{{ route('home') }}" class="block py-2 hover:text-amber-300 transition">Home</a>
                <a href="{{ route('order') }}" class="block py-2 hover:text-amber-300 transition">Order</a>
                <a href="{{ route('pesanan') }}" class="block py-2 hover:text-amber-300 transition">Pesanan</a>
                <a href="{{ route('history') }}" class="block py-2 hover:text-amber-300 transition">History</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block py-2 hover:text-amber-300 transition">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="min-h-screen">
        <!-- Filter bar -->
        <div class="bg-white shadow-sm border-b border-gray-200/20 py-5">
            <div class="container mx-auto px-4 space-y-4">
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-gray-800">Kategori:</span>
                        <button onclick="filterCategory('semua')" data-cat="semua" class="cat-btn px-4 py-2 rounded-full text-sm border border-gray-200 transition">Semua</button>
                        <button onclick="filterCategory('makanan')" data-cat="makanan" class="cat-btn px-4 py-2 rounded-full text-sm border border-gray-200 transition">Makanan</button>
                        <button onclick="filterCategory('jajanan')" data-cat="jajanan" class="cat-btn px-4 py-2 rounded-full text-sm border border-gray-200 transition">Jajanan</button>
                        <span class="w-px h-6 bg-warm-gray/30 mx-1"></span>
                        <button onclick="filterCategory('minuman')" data-cat="minuman" class="cat-btn px-4 py-2 rounded-full text-sm border border-gray-200 transition">Minuman</button>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-gray-800">Tenant:</span>
                        <select id="filter-tenant" onchange="filterTenant(this.value)"
                                class="px-4 py-2 border border-gray-200 rounded-lg bg-white text-gray-800 focus:ring-2 focus:ring-deep-forest focus:border-transparent outline-none transition min-w-48">
                            <option value="semua">Semua Tenant</option>
                            @foreach ($tenants as $tenant)
                                <option value="{{ $tenant->slug }}" @if(request('tenant') === $tenant->slug) selected @endif>{{ $tenant->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <div class="space-y-8">
                <!-- Cart -->
                <div id="cart-container" class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200/20 hidden">
                    <div class="px-6 py-5 bg-[#212529]">
                        <h3 class="text-2xl font-bold text-amber-50 flex items-center">
                            
                            Keranjang Belanja
                            <span id="cart-count" class="ml-3 bg-mauve-bark text-gray-900 text-sm font-bold px-3 py-1 rounded-full">0</span>
                        </h3>
                        <div id="cart-tenants" class="mt-3 text-sm text-amber-50/90 space-y-1"></div>
                        <p id="cart-note" class="mt-2 text-xs text-amber-700"></p>
                    </div>
                    <div class="px-6 py-4">
                        <div id="cart-items" class="space-y-3 mb-4"></div>
                        <div class="border-t border-gray-200/20 pt-4 flex items-center justify-between">
                            <span class="text-xl font-bold text-gray-800">Total</span>
                            <span id="cart-total" class="text-2xl font-bold text-gray-900">Rp0</span>
                        </div>
                        <button id="checkout-btn" onclick="checkout()"
                                class="w-full mt-4 bg-mauve-bark hover:bg-mauve-bark/90 text-gray-900 font-bold py-4 rounded-full transition-colors">
                            Checkout
                        </button>
                    </div>
                </div>

                <!-- Menu Items -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($makanans as $makanan)
                        <div class="item-card bg-white rounded-xl shadow-sm border border-gray-200/20 overflow-hidden hover:shadow-md hover:border-deep-forest/30 transition-all duration-300"
                             data-category="{{ strtolower($makanan->category ?? 'makanan') }}"
                             data-tenant="{{ $makanan->tenant->slug ?? '' }}">
                            <div class="h-48 bg-amber-50 overflow-hidden">
                                @if ($makanan->image)
                                    @if (str_starts_with($makanan->image, 'http'))
                                        <img src="{{ $makanan->image }}" alt="{{ $makanan->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    @else
                                        <img src="{{ asset('storage/' . $makanan->image) }}" alt="{{ $makanan->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    @endif
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold">No Image</div>
                                @endif
                            </div>
                            <div class="p-5">
                                <h4 class="font-bold text-lg text-gray-800 mb-1">{{ $makanan->name }}</h4>
                                <p class="text-xs text-gray-600 mb-2">{{ $makanan->tenant->name ?? 'Tenant' }}</p>
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $makanan->description }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-gray-900">Rp{{ number_format($makanan->price, 0, ',', '.') }}</span>
                                    @if ($makanan->is_available)
                                        <div id="order-controls-makanan-{{ $makanan->id }}" class="order-controls">
                                            <button onclick="addToCart('makanan', {{ $makanan->id }}, '{{ $makanan->name }}', {{ $makanan->price }}, '{{ $makanan->tenant->name ?? '' }}')"
                                                    class="add-btn bg-mauve-bark hover:bg-mauve-bark/90 text-gray-900 font-bold px-5 py-2 rounded-full transition-colors text-sm">
                                                Tambah
                                            </button>
                                            <div class="qty-controls hidden flex items-center gap-2">
                                                <button onclick="updateQuantity('makanan', {{ $makanan->id }}, -1)"
                                                        class="w-8 h-8 bg-[#212529]/10 hover:bg-[#212529]/20 text-gray-900 rounded-full font-bold">−</button>
                                                <span class="qty-display font-bold text-gray-800 min-w-[24px] text-center">0</span>
                                                <button onclick="updateQuantity('makanan', {{ $makanan->id }}, 1)"
                                                        class="w-8 h-8 bg-[#212529] hover:bg-[#212529]/90 text-amber-50 rounded-full font-bold">+</button>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-sm text-red-600 font-medium">Tidak Tersedia</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach ($minumans as $minuman)
                        <div class="item-card bg-white rounded-xl shadow-sm border border-gray-200/20 overflow-hidden hover:shadow-md hover:border-deep-forest/30 transition-all duration-300"
                             data-category="minuman"
                             data-tenant="{{ $minuman->tenant->slug ?? '' }}">
                            <div class="h-48 bg-amber-50 overflow-hidden">
                                @if ($minuman->image)
                                    @if (str_starts_with($minuman->image, 'http'))
                                        <img src="{{ $minuman->image }}" alt="{{ $minuman->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    @else
                                        <img src="{{ asset('storage/' . $minuman->image) }}" alt="{{ $minuman->name }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    @endif
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold">No Image</div>
                                @endif
                            </div>
                            <div class="p-5">
                                <h4 class="font-bold text-lg text-gray-800 mb-1">{{ $minuman->name }}</h4>
                                <p class="text-xs text-gray-600 mb-2">{{ $minuman->tenant->name ?? 'Tenant' }}</p>
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $minuman->description }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-bold text-gray-900">Rp{{ number_format($minuman->price, 0, ',', '.') }}</span>
                                    @if ($minuman->is_available)
                                        <div id="order-controls-minuman-{{ $minuman->id }}" class="order-controls">
                                            <button onclick="addToCart('minuman', {{ $minuman->id }}, '{{ $minuman->name }}', {{ $minuman->price }}, '{{ $minuman->tenant->name ?? '' }}')"
                                                    class="add-btn bg-mauve-bark hover:bg-mauve-bark/90 text-gray-900 font-bold px-5 py-2 rounded-full transition-colors text-sm">
                                                Tambah
                                            </button>
                                            <div class="qty-controls hidden flex items-center gap-2">
                                                <button onclick="updateQuantity('minuman', {{ $minuman->id }}, -1)"
                                                        class="w-8 h-8 bg-[#212529]/10 hover:bg-[#212529]/20 text-gray-900 rounded-full font-bold">−</button>
                                                <span class="qty-display font-bold text-gray-800 min-w-[24px] text-center">0</span>
                                                <button onclick="updateQuantity('minuman', {{ $minuman->id }}, 1)"
                                                        class="w-8 h-8 bg-[#212529] hover:bg-[#212529]/90 text-amber-50 rounded-full font-bold">+</button>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-sm text-red-600 font-medium">Tidak Tersedia</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('userDropdownToggle');
        const menu = document.getElementById('userDropdownMenu');
        toggleBtn.addEventListener('click', () => menu.classList.toggle('hidden'));
        window.addEventListener('click', function(e) {
            if (!toggleBtn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });

        let cart = {};
        let activeCategory = 'semua';
        let activeTenant = '{{ request('tenant') ?? 'semua' }}';

        function filterCategory(cat) {
            activeCategory = cat;
            document.querySelectorAll('.cat-btn').forEach(btn => {
                if (btn.dataset.cat === cat) {
                    btn.classList.add('bg-[#212529]', 'text-amber-50', 'border-deep-forest');
                    btn.classList.remove('bg-white', 'text-gray-800', 'border-gray-200');
                } else {
                    btn.classList.remove('bg-[#212529]', 'text-amber-50', 'border-deep-forest');
                    btn.classList.add('bg-white', 'text-gray-800', 'border-gray-200');
                }
            });
            applyFilters();
        }

        function filterTenant(slug) {
            activeTenant = slug;
            applyFilters();
        }

        function applyFilters() {
            document.querySelectorAll('.item-card').forEach(card => {
                const cardCat = card.dataset.category;
                const cardTenant = card.dataset.tenant;
                const catMatch = activeCategory === 'semua' || cardCat === activeCategory;
                const tenantMatch = activeTenant === 'semua' || cardTenant === activeTenant;
                card.style.display = (catMatch && tenantMatch) ? 'block' : 'none';
            });
        }

        filterCategory(activeCategory);

        function addToCart(productType, id, name, price, tenantName) {
            const key = `${productType}-${id}`;
            if (!cart[key]) {
                cart[key] = { productType, id, name, price, tenantName, qty: 0 };
            }
            cart[key].qty += 1;
            updateCartDisplay();
            updateOrderControls(productType, id);
        }

        function updateQuantity(productType, id, delta) {
            const key = `${productType}-${id}`;
            if (!cart[key]) return;
            cart[key].qty += delta;
            if (cart[key].qty <= 0) {
                delete cart[key];
            }
            updateCartDisplay();
            updateOrderControls(productType, id);
        }

        function removeFromCart(productType, id) {
            const key = `${productType}-${id}`;
            delete cart[key];
            updateCartDisplay();
            updateOrderControls(productType, id);
        }

        function updateOrderControls(productType, id) {
            const key = `${productType}-${id}`;
            const container = document.getElementById(`order-controls-${productType}-${id}`);
            if (!container) return;

            const addBtn = container.querySelector('.add-btn');
            const qtyControls = container.querySelector('.qty-controls');
            const qtyDisplay = container.querySelector('.qty-display');

            if (cart[key] && cart[key].qty > 0) {
                addBtn.classList.add('hidden');
                qtyControls.classList.remove('hidden');
                qtyDisplay.textContent = cart[key].qty;
            } else {
                addBtn.classList.remove('hidden');
                qtyControls.classList.add('hidden');
            }
        }

        function updateCartDisplay() {
            const cartContainer = document.getElementById('cart-container');
            const cartItemsEl = document.getElementById('cart-items');
            const cartTotalEl = document.getElementById('cart-total');
            const cartCount = document.getElementById('cart-count');
            const cartTenants = document.getElementById('cart-tenants');
            const cartNote = document.getElementById('cart-note');

            cartItemsEl.innerHTML = '';
            cartTenants.innerHTML = '';

            let total = 0;
            let itemCount = 0;
            const byTenant = {};

            Object.values(cart).forEach(item => {
                byTenant[item.tenantName] = (byTenant[item.tenantName] || 0) + item.price * item.qty;
                total += item.price * item.qty;
                itemCount += item.qty;

                const row = document.createElement('div');
                row.className = 'flex items-center justify-between bg-amber-50/30 p-4 rounded-lg';
                row.innerHTML = `
                    <div>
                        <h6 class="font-bold text-gray-800">${item.name}</h6>
                        <p class="text-xs text-gray-600">${item.tenantName || ''} · Rp${item.price.toLocaleString('id-ID')}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center space-x-2">
                            <button onclick="updateQuantity('${item.productType}', ${item.id}, -1)"
                                    class="w-7 h-7 bg-[#212529]/10 hover:bg-[#212529]/20 text-gray-900 rounded-full text-sm font-bold">−</button>
                            <span class="font-bold text-gray-800 min-w-[20px] text-center">${item.qty}</span>
                            <button onclick="updateQuantity('${item.productType}', ${item.id}, 1)"
                                    class="w-7 h-7 bg-[#212529] hover:bg-[#212529]/90 text-amber-50 rounded-full text-sm font-bold">+</button>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800">Rp${(item.price * item.qty).toLocaleString('id-ID')}</p>
                            <button onclick="removeFromCart('${item.productType}', ${item.id})"
                                    class="text-red-600 hover:text-red-700 text-xs font-medium">Hapus</button>
                        </div>
                    </div>`;
                cartItemsEl.appendChild(row);
            });

            Object.entries(byTenant).forEach(([tenant, amount]) => {
                const el = document.createElement('div');
                el.className = 'flex justify-between';
                el.innerHTML = `<span>🏪 ${tenant}</span><span class="font-bold">Rp${amount.toLocaleString('id-ID')}</span>`;
                cartTenants.appendChild(el);
            });

            cartCount.textContent = itemCount;
            cartTotalEl.textContent = `Rp${total.toLocaleString('id-ID')}`;

            const tenantCount = Object.keys(byTenant).length;
            cartNote.textContent = tenantCount > 1
                ? `Pesanan kamu dari ${tenantCount} tenant — otomatis dipecah jadi ${tenantCount} order, satu untuk tiap tenant.`
                : '';

            cartContainer.classList.toggle('hidden', itemCount === 0);
        }

        async function checkout() {
            if (Object.keys(cart).length === 0) {
                alert('Keranjang belanja kosong!');
                return;
            }

            const btn = document.getElementById('checkout-btn');
            const original = btn.innerHTML;
            btn.innerHTML = 'Memproses...';
            btn.disabled = true;

            const payload = {
                items: Object.values(cart).map(i => ({
                    product_type: i.productType,
                    id: i.id,
                    qty: i.qty,
                })),
            };

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch('{{ route('checkout') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();

                if (result.success) {
                    cart = {};
                    updateCartDisplay();
                    document.querySelectorAll('[id^="order-controls-"]').forEach(c => {
                        const parts = c.id.split('-');
                        updateOrderControls(parts[2], parts[3]);
                    });

                    if (result.redirect_url) {
                        window.location.href = result.redirect_url;
                    } else {
                        window.location.href = '{{ route('pesanan') }}';
                    }
                } else {
                    alert('Gagal: ' + (result.message || 'Terjadi kesalahan'));
                }
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan saat checkout. Silakan coba lagi.');
            } finally {
                btn.innerHTML = original;
                btn.disabled = false;
            }
        }
    </script>
</body>
</html>
