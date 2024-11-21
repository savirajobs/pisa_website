<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/dashboard') ? '' : 'collapsed' }}"
                href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @if (Auth::user()->role == 'super-admin')
            <li class="nav-heading">Content Management</li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/post*') ? '' : 'collapsed' }}"
                    href="{{ route('admin.post.index') }}">
                    <i class="bi bi-building-fill"></i>
                    <span>Pos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/user*') ? '' : 'collapsed' }}"
                    href="{{ route('admin.gallery.index') }}">
                    <i class="bi bi-card-image"></i>
                    <span>Galeri</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/user*') ? '' : 'collapsed' }}"
                    href="{{ route('admin.program.index') }}">
                    <i class="bi bi-grid"></i>
                    <span>Layanan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/user*') ? '' : 'collapsed' }}"
                    href="{{ route('admin.law.index') }}">
                    <i class="bi bi-journals"></i>
                    <span>Dasar Hukum</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/user*') ? '' : 'collapsed' }}"
                    href="{{ route('admin.feedback.index') }}">
                    <i class="bi bi-file-earmark-arrow-down"></i>
                    <span>Konsultasi & Pengaduan</span>
                </a>
            </li>
            <li class="nav-heading">Master Management</li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/user*') ? '' : 'collapsed' }}"
                    href="{{ route('admin.category.index') }}">
                    <i class="bi bi-newspaper"></i>
                    <span>Master Category</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/user*') ? '' : 'collapsed' }}"
                    href="{{ route('admin.users.index') }}">
                    <i class="bi bi-person"></i>
                    <span>Master User</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/setting*') ? '' : 'collapsed' }}"
                    href="{{ route('admin.setting.index') }}">
                    <i class="bi bi-gear"></i>
                    <span>Setting Page</span>
                </a>
            </li>
        @else
            <li class="nav-heading">Content Management</li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/post*') ? '' : 'collapsed' }}"
                    href="{{ route('admin.post.index') }}">
                    <i class="bi bi-building-fill"></i>
                    <span>Pos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/user*') ? '' : 'collapsed' }}"
                    href="{{ route('admin.gallery.index') }}">
                    <i class="bi bi-card-image"></i>
                    <span>Galeri</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/user*') ? '' : 'collapsed' }}"
                    href="{{ route('admin.law.index') }}">
                    <i class="bi bi-journals"></i>
                    <span>Dasar Hukum</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('admin/user*') ? '' : 'collapsed' }}"
                    href="{{ route('admin.feedback.index') }}">
                    <i class="bi bi-file-earmark-arrow-down"></i>
                    <span>Konsultasi & Pengaduan</span>
                </a>
            </li>
        @endif
    </ul>

</aside>
