@extends('layouts.main')

@section('title', 'Organizational Charts — International Longevity Alliance')
@section('activeAbout', 'menu-active')

@section('content')
	<section class="banner-area relative" id="home">	
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row d-flex align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<h1 class="text-white">
						Organizational Charts			
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
				Under Construction
			</p>
		</div>
	</section>
@endsection
