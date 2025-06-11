<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Njajan - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="C:\VSCode\lara-nusantara\resources\css\styles.css" rel="stylesheet">
</head>
<body id="home">
    <div class="wrapper">
        <div class="content">
            <div class="container">
                {{-- NAVBAR --}}
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                    <div class="container">
                        <a class="navbar-brand" href="#">NJAJAN</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="nav-link active" href="/index.html">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/about.html">Tentang Kami</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/menu.html">Menu</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="feedback.html">Feedback</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/contact.html">Kontak</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin.html">Admin</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                @yield('content')
            </div>
        </div>
        <footer class="bg-dark text-white py-4 mt-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>NJAJAN</h5>
                            <p>Jl. Keabadian No. 99<br>Buka setiap hari</p>
                        </div>
                        <div class="col-md-4">
                            <h5>Hubungi Kami</h5>
                            <p>Email: info@njajanautentik<br>Telp: (059) 1234-5678</p>
                        </div>
                        <div class="col-md-4">
                            <h5>Media Sosial</h5>
                            <a href="https://www.instagram.com/upnveteranjawatimur/" class="text-light"><i class="fab fa-instagram fa-2x"></i></a>
                            <a href="https://www.youtube.com/@UPNVeteranJawaTimurOfficial" class="text-light"><i class="fab fa-youtube fa-2x"></i></a>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <p>&copy; 2024 Njajan Autentik - All rights reserved</p>
                    </div>
                </div>
        </footer>
    </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>