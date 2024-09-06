@extends('auth.layouts.app')

@section('title','Login')

@section('content')
<div class="col-sm-6 login-section-wrapper">
	<div class="brand-wrapper">
		<img src="{{ asset('asset/img/logo.png') }}" alt="{{ config('app.name') }}" class="logo">
	</div>
	<div class="login-wrapper my-auto">
		<h1 class="login-title">{{ __('Login') }}</h1>
		<form method="POST" action="{{ route('login') }}">
			@csrf
			<div class="form-group">
				<label for="email">{{ __('Email Address') }}</label>
				<input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
					placeholder="email@example.com">
				@error('email')
				<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<div class="form-group mb-4">
				<label for="password">{{ __('Password') }}</label>
				<input type="password" name="password" id="password"
					class="form-control @error('password') is-invalid @enderror" placeholder="enter your passsword">
				@error('password')
				<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
			<button class="btn btn-block login-btn">{{ __('Login') }}</button>
		</form>
		</p>
	</div>
</div>
<div class="col-sm-6 px-0 d-none d-sm-block">
	<img src="{{ asset('asset/img/login.jpg') }}" alt="{{ config('app.name') }}" class="login-img">
</div>
@endsection