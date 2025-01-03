<div class="container-fluid border-bottom bg-light wow fadeIn" data-wow-delay="0.1s">
    <div class="container topbar bg-primary d-none d-lg-block py-2" style="border-radius: 0 40px">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#"
                        class="text-white">Jl. DR. Sutomo No.50, Kota Blitar</a></small>
                <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#"
                        class="text-white">dp3a-p2kb@blitarkota.go.id</a></small>
            </div>
            <div class="top-link pe-2">
                <a href="" class="btn btn-light btn-sm-square rounded-circle"><i
                        class="fab fa-facebook-f text-secondary"></i></a>
                <a href="" class="btn btn-light btn-sm-square rounded-circle"><i
                        class="fab fa-twitter text-secondary"></i></a>
                <a href="" class="btn btn-light btn-sm-square rounded-circle"><i
                        class="fab fa-instagram text-secondary"></i></a>
                <a href="" class="btn btn-light btn-sm-square rounded-circle me-0"><i
                        class="fab fa-linkedin-in text-secondary"></i></a>
                <a href="{{ route('login') }}" type="button" class="btn btn-light btn-xl-square ms-2">
                    <i class="bi bi-lock-fill text-secondary">Login</i>
                </a>
            </div>
        </div>
    </div>
    {{-- <div class="row container-fluid bg-light justify-content-center">
        <div class="col-md-6 col-lg-4 col-xl-3 wow fadeIn">
            <a href="" class="navbar-brand">
                <img src="{{ asset('asset/img/pisa-logo-2.png') }}" style="width: 100%; height: 80%;">
                <h1 class="text-primary display-6">PI<span class="text-secondary">SA</span></h1>
            </a>
        </div>
    </div> --}}
    <div class="container px-0">
        {{-- <a href="index.html" class="navbar-brand">
            <img src="{{ asset('asset/img/pisa-logo.png') }}" style="width: 100%px; height: 100%; text-align=center;">
        </a> --}}
        <nav class="navbar navbar-light navbar-expand-xl py-3">
            <a href="" class="navbar-brand">
                <img src="{{ asset('asset/img/pisa-logo-2.png') }}" style="width: 200px; height:100%;">
                {{-- <h1 class="text-primary display-6">PI<span class="text-secondary">SA</span></h1> --}}
            </a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="{{ route('frontend.index') }}" class="nav-item nav-link active">Home</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Profil</a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <a href="{{ route('frontend.profile') }}" class="dropdown-item">Sekretariat</a>
                            <a href="{{ route('frontend.law') }}" class="dropdown-item">Dasar Hukum</a>
                            <a href="#" class="dropdown-item">Forum Anak</a>
                        </div>
                    </div>
                    <a href="{{ route('frontend.news.index') }}" class="nav-item nav-link">Berita</a>
                    <a href="{{ route('frontend.article.index') }}" class="nav-item nav-link">Artikel</a>
                    <div class="nav-item dropdown">
                        <a href="{{ route('frontend.images.index') }}" class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown">Layanan</a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <a href="{{ route('frontend.layanan.perpusbk') }}" class="dropdown-item">Perpustakaan Bung Karno</a>
                            <a href="{{ route('frontend.layanan.pld') }}" class="dropdown-item">Pusat Layanan Disabilitas</a>
                            <a href="{{ route('frontend.layanan.laportp2a') }}" class="dropdown-item">Lapor Kekerasan</a>
                            <a href="#" class="dropdown-item">WiFi Publik</a>
                        </div>
                    </div>
                    <a href="{{ route('frontend.facility.index') }}" class="nav-item nav-link">Fasilitas</a>
                    {{-- <a href="{{ route('frontend.images.index') }}" class="nav-item nav-link">Galeri</a> --}}
                    <div class="nav-item dropdown">
                        <a href="{{ route('frontend.images.index') }}" class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown">Galeri</a>
                        <div class="dropdown-menu m-0 bg-secondary rounded-0">
                            <a href="{{ route('frontend.images.index') }}" class="dropdown-item">Foto</a>
                            <a href="{{ route('frontend.videos.index') }}" class="dropdown-item">Video</a>
                        </div>
                    </div>
                    <a href="{{ route('frontend.feedback.index') }}" class="nav-item nav-link">Pengaduan</a>
                </div>
                <div class="d-flex me-4">
                    <div id="phone-tada" class="d-flex align-items-center justify-content-center">
                        <a href="" class="position-relative wow tada" data-wow-delay=".9s">
                            <i class="fa fa-phone-alt text-primary fa-2x me-4"></i>
                            <div class="position-absolute" style="top: -7px; left: 20px;">
                                <span><i class="fa fa-comment-dots text-secondary"></i></span>
                            </div>
                        </a>
                    </div>
                    <div class="d-flex flex-column pe-3 border-end border-primary">
                        <span class="text-primary">Pusat Informasi</span>
                        <a href="#"><span class="text-secondary">Gratis: (0342) 801080</span></a>
                    </div>
                </div>
                <button class="btn-search btn btn-primary btn-md-square rounded-circle" data-bs-toggle="modal"
                    data-bs-target="#searchModal"><i class="fas fa-search text-white"></i></button>
            </div>
        </nav>
    </div>
</div>
