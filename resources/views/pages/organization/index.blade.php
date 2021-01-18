<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="description" content="{{ $organization->description }}">
		<meta name="author" content="Adeyinka M. Adefolurin">
		<meta name="robots" content="index, follow">
		<meta name="language" content="English">
		<meta name="keywords" content="{{ str_replace(' ', ',', $organization->description) }},longevity,ila">

		<!-- Open Graph / Facebook -->
		<meta property="og:type" content="website">
		<meta property="og:url" content="{{ route('organization.index', ['id' => $organization->id]) }}">
		<meta property="og:title" content="{{ $organization->name }}">
		<meta property="og:description" content="{{ $organization->description }}">
		<meta property="og:image" content="{{ asset('images/logos/'.$organization->logo) }}">

		<!-- Twitter -->
		<meta property="twitter:card" content="summary_large_image">
		<meta property="twitter:url" content="{{ route('organization.index', ['id' => $organization->id]) }}">
		<meta property="twitter:title" content="{{ $organization->name }}">
		<meta property="twitter:description" content="{{ $organization->description }}">
		<meta property="twitter:image" content="{{ asset('images/logos/'.$organization->logo) }}">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Icons -->
		<link rel="shortcut icon" href="{{ asset('images/logos/'.$organization->logo) }}" type="image/x-icon">
		<link rel="icon" href="{{ asset('images/logos/'.$organization->logo) }}" type="image/x-icon">

		<!-- Title -->
		<title>{{ $organization->name }}</title>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Muli:300,400,700,900" rel="stylesheet">

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('organization/css/jquery-ui.css') }}" rel="stylesheet">
		<link href="{{ asset('organization/css/owl.carousel.min.css') }}" rel="stylesheet">
		<link href="{{ asset('organization/css/owl.theme.default.min.css') }}" rel="stylesheet">
		<link href="{{ asset('organization/css/owl.theme.default.min.css') }}" rel="stylesheet">
		<link href="{{ asset('organization/css/jquery.fancybox.min.css') }}" rel="stylesheet">
		<link href="{{ asset('organization/fonts/icomoon/style.css') }}" rel="stylesheet">
		<link href="{{ asset('organization/fonts/flaticon/font/flaticon.css') }}" rel="stylesheet">
		<link href="{{ asset('organization/css/aos.css') }}" rel="stylesheet">
		<link href="{{ asset('organization/css/style.css') }}" rel="stylesheet">
	</head>
	<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300" class="bg-white">
		<div id="app">
			<organization-app></organization-app>
		</div>

		<!-- Scripts -->	
		<script src="{{ asset('js/app.js') }}"></script>
		<script src="{{ asset('organization/js/jquery-3.3.1.min.js') }}"></script>
		<script src="{{ asset('organization/js/jquery-migrate-3.0.1.min.js') }}"></script>
		<script src="{{ asset('organization/js/jquery-ui.js') }}"></script>
		<script src="{{ asset('organization/js/owl.carousel.min.js') }}"></script>
		<script src="{{ asset('organization/js/jquery.stellar.min.js') }}"></script>
		<script src="{{ asset('organization/js/jquery.countdown.min.js') }}"></script>
		<script src="{{ asset('organization/js/jquery.easing.1.3.js') }}"></script>
		<script src="{{ asset('organization/js/aos.js') }}"></script>
		<script src="{{ asset('organization/js/jquery.fancybox.min.js') }}"></script>
		<script src="{{ asset('organization/js/jquery.sticky.js') }}"></script>
		<script src="{{ asset('organization/js/main.js') }}"></script>
	</body>
</html>