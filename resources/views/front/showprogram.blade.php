@extends('front.layouts.app')

@section('title', config('app.name'))

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s"
        style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.05)), url({{ asset('asset/img/hero-img.jpg') }});">
        <div class="container text-center py-5">
            <h1 class="display-2 text-white mb-4">Program</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Program Anak</a></li>
                    <li class="breadcrumb-item text-white" aria-current="page">Our Blog</li>
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
    width: 100%; /* Membuat gambar memenuhi lebar kontainer */
    height: 500px; /* Menjaga proporsi tinggi */
    object-fit: cover; /* Memotong gambar jika perlu */
}
</style>

    <!-- Start Section -->
    <div class="container-fluid program  py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                    Program Anak</h4>
                <h1 class="mb-5 display-3">{{ $program->post_title }}</h1>
            </div>
            <div class="row g-5 justify-content-center">
                <div class="program-img position-relative">
                    <div id="carouselExample" class="carousel slide">
                        <div class="carousel-inner">
                            @foreach ($filenames as $index => $filename)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('/asset/img/' . $filename) }}" class="d-block w-100"
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
                

                    {{-- @foreach ($filenames as $filename)
                        @if (is_null($filename))
                            <img src="{{ asset('/asset/img/no-image.jpg') }}" class="img-fluid w-50 img-thumbnail mx-auto d-block" alt="Image">
                        @else
                            <img src="{{ asset('/asset/img/' . $filename) }}" class="img-fluid w-50 img-thumbnail mx-auto d-block" alt="Image">
                        @endif
                    @endforeach --}}
                </div>
                <div class="container py-5 justify">
                    <p style="text-align:justify; font-size:110%;">{{ $program->post_desc }}</p>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- End section -->
@endsection
