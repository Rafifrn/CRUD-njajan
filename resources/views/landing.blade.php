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

    <!-- Hero Section -->
    <section class="hero-bg text-white py-20 md:py-32 flex items-center">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-4 animate-fade-in-down">Selamat Datang di Njajan</h1>
            <p class="text-xl md:text-2xl mb-8 animate-fade-in-down delay-100">Aneka Jajanan dengan Rasa Autentik</p>
        </div>
    </section>

    <!-- Why Choose Us -->
    <!-- Mengapa Memilih Njajan -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-[#212529]">Mengapa Memilih Njajan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <!-- Card 1 -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-all border border-gray-200 text-center">
                <div class="text-[#212529] mb-4">
                    <i class="fas fa-mug-hot text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-[#212529]">Ragam Jajanan Nusantara Autentik</h3>
                <p class="text-gray-700">Njajan menghadirkan berbagai pilihan jajanan khas dari seluruh penjuru Nusantara—mulai dari yang legendaris hingga yang jarang ditemukan—disajikan dengan cita rasa otentik dan bahan berkualitas.</p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-all border border-gray-200 text-center">
                <div class="text-[#212529] mb-4">
                    <i class="fas fa-store text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-[#212529]">Tempat Nyaman dan Elegan</h3>
                <p class="text-gray-700">Tempat kami didesain dengan nuansa modern dan sentuhan budaya lokal, menciptakan suasana yang nyaman untuk bersantai, berkumpul, atau menikmati waktu luang dengan hidangan khas daerah.</p>
            </div>

            <!-- Card 3 -->
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-all border border-gray-200 text-center">
                <div class="text-[#212529] mb-4">
                    <i class="fas fa-users text-4xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-[#212529]">UMKM dengan Sentuhan Premium</h3>
                <p class="text-gray-700">Sebagai UMKM, kami mengutamakan kualitas dan keunikan produk. Dengan kemasan menarik, rasa istimewa, dan harga yang tetap bersahabat, Njajan siap menjadi pilihan utama bagi pecinta kuliner tradisional yang berkelas.</p>
            </div>
        </div>

        <!-- Jam Operasional -->
        <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md border border-gray-200 text-center">
            <h3 class="text-xl font-semibold mb-4 text-[#212529]">Jam Operasional</h3>
            <div class="text-gray-700">
                <div class="flex justify-between py-1 border-b">
                    <span><strong>Senin - Jumat</strong></span>
                    <span>07:00 - 22:00</span>
                </div>
                <div class="flex justify-between py-1 border-b">
                    <span><strong>Sabtu</strong></span>
                    <span>08:00 - 23:00</span>
                </div>
                <div class="flex justify-between py-1">
                    <span><strong>Minggu</strong></span>
                    <span>09:00 - 21:00</span>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Our Journey -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0 md:pr-8">
                    <img src="http://njajan.zhaffran.com/img/wafieq-akmal-7q4sipu2UG0-unsplash.jpg" alt="Perjalanan Njajan" class="rounded-lg shadow-xl w-full object-cover h-64 md:h-96">
                </div>
                <div class="md:w-1/2">
                    <h2 class="text-3xl font-bold mb-6 text-[#212529]">Perjalanan Njajan</h2>
                    <p class="text-gray-700 mb-4">Njajan hadir dari semangat untuk mengangkat kekayaan kuliner lokal ke panggung yang lebih luas. Kami menghadirkan jajanan tradisional dari berbagai daerah di Indonesia—mulai dari pasar lokal hingga pelosok desa—yang diracik dengan standar kebersihan dan rasa yang tinggi, tanpa meninggalkan keaslian cita rasanya.</p>
                    <p class="text-gray-700 mb-6">Sebagai produk UMKM, Njajan berkomitmen untuk memberdayakan produsen lokal serta mengenalkan kembali kekayaan rasa Nusantara kepada masyarakat modern. Dengan suasana tempat yang elegan dan pelayanan ramah, Njajan tak hanya menjadi tempat makan, tapi juga destinasi kuliner budaya.</p>
                    <a href="http://njajan.zhaffran.com/about.html" class="inline-block bg-[#212529] hover:bg-[#3E1010] text-white px-6 py-2 rounded-full font-semibold shadow-lg smooth-transition">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#212529] text-gray-100 py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Column 1 -->
                <div>
                    <h3 class="text-xl font-bold mb-4 text-white">NJAJAN</h3>
                    <p class="mb-2">Jl. Keabadian No. 99</p>
                    <p>Buka setiap hari</p>
                </div>
                
                <!-- Column 2 -->
                <div>
                    <h3 class="text-xl font-bold mb-4 text-white">Hubungi Kami</h3>
                    <p class="mb-2"><i class="fas fa-envelope mr-2"></i> info@njajanautentik</p>
                    <p><i class="fas fa-phone mr-2"></i> (059) 1234-5678</p>
                </div>
                
                <!-- Column 3 -->
                <div>
                    <h3 class="text-xl font-bold mb-4 text-white">Media Sosial</h3>
                    <div class="flex space-x-4">
                        <a href="https://www.instagram.com/upnveteranjawatimur/" class="text-2xl hover:text-amber-300 smooth-transition"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/@UPNVeteranJawaTimurOfficial" class="text-2xl hover:text-amber-300 smooth-transition"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="text-2xl hover:text-amber-300 smooth-transition"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-2xl hover:text-amber-300 smooth-transition"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 pt-6 border-t border-gray-700 text-center">
                <p>&copy; 2024 Njajan Autentik - All rights reserved</p>
            </div>
        </div>
    </footer>

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
</body>
</html>