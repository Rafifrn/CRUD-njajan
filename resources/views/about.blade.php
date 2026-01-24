-- Active: 1747999125139@@127.0.0.1@3306
-- Active: 1747999125139@@127.0.0.1@3306
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Njajan - Tentang Kami</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: sans-serif;
            background-color: #FFFFFF;
        }
        
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), 
                        url('https://images.unsplash.com/photo-1551218808-94e220e084d2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
        }
        
        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 32px;
            left: 6px;
            height: calc(100% - 32px);
            width: 2px;
            background-color: #d1d5db;
        }
        
        .fade-in {
            animation: fadeIn 1.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
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

    <!-- About Section -->
    <section class="py-16 px-6 max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Cerita Kami</h2>
            <div class="w-24 h-1 bg-gray-400 mx-auto"></div>
        </div>
        
        <!-- Timeline -->
        <div class="max-w-4xl mx-auto relative fade-in">
            <!-- Timeline Item 1 -->
            <div class="timeline-item mb-12 relative pl-8">
                <div class="absolute left-0 top-0 w-4 h-4 rounded-full bg-gray-600 border-4 border-gray-300 z-10"></div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-[#212529]-800 mb-2">Berdiri Tahun 2025</h3>
                    <p class="text-gray-700">
                        Dengan misi sederhana: memperkenalkan kembali ragam jajanan khas Nusantara kepada generasi masa kini. Kami percaya bahwa di balik setiap kue tradisional, ada cerita, budaya, dan kehangatan yang patut dijaga.
                    </p>
                </div>
            </div>
            
            <!-- Timeline Item 2 -->
            <div class="timeline-item mb-12 relative pl-8">
                <div class="absolute left-0 top-0 w-4 h-4 rounded-full bg-gray-600 border-4 border-gray-300 z-10"></div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-[#212529]-800 mb-2">Perjalanan Kami</h3>
                    <p class="text-gray-700">
                        Dimulai dari usaha kecil perkuliahan, kini Njajan tumbuh menjadi tempat pilihan bagi pecinta kuliner lokal yang mencari cita rasa autentik dalam suasana yang nyaman dan modern.
                    </p>
                </div>
            </div>
            
            <!-- Timeline Item 3 -->
            <div class="timeline-item mb-12 relative pl-8">
                <div class="absolute left-0 top-0 w-4 h-4 rounded-full bg-gray-600 border-4 border-gray-300 z-10"></div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-bold text-[#212529]-800 mb-2">Kolaborasi dan Inovasi</h3>
                    <p class="text-gray-700">
                        Kami bekerja sama dengan UMKM dan para pengrajin makanan lokal untuk menghadirkan jajanan berkualitas, menggunakan resep turun-temurun dan bahan-bahan pilihan. Dengan kemasan menarik dan pelayanan profesional, Njajan menghadirkan tradisi dalam tampilan yang elegan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-16 bg-[#EFEEEA]">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Visi & Misi Kami</h2>
                <div class="w-24 h-1 bg-gray-400 mx-auto"></div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md fade-in">
                    <div class="text-gray-500 mb-4">
                        <i class="fas fa-eye fa-3x"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#212529] mb-4">Visi</h3>
                    <p class="text-gray-700">Menjadi pelestari utama kuliner tradisional Indonesia dengan menyajikannya dalam kemasan yang modern, tanpa mengorbankan keaslian cita rasa dan cerita di baliknya.</p>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-md fade-in" style="animation-delay: 0.3s;">
                    <div class="text-gray-500 mb-4">
                        <i class="fas fa-bullseye fa-3x"></i>
                    </div>
                    <h3 class="text-xl font-bold text-[#212529] mb-4">Misi</h3>
                    <ul class="text-gray-700 list-disc pl-5 space-y-2">
                        <li>Menjaga resep turun-temurun agar tetap autentik</li>
                        <li>Mendukung UMKM lokal dalam rantai produksi</li>
                        <li>Memperkenalkan kuliner tradisional kepada generasi muda</li>
                        <li>Menjaga kualitas dan kebersihan dalam setiap proses</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Gallery Njajan</h2>
                <div class="w-24 h-1 bg-gray-400 mx-auto"></div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 fade-in">
                <div class="group relative overflow-hidden rounded-lg shadow-md h-48">
                    <img src="https://indonesiakaya.com/wp-content/uploads/2023/04/pm_Artboard_1.jpg" 
                         alt="Traditional Food" 
                         class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                        <span class="text-white font-bold">Pempek Palembang</span>
                    </div>
                </div>
                
                <div class="group relative overflow-hidden rounded-lg shadow-md h-48">
                    <img src="https://i.gojekapi.com/darkroom/gofood-indonesia/v2/images/uploads/c15f4eeb-9d4b-4aa4-9fa2-623abe231191_Go-Biz_20220606_173141.jpeg" 
                         alt="Traditional Food" 
                         class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                        <span class="text-white font-bold">Tekwan</span>
                    </div>
                </div>
                
                <div class="group relative overflow-hidden rounded-lg shadow-md h-48">
                    <img src="https://paltv.disway.id/upload/40f0b37b00f21f7402e230d821f07048.jpeg" 
                         alt="Traditional Food" 
                         class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                        <span class="text-white font-bold">Lontong Kupang</span>
                    </div>
                </div>
                
                <div class="group relative overflow-hidden rounded-lg shadow-md h-48">
                    <img src="https://indonesiakaya.com/wp-content/uploads/2020/10/sate_bulayak_1200.jpg" 
                         alt="Traditional Food" 
                         class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                        <span class="text-white font-bold">Sate Bulayak</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-[#EFEEEA]">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Tim Kami</h2>
                <div class="w-24 h-1 bg-gray-400 mx-auto"></div>
                <p class="max-w-2xl mx-auto text-gray-600 mt-4">Dikelola oleh tim yang berdedikasi untuk melestarikan kuliner tradisional</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <!-- Team Member 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition duration-300 hover:shadow-xl fade-in">
                    <img src="https://fasilkom.upnjatim.ac.id/wp-content/uploads/2024/10/M-Muharrom-Al-H.jpg" 
                         alt="Team Member" 
                         class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="font-bold text-xl text-[#212529]">M. Muharrom Al Haromainy, S.Kom., M.Kom</h3>
                        <p class="text-gray-400">199506012022031006</p>
                        <p class="text-gray-600 mt-3">Informatics</p>
                    </div>
                </div>
                
                <!-- Team Member 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition duration-300 hover:shadow-xl fade-in" style="animation-delay: 0.2s;">
                    <img src="{{ asset('storage/foto/rafii.jpg') }}" alt="Team Member"
                         class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="font-bold text-xl text-[#212529]">Muhammad Rafi Zhafran</h3>
                        <p class="text-gray-400">23081010225</p>
                        <p class="text-gray-600 mt-3">Informatics</p>
                    </div>
                </div>
                
                <!-- Team Member 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition duration-300 hover:shadow-xl fade-in" style="animation-delay: 0.4s;">
                    <img src="{{ asset('storage/foto/deas.jpg') }}" alt="Team Member"
                         class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="font-bold text-xl text-[#212529]">M. Naufal Deanasvha</h3>
                        <p class="text-gray-400">23081010082</p>
                        <p class="text-gray-600 mt-3">Informatics</p>
                    </div>
                </div>
                
                <!-- Team Member 4 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden transition duration-300 hover:shadow-xl fade-in" style="animation-delay: 0.6s;">
                   <img src="{{ asset('storage/foto/rira.jpg') }}" alt="Team Member"
                         class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="font-bold text-xl text-[#212529]">Nadhira Ignasia</h3>
                        <p class="text-gray-400">23081010</p>
                        <p class="text-gray-600 mt-3">Informatics</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- <!-- CTA Section -->
    <section class="py-20 px-6 bg-amber-700 text-white">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl font-bold mb-6">Tertarik Dengan Produk Kami?</h2>
            <p class="text-xl mb-8">Jelajahi berbagai jajanan tradisional berkualitas dengan cita rasa autentik dalam kemasan modern.</p>
            <a href="#" class="inline-block bg-white text-amber-700 px-8 py-3 rounded-full font-bold hover:bg-amber-100 transition duration-300">
                Lihat Menu Kami
            </a>
        </div>
    </section> --}}

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

        // Animation on scroll
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        function handleScroll() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach(element => {
                if (isInViewport(element)) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        }

        // Initialize elements as invisible
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.fade-in');
            elements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(20px)';
                element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            });

            window.addEventListener('scroll', handleScroll);
            handleScroll(); // Check on load
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