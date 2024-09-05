<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title>@yield('title')</title>
	<meta name="robots" content="noindex" />
	<meta name="googlebot" content="noindex" />
	<meta name="googlebot-news" content="noindex" />
	<meta name="slurp" content="noindex" />
	<meta name="msnbot" content="noindex" />
	<meta content="{{ csrf_token() }}" name="csrf-token">
	<link href="{{ asset('asset/img/favicon.png') }}" rel="icon">
	<link href="{{ asset('asset/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
	<link href="https://fonts.gstatic.com" rel="preconnect">
	<link
		href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
		rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
		integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css"
		integrity="sha512-oAvZuuYVzkcTc2dH5z1ZJup5OmSQ000qlfRvuoTTiyTBjwX1faoyearj8KdMq0LgsBTHMrRuMek7s+CxF8yE+w=="
		crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="{{ asset('asset/css/style.css') }}" rel="stylesheet">
	<style>
		.invalid-feedback {
			display: block !important;
		}
	</style>
	@stack('css')
</head>

<body>

	@include('admin.layouts.header')

	@include('admin.layouts.sidebar')

	@yield('content')

	@include('admin.layouts.footer')

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"
		integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<script src="{{ asset('asset/js/main.js') }}"></script>
	@stack('js')
</body>

</html>