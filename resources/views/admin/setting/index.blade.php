@extends('admin.layouts.app')

@section('title', 'Setting Page')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{{ __('Setting Page') }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ __('Setting Page') }}</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                        </h5>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-settingPage" role="tabpanel"
                                aria-labelledby="pills-settingPage-tab" tabindex="0">
                                <table id="settingPage" class="table table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Page</th>
                                            <th>Page Contents</th>
                                            <th>Updated At</th>
                                            <th>Updated By</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('admin.setting.modal')
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
    <!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script> -->
    <!-- <script type="text/javascript">
        $(document).ready(function() {
            $('.summernote').summernote();
        });
    </script> -->
    @include('admin.setting.script')
@endpush
