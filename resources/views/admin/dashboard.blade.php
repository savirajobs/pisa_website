@extends('admin.layouts.app')

@section('title','Dashboard Admin')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        {{-- <div class="row"> --}}
            <!-- Left side columns -->
            <!-- <div class="col-lg-8"> -->
            <div class="row">
                @if (auth()->user()->role == 'super-admin')
                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Akun OPD</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-building-lock"></i>
                                </div>
                                <div class="ps-3">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Sales Card -->
                @endif

                <!-- Revenue Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Julmah Kegiatan</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-card-checklist"></i>
                                    </div>
                                    <div class="ps-3">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Revenue Card -->

                <!-- Customers Card -->
                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Peserta</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Customers Card -->

            </div>
        <!-- </div>End Left side columns -->
        {{-- </div> --}}
    </section>
</main><!-- End #main -->
@endsection

