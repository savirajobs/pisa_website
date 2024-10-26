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
                    <li class="breadcrumb-item"><a href="#">Profile</a></li>
                    <li class="breadcrumb-item text-white" aria-current="page">Sekretariat</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->
{{-- 
    @php
        dd($profile);
    @endphp --}}

    <!-- About Start -->
    <div class="container-fluid py-5 about bg-light">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                @if (is_null($profile->notes))
                    <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s" style="height:375px;">
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
                        {{-- <div class="video border"
                            style="background: linear-gradient(rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.1)), url({{ asset('asset/img/about.jpg') }});">
                            <button type="button" class="btn btn-play" data-bs-toggle="modal"
                                data-src="https://www.youtube.com/watch?v=Olm4j04rMMI" data-bs-target="#videoModal">
                                <span></span>
                            </button>
                        </div> --}}
                        <iframe width="100%" height="375"
                            src="https://www.youtube.com/embed/Olm4j04rMMI?si=lHzUo-COgP6C93O4?autoplay=1&mute=1">
                        </iframe>
                    </div>
                @endif

                {{-- @php
                    dd($profile);
                @endphp --}}


                <div class="col-lg-7 wow fadeIn" data-wow-delay="0.3s">
                    <h4
                        class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                        Tentang PISA</h4>
                    <h1 class="text-dark mb-4 display-5">{{ $profile->post_title }}</h1>
                    <p class="text-dark mb-4">{!! $profile->post_desc !!}
                    </p>
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2"></i>Sport Activites</h6>
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-primary"></i>Outdoor Games</h6>
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-secondary"></i>Nutritious Foods
                            </h6>
                        </div>
                        <div class="col-lg-6">
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2"></i>Highly Secured</h6>
                            <h6 class="mb-3"><i class="fas fa-check-circle me-2 text-primary"></i>Friendly Environment
                            </h6>
                            <h6><i class="fas fa-check-circle me-2 text-secondary"></i>Qualified Teacher</h6>
                        </div>
                    </div>
                    {{-- <a href="" class="btn btn-primary px-5 py-3 btn-border-radius">More Details</a> --}}
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
dd($secretary)
@endphp --}}

    <!-- Sekretariat -->
    <div class="container-fluid program py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                {{-- <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                    {{ $secretary->post_title }}</h4> --}}
                <h1 class="text-dark mb-4 display-5"> {{ $secretary->post_title }}</h1>
            </div>
            <div class="row g-5 justify-content-center">
                @if ($secretary)
                    <p>{!! $secretary->post_desc !!}</p>
                @else
                    <p>Deskripsi tidak tersedia.</p>
                @endif
            </div>
        </div>
    </div>






@endsection
