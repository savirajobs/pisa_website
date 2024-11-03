@extends('admin.layouts.app')

@section('title', 'Galeri')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{{ __('Galeri') }}</h1>
            <h6 class="text-muted">Buat, edit, dan kelola galeri gambar dan video Anda.</h6>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ __('Galeri') }}</li>
                </ol>
            </nav>
        </div>

        {{-- @php
dd($latest_programs)
@endphp --}}

        <section class="section dashboard">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                        </h5>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-foto-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-foto" type="button" role="tab" aria-controls="pills-foto"
                                    aria-selected="true">Foto</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-video-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-video" type="button" role="tab" aria-controls="pills-video"
                                    aria-selected="false">Video</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-foto" role="tabpanel"
                                aria-labelledby="pills-foto-tab" tabindex="0">
                                <h5 class="card-title">
                                    <button class="btn btn-primary btn-sm add-btn" data-bs-toggle="modal"
                                        data-bs-target="#modal-add-gallery"><i class="bi bi-camera"></i> Buat
                                        Galeri Baru </button>
                                </h5>
                                <table id="table-gallery" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Judul Galeri</th>
                                            <th>Status Terbit</th>
                                            <th>Kreator</th>
                                            <th>Tanggal Pos</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab"
                                tabindex="0">
                                <h5 class="card-title">
                                    <button class="btn btn-primary btn-sm add-btn" data-bs-toggle="modal"
                                        data-bs-target="#modal-add-video"><i class="bi bi-person-video"></i> Buat
                                        Galeri Baru </button>
                                </h5>
                                <table id="table-video" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Judul Galeri</th>
                                            <th>Status Terbit</th>
                                            <th>Kreator</th>
                                            <th>Tanggal Pos</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('admin.gallery.modal')
    </main>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('asset/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.13.2/sweetalert2.min.css"
        integrity="sha512-WxRv0maH8aN6vNOcgNFlimjOhKp+CUqqNougXbz0E+D24gP5i+7W/gcc5tenxVmr28rH85XHF5eXehpV2TQhRg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('js')
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('asset/js/iziToast.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.13.2/sweetalert2.min.js"
        integrity="sha512-IrKvpZPCfiNhluFq0+cT7qLFt2qHImPSyjJ841Hlg5Be38kpvn8CckiQSUzP67RFpqumZluboTerUqhmCCV24g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @include('admin.gallery.script')
@endpush
