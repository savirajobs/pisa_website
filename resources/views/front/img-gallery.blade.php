@extends('front.layouts.app')

@section('title', config('app.name'))

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s"
        style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.05)), url({{ asset('asset/img/hero-img.jpg') }});">
        <div class="container text-center py-5">
            <h1 class="display-2 text-white mb-4">Galeri</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                    <li class="breadcrumb-item text-white" aria-current="page">Galeri Foto & Video</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Image Gallery Start-->
    <div class="container-fluid team py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                    Foto</h4>
                <h1 class="mb-5 display-4"> Dokumetasi Aktivitas</h1>
            </div>
            <div class="row g-5 justify-content-center">
                @foreach ($img_gallery as $gallery)
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay="0.1s">
                        <a href="{{ route('frontend.images.show', ['slug' => $gallery->slug]) }}">
                            <div class="team-item border border-primary img-border-radius overflow-hidden d-flex flex-column">
                                @if (is_null($gallery->image_name))
                                    <img src="{{ asset('/asset/img/no-image.jpg') }}" class="img-fluid w-100" alt="Image"
                                        style="height:286px;">
                                @else
                                    <img src="{{ asset('/images/' . $gallery->image_name) }}" class="img-fluid w-100"
                                        alt="Image" style="height:286px;">
                                @endif
                                <div class="team-icon d-flex align-items-start justify-content-center">
                                    <a class="share btn btn-primary btn-md-square text-white rounded-circle me-3"
                                        href=""><i class="fas fa-share-alt"></i></a>
                                    <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3"
                                        href=""><i class="fab fa-facebook-f"></i></a>
                                    <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3"
                                        href=""><i class="fab fa-twitter"></i></a>
                                    <a class="share-link btn btn-primary btn-md-square text-white rounded-circle"
                                        href=""><i class="fab fa-instagram"></i></a>
                                </div>
                                <div class="team-content text-center py-3 flex-grow-1">
                                    <h4 class="text-primary">{{ $gallery->post_title }}</h4>
                                    {{-- <p class="text-muted mb-2">{{ $gallery->post_desc }}</p> --}}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="pagination justify-content-center">
            {{ $img_gallery->links('pagination::bootstrap-5') }}
        </div>
    </div>
    <!-- Image Gallery End-->

    <!-- Video Gallery Start-->
    <div class="container-fluid team py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                    Video</h4>
                <h1 class="mb-5 display-4">Video Kota Layak Anak</h1>
            </div>
            <div class="row g-5 justify-content-center">
                @foreach ($img_gallery as $gallery)
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeIn" data-wow-delay="0.1s">
                        <div class="team-item border border-primary img-border-radius overflow-hidden d-flex flex-column">
                            @if (is_null($gallery->image_name))
                                <img src="{{ asset('/asset/img/no-image.jpg') }}" class="img-fluid w-100" alt="Image"
                                    style="height:286px;">
                            @else
                                <img src="{{ asset('/images/' . $gallery->image_name) }}" class="img-fluid w-100"
                                    alt="Image" style="height:286px;">
                            @endif
                            <div class="team-icon d-flex align-items-start justify-content-center">
                                <a class="share btn btn-primary btn-md-square text-white rounded-circle me-3"
                                    href=""><i class="fas fa-share-alt"></i></a>
                                <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3"
                                    href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="share-link btn btn-primary btn-md-square text-white rounded-circle me-3"
                                    href=""><i class="fab fa-twitter"></i></a>
                                <a class="share-link btn btn-primary btn-md-square text-white rounded-circle"
                                    href=""><i class="fab fa-instagram"></i></a>
                            </div>
                            <div class="team-content text-center py-3 flex-grow-1">
                                <h4 class="text-primary">{{ $gallery->post_title }}</h4>
                                {{-- <p class="text-muted mb-2">{{ $gallery->post_desc }}</p> --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="pagination justify-content-center">
            {{ $img_gallery->links('pagination::bootstrap-5') }}
        </div>
    </div>
    <!-- Video Gallery End-->

@endsection
