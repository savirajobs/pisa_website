@extends('front.layouts.app')

@section('title', config('app.name'))

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s"
        style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.05)), url({{ asset('asset/img/hero-img.jpg') }});">
        <div class="container text-center py-5">
            <h1 class="display-2 text-white mb-4">Program Anak</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item text-white" aria-current="page">Program Anak</li>
                    <!--<li class="breadcrumb-item text-white" aria-current="page">Our Blog</li>-->
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Programs Start -->
    <div class="container-fluid program  py-5">
        <div class="container py-5">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                    Program Anak</h4>
                <h1 class="mb-5 display-3">We Offer An Exclusive Program For Kids</h1>
            </div>
            <div class="row g-5 justify-content-center">
                @forelse ($programs as $program)
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
                                <div class="program-text-inner flex-grow-1 d-flex flex-column justify-content-center">
                                    <a href="{{ route('frontend.program.show', ['slug' => $program->slug]) }}">
                                        <h4 style="text-align:center;">
                                            {{ $program->post_title }} </h4>
                                    </a>
                                    <p class="mt-3 mb-0" style="text-align: center;">
                                        {!! $program->short_desc . '...' !!}</p>
                                </div>
                            </div>
                            {{-- <div
                                class="program-teacher d-flex align-items-center border-top border-primary bg-white px-4 py-3 rounded-bottom">
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
                @empty
                    <span style="text-align:center;">No Items Found</span>
                @endforelse
            </div>
            {{-- <div class="text-center wow fadeIn" data-wow-delay="0.1s" style= "margin-top: 50px;";>
                <a href="#" class="btn btn-primary px-5 py-3 text-white btn-border-radius">Vew All Programs</a>
            </div> --}}
        </div>
    </div>
    </div>

    <!-- Program End -->
@endsection
