@extends('front.layouts.app')

@section('title', config('app.name'))

@section('content')
    <!-- Hero Start -->
    @if ($header_img->isNotEmpty())
        <div id="heroCarousel" class="carousel slide position-relative" data-bs-ride="carousel" data-bs-interval="2500">

            <!-- Teks tetap floating di atas carousel -->
            <div class="position-absolute top-50 translate-middle text-start"
                style="z-index: 10; max-width: 100%; left: 30%; margin-left: 20px;">
                <h1 class="mb-3 text-primary">Kota Blitar</h1>
                <h1 class="mb-5 display-1 text-white">Pusat Informasi <br> Sahabat Anak</h1>
            </div>


            <div class="carousel-inner">
                @foreach ($header_img as $index => $headerimg)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="carousel-image"
                            style="background: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.3)), url('{{ asset('images/' . $headerimg->file_name) }}'); background-repeat: no-repeat; background-position: center center; background-size: cover; height: 50vh;">
                        </div>
                    </div>
                @endforeach

                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    @else
        <div class="container-fluid py-5 hero-header wow fadeIn" data-wow-delay="0.1s"
            style="background: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.3)), url('{{ asset('/asset/img/hero-img.jpg') }}'); background-repeat: no-repeat; background-position: center center; background-size: cover; height: 50vh;">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-7 col-md-12">
                        <h1 class="mb-3 text-primary">Kota Blitar</h1>
                        <h1 class="mb-5 display-1 text-white">Pusat Informasi Sahabat Anak</h1>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Hero End -->

    {{--     
    @php
        dd($profile);
    @endphp --}}

    <!-- About Start -->
    <div class="container-fluid py-5 about bg-light"
        style="background: linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)), url({{ asset('asset/img/background.jpg') }});">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                @if (is_null($profile->notes))
                    <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s">
                        @if (is_null($profile->file_name))
                            <img src="{{ asset('/asset/img/no-image.jpg') }}" class="img-fluid w-100" alt="Image"
                                style= "height: 100%;">
                        @else
                            <img src="{{ asset('/images/' . $profile->file_name) }}" class="img-fluid w-100" alt="Image"
                                style="height: 100%; ">
                        @endif
                    </div>
                @else
                    <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s">
                        <iframe width="100%" height="400" src="{{ $profile->notes }}"allowfullscreen>
                        </iframe>
                    </div>
                @endif
                <div class="col-lg-7 wow fadeIn" data-wow-delay="0.3s">
                    <h4
                        class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                        Tentang PISA</h4>
                    <h1 class="text-dark mb-4 display-5">{{ $profile->post_title }}</h1>
                    <p class="text-dark mb-4">{!! $profile->post_desc !!}
                    </p>
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2"></i>Perpustakaan</h6>
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-primary"></i>Ruang Baca</h6>
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-secondary"></i>Ruang Kreatifitas</h6>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2"></i>Ruang Multimedia</h6>
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-primary"></i>Permainan Edukasi</h6>
                            <h6><i class="fas fa-check-circle me-2 text-secondary"></i>Permainan Tradisional</h6>
                        </div>
                    </div>
                    <a href="{{ route('frontend.profile') }}" class="btn btn-primary px-5 py-3 btn-border-radius">Baca
                        Selengkapnya</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Video -->
    {{-- <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen
                            allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- About End -->

    {{-- @php
dd($latest_programs)
@endphp --}}

    <!-- Programs Start -->
    <div class="container-fluid program py-5 bg-white">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                    Layanan</h4>
                <h1 class="mb-5 display-3">Layanan Program Pendukung</h1>
            </div>
            <div class="row g-5 justify-content-center">
                @if ($latest_programs->isNotEmpty())
                    @foreach ($latest_programs as $program)
                        <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn d-flex" data-wow-delay="0.1s">
                            {{-- @foreach ($latest_programs as $post) --}}
                            <div class="program-item rounded d-flex flex-column flex-fill">
                                <div class="program-img position-relative">
                                    <a href="{{ route('frontend.program.show', ['slug' => $program->slug]) }}">
                                        <div class="overflow-hidden img-border-radius">
                                            @if (is_null($program->image_name))
                                                <img src="{{ asset('/asset/img/no-image.jpg') }}" class="img-fluid w-100"
                                                    alt="Image" style= "height: 300px;">
                                            @else
                                                <img src="{{ asset('/images/' . $program->image_name) }}"
                                                    class="img-fluid w-100" alt="Image" style= "height: 300px;">
                                            @endif
                                            {{-- <img src="{{ asset('/asset/img/' . $post->image_name) }}" class="img-fluid w-100" alt="Image" style= "height: 300px;"> --}}
                                        </div>
                                        <div class="px-4 py-2 bg-primary text-white program-rate">Gratis</div>
                                    </a>
                                </div>
                                <div class="program-text bg-white px-4 pb-3 flex-fill d-flex flex-column">
                                    <a href="{{ route('frontend.program.show', ['slug' => $program->slug]) }}">
                                        <div class="program-text-inner flex-grow-1 d-flex flex-column justify-content-center"
                                            style="height: 100%; min-height: 150px; max-height: 300px; overflow-y: auto;">
                                            <a href="{{ route('frontend.program.show', ['slug' => $program->slug]) }}"
                                                class="h4" style="text-align:center;">
                                                {{ $program->post_title }} </a>
                                            <p class="mt-3 mb-0">
                                                {!! $program->short_desc . '...' !!}</p>
                                        </div>
                                    </a>
                                </div>
                                {{-- <div
                                class="program-teacher d-flex align-items-center border-top border-primary bg-white px-4 py-3 rounded">
                                <img src="{{ asset('asset/img/program-teacher.jpg') }}"
                                    class="img-fluid rounded-circle p-2 border border-primary bg-white" alt="Image"
                                    style="width: 70px; height: 70px;">
                                <div class="ms-3">
                                    <h6 class="mb-0 text-primary">{{ $program->user_name }}</h6>
                                    <small>Tim Penulis</small>
                                </div>
                            </div> --}}
                            </div>
                            {{-- @endforeach --}}
                        </div>
                    @endforeach
                @else
                    <!-- Kode jika $items kosong -->
                    <span style="text-align:center;">Layanan tidak ditemukan</span>
                @endif
            </div>
            <div class="text-center wow fadeIn" data-wow-delay="0.1s" style= "margin-top: 50px;";>
                <a href="{{ route('frontend.program.index') }}"
                    class="btn btn-primary px-5 py-3 text-white btn-border-radius">Selengkapnya</a>
            </div>
        </div>
    </div>


    <!-- Program End -->
    {{-- @php
dd($latest_events)
@endphp --}}
    <!-- Events Start -->
    <div class="container-fluid events py-5 bg-white">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                    Artikel</h4>
                <h1 class="mb-5 display-3">Artikel Anak</h1>
            </div>

            <div class="row g-5 justify-content-center">
                @if ($latest_article->isNotEmpty())
                    @foreach ($latest_article as $article)
                        <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn d-flex" data-wow-delay="0.1s">
                            <div class="events-item bg-primary rounded d-flex flex-column flex-fill">
                                <div class="events-inner position-relative">
                                    <div class="events-img overflow-hidden rounded-circle position-relative"
                                        style="height:255px;">
                                        @if (is_null($article->image_name))
                                            <img src="{{ asset('/asset/img/no-image.jpg') }}"
                                                class="img-fluid w-100 rounded-circle" alt="Image">
                                        @else
                                            <img src="{{ asset('/images/' . $article->image_name) }}"
                                                class="img-fluid w-100 rounded-circle" alt="Image"
                                                style="height:255px;">
                                        @endif
                                        {{-- <img src="{{ asset('asset/img/event-1.jpg') }}" class="img-fluid w-100 rounded-circle"
                                alt="Image"> --}}
                                        <div class="event-overlay">
                                            @if (is_null($article->image_name))
                                                <a href="{{ asset('/asset/img/no-image.jpg') }}"
                                                    data-lightbox="event-1"><i
                                                        class="fas fa-search-plus text-white fa-2x"></i></a>
                                            @else
                                                <a href="{{ asset('/images/' . $article->image_name) }}"
                                                    data-lightbox="event-1"><i
                                                        class="fas fa-search-plus text-white fa-2x"></i></a>
                                            @endif
                                            {{-- <a href="{{ asset('asset/img/event-1.jpg') }}" data-lightbox="event-1"><i
                                        class="fas fa-search-plus text-white fa-2x"></i></a> --}}
                                        </div>
                                    </div>
                                    <div class="px-4 py-2 bg-secondary text-white text-center events-rate">
                                        Informasi
                                    </div>
                                    <div class="d-flex justify-content-between px-4 py-2 bg-secondary">
                                        <small class="text-white"><i class="fas fa-calendar me-1 text-primary"></i>
                                            @if (is_null($article->event_at))
                                                {{ \Carbon\Carbon::parse($article->created_at)->format('d M Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($article->event_at)->format('d M Y') }}
                                            @endif
                                            {{-- {{ \Carbon\Carbon::parse($article->created_at)->format('d M Y') }} --}}
                                        </small>
                                        <small class="text-white"><i class="fas fa-map-marker-alt me-1 text-primary"></i>
                                            @if (is_null($article->notes))
                                                Kota Blitar
                                            @else
                                                {{ $article->notes }}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div class="events-text p-4 border border-primary bg-white border-top-0 rounded-bottom flex-fill d-flex flex-column"
                                    style="height:50%; min-height:150px; max-height:300px; overflow-y: auto;">
                                    <a href="#" class="h4"> {{ $article->post_title }}</a>
                                    <p class="mb-0 mt-3"> {!! $article->short_desc . '...' !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Kode jika $items kosong -->
                    <span style="text-align:center;">Artikel tidak ditemukan</span>
                @endif
            </div>
        </div>
        <div class="text-center wow fadeIn" data-wow-delay="0.1s">
            <a href="#" class="btn btn-primary px-5 py-3 text-white btn-border-radius">Selengkapnya</a>
        </div>
    </div>
    <!-- Events End-->
    {{-- @php
dd($latest_news)
@endphp --}}
    <!-- Blog Start-->
    <div class="container-fluid blog py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                    Berita</h4>
                <h1 class="mb-5 display-3">Dunia Anak dalam Berita</h1>
            </div>
            <div class="row g-5 justify-content-center">
                @if ($latest_news->isNotEmpty())
                    @foreach ($latest_news as $news)
                        <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn d-flex" data-wow-delay="0.1s">
                            <div class="blog-item rounded-bottom d-flex flex-column flex-fill">
                                <div class="blog-img overflow-hidden position-relative img-border-radius">
                                    @if (is_null($news->image_name))
                                        <img src="{{ asset('/asset/img/no-image.jpg') }}" class="img-fluid w-100"
                                            alt="Image" style="height: 300px;">
                                    @else
                                        <img src="{{ asset('/images/' . $news->image_name) }}" class="img-fluid w-100"
                                            alt="Image" style="height: 300px;">
                                    @endif
                                </div>
                                <div
                                    class="d-flex justify-content-between px-4 py-3 bg-light border-bottom border-primary blog-date-comments">
                                    <small class="text-dark"><i class="fas fa-calendar me-1 text-dark"></i>
                                        @if (is_null($news->event_at))
                                            {{ \Carbon\Carbon::parse($news->created_at)->format('d M Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($news->event_at)->format('d M Y') }}
                                        @endif
                                        {{-- {{ \Carbon\Carbon::parse($news->created_at)->format('d M Y') }} --}}
                                    </small>
                                    {{-- <small class="text-dark"><i class="fas fa-comment-alt me-1 text-dark"></i> Comments (15)</small> --}}
                                </div>
                                <div class="px-4 pb-4 bg-light rounded-bottom flex-fill d-flex flex-column">
                                    <div class="blog-text-inner flex-grow-1" style="margin-top:10px;">
                                        <a href="#" class="h4">{{ $news->post_title }}</a>
                                        <p class="mt-3 mb-4">{!! $news->short_desc . '...' !!}</p>
                                    </div>
                                    <div class="text-center mt-auto">
                                        <a href="#"
                                            class="btn btn-primary text-white px-4 py-2 mb-3 btn-border-radius">Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Kode jika $items kosong -->
                    <span style="text-align:center;">Berita tidak ditemukan</span>
                @endif
            </div>
        </div>
    </div>
    <!-- Blog End-->
    {{-- @php
dd($img_gallery)
@endphp --}}
    <!-- Team Start-->
    <div class="container-fluid team py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                    Galeri Foto</h4>
                <h1 class="mb-5 display-3">Dokumentasi Kegiatan</h1>
            </div>
            <div class="row g-5 justify-content-center">
                @if ($gallery_img->isNotEmpty())
                    @foreach ($gallery_img as $gallery)
                        <div class="col-md-6 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay="0.1s">
                            <a href="{{ route('frontend.images.show', ['slug' => $gallery->slug]) }}">
                                <div
                                    class="team-item border border-primary img-border-radius overflow-hidden d-flex flex-column">
                                    @if (is_null($gallery->image_name))
                                        <img src="{{ asset('/asset/img/no-image.jpg') }}" class="img-fluid w-100"
                                            alt="Image" style="height:286px;">
                                    @else
                                        <img src="{{ asset('/images/' . $gallery->image_name) }}" class="img-fluid w-100"
                                            alt="Image" style="height:286px;">
                                    @endif
                                    {{-- <div class="team-icon d-flex align-items-center justify-content-center">
                                        <a class="share btn btn-primary btn-md-square text-white rounded-circle me-3"
                                            href=""><i class="fas fa-share-alt"></i></a>
                                        <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3"
                                            href=""><i class="fab fa-facebook-f"></i></a>
                                        <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3"
                                            href=""><i class="fab fa-twitter"></i></a>
                                        <a class="share-link btn btn-primary btn-md-square text-white rounded-circle"
                                            href=""><i class="fab fa-instagram"></i></a>
                                    </div> --}}
                                    <div class="team-content text-center py-3  flex-grow-1">
                                        <h4 class="text-primary">{{ $gallery->post_title }}</h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <!-- Kode jika $items kosong -->
                    <span style="text-align:center;">Galeri tidak ditemukan</span>
                @endif
            </div>
        </div>
    </div>
    <!-- Team End-->
@endsection
