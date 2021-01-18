<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta name="description" content="@yield('description', 'International Longevity Alliance')">
		<meta name="author" content="Adeyinka M. Adefolurin">
		<meta name="robots" content="index, follow">
		<meta name="language" content="English">
		<meta name="keywords" content="health,organization,longevity,ila">

		<!-- Open Graph / Facebook -->
		<meta property="og:type" content="website">
		<meta property="og:url" content="{{ url()->current() }}">
		<meta property="og:title" content="@yield('title', 'International Longevity Alliance')">
		<meta property="og:description" content="@yield('description', 'International Longevity Alliance')">
		<meta property="og:image" content="{{ asset('main/img/logo.png') }}">

		<!-- Twitter -->
		<meta property="twitter:card" content="summary_large_image">
		<meta property="twitter:url" content="{{ url()->current() }}">
		<meta property="twitter:title" content="@yield('title', 'International Longevity Alliance')">
		<meta property="twitter:description" content="@yield('description', 'International Longevity Alliance')">
		<meta property="twitter:image" content="{{ asset('main/img/logo.png') }}">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Icons -->
		<link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
		<link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">

		<!-- Title -->
		<title>@yield('title') | {{ config('app.name') }}</title>

		<!-- Fonts -->
		<link href="{{ asset('master/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> 

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('master/css/sb-admin-2.min.css') }}" rel="stylesheet">
		<link href="{{ asset('master/css/style.css') }}" rel="stylesheet">
	</head>
	
	<body class="@yield('page-background')">
		<div id="app">
			@yield('content')
		</div>

		<!-- Scripts -->	
		<script src="{{ asset('js/app.js') }}"></script>
		<script src="{{ asset('master/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
		<script src="{{ asset('master/js/sb-admin-2.min.js') }}"></script>
	</body>
</html>
