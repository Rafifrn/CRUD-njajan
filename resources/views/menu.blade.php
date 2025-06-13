<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Njajan - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-bg {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('http://njajan.zhaffran.com/img/sour-moha-4Tgjeh1fWCc-unsplash.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        .smooth-transition {
            transition: all 0.3s ease;
        }

        .cart-slide-in {
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }
        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="font-sans bg-slate-50">
    <!-- Navigation -->
    <nav class="bg-[#212529] text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="#" class="text-2xl font-bold">NJAJAN</a>
                
                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex space-x-6">
                    <a href="/" class="hover:text-amber-100 smooth-transition">Home</a>
                    <a href="/about" class="hover:text-amber-100 smooth-transition">Tentang Kami</a>
                    <a href="/menu" class="hover:text-amber-100 smooth-transition">Menu</a>
                    <div class="relative">
                    <button id="userDropdownToggle" class="flex items-center space-x-2 text-white focus:outline-none">
                        <span>{{ Auth::user()->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                        <!-- Dropdown menu -->
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

                <!-- Mobile Navigation -->
                <div id="mobile-menu" class="hidden md:hidden mt-4 pb-2">
                    <a href="/" class="block py-2 hover:text-amber-200 smooth-transition">Home</a>
                    <a href="/about" class="block py-2 hover:text-amber-200 smooth-transition">Tentang Kami</a>
                    <a href="/menu" class="block py-2 hover:text-amber-200 smooth-transition">Menu</a>
                    
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Background -->
<div class="min-h-screen bg-gray-50">
    <!-- Filter berdasarkan daerah -->
    <div class="bg-white shadow-sm border-b border-gray-200 py-6">
        <div class="container mx-auto px-4">
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <label for="filter-region" class="text-lg font-semibold text-gray-700 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"></path>
                    </svg>
                    Filter Daerah:
                </label>
                <select class="px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 focus:ring-2 focus:ring-gray-800 focus:border-transparent outline-none transition-all duration-200 min-w-48" 
                        id="filter-region" 
                        onchange="filterRegion(this)"
                        style="background-color: #212529; color: white;">
                    <option value="semua">Semua Daerah</option>
                    @foreach ($regions as $region)
                        <option value="{{ strtolower($region) }}">{{ ucfirst($region) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Menu Container -->
    <div class="container mx-auto px-4 py-8">
        <div class="space-y-8">
            <!-- Shopping Cart -->
            <div id="cart-container" class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 hidden">
                <div class="px-6 py-5" style="background-color: #212529;">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <span class="mr-3 text-3xl">🛒</span>
                        Keranjang Belanja
                        <span id="cart-count" class="ml-3 bg-red-500 text-white text-sm px-2 py-1 rounded-full">0</span>
                    </h3>
                </div>
                <div class="p-6">
                    <div id="cart-items" class="space-y-4 mb-6"></div>
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center text-lg font-bold">
                            <span>Total:</span>
                            <span id="cart-total" class="text-green-600">Rp0</span>
                        </div>
                        <button onclick="checkout()" class="w-full mt-4 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>

            <!-- Makanan Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="px-6 py-5" style="background-color: #212529;">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <span class="mr-3 text-3xl">🍽️</span>
                        Makanan
                        <span class="ml-auto text-sm font-normal text-gray-300">Pilihan Terbaik</span>
                    </h3>
                </div>
                <div class="p-6 bg-gray-50">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6" id="makanan-list">
                        @foreach ($makanans as $makanan)
                            <div class="menu-item" data-region="{{ strtolower($makanan->region ?? '') }}">
                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 h-full flex flex-col overflow-hidden hover:shadow-lg hover:border-gray-300 transition-all duration-300 group">
                                    <div class="relative overflow-hidden">
                                        <img src="{{ asset('storage/' . $makanan->image) }}" 
                                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300" 
                                             alt="{{ $makanan->name }}">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
                                    </div>
                                    <div class="p-4 flex flex-col flex-grow">
                                        <h5 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-gray-900 transition-colors">{{ $makanan->name }}</h5>
                                        <p class="text-sm text-gray-600 mb-4 flex-grow leading-relaxed">{{ $makanan->description }}</p>
                                        <div class="mt-auto space-y-3">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm text-gray-500 flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ ucfirst($makanan->region) }}
                                                </p>
                                            </div>
                                            <p class="text-xl font-bold flex items-center mb-3" style="color: #212529;">
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                </svg>
                                                Rp{{ number_format($makanan->price, 0, ',', '.') }}
                                            </p>
                                            
                                            <!-- Order Button and Quantity Controls -->
                                            <div id="order-controls-makanan-{{ $makanan->id }}">
                                                <button onclick="addToCart('makanan', {{ $makanan->id }}, '{{ $makanan->name }}', {{ $makanan->price }}, '{{ $makanan->image }}')" 
                                                       class="w-full text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center hover:shadow-md transform hover:-translate-y-0.5"
                                                       style="background-color: #212529;"
                                                       onmouseover="this.style.backgroundColor='#343a40'"
                                                       onmouseout="this.style.backgroundColor='#212529'">
                                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                                                    </svg>
                                                    Pesan Sekarang
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Minuman Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
                <div class="px-6 py-5" style="background-color: #212529;">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <span class="mr-3 text-3xl">🥤</span>
                        Minuman
                        <span class="ml-auto text-sm font-normal text-gray-300">Segar & Nikmat</span>
                    </h3>
                </div>
                <div class="p-6 bg-gray-50">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6" id="minuman-list">
                        @foreach ($minumans as $minuman)
                            <div class="menu-item" data-region="{{ strtolower($minuman->region ?? '') }}">
                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 h-full flex flex-col overflow-hidden hover:shadow-lg hover:border-gray-300 transition-all duration-300 group">
                                    <div class="relative overflow-hidden">
                                        <img src="{{ asset('storage/' . $minuman->image) }}" 
                                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300" 
                                             alt="{{ $minuman->name }}">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
                                    </div>
                                    <div class="p-4 flex flex-col flex-grow">
                                        <h5 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-gray-900 transition-colors">{{ $minuman->name }}</h5>
                                        <p class="text-sm text-gray-600 mb-4 flex-grow leading-relaxed">{{ $minuman->description }}</p>
                                        <div class="mt-auto space-y-3">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm text-gray-500 flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    {{ ucfirst($minuman->region) }}
                                                </p>
                                            </div>
                                            <p class="text-xl font-bold flex items-center mb-3" style="color: #212529;">
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256.098.512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                </svg>
                                                Rp{{ number_format($minuman->price, 0, ',', '.') }}
                                            </p>
                                            
                                            <!-- Order Button and Quantity Controls -->
                                            <div id="order-controls-minuman-{{ $minuman->id }}">
                                                <button onclick="addToCart('minuman', {{ $minuman->id }}, '{{ $minuman->name }}', {{ $minuman->price }}, '{{ $minuman->image }}')" 
                                                       class="w-full text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center hover:shadow-md transform hover:-translate-y-0.5"
                                                       style="background-color: #212529;"
                                                       onmouseover="this.style.backgroundColor='#343a40'"
                                                       onmouseout="this.style.backgroundColor='#212529'">
                                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                                                    </svg>
                                                    Pesan Sekarang
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>

<script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        const toggleBtn = document.getElementById('userDropdownToggle');
        const menu = document.getElementById('userDropdownMenu');

        toggleBtn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Optional: Tutup dropdown saat klik di luar
        window.addEventListener('click', function(e) {
            if (!toggleBtn.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
        function filterRegion(select) {
            const region = select.value.toLowerCase(); // pastikan lowercase
            const items = document.querySelectorAll('.menu-item');

            items.forEach(item => {
                const itemRegion = item.dataset.region?.toLowerCase() ?? '';
                if (region === 'semua' || itemRegion === region) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

    let cart = {};
    let cartTotal = 0;

    function addToCart(category, id, name, price, image) {
        const itemKey = `${category}-${id}`;
        
        if (cart[itemKey]) {
            cart[itemKey].quantity += 1;
        } else {
            cart[itemKey] = {
                id: id,
                category: category,
                name: name,
                price: price,
                image: image,
                quantity: 1
            };
        }
        
        updateCartDisplay();
        updateOrderControls(category, id);
    }

    function updateQuantity(category, id, change) {
        const itemKey = `${category}-${id}`;
        
        if (cart[itemKey]) {
            cart[itemKey].quantity += change;
            
            if (cart[itemKey].quantity <= 0) {
                delete cart[itemKey];
                resetOrderControls(category, id);
            }
        }
        
        updateCartDisplay();
        updateOrderControls(category, id);
    }

    function removeFromCart(category, id) {
        const itemKey = `${category}-${id}`;
        delete cart[itemKey];
        updateCartDisplay();
        resetOrderControls(category, id);
    }

    function updateOrderControls(category, id) {
        const itemKey = `${category}-${id}`;
        const controlsDiv = document.getElementById(`order-controls-${category}-${id}`);
        
        if (cart[itemKey]) {
            const quantity = cart[itemKey].quantity;
            controlsDiv.innerHTML = `
                <div class="flex items-center justify-between bg-gray-100 rounded-lg p-2">
                    <button onclick="updateQuantity('${category}', ${id}, -1)" 
                            class="w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <span class="font-bold text-lg">${quantity}</span>
                    <button onclick="updateQuantity('${category}', ${id}, 1)" 
                            class="w-8 h-8 bg-green-500 hover:bg-green-600 text-white rounded-full flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            `;
        }
    }

    function resetOrderControls(category, id) {
        const controlsDiv = document.getElementById(`order-controls-${category}-${id}`);
        const itemData = getItemData(category, id);
        
        controlsDiv.innerHTML = `
            <button onclick="addToCart('${category}', ${id}, '${itemData.name}', ${itemData.price}, '${itemData.image}')" 
                   class="w-full text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 flex items-center justify-center hover:shadow-md transform hover:-translate-y-0.5"
                   style="background-color: #212529;"
                   onmouseover="this.style.backgroundColor='#343a40'"
                   onmouseout="this.style.backgroundColor='#212529'">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                </svg>
                Pesan Sekarang
            </button>
        `;
    }

    async function getItemData(category, id) {
    try {
        const response = await fetch(`/api/item/${category}/${id}`);
        if (!response.ok) {
            throw new Error('Gagal mengambil data');
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error(error);
        return null;
    }
}

    function updateCartDisplay() {
        const cartContainer = document.getElementById('cart-container');
        const cartItems = document.getElementById('cart-items');
        const cartCount = document.getElementById('cart-count');
        const cartTotalElement = document.getElementById('cart-total');
        
        // Clear cart items
        cartItems.innerHTML = '';
        
        let total = 0;
        let itemCount = 0;
        
        // Add items to cart display
        Object.values(cart).forEach(item => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            itemCount += item.quantity;
            
            const cartItem = document.createElement('div');
            cartItem.className = 'flex items-center justify-between bg-gray-50 p-4 rounded-lg';
            cartItem.innerHTML = `
                <div class="flex items-center space-x-4">
                    <img src="/storage/${item.image}" alt="${item.name}" class="w-16 h-16 object-cover rounded-lg">
                    <div>
                        <h6 class="font-semibold text-gray-800">${item.name}</h6>
                        <p class="text-sm text-gray-600">Rp${item.price.toLocaleString('id-ID')}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-2">
                        <button onclick="updateQuantity('${item.category}', ${item.id}, -1)" 
                                class="w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center text-sm">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <span class="font-semibold text-gray-800 min-w-[20px] text-center">${item.quantity}</span>
                        <button onclick="updateQuantity('${item.category}', ${item.id}, 1)" 
                                class="w-6 h-6 bg-green-500 hover:bg-green-600 text-white rounded-full flex items-center justify-center text-sm">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-800">Rp${itemTotal.toLocaleString('id-ID')}</p>
                        <button onclick="removeFromCart('${item.category}', ${item.id})" 
                                class="text-red-500 hover:text-red-700 text-sm">
                            Hapus
                        </button>
                    </div>
                </div>
            `;
            cartItems.appendChild(cartItem);
        });
        
        // Update cart count and total
        cartCount.textContent = itemCount;
        cartTotalElement.textContent = `Rp${total.toLocaleString('id-ID')}`;
        
        // Show/hide cart container
        if (itemCount > 0) {
            cartContainer.classList.remove('hidden');
        } else {
            cartContainer.classList.add('hidden');
        }
        
        cartTotal = total;
    }

    function filterRegion(select) {
        const selectedRegion = select.value;
        const menuItems = document.querySelectorAll('.menu-item');
        
        menuItems.forEach(item => {
            const itemRegion = item.getAttribute('data-region');
            if (selectedRegion === 'semua' || itemRegion === selectedRegion) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    async function checkout() {
    if (Object.keys(cart).length === 0) {
        alert('Keranjang belanja kosong!');
        return;
    }
    
    // Prepare order data
    const orderData = {
        items: Object.values(cart).map(item => ({
            id: item.id,
            category: item.category,
            name: item.name,
            price: item.price,
            quantity: item.quantity,
            subtotal: item.price * item.quantity,
            image: item.image
        })),
        total: cartTotal,
        order_date: new Date().toISOString(),
        status: 'pending'
    };
    
    try {
        // Show loading state
        const checkoutBtn = document.querySelector('button[onclick="checkout()"]');
        const originalText = checkoutBtn.innerHTML;
        checkoutBtn.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Memproses...
        `;
        checkoutBtn.disabled = true;
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Send order data to Laravel backend
        const response = await fetch('/orders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(orderData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert(`Pesanan berhasil dikirim! ID Pesanan: #${result.order_id}`);
            
            // Clear cart
            cart = {};
            updateCartDisplay();
            
            // Reset all order controls
            document.querySelectorAll('[id^="order-controls-"]').forEach(control => {
                const parts = control.id.split('-');
                const category = parts[2];
                const id = parts[3];
                resetOrderControls(category, id);
            });
            
        } else {
            alert('Gagal mengirim pesanan: ' + (result.message || 'Terjadi kesalahan'));
        }
        
    } catch (error) {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat mengirim pesanan. Silakan coba lagi.');
    } finally {
        // Restore button state
        const checkoutBtn = document.querySelector('button[onclick="checkout()"]');
        checkoutBtn.innerHTML = 'Checkout';
        checkoutBtn.disabled = false;
    }
}
    </script>
</html>