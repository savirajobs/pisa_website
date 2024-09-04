@extends('layouts.app')

@section('title','Login')

@section('content')


<div class="card mb-3">

	<div class="card-body">

	<div class="pt-4 pb-2">
		<h5 class="card-title text-center pb-0 fs-4">{{ __('Login') }}</h5>
		<p class="text-center small">Enter your username & password to login</p>
	</div>

	<form class="row g-3" method="POST" action="{{ route('login') }}">
		@csrf
		<div class="col-12">
			<label for="yourEmail" class="form-label">{{ __('Email Address') }}</label>
			<div class="input-group has-validation">
				<span class="input-group-text" id="inputGroupPrepend">@</span>
				<input type="email" class="form-control" id="yourEmail" @error('email') is-invalid @enderror name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
				@error('email')
					<div class="invalid-feedback">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<div class="col-12">
			<label for="yourPassword" class="form-label">{{ __('Password') }}</label>
			<input type="password" name="password" class="form-control" id="yourPassword" required>
			@error('password')
				<div class="invalid-feedback">{{ $message }}</div>
			@enderror
		</div>

		<div class="col-12">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" name="remember" id="rememberMe" value="true" {{ old('remember') ? 'checked' : '' }}>
				<label class="form-check-label" for="rememberMe">{{ __('Remember Me') }}</label>
			</div>
		</div>
		<div class="col-12">
			<button class="btn btn-primary w-100" type="submit">{{ __('Login') }}</button>
		</div>
	</form>

	</div>
</div>
@endsection
