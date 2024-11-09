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
                    <li class="breadcrumb-item text-white" aria-current="page">Berita & Informasi</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Display Kegiatan & Informasi-->

    <!-- Kegiatan & Informasi End -->

    <!-- Display Berita -->
    <div class="row container-fluid blog py-5">
        <div class="col-xl-8 container py-5">
            {{-- <div class="container"> --}}
            <h5>Berita Terkini</h5>
            <hr style="border: 2px solid #d63384; width: 100%; margin: 20px auto;">
            @forelse ($latest_news as $news)
                <div class="col-xl-12">
                    <div class="text-center bg-light">
                        <div class="d-flex align-items-stretch justify-content-center"
                            style="margin-top: 5%; margin-bottom: 5%;">
                            <div class="col-4 d-flex align-items-center">
                                <div style="position: relative; width: 100%; height: 300px;">
                                    @if (is_null($news->image_name))
                                        <img src="{{ asset('/asset/img/no-image.jpg') }}" class="img-fluid w-100"
                                            alt="Image" style="height: 100%;">
                                    @else
                                        <img src="{{ asset('/images/' . $news->image_name) }}" class="img-fluid w-100"
                                            alt="Image" style="height: 100%;">
                                    @endif
                                    <div
                                        style="position: absolute; top: 10%; left: 20%; transform: translate(-50%, -50%); color: #393d72; font-size: 15px; background-color: lightpink; padding: 5px 10px; border-radius: 5px;">
                                        {{ \Carbon\Carbon::parse($news->created_at)->translatedFormat('d F Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-8 d-flex flex-column justify-content-center">
                                <div class="service-content-inner" style="padding-left: 20px; padding-right: 20px;">
                                    <a href="{{ route('frontend.news.show', ['slug' => $news->slug]) }}">
                                        <h4>{{ $news->post_title }}</h4>
                                    </a>
                                    <a href ="{{ route('frontend.news.show', ['slug' => $news->slug]) }}">
                                        <p class="my-3">{!! $news->short_desc . '...' !!}</p>
                                    </a>
                                    <a href="{{ route('frontend.news.show', ['slug' => $news->slug]) }}"
                                        class="btn btn-primary text-white px-4 py-2 my-2 btn-border-radius">Read
                                        More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <span style="text-align:center;">Tidak ada berita ditemukan</span>
            @endforelse
            <!-- Pagination links -->
            <div class="pagination justify-content-end">
                {{ $latest_news->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>


@endsection
