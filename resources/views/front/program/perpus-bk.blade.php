@extends('front.layouts.app')

@section('title', config('app.name'))

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s"
        style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.05)), url({{ asset('asset/img/hero-img.jpg') }});">
        <div class="container text-center py-5">
            <h1 class="display-2 text-white mb-4">Layanan</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="#">Layanan</a></li>
                    <li class="breadcrumb-item text-white" aria-current="page">{{ $data->post_title }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
    {{-- @php
dd($filenames)
@endphp --}}
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
    </style>

    <!-- Start Section -->
    <div class="container-fluid program py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                    Layanan</h4>
                <h1 class="mb-5 display-4">{{ $data->post_title }}</h1>
            </div>
            <div class="row g-5 justify-content-center">
                <div class="program-img position-relative">
                    <p style="text-align:center;">by {{ $data->user_name }} -
                        {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('l, d F Y') }}</p>
                    <div class="top-link d-flex gap-3 pe-2"
                        style="justify-content: center; align-items: center; margin-bottom:10px;">
                        <!-- Share to Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                            class="btn btn-secondary btn-sm-square rounded-circle"><i
                                class="fab fa-facebook-f text-white fa-lg"></i></a>
                        <!-- Share to Twitter -->
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($data->post_title) }}&url={{ urlencode(request()->fullUrl()) }}"
                            class="btn btn-secondary btn-sm-square rounded-circle"><i
                                class="fab fa-twitter text-white fa-lg"></i></a>
                        <!-- Share to Whatsapp -->
                        <a href="https://wa.me/?text={{ urlencode($data->post_title . ' ' . request()->fullUrl()) }}"
                            class ="btn btn-secondary btn-sm-square rounded-circle"><i
                                class="fab fa-whatsapp text-white fa-lg"></i></a>
                        <!-- Share to LinkedIn -->
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}"
                            class="btn btn-secondary btn-sm-square rounded-circle me-0"><i
                                class="fab fa-linkedin-in text-white fa-lg"></i></a>
                    </div>
                    {{-- @foreach ($filenames as $filename) --}}
                    @if (is_null($data->file_name))
                        <img src="{{ asset('/asset/img/no-image.jpg') }}"
                            class="img-fluid w-75 mx-auto d-block rounded" alt="Image" >
                    @else
                        <img src="{{ asset('/images/' . $data->file_name) }}"
                            class="img-fluid w-75 mx-auto d-block rounded" alt="Image" >
                    @endif
                    {{-- @endforeach --}}
                </div>
                <div class="container-full py-5 justify">
                    <p style="text-align: justify; font-size: 100%;">
                        {!! $data->post_desc !!}
                    </p>
                </div>
                <div class="container-full"
                    style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <h6 style="text-align:center;">Untuk mengetahui informasi pendaftaran bisa menghubungi kontak berikut
                        ini :</h6>
                    <i class="bi bi-house-door" style="font-size: 48px; margin-top: 10px;"></i>
                    <h6 style="text-align:center;">{{ $data->post_title }}</h6>
                    @if (is_null($data->notes))
                        <button type="button" class="btn btn-primary">Daftar</button>
                    @else
                        <h6 style="text-align:center; margin-top:10px;"> {{ $data->notes }}</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- End section -->
@endsection