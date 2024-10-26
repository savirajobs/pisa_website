@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
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
                                <h5 class="card-title">Total Pengunjung</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-building-lock"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h1><span id="totalVisitor"></span></h1>
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
                            <h5 class="card-title">Total Post</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-card-checklist"></i>
                                </div>
                                <div class="ps-3">
                                    <h1><span id="totalPost"></span></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Revenue Card -->

                <!-- Customers Card -->
                <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Total Pengaduan Masuk</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h1><span id="totalFeedback"></span></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Customers Card -->

            </div>
            <!-- </div>End Left side columns -->

            <div class="row">
                <div class="col-xxl-6 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Pengunjung Perbulan</h5>
                            <canvas id="countGuest" style="width:100%;max-width:600px"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Post Perbulan</h5>
                            <canvas id="countPost" style="width:100%;max-width:600px"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-12 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <canvas id="feedbackPie" style="width:100%;max-width:600px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xxl-6 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <canvas id="consultationPie" style="width:100%;max-width:600px"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-12">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            <canvas id="complaintPie" style="width:100%;max-width:600px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            {{--
        </div> --}}

        </section>
    </main><!-- End #main -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script>
        // Data JSON
        const jsonVisitor = '{{ $totalVisitor }}';

        const cleanTotalVisitor = jsonVisitor.replace(/&quot;/g, '"');
        const dataTotalVisitor = JSON.parse(cleanTotalVisitor);
        const totalVisitor = dataTotalVisitor.map(item => item.total);
        console.log(totalVisitor);

        // Menampilkan angka ke dalam elemen dengan id 'total'
        document.getElementById('totalVisitor').innerText = totalVisitor;

        // Data JSON
        const jsonPost = '{{ $totalPost }}';

        const cleanTotalPost = jsonPost.replace(/&quot;/g, '"');
        const dataTotalPost = JSON.parse(cleanTotalPost);
        const totalPost = dataTotalPost.map(item => item.total);
        console.log(totalPost);

        // Menampilkan angka ke dalam elemen dengan id 'total'
        document.getElementById('totalPost').innerText = totalPost;

        // Data JSON
        const jsonFeedback = '{{ $totalFeedback }}';

        const cleanTotalFeedback = jsonFeedback.replace(/&quot;/g, '"');
        const dataTotalFeedback = JSON.parse(cleanTotalFeedback);
        const totalFeedback = dataTotalFeedback.map(item => item.total);
        console.log(totalFeedback);

        // Menampilkan angka ke dalam elemen dengan id 'total'
        document.getElementById('totalFeedback').innerText = totalFeedback;
    </script>
    <script>
        let dataGuest = '{{ $countGuest }}';

        // Ganti &quot; dengan "
        const cleanedDataString = dataGuest.replace(/&quot;/g, '"');

        // Parse string JSON menjadi array
        const data = JSON.parse(cleanedDataString);

        const countGuest = data.map(item => item.jumlah);
        console.log(countGuest);
        const monthGuest = data.map(item => item.month);
        console.log(monthGuest);

        new Chart("countGuest", {
            type: "line",
            data: {
                labels: monthGuest,
                datasets: [{
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(0,0,255,1.0)",
                    borderColor: "rgba(0,0,255,0.1)",
                    data: countGuest
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            min: 1,
                            max: 10
                        }
                    }],
                }
            }
        });
    </script>
    <script>
        var postbarColors = ["#00CCDD", "#00CCDD", "#00CCDD", "#00CCDD", "#00CCDD", "#00CCDD", "#00CCDD", "#00CCDD",
            "#00CCDD", "#00CCDD", "#00CCDD", "#00CCDD"
        ];

        let getDataPost = '{{ $countPost }}';

        // Ganti &quot; dengan "
        const cleanDatapost = getDataPost.replace(/&quot;/g, '"');

        // Parse string JSON menjadi array
        const dataPost = JSON.parse(cleanDatapost);

        const countPost = dataPost.map(item => item.jumlah);
        console.log(countPost);
        const monthPost = dataPost.map(item => item.month);
        console.log(monthPost);

        new Chart("countPost", {
            type: "bar",
            data: {
                labels: monthPost,
                datasets: [{
                    backgroundColor: postbarColors,
                    data: countPost
                }]
            },
            options: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: "Total Post"
                }
            }
        });
    </script>
    <script>
        var feedbackbarColors = [
            "#507687",
            "#FCFAEE",
            "#B8001F"
        ];

        let getDataFeedback = '{{ $ratioFeedback }}';

        // Ganti &quot; dengan "
        const cleanDataFeedback = getDataFeedback.replace(/&quot;/g, '"');

        // Parse string JSON menjadi array
        const dataFeedback = JSON.parse(cleanDataFeedback);

        const countFeedback = dataFeedback.map(item => item.jumlah);
        console.log(countFeedback);
        const feedback_category = dataFeedback.map(item => item.category_desc);
        console.log(feedback_category);

        new Chart("feedbackPie", {
            type: "pie",
            data: {
                labels: feedback_category,
                datasets: [{
                    backgroundColor: feedbackbarColors,
                    data: countFeedback
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "Rasio Feedback"
                }
            }
        });
    </script>
    <script>
        var barColors = [
            "#0B192C",
            "#1E3E62"
        ];
        let getDataConsultation = '{{ $consultation }}';

        // Ganti &quot; dengan "
        const cleanDataConsultation = getDataConsultation.replace(/&quot;/g, '"');

        // Parse string JSON menjadi array
        const dataConsultation = JSON.parse(cleanDataConsultation);

        const countConsultation = dataConsultation.map(item => item.jumlah);
        console.log(countConsultation);
        const statusConsultation = dataConsultation.map(item => item.status);
        console.log(statusConsultation);


        new Chart("consultationPie", {
            type: "pie",
            data: {
                labels: statusConsultation,
                datasets: [{
                    backgroundColor: barColors,
                    data: countConsultation
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "Jumlah Konsultasi"
                }
            }
        });
    </script>
    <script>
        var barColors = [
            "#6A9AB0",
            "#EAD8B1"
        ];

        let getDataComplaint = '{{ $complaint }}';

        // Ganti &quot; dengan "
        const cleanDataComplaint = getDataComplaint.replace(/&quot;/g, '"');

        // Parse string JSON menjadi array
        const dataComplaint = JSON.parse(cleanDataComplaint);

        const countComplaint = dataComplaint.map(item => item.jumlah);
        console.log(countComplaint);
        const statusComplaint = dataComplaint.map(item => item.status);
        console.log(statusComplaint);

        new Chart("complaintPie", {
            type: "pie",
            data: {
                labels: statusComplaint,
                datasets: [{
                    backgroundColor: barColors,
                    data: countComplaint
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "Jumlah Komplain"
                }
            }
        });
    </script>
@endsection
