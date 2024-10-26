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
                    <li class="breadcrumb-item"><a href="#">Berita & Informasi</a></li>
                    <li class="breadcrumb-item text-white" aria-current="page">{{ $news->post_title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <style>
        .carousel-item img {
            width: 100%;
            /* Membuat gambar memenuhi lebar kontainer */
            height: 750px;
            /* Menjaga proporsi tinggi */
            object-fit: cover;
            /* Memotong gambar jika perlu */
            padding: 10px;
            transition: all 0.5s ease-in-out;
            z-index: 10;
            opacity: 1;
        }

        .container-full {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .container-full related-news-label h5 {
            display: flex;
            align-items: center;
            background-color: #ADD8E6;
            height: 30px;
            /* Sesuaikan tinggi sesuai kebutuhan */
        }

        .container-full h5 span {
            padding-left: 10px;
            padding-right: 10px;
            background-color: lightpink;
            /* Agar span memenuhi lebar */
            height: 100%;
            /* Agar span memenuhi tinggi */
            display: flex;
            align-items: center;
            /* Untuk menyelaraskan teks di tengah vertikal */
        }
    </style>


    {{-- @php
        dd($relatednews);
    @endphp --}}

    <!-- Start Section -->
    <div class="container-fluid program  py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                    @if ($news->post_type == 'NW')
                        Berita
                    @elseif($news->post_type == 'IF')
                        Informasi
                    @endif
                </h4>
                <h1 class="mb-5 display-4">{{ $news->post_title }}</h1>
            </div>
            <div class="row g-5 justify-content-center">
                <div class="program-img position-relative">
                    <p style="text-align:center;">by {{ $user }} - {{ \Carbon\Carbon::parse($news->created_at)->translatedFormat('l, d F Y') }}</p>
                    
                    <div id="carouselExample" class="carousel slide">
                        <div class="carousel-inner">
                            @foreach ($filenames as $index => $filename)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('/images/' . $filename) }}" class="d-block w-100"
                                        alt="Slide {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="container-full py-5 justify">
                    <p style="text-align: justify; font-size: 110%;">
                        {!! $news->post_desc !!}
                    </p>
                </div>
                <div class="container-full justify related-news-label">
                    <h5><span>Berita Lainnya:</span></h5>
                </div>
                <div class="container-full justify">
                    <div class="row card-deck">
                        @forelse ($relatednews as $relatednews)
                            <div class="col-xl-3 col-md-4 col-sm-6">
                                <div class="card" style="width: 18rem;">
                                    @if (is_null($relatednews->image_name))
                                        <img class="card-img-top" src="{{ asset('/asset/img/no-image.jpg') }}"
                                            style="height:215px;">
                                    @else
                                        <img class="card-img-top" src="{{ asset('/images/' . $relatednews->image_name) }}"
                                            style="height:215px;">
                                    @endif
                                    {{-- <img class="card-img-top" src="..." alt="Card image cap"> --}}
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $relatednews->post_title }}</h5>
                                        <p class="card-text"><small class="text-muted">
                                                {{-- {{ dd($relatednews) }} --}}
                                                {{ \Carbon\Carbon::parse($relatednews->created_at)->translatedFormat('d F Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <span>Tidak ada berita</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- End section -->
@endsection
