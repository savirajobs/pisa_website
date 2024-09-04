<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/dashboard') ? '' : 'collapsed'}}" href="{{ route('dashboard') }}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        @if (Auth::user()->role == 'super-admin')
        <li class="nav-item">
            <a class="nav-link collapsed">
            <i class="bi bi-card-checklist"></i>
            <span>Other</span>
            </a>
        </li><!-- End Kegiatan Nav -->
        @endif
    </ul>

</aside><!-- End Sidebar-->