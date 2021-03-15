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
		<meta property="og:url" content="{{ route('index') }}">
		<meta property="og:title" content="@yield('title', 'International Longevity Alliance')">
		<meta property="og:description" content="@yield('description', 'International Longevity Alliance')">
		<meta property="og:image" content="{{ asset('favicon.png') }}">

		<!-- Twitter -->
		<meta property="twitter:card" content="summary_large_image">
		<meta property="twitter:url" content="{{ route('index') }}">
		<meta property="twitter:title" content="@yield('title', 'International Longevity Alliance')">
		<meta property="twitter:description" content="@yield('description', 'International Longevity Alliance')">
		<meta property="twitter:image" content="{{ asset('favicon.png') }}">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Icons -->
		<link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
		<link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">

		<!-- Title -->
		<title>@yield('title') | {{ config('app.name') }}</title>

		<!-- Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('main/css/linearicons.css') }}" rel="stylesheet">
		<link href="{{ asset('main/css/font-awesome.min.css') }}" rel="stylesheet">
		<link href="{{ asset('main/css/magnific-popup.css') }}" rel="stylesheet">
		<link href="{{ asset('main/css/nice-select.css') }}" rel="stylesheet">
		<link href="{{ asset('main/css/hexagons.min.css') }}" rel="stylesheet">
		<link href="{{ asset('main/css/animate.min.css') }}" rel="stylesheet">
		<link href="{{ asset('main/css/owl.carousel.css') }}" rel="stylesheet">
		<link href="{{ asset('main/css/main.css') }}" rel="stylesheet">
		<link href="{{ asset('main/css/style.css') }}" rel="stylesheet">
	</head>
	<body>
		<div id="app">
			<header id="header" id="home">
				<div class="header-top">
					<div class="container">
						<div class="row">
							<div class="col-lg-6 col-sm-6 col-4 header-top-left no-padding">
								<ul>
									<li><a href="#"><i class="fa fa-facebook"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter"></i></a></li>
									<li><a href="#"><i class="fa fa-instagram"></i></a></li>
									<li><a href="#"><i class="fa fa-youtube"></i></a></li>
								</ul>
							</div>
							<div class="col-lg-6 col-sm-6 col-8 header-top-right no-padding">
								<a href="tel:{{ env('ILA_TELEPHONE') }}">{{ env('ILA_TELEPHONE') }}</a>
								<a href="mailto:{{ env('ILA_EMAIL') }}">{{ env('ILA_EMAIL') }}</a>
							</div>
						</div>
					</div>
				</div>
				<div class="container main-menu">
					<div class="row align-items-center justify-content-between d-flex">
						<div id="logo">
							<a href="{{ route('index') }}"><img src="{{ asset('main/img/logo.png') }}" alt="logo" title="ILA" /></a>
						</div>
						<nav id="nav-menu-container">
							<ul class="nav-menu">
								<li class="@yield('activeHome')"><a href="{{ route('index') }}">Home</a></li>
								<li class="@yield('activeAbout') menu-has-children">
									<a href="#">About</a>
									<ul>
										<li><a href="{{ route('about.manifesto') }}">Manifesto</a></li>
										<li><a href="{{ route('about.history') }}">ILA History</a></li>
										<li><a href="{{ route('about.boardMembers') }}">Board of Directors</a></li>
										<li><a href="{{ route('about.advisoryBoard') }}">Board of Advisors</a></li>
										<li><a href="{{ route('about.organizationalCharts') }}">Organizational Chart</a></li>
										<li><a href="{{ route('about.report') }}">Reports</a></li>
									</ul>
								</li>
								<li class="@yield('activeProjects') menu-has-children">
									<a href="#">Projects</a>
									<ul>

										<li><a href="/major-mouse-testing-program">Major Mouse Testing Program</a></li>
										<li><a href="#">Longevity Reporter</a></li>
										<li><a href="#">Public Events</a></li>
										<li><a href="#">Improving Health Policy</a></li>
									</ul>
								</li>
								<li class="@yield('activeLibrary') menu-has-children">
									<a href="#">Library</a>
									<ul>
										<li><a href="#">Videos</a></li>
										<li><a href="#">Books</a></li>
										<li><a href="#">Alliance promotes aging the International Classification of Diseases</a></li>
									</ul>
								</li>
								<li class="@yield('activeMembers')"><a href="#">Members</a></li>
								<li class="@yield('activeContact')"><a href="#">Contact Us</a></li>
								<li class="@yield('activeRegister')">
									@auth
									<a href="{{ route('home') }}">My Account</a>
									@else
									<a href="{{ route('login') }}">Sign In</a>
									@endauth
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</header>

			@yield('content', 'Searching for file...')

			<footer class="footer-area section-gap">
				<div class="container">
					<div class="row">
						<div class="col-lg-5 col-md-6 col-sm-6">
							<div class="single-footer-widget">
								<h6>About Us</h6>
								<p>
									HEALTHY LONGEVITY FOR ALL THROUGH SCIENTIFIC RESEARCH
								</p>
								<p class="footer-text">
									Copyright &copy; 2010 - <?php echo date("Y") ?> All rights reserved
								</p>
							</div>
						</div>
						<div class="col-lg-5  col-md-6 col-sm-6">
							<div class="single-footer-widget">
								<h6>Newsletter</h6>
								<p>Stay update with our latest</p>
								<div class="">
									<form action="#" method="get" class="form-inline">
										<input class="form-control" name="EMAIL" placeholder="Enter Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email '" required="" type="email">
			                            <button class="click-btn btn btn-default"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
									</form>
								</div>
							</div>
						</div>
						<div class="col-lg-2 col-md-6 col-sm-6 social-widget">
							<div class="single-footer-widget">
								<h6>Follow Us</h6>
								<p>Let us be social</p>
								<div class="footer-social d-flex align-items-center">
									<a href="#"><i class="fa fa-facebook"></i></a>
									<a href="#"><i class="fa fa-twitter"></i></a>
									<a href="#"><i class="fa fa-instagram"></i></a>
									<a href="#"><i class="fa fa-youtube"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</footer>
		</div>

		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}"></script>
		<script src="{{ asset('main/js/vendor/jquery-2.2.4.min.js') }}"></script>
		<script src="{{ asset('main/js/easing.min.js') }}"></script>
		<script src="{{ asset('main/js/hoverIntent.js') }}"></script>
		<script src="{{ asset('main/js/superfish.js') }}"></script>
		<script src="{{ asset('main/js/jquery.magnific-popup.min.js') }}"></script>
		<script src="{{ asset('main/js/owl.carousel.min.js') }}"></script>
		<script src="{{ asset('main/js/hexagons.min.js') }}"></script>
		<script src="{{ asset('main/js/jquery.nice-select.min.js') }}"></script>
		<script src="{{ asset('main/js/jquery.counterup.min.js') }}"></script>
		<script src="{{ asset('main/js/waypoints.min.js') }}"></script>
		<script src="{{ asset('main/js/main.js') }}"></script>
	</body>
</html>