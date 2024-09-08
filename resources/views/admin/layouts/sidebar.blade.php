<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

	<ul class="sidebar-nav" id="sidebar-nav">

		<li class="nav-item">
			<a class="nav-link {{ Request::is('admin/dashboard') ? '' : 'collapsed'}}"
				href="{{ route('admin.dashboard') }}">
				<i class="bi bi-grid"></i>
				<span>Dashboard</span>
			</a>
		</li>

		@if (Auth::user()->role == 'super-admin')
		<li class="nav-heading">Content Management</li>
		<li class="nav-item">
			<a class="nav-link {{ (request()->is('admin/post*')) ? '' : 'collapsed'}}"
				href="{{ route('admin.post.index') }}">
				<i class="bi bi-building-fill"></i>
				<span>Post</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link {{ (request()->is('admin/user*')) ? '' : 'collapsed' }}"
				href="{{ route('admin.users.index') }}">
				<i class="bi bi-card-image"></i>
				<span>Media</span>
			</a>
		</li>
		<li class="nav-heading">Master User</li>
		<li class="nav-item">
			<a class="nav-link {{ (request()->is('admin/user*')) ? '' : 'collapsed' }}"
				href="{{ route('admin.users.index') }}">
				<i class="bi bi-person"></i>
				<span>Master User</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link collapsed">
				<i class="bi bi-card-checklist"></i>
				<span>Other</span>
			</a>
		</li>
		@endif
	</ul>

</aside>