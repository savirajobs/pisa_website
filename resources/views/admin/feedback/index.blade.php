@extends('admin.layouts.app')

@section('title','Konsultasi & Pengaduan')

@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>{{ __('Konsultasi & Pengaduan') }}</h1>
		<h6 class="text-muted">Kelola semua konsultasi dan pengaduan yang masuk.</h6>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
				<li class="breadcrumb-item active">{{ __('Konsultasi & Pengaduan') }}</li>
			</ol>
		</nav>
	</div>

	<section class="section dashboard">
		<div class="row">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">
					</h5>
					<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="pills-consultation-tab" data-bs-toggle="pill" data-bs-target="#pills-consultation" type="button" role="tab" aria-controls="pills-consultation" aria-selected="true">Konsultasi</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="pills-complaint-tab" data-bs-toggle="pill" data-bs-target="#pills-complaint" type="button" role="tab" aria-controls="pills-complaint" aria-selected="false">Pengaduan</button>
					</li>
					</ul>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-consultation" role="tabpanel" aria-labelledby="pills-consultation-tab" tabindex="0">
							<table id="consultation" class="table table-striped" style="width:100%">
								<thead>
									<tr>
										<th>Judul Pesan</th>
										<th>Pengirim</th>
										<th>Nomor Telepon</th>
										<th>Tanggal Submit</th>
										{{-- <th>Status</th> --}}
										<th>Aksi</th>
									</tr>
								</thead>
							</table>
						</div>
						<div class="tab-pane fade" id="pills-complaint" role="tabpanel" aria-labelledby="pills-complaint-tab" tabindex="0">
							<table id="complaint" class="table table-striped" style="width:100%">
								<thead>
									<tr>
										<th>Judul Pesan</th>
										<th>Pengirim</th>
										<th>Nomor Telepon</th>
										<th>Tanggal Submit</th>
										{{-- <th>Status</th> --}}
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
	@include('admin.feedback.modal')
</main>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="{{ asset('asset/css/iziToast.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.13.2/sweetalert2.min.css"
	integrity="sha512-WxRv0maH8aN6vNOcgNFlimjOhKp+CUqqNougXbz0E+D24gP5i+7W/gcc5tenxVmr28rH85XHF5eXehpV2TQhRg=="
	crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" integrity="sha512-ZbehZMIlGA8CTIOtdE+M81uj3mrcgyrh6ZFeG33A4FHECakGrOsTPlPQ8ijjLkxgImrdmSVUHn1j+ApjodYZow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('js')
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('asset/js/iziToast.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.13.2/sweetalert2.min.js"
	integrity="sha512-IrKvpZPCfiNhluFq0+cT7qLFt2qHImPSyjJ841Hlg5Be38kpvn8CckiQSUzP67RFpqumZluboTerUqhmCCV24g=="
	crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@include('admin.feedback.script')
@endpush