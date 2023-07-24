@php
$configData = Helper::applClasses();
@endphp
@extends('layouts/fullLayoutMaster')

@section('title', 'Login')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection

@section('content')
<div class="auth-wrapper auth-cover">
  <div class="auth-inner row m-0">
	<!-- Brand logo-->
	{{-- <a class="brand-logo" href="#">
		<img src="{{ asset('images/login/pm2.png')}}" style="max-width:10%">
	</a> --}}
	<!-- /Brand logo-->

	<!-- Left Text-->
	<div class="d-none d-lg-flex col-lg-8 align-items-center ">
	  <div class="w-100 d-lg-flex align-items-center justify-content-center ">
		@if($configData['theme'] === 'dark')
		  <img class="img-fluid" src="{{asset('images/login/loginbg.svg')}}" style="max-width:70%" alt="Login V2" />
		  @else
		  <img class="img-fluid" src="{{asset('images/login/loginbg.svg')}}" style="max-width:70%" alt="Login V2" />
		  @endif
	  </div>
	</div>
	<!-- /Left Text-->

	<!-- Login-->
	<div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
	  <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
			
		<div class="text-center">
			<img src="{{ asset('images/login/punto.png')}}" style="max-width:50%;padding-bottom:5px">
			<h2 class="card-title fw-bold mb-1">Bienvenidos 👋</h2>
			<p class="card-text mb-2">Iniciar Sesión</p>
		</div>

		<form class="auth-login-form mt-2" action="{{route('login')}}" method="POST">
			@csrf
		  <div class="mb-1">
			<label class="form-label" for="email">Correo</label>
			<input class="form-control @error('email') error @enderror" id="email" type="text" name="email" placeholder="user@perumedical.pe" value="{{old('email')}}" aria-describedby="email @error('email'){{'email-error'}}@enderror" autofocus="" tabindex="1" />
			@error('email')
				<span id="email-error" class="error">{{$message}}</span>
			@enderror
		  </div>
		  <div class="mb-1">
			<div class="d-flex justify-content-between">
			  <label class="form-label" for="password">Contraseña</label>
			  <a href="{{url("auth/forgot-password")}}">
				<small>Olvidaste tu contraseña?</small>
			  </a>
			</div>
			<div class="input-group input-group-merge form-password-toggle">
			  <input class="form-control form-control-merge @error('password') error @enderror" id="password" type="password" name="password" placeholder="············" aria-describedby="password @error('password'){{'password-error'}}@enderror" tabindex="2" />
			  <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
			</div>
			@error('password')
				<span id="password-error" class="error">{{$message}}</span>
			@enderror
		  </div>
		  <button class="btn btn-primary w-100" tabindex="4">Ingresar</button>
		</form>
	  </div>
	</div>
	<!-- /Login-->
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))}}"></script>
@endsection

@section('page-script')
<script src="{{asset(mix('js/scripts/pages/auth-login.js'))}}"></script>
@endsection
