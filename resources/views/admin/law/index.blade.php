@extends('admin.layouts.app')

@section('title', 'Dasar Hukum')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{{ __('Dasar Hukum') }}</h1>
            <h6 class="text-muted">Buat, edit, dan kelola dasar hukum, SOP, SK, dan lainnya.</h6>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ __('Law Management') }}</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <button class="btn btn-primary btn-sm add-btn" data-bs-toggle="modal"
                                data-bs-target="#addDataPost"><i class="bi bi-book"></i> Tambah Dasar Hukum </button>
                        </h5>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-posted" role="tabpanel"
                                aria-labelledby="pills-posted-tab" tabindex="0">
                                <table id="law" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Dasar Hukum</th>
                                            <th>Status Terbit</th>
                                            <th>Tanggal Pos</th>
                                            <th>Kreator</th>
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
        @include('admin.law.modal')
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
    @include('admin.law.script')
@endpush
