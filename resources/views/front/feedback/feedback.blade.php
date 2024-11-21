@extends('front.layouts.app')

@section('title', config('app.name'))

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s"
        style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.05)), url({{ asset('asset/img/hero-img.jpg') }});">
        <div class="container text-center py-5">
            <h1 class="display-2 text-white mb-4">Konsultasi & Pengaduan</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item text-white" aria-current="page">Konsultasi & Pengaduan</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Contact Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 100%;">
                    <h4
                        class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">
                        Formulir</h4>
                    <h1 class="display-3">Hubungi Kami</h1>
                    <p class="mb-5">Layanan ini menyediakan konsultasi dan pengaduan untuk anak-anak dan remaja serta
                        orang tua terkait pendidikan, kesehatan mental, dan perlindungan anak. Kami siap mendengarkan,
                        memberikan solusi, dan menjaga kerahasiaan informasi dalam lingkungan yang aman dan nyaman.
                        {{-- <a href="https://htmlcodex.com/contact-form">Download Now</a>.</p> --}}
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                        <div class="d-flex w-100 border border-primary p-3 rounded bg-white">
                            <i class="fas fa-map-marker-alt fa-2x text-primary me-4"></i>
                            <div class="">
                                <h4>Alamat</h4>
                                <p class="mb-2">Jl. DR. Sutomo No.50, Kota Blitar</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                        <div class="d-flex w-100 border border-primary p-3 rounded bg-white">
                            <i class="fas fa-envelope fa-2x text-primary me-4"></i>
                            <div class="">
                                <h4>Email</h4>
                                <p class="mb-2">dp3a-p2kb@blitarkota.go.id</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                        <div class="d-flex w-100 border border-primary p-3 rounded bg-white">
                            <i class="fa fa-phone-alt fa-2x text-primary me-4"></i>
                            <div class="">
                                <h4>Hotline (WA)</h4>
                                {{-- <p class="mb-2">Gratis: (0342) 801080</p> --}}
                                <p class="mb-2">0812-9206-6600</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.3s">
                        <form id="upload_feedback" method='POST'>
                            @csrf
                            <input type="text" class="w-100 form-control py-3 mb-3 border-primary" name='name'
                                id='name' placeholder="Nama Anda">
                            <input type="email" class="w-100 form-control py-3 mb-3 border-primary" name='email'
                                id='email' placeholder="Email">
                            <input type="numeric" class="w-100 form-control py-3 mb-3 border-primary" name='phone'
                                id='phone' placeholder="No. Whatsapp">

                            <select class="form-select w-100 form-control py-3 mb-3 border-primary" id="category"
                                name="category" required>
                                <option value="" selected>Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->category_desc }}</option>
                                @endforeach
                            </select>

                            <input type="text" class="w-100 form-control py-3 mb-3 border-primary" name='title'
                                id='title' placeholder="Judul Pesan">
                            <textarea class="w-100 form-control mb-3 border-primary" rows="8" cols="10" name='message' id='message'
                                placeholder="Pesan Anda"></textarea>
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <div class="me-3">
                                    <!-- Gambar captcha, tambahkan URL route yang langsung memuat captcha -->
                                    <img src="{{ url('/captcha-image') }}" alt="Captcha" id="captcha-image">
                                </div>
                                <button type="button" class="btn btn-secondary btn-sm me-3" id="reload_captcha">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                                <input type="text" class="form-control w-50 py-2 border-primary" name="captcha"
                                    id="captcha" placeholder="Captcha">
                            </div>
                            <button class="w-100 btn btn-primary form-control py-3 border-primary text-white bg-primary"
                                type="submit" id="btn_feedback">Submit</button>
                        </form>

                    </div>
                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                        <div class="border border-primary h-100 rounded">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3950.0397953806987!2d112.1764237759659!3d-8.097424280989575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78ec657d52691d%3A0x48e55b98b4ba253d!2sDinas%20Pemberdayaan%20Perempuan%2C%20Perlindungan%20Anak%2C%20Pengendalian%20Penduduk%20dan%20KB%20Kota%20Blitar!5e0!3m2!1sen!2sid!4v1730106510031!5m2!1sen!2sid"
                                class="w-100 h-100 rounded" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
    @include('front.feedback.modal')
@endsection

@push('js')
    @include('front.feedback.script')
@endpush
