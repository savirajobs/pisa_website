@extends('front.layouts.app')

@section('title', config('app.name'))

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s"
        style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.05)), url({{ asset('asset/img/hero-img.jpg') }});">
        <div class="container text-center py-5">
            <h1 class="display-2 text-white mb-4">Fasilitas</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                    <li class="breadcrumb-item text-white" aria-current="page">Fasilitas</li>
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
                    Fasilitas</h4>
                <h1 class="mb-5 display-3">Perpustakaan, Permainan dan Edukasi</h1>
            </div>
            <div class="row g-5 justify-content-center">
                @forelse ($facilities as $facility)
                    <div class="col-md-6 col-lg-6 col-xl-4 wow fadeIn d-flex" data-wow-delay="0.1s">
                        <div class="events-item bg-primary rounded d-flex flex-column flex-fill">
                            <div class="events-inner position-relative">
                                <a href="{{ route('frontend.facility.show', ['slug' => $facility->slug]) }}">
                                    <div class="events-img overflow-hidden rounded-circle position-relative"
                                        style="height:255px;">
                                        @if (is_null($facility->image_name))
                                            <img src="{{ asset('/asset/img/no-image.jpg') }}"
                                                class="img-fluid w-100 rounded-circle" alt="Image">
                                        @else
                                            <img src="{{ asset('/images/' . $facility->image_name) }}"
                                                class="img-fluid w-100 rounded-circle" alt="Image">
                                        @endif
                                        <img src="img/event-1.jpg" class="img-fluid w-100 rounded-circle" alt="Image">
                                        <div class="event-overlay">
                                            <a href="img/event-1.jpg" data-lightbox="event-1"><i
                                                    class="fas fa-search-plus text-white fa-2x"></i></a>
                                        </div>
                                    </div>
                                </a>
                                <!--<div class="px-4 py-2 bg-secondary text-white text-center events-rate">29 Nov</div>-->
                                <div class="d-flex justify-content-between px-4 py-2 bg-secondary">
                                    <small class="text-white">
                                        <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                                        @if (is_null($facility->notes))
                                            Kota Blitar
                                        @else
                                            {{ $facility->notes }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <div
                                class="events-text p-4 border border-primary bg-white border-top-0 rounded-bottom flex-fill d-flex flex-column">
                                <a href="{{ route('frontend.facility.show', ['slug' => $facility->slug]) }}">
                                    <h4 style="text-align:center;">{{ $facility->post_title }}</h4>
                                </a>
                                <a href="{{ route('frontend.facility.show', ['slug' => $facility->slug]) }}">
                                    <p class="mb-0 mt-3">{!! $facility->short_desc . '...' !!}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <span style="text-align:center;">No Items Found</span>
                @endforelse
            </div>
        </div>
    </div>
    <!-- Events End-->

@endsection
