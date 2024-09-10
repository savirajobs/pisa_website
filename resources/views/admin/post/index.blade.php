@extends('admin.layouts.app')

@section('title','Content Management | Post')

@section('content')
<main id="main" class="main">
	<div class="pagetitle">
		<h1>{{ __('Content Management | Post') }}</h1>
		<nav>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
				<li class="breadcrumb-item active">{{ __('Post') }}</li>
			</ol>
		</nav>
	</div>

	<section class="section dashboard">
		<div class="row">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">
						<button class="btn btn-primary btn-sm add-btn" data-bs-toggle="modal"
							data-bs-target="#addDataPost"><i class="bi bi-building-add"></i> Add
							Post</button>
					</h5>

					<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="pills-posted-tab" data-bs-toggle="pill" data-bs-target="#pills-posted" type="button" role="tab" aria-controls="pills-posted" aria-selected="true">Posted</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="pills-draft-tab" data-bs-toggle="pill" data-bs-target="#pills-draft" type="button" role="tab" aria-controls="pills-draft" aria-selected="false">Draft</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-controls="pills-all" aria-selected="false">All</button>
					</li>
					</ul>
					<div class="tab-content" id="pills-tabContent">
						<div class="tab-pane fade show active" id="pills-posted" role="tabpanel" aria-labelledby="pills-posted-tab" tabindex="0">
							<table id="posted" class="table table-striped" style="width:100%">
								<thead>
									<tr>
										<th>Content Title</th>
										<th>Publish</th>
										<th>Published at</th>
										<th>Upcoming Date</th>
										<th>Created By</th>
										<th>Actions</th>
									</tr>
								</thead>
							</table>
						</div>
						<div class="tab-pane fade" id="pills-draft" role="tabpanel" aria-labelledby="pills-draft-tab" tabindex="0">
							<table id="post_draft" class="table table-striped" style="width:100%">
								<thead>
									<tr>
										<th>Content Title</th>
										<th>Publish</th>
										<th>Published at</th>
										<th>Upcoming Date</th>
										<th>Created By</th>
										<th>Actions</th>
									</tr>
								</thead>
							</table>
						</div>
						<div class="tab-pane fade" id="pills-all" role="tabpanel" aria-labelledby="pills-all-tab" tabindex="0">
						<table id="post_all" class="table table-striped" style="width:100%">
								<thead>
									<tr>
										<th>Content Title</th>
										<th>Publish</th>
										<th>Published at</th>
										<th>Upcoming Date</th>
										<th>Created By</th>
										<th>Actions</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	@include('admin.post.modal')
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
<script src="https://cdn.tiny.cloud/1/0153yiw15e288ww6llt72zwet66nk5rvcjw7k6wfzm8jfvee/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script> 
<script>
	tinymce.init({
	selector: 'textarea#editor',
	});
</script>
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: [
      // Core editing features
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
      // Your account includes a free trial of TinyMCE premium features
      // Try the most popular premium features until Sep 21, 2024:
      'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown',
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',
    mergetags_list: [
      { value: 'First.Name', title: 'First Name' },
      { value: 'Email', title: 'Email' },
    ],
    ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  });
</script>
@include('admin.post.script')
@endpush