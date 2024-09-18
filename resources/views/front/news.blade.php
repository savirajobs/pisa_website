@extends('front.layouts.app')

@section('title', config('app.name'))

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s"
        style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.05)), url({{ asset('asset/img/hero-img.jpg') }});">
        <div class="container text-center py-5">
            <h1 class="display-2 text-white mb-4">Berita & Informasi</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                    {{-- <li class="breadcrumb-item"><a href="#">Event</a></li> --}}
                    <li class="breadcrumb-item text-white" aria-current="page">Berita & Informasi</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Display Kegiatan & Informasi-->

    <!-- Kegiatan & Informasi End -->

    <!-- Display Berita -->
    <div class="container-fluid blog py-5">
        <div class="container py-5">
            {{-- <div class="container"> --}}
            <div class="col-9">
                <div class="text-center border-primary border bg-white">
                    <div class="d-flex align-items-center justify-content-center">
                        <div class="col-4">
                            <img src="{{ asset('asset/img/blog-1.jpg') }}" class="img-fluid w-100" style="margin-top=15px; margin-bottom=15px;" alt="Image">
                        </div>
                        <div class="col-7">
                            <div class="service-content-inner">
                                <a href="#" class="h4">Study & Game</a>
                                <p class="my-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, culpa
                                    qui
                                    officiis animi Lorem ipsum dolor sit amet,
                                    consectetur adipisicing elit.</p>
                                <a href="#" class="btn btn-primary text-white px-4 py-2 my-2 btn-border-radius">Read
                                    More</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 
            <div class="text-center border-primary border bg-white">
                <div class="d-flex align-items-center justify-content-center">
                    <div class="service-content-inner"> --}}
                {{-- <div class="p-4"><i class="fas fa-gamepad fa-6x text-primary"></i></div> --}}
                {{-- <a href="#" class="h4">Study & Game</a>
                        <p class="my-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Natus, culpa qui
                            officiis animi Lorem ipsum dolor sit amet,
                            consectetur adipisicing elit.</p>
                        <a href="#" class="btn btn-primary text-white px-4 py-2 my-2 btn-border-radius">Read More</a>
                    </div>
                </div>
            </div>
            </div> --}}
                {{-- <div class="col-9">
                <h2>Judul</h2>
            </div>
            <div class="col-4">
                <img src="{{ asset('asset/img/blog-1.jpg') }}" class="img-fluid w-100" alt="Image">
            </div>
            <div class="col-6">industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when
                an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not
                only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was
                popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more
                recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
            </div> --}}
            </div>
        </div>
    </div>
    <!-- Berita End -->

@endsection
