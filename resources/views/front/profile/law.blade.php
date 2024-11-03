@extends('front.layouts.app')

@section('title', config('app.name'))

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s"
        style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.05)), url({{ asset('asset/img/hero-img.jpg') }});">
        <div class="container text-center py-5">
            <h1 class="display-2 text-white mb-4">Profile</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="#">Profil</a></li>
                    <li class="breadcrumb-item text-white" aria-current="page">Dasar Hukum</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    {{-- @php
        dd($facilities);
    @endphp --}}

    <!-- Events Start -->
    <div class="container-fluid events py-5 bg-light">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                    Dasar Hukum</h4>
                <h1 class="mb-5 display-3">Peraturan & SOP</h1>
            </div>
            <div class="row g-5 justify-content-center">
                <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn d-flex justify-content-center" data-wow-delay="0.1s">
                    <div class="card-deck d-flex flex-row" style="gap: 1rem;">
                        @forelse($laws as $law)
                            <div class="card" style="width: 18rem;">
                                <center>
                                    <a href={{ route('frontend.law.show', $law->slug) }}>
                                        <img class="card-img-top" src="{{ asset('/asset/img/logo-blitar.png') }}"
                                            style="width:150px; height:100%; margin-top:5px;" alt="Card image cap"> </a>
                                </center>
                                <div class="card-body">
                                    <a href={{ route('frontend.law.show', $law->slug) }}>
                                        <h5 class="card-title" style="text-align:center;">{{ $law->post_title }}</h5>
                                        {{-- <p class="card-text">{!! $law->post_desc !!}</p> --}}
                                    </a>
                                </div>
                                <div class="card-footer">
                                    <a href={{ route('frontend.law.show', $law->slug) }}>
                                        <i class="bi bi-calendar-check"></i>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($law->created_at)->translatedFormat('d F Y') }}</small>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <span style="text-align:center;">Tidak ada dasar hukum ditemukan</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="pagination justify-content-center">
            {{ $laws->links('pagination::bootstrap-5') }}
        </div>
    </div>
    <!-- Events End-->

@endsection
