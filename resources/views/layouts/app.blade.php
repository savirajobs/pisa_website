<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>@yield('title') | {{ config('app.name') }}</title>

	<link href="asset/img/favicon.png" rel="icon">
	<link href="asset/img/apple-touch-icon.png" rel="apple-touch-icon">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<link href="https://fonts.gstatic.com" rel="preconnect">
	<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">

	<link href="{{ asset('asset') }}/css/frontend.css" rel="stylesheet">
	<link href="{{ asset('asset') }}/css/app.css" rel="stylesheet">
	
	@stack('styles')
</head>

<body>
	<main>
		<div class="container">
			<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

							@yield('content')

							<div class="credits">
								Designed by <a href="#">BootstrapMade</a>
							</div>

						</div>
					</div>
				</div>
			</section>
		</div>
	</main>

	<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha384-1H217gwSVyLSIfaLxHbE7dRb3v4mYCKbpQvzx0cegeju1MVsGrX5xXxAvs/HgeFs" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

	<script src="{{ asset('assets') }}/js/3yMLrbqRXawa2j48.js"></script>
	@stack('scripts')
</body>
</html>