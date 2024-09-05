@extends('admin.layouts.app')

@section('title','Master User')

@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>{{ __('Master User') }}</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
				<li class="breadcrumb-item active">{{ __('Master User') }}</li>
			</ol>
		</nav>
	</div>

	<section class="section dashboard">
		<div class="row">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">
						<button class="btn btn-primary btn-sm add-btn" data-bs-toggle="modal"
							data-bs-target="#addDataModal"><i class="bi bi-person-add"></i> Add
							User</button>
					</h5>
					<table id="userID" class="table table-striped" style="width:100%">
						<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Role</th>
								<th>Updated At</th>
								<th>Actions</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</section>
	@include('admin.users.modal')
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
@include('admin.users.script')
@endpush