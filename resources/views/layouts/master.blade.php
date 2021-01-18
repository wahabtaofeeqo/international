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
		<title>{{ config('app.name') }}</title>

		<!-- Fonts -->
		<link href="{{ asset('master/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> 

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('master/css/sb-admin-2.min.css') }}" rel="stylesheet">
		<link href="{{ asset('master/css/style.css') }}" rel="stylesheet">
	</head>
	
	<body id="page-top">
		<div id="app">
			<div id="wrapper">
				<!-- Sidebar -->
				<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
					<!-- Sidebar - Brand -->
					<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('index') }}">
						<div class="sidebar-brand-icon">
							<i class="fas fa-smile"></i>
						</div>
						<div class="sidebar-brand-text mx-3">{{ config('app.name') }} <sup><i class="fas fa-sm fa-heartbeat"></i></sup></div>
					</a>

					<hr class="sidebar-divider my-0">

					<li class="nav-item">
						<router-link class="nav-link" to="/{{ Auth::user()->role->name }}">
							<i class="fas fa-fw fa-tachometer-alt"></i>
							<span>Dashboard</span>
						</router-link>
					</li>

					@can('canWorkOnPost')
						<li class="nav-item">
							<a class="nav-link collapsed" href="#" id="blogparent" data-toggle="collapse" data-target="#blog" aria-expanded="true" aria-controls="blog">
								<i class="fas fa-fw fa-pen"></i>
								<span>Blog</span>
							</a>
							<div id="blog" class="collapse" aria-labelledby="blog" data-parent="#accordionSidebar">
								<div class="bg-white py-2 collapse-inner rounded">
									<h6 class="collapse-header">Articles:</h6>
									<router-link class="collapse-item" to="/{{ Auth::user()->role->name }}/blog">Add New</router-link>
									<router-link class="collapse-item" to="/{{ Auth::user()->role->name }}/blog/manage">Manage</router-link>
									<h6 class="collapse-header">Comments:</h6>
									<router-link class="collapse-item" to="/{{ Auth::user()->role->name }}/blog/comments">Manage</router-link>
								</div>
							</div>
						</li>
					@endcan

					@can('canWorkOnNewsletter')
						<li class="nav-item">
							<a class="nav-link collapsed" href="#" id="newslettersparent" data-toggle="collapse" data-target="#newsletters" aria-expanded="true" aria-controls="newsletters">
								<i class="fas fa-fw fa-newspaper"></i>
								<span>Newsletters</span>
							</a>
							<div id="newsletters" class="collapse" aria-labelledby="newsletters" data-parent="#accordionSidebar">
								<div class="bg-white py-2 collapse-inner rounded">
									<h6 class="collapse-header">Mailing:</h6>
									<router-link class="collapse-item" to="/{{ Auth::user()->role->name }}/newsletters">Create</router-link>
									<router-link class="collapse-item" to="/{{ Auth::user()->role->name }}/newsletters/manage">Manage</router-link>
								</div>
							</div>
						</li>
					@endcan

					@can('canControlOrganization')
						<li class="nav-item">
							<a class="nav-link collapsed" href="#" id="membershipparent" data-toggle="collapse" data-target="#membership" aria-expanded="true" aria-controls="membership">
								<i class="fas fa-fw fa-users"></i>
								<span>Membership</span>
							</a>
							<div id="membership" class="collapse" aria-labelledby="membership" data-parent="#accordionSidebar">
								<div class="bg-white py-2 collapse-inner rounded">
									<h6 class="collapse-header">Control:</h6>
									<router-link class="collapse-item" to="/{{ Auth::user()->role->name }}/membership/requests">Pending Requests</router-link>
									<router-link class="collapse-item" to="/{{ Auth::user()->role->name }}/membership/add">Add Member</router-link>
									<router-link class="collapse-item" to="/{{ Auth::user()->role->name }}/membership/">Show All</router-link>
								</div>
							</div>
						</li>

						<hr class="sidebar-divider">

						<div class="sidebar-heading">
							General
						</div>

						@can('canControlEverything')
							<li class="nav-item">
								<a class="nav-link collapsed" href="#" id="locationparent" data-toggle="collapse" data-target="#location" aria-expanded="true" aria-controls="location">
									<i class="fas fa-fw fa-map-marker"></i>
									<span>Locations</span>
								</a>
								<div id="location" class="collapse" aria-labelledby="location" data-parent="#accordionSidebar">
									<div class="bg-white py-2 collapse-inner rounded">
										<router-link class="collapse-item" to="/{{ Auth::user()->role->name }}/location/">Country</router-link>
										<router-link class="collapse-item" to="/{{ Auth::user()->role->name }}/location/region">Region</router-link>
										<router-link class="collapse-item" to="/{{ Auth::user()->role->name }}/location/city">City</router-link>
									</div>
								</div>
							</li>
							<li class="nav-item">
								<router-link class="nav-link" to="/{{ Auth::user()->role->name }}/languages">
									<i class="fas fa-fw fa-code"></i>
									<span>Languages</span>
								</router-link>
							</li>
						@endcan
						<li class="nav-item">
							<router-link class="nav-link" to="/{{ Auth::user()->role->name }}/messages">
								<i class="fas fa-fw fa-comment"></i>
								<span>Messages</span>
							</router-link>
						</li>

						<li class="nav-item">
							<router-link class="nav-link" to="/{{ Auth::user()->role->name }}/subscribers">
								<i class="fas fa-fw fa-list"></i>
								<span>Subscribers</span>
							</router-link>
						</li>

						<li class="nav-item">
							<a class="nav-link collapsed" href="#" id="settingsparent" data-toggle="collapse" data-target="#settings" aria-expanded="true" aria-controls="settings">
								<i class="fas fa-fw fa-cog"></i>
								<span>Settings</span>
							</a>
							<div id="settings" class="collapse" aria-labelledby="settings" data-parent="#accordionSidebar">
								<div class="bg-white py-2 collapse-inner rounded">
									<h6 class="collapse-header">Organization:</h6>
									<router-link class="collapse-item" to="/{{ Auth::user()->role->name }}/settings/">Profile</router-link>
									<router-link class="collapse-item" to="/{{ Auth::user()->role->name }}/settings/routing">Routing</router-link>
								</div>
							</div>
						</li>
					@endcan

					<hr class="sidebar-divider">

					<div class="sidebar-heading">
						Personal
					</div>

					<li class="nav-item">
						<router-link class="nav-link" to="/{{ Auth::user()->role->name }}/profile">
							<i class="fas fa-fw fa-user"></i>
							<span>Profile</span>
						</router-link>
					</li>

					<div class="text-center d-none d-md-inline" title="Toggle Sidebar">
						<button class="rounded-circle border-0" id="sidebarToggle"></button>
					</div>
				</ul>

				<div id="content-wrapper" class="d-flex flex-column">
					<!-- Main Content -->
					<div id="content">
						<!-- Topbar -->
						<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
							<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
								<i class="fa fa-bars"></i>
							</button>

							<div class="text-info mr-auto ml-md-2 my-2 my-md-0 mw-100">
								Last seen: {{ \Carbon\Carbon::parse(Auth::user()->last_seen)->diffForHumans() }}
							</div>

							<ul class="navbar-nav ml-auto">
								@if(Auth::user()->organization)
									<div class="topbar-divider d-none d-sm-block"></div>
									
									<li class="nav-item dropdown no-arrow" title="Your Organization">
										<a class="nav-link dropdown-toggle" href="#" id="organizationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<organization-navbar></organization-navbar>
										</a>

										<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="organizationDropdown">
											<a class="dropdown-item" href="{{ route('organization.index', ['id' => Auth::user()->organization_id]) }}">
												<i class="fas fa-globe fa-sm fa-fw mr-2 text-gray-400"></i>
												Open Site
											</a>
											@if(Auth::user()->isAdmin())
											<a class="dropdown-item" href="#">
												<i class="fas fa-cog fa-sm fa-fw mr-2 text-gray-400"></i>
												Settings
											</a>
											@endif
										</div>
									</li>
								@endif

								<div class="topbar-divider d-none d-sm-block"></div>

								<li class="nav-item dropdown no-arrow" title="You">
									<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<profile-navbar></profile-navbar>
									</a>

									<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
											<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
											Logout
										</a>
									</div>
								</li>
							</ul>
						</nav>

						<!-- Components -->
						<div class="container-fluid">
							<router-view></router-view>
						</div>
					</div>
					
					<!-- Footer -->
					<footer class="sticky-footer bg-white">
						<div class="container my-auto">
							<div class="copyright text-center my-auto">
								<span>Copyright &copy; {{ config('app.fullname') }} @php echo date('Y'); @endphp</span>
							</div>
						</div>
					</footer>
				</div>
			</div>

			<!-- Scroll to Top Button-->
			<a class="scroll-to-top rounded" href="#page-top">
				<i class="fas fa-angle-up"></i>
			</a>

			<!-- Logout Modal-->
			<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title text-primary" id="exampleModalLabel">
								Leaving us so soon? <i class="fas fa-smile"></i>
							</h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true"><i class="fas fa-close"></i></span>
							</button>
						</div>
						<div class="modal-body">
							Select "Logout" below if you are ready to end your current session.
						</div>
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
							<a class="btn btn-primary" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
						</div>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
					</div>
				</div>
			</div>
		</div>

		<!-- Scripts -->	
		<script src="{{ asset('js/app.js') }}"></script>
		<script src="{{ asset('master/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
		<script src="{{ asset('master/js/sb-admin-2.min.js') }}"></script>
	</body>
</html>
