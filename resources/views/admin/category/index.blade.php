@extends('admin.layouts.app')

@section('title', 'Master Category')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{{ __('Master Category') }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ __('Category') }}</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <button class="btn btn-primary btn-sm add-btn" data-bs-toggle="modal"
                                data-bs-target="#addDataCategory"><i class="bi bi-database-add"></i> Add
                                Category</button>
                        </h5>

                        <table id="category" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Category Name</th>
                                    <th>Slug</th>
                                    <th>Created by</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        @include('admin.category.modal')
    </main>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('asset/css/iziToast.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.13.2/sweetalert2.min.css"
        integrity="sha512-WxRv0maH8aN6vNOcgNFlimjOhKp+CUqqNougXbz0E+D24gP5i+7W/gcc5tenxVmr28rH85XHF5eXehpV2TQhRg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css"
        integrity="sha512-ZbehZMIlGA8CTIOtdE+M81uj3mrcgyrh6ZFeG33A4FHECakGrOsTPlPQ8ijjLkxgImrdmSVUHn1j+ApjodYZow=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('js')
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('asset/js/iziToast.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.13.2/sweetalert2.min.js"
        integrity="sha512-IrKvpZPCfiNhluFq0+cT7qLFt2qHImPSyjJ841Hlg5Be38kpvn8CckiQSUzP67RFpqumZluboTerUqhmCCV24g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"
        integrity="sha512-lVkQNgKabKsM1DA/qbhJRFQU8TuwkLF2vSN3iU/c7+iayKs08Y8GXqfFxxTZr1IcpMovXnf2N/ZZoMgmZep1YQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script src="https://cdn.tiny.cloud/1/0153yiw15e288ww6llt72zwet66nk5rvcjw7k6wfzm8jfvee/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>  --}}
    {{-- <script>
	tinymce.init({
	selector: 'textarea#editor',
	});
</script> --}}
    {{-- <script>
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
</script> --}}
    @include('admin.category.script')
@endpush
