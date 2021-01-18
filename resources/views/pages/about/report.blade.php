@extends('layouts.main')

@section('title', 'Report — International Longevity Alliance')
@section('activeAbout', 'menu-active')

@section('content')
	<section class="banner-area relative" id="home">	
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row d-flex align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<h1 class="text-white">
						Reports			
					</h1>	
					<p class="text-white link-nav">
						<a href="{{ route('index') }}">Home </a> 
						<span class="lnr lnr-arrow-right"></span> 
						About Us
					</p>
				</div>	
			</div>
		</div>
	</section>
	
	<section class="sample-text-area">
		<div class="container">
			<p class="sample-text">
				<ul>
					<li>
						<h4>
							<a href="#">The ILA Report 2018</a>
						</h4>
					</li>
					<li>
						<h4>
							<a href="#">The ILA Report 2017</a>
						</h4>
					</li>
					<li>
						<h4>
							<a href="#">The ILA Report 2016</a>
						</h4>
					</li>
					<li>
						<h4>
							<a href="#">The ILA Report 2015</a>
						</h4>
					</li>
					<li>
						<h4>
							<a href="#">The ILA Report 2014</a>
						</h4>
					</li>
					<li>
						<h4>
							<a href="#">The ILA Report 2013</a>
						</h4>
					</li>
				</ul>
			</p>
		</div>
	</section>
@endsection
