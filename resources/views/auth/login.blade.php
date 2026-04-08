<!DOCTYPE html>
<html lang="fr-FR">
<head>
	<title>{{ config('app.name') }} - Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{ asset('assets/images/icons/favicon.ico') }}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/fonts/iconic/css/material-design-iconic-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/animsition/css/animsition.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/daterangepicker/daterangepicker.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100" style="background-image: url('assets/images/temple.jpeg');">
			<div class="wrap-login100">
                {{-- INCLUDING MESSAGE --}}
                @include('auth._messages')
                {{-- INCLUDING FORM --}}

				@if (session('retry_after'))
					<div class="alert alert-danger">
						⏳ Trop de tentatives de connexion.<br>
						Réessayez dans <strong>
							<span id="countdown">{{ session('retry_after') }}</span>
						</strong> secondes.
					</div>
				@endif


				<form class="login100-form validate-form" action="{{ route('auth_login') }}" method="post">
                    @csrf

					<span class="login100-form-title p-b-34 p-t-5">
						CONNEXION
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" value="{{ old('username') }}" placeholder="Nom utilisateur">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					{{-- @error('username')
						<small class="text-danger d-block mt-1">
							{{ $message }}
						</small>
					@enderror --}}
					{{-- @error('password') is-invalid @enderror --}}

					<div class="wrap-input100 validate-input " data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Mot de passe">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					{{-- @error('password')
						<small class="text-danger d-block mt-1">
							{{ $message }}
						</small>
					@enderror --}}

					<div class="container-login100-form-btn">
						<button id="loginBtn" class="login100-form-btn" type="submit">
							Se connecter
						</button>
					</div>

					<div class="text-center p-t-20">
						<a class="txt1" href="#">
							Mot de passe oublié ?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	@if (session('retry_after'))
		<script>
			let seconds = {{ session('retry_after') }};
			const btn = document.getElementById('loginBtn');
			const countdownEl = document.getElementById('countdown');

			if (btn) {
				btn.disabled = true;
				btn.innerText = `Connexion (${seconds}s)`;
			}

			const timer = setInterval(() => {
				seconds--;

				if (seconds <= 0) {
					clearInterval(timer);

					if (btn) {
						btn.disabled = false;
						btn.innerText = 'Se connecter';
					}

					if (countdownEl) {
						countdownEl.innerText = '0';
					}

					return;
				}

				if (btn) btn.innerText = `Connexion (${seconds}s)`;
				if (countdownEl) countdownEl.innerText = seconds;

			}, 1000);
		</script>
	@endif

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="{{ asset('assets/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('assets/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('assets/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('assets/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('assets/vendor/countdowntime/countdowntime.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('assets/js/main.js') }}"></script>

</body>
</html>