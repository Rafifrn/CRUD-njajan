<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    </script>
</html>