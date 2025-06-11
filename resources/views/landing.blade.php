@extends('master')
@section('content')
    <header class="hero">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12 text-center">
                    <h1 class="text-black">Selamat Datang di Njajan </h1>
                    <p class="lead text-black">Aneka Jajanan dengan Rasa Autentik</p>
                </div>
            </div>
        </div>
    </header>

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Mengapa Memilih Njajan</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <div class="feature-icon mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" class="bi bi-cup-hot" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M.5 6a.5.5 0 0 0-.488.608l1.652 7.434A2.5 2.5 0 0 0 4.104 16h5.792a2.5 2.5 0 0 0 2.44-1.958l.131-.59a3 3 0 0 0 1.3-5.854l.221-.99A.5.5 0 0 0 13.5 6H.5ZM13 12.5a2.01 2.01 0 0 1-.316-.025l.867-3.898A2.001 2.001 0 0 1 13 12.5ZM2.64 13.825 1.123 7h11.754l-1.517 6.825A1.5 1.5 0 0 1 9.896 15H4.104a1.5 1.5 0 0 1-1.464-1.175Z"/>
                                    <path d="m4.4.8-.003.004-.014.019a4.167 4.167 0 0 0-.204.31 2.327 2.327 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 3.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 3.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 3 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 4.4.8Zm3 0-.003.004-.014.019a4.167 4.167 0 0 0-.204.31 2.327 2.327 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 6.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 6.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 6 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 7.4.8Zm3 0-.003.004-.014.019a4.077 4.077 0 0 0-.204.31 2.337 2.337 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 9.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252 4.334 4.334 0 0 0-.308-.445l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 9 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 10.4.8Z"/>
                                </svg>
                            </div>
                            <h4>Ragam Jajanan Nusantara Autentik</h4>
                            <p class="text-muted">Njajan menghadirkan berbagai pilihan jajanan khas dari seluruh penjuru Nusantara—mulai dari yang legendaris hingga yang jarang ditemukan—disajikan dengan cita rasa otentik dan bahan berkualitas</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <div class="feature-icon mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" class="bi bi-shop" viewBox="0 0 16 16">
                                    <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
                                </svg>
                            </div>
                            <h4>Tempat Nyaman dan Elegan</h4>
                            <p class="text-muted">Tempat kami didesain dengan nuansa modern dan sentuhan budaya lokal, menciptakan suasana yang nyaman untuk bersantai, berkumpul, atau menikmati waktu luang dengan hidangan khas daerah</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <div class="feature-icon mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" class="bi bi-people" viewBox="0 0 16 16">
                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z"/>
                                </svg>
                            </div>
                            <h4>UMKM dengan Sentuhan Premium</h4>
                            <p class="text-muted">Sebagai UMKM, kami mengutamakan kualitas dan keunikan produk. Dengan kemasan menarik, rasa istimewa, dan harga yang tetap bersahabat, Njajan siap menjadi pilihan utama bagi pecinta kuliner tradisional yang berkelas.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-md-6 offset-md-3">
                    <div class="card border-0 shadow">
                        <div class="card-body p-4">
                            <h4 class="text-center mb-4">Jam Operasional</h4>
                            <div class="row g-0 border-bottom pb-2 mb-2">
                                <div class="col-6">
                                    <p class="mb-0 fw-bold">Senin - Jumat</p>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="mb-0">07:00 - 22:00</p>
                                </div>
                            </div>
                            <div class="row g-0 border-bottom pb-2 mb-2">
                                <div class="col-6">
                                    <p class="mb-0 fw-bold">Sabtu</p>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="mb-0">08:00 - 23:00</p>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col-6">
                                    <p class="mb-0 fw-bold">Minggu</p>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="mb-0">09:00 - 21:00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <img src="/img/wafieq-akmal-7q4sipu2UG0-unsplash.jpg" alt="Perjalanan Kopi Kami" class="img-fluid rounded shadow-lg" onerror="this.src='/api/placeholder/600/400'">
                </div>
                <div class="col-md-6">
                    <h2 class="mb-4">Perjalanan Njajan</h2>
                    <p>Njajan hadir dari semangat untuk mengangkat kekayaan kuliner lokal ke panggung yang lebih luas. Kami menghadirkan jajanan tradisional dari berbagai daerah di Indonesia—mulai dari pasar lokal hingga pelosok desa—yang diracik dengan standar kebersihan dan rasa yang tinggi, tanpa meninggalkan keaslian cita rasanya</p>
                    <p>Sebagai produk UMKM, Njajan berkomitmen untuk memberdayakan produsen lokal serta mengenalkan kembali kekayaan rasa Nusantara kepada masyarakat modern. Dengan suasana tempat yang elegan dan pelayanan ramah, Njajan tak hanya menjadi tempat makan, tapi juga destinasi kuliner budaya</p>
                    <a href="/about.html" class="btn btn-primary mt-3">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </section>
@endsection