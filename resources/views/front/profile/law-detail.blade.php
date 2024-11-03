@extends('front.layouts.app')

@section('title', config('app.name'))

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s"
        style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.05)), url({{ asset('asset/img/hero-img.jpg') }});">
        <div class="container text-center py-5">
            <h1 class="display-2 text-white mb-4">Profil</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="#">Profil</a></li>
                    <li class="breadcrumb-item"><a href="#">Dasar Hukum</a></li>
                    <li class="breadcrumb-item text-white" aria-current="page">{{ $law->post_title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- @php
        dd($law);
    @endphp --}}

    <!-- Start Section -->
    <div class="container-fluid program  py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                    Dasar Hukum</h4>
                <h1 class="mb-5 display-4">{{ $law->post_title }}</h1>
                <div class="top-link d-flex gap-3 pe-2"
                    style="justify-content: center; align-items: center; margin-bottom:20px;">
                    <!-- Share to Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                        class="btn btn-secondary btn-sm-square rounded-circle"><i
                            class="fab fa-facebook-f text-white fa-lg"></i></a>
                    <!-- Share to Twitter -->
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($law->post_title) }}&url={{ urlencode(request()->fullUrl()) }}"
                        class="btn btn-secondary btn-sm-square rounded-circle"><i
                            class="fab fa-twitter text-white fa-lg"></i></a>
                    <!-- Share to Whatsapp -->
                    <a href="https://wa.me/?text={{ urlencode($law->post_title . ' ' . request()->fullUrl()) }}"
                        class ="btn btn-secondary btn-sm-square rounded-circle"><i
                            class="fab fa-whatsapp text-white fa-lg"></i></a>
                    <!-- Share to LinkedIn -->
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}"
                        class="btn btn-secondary btn-sm-square rounded-circle me-0"><i
                            class="fab fa-linkedin-in text-white fa-lg"></i></a>
                </div>
            </div>
            <div class="row g-5 justify-content-center">
                <iframe src="{{ asset('/pdf/' . $law->file_name) }}" width="100%" height="800px">
                </iframe>
            </div>
            <div class="container justify-content-center" style="margin-top:30px;">
                <h5><span>Dasar Hukum Lainnya:</span></h5>
                <hr style="border: 2px solid #d63384; width: 100%; margin: 20px auto;">
            </div>
            <div class="row container-full justify">
                <div class="card-deck d-flex flex-row justify-content-start">
                    @forelse ($relatedlaw as $relatedlaw)
                        <div class="col-xl-3 col-md-4 col-sm-6">
                            <div class="card" style="width: 18rem;">
                                <center>
                                    <a href="{{ route('frontend.law.show', $relatedlaw->slug) }}">
                                        <img class="card-img-top" src="{{ asset('/asset/img/logo-blitar.png') }}"
                                            style="width:150px; height:100%; margin-top:5px;">
                                    </a>
                                </center>
                                <div class="card-body">
                                    <a href="{{ route('frontend.law.show', $relatedlaw->slug) }}">
                                        <h5 class="card-title" style="text-align:center;">{{ $relatedlaw->post_title }}
                                        </h5>
                                    </a>
                                </div>
                                <div class="card-footer">
                                    <a href={{ route('frontend.law.show', $relatedlaw->slug) }}>
                                        <i class="bi bi-calendar-check"></i>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($relatedlaw->created_at)->translatedFormat('d F Y') }}</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <span>Tidak ada Dasar Hukum lainnya</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>


    <!-- End section -->
@endsection
