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

    <style>
        .container-full {
            width: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            /* Pusatkan secara horizontal */
            align-items: center;
            /* Pusatkan secara vertikal */
        }
    </style>

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
                        <!-- 16:9 aspect ratio -->
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" width="100%" height="375"
                                src="{{ $profile->notes }}" allowfullscreen></iframe>
                        </div>
                        {{-- <iframe width="100%" height="375" src="{{ $profile->notes }}">
                        </iframe> --}}
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
    {{-- <div class="container-fluid py-5 about bg-light">
        <div class="container py-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="border border-primary h-100 rounded">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3950.0397953806987!2d112.1764237759659!3d-8.097424280989575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78ec657d52691d%3A0x48e55b98b4ba253d!2sDinas%20Pemberdayaan%20Perempuan%2C%20Perlindungan%20Anak%2C%20Pengendalian%20Penduduk%20dan%20KB%20Kota%20Blitar!5e0!3m2!1sen!2sid!4v1730106510031!5m2!1sen!2sid"
                            class="w-100 h-100 rounded" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeIn">
                    <h4>Sekretariat</h4>
                    <p>Alamat : Jl. DR. Sutomo No.50, Sananwetan, Kec. Sananwetan, Kota Blitar, Jawa Timur 66137 </p>
                    <p>No Telp : 0342801080</p>
                    <p>Email : https://dp3ap2kb.blitarkota.go.id/</p>
                </div>
            </div>
        </div>
    </div> --}}

@endsection
