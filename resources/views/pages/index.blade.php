@extends('layouts.main')

@section('title', 'Home — International Longevity Alliance')
@section('activeHome', 'menu-active')

@section('content')
	<!-- Banner -->
	<section class="banner-area relative" id="home">
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row fullscreen d-flex align-items-center justify-content-center">
				<div class="banner-content col-lg-12 col-md-12">
					<div class="banner-info">
						<h6 class="text-uppercase">Welcome to   </h6>
						<h1>International Longevity Alliance (ILA)</h1>
						<p class="text-white">HEALTHY LONGEVITY FOR ALL THROUGH SCIENTIFIC RESEARCH</p>
					</div>

					<a href="#introduction" class="primary-btn header-btn text-uppercase">Get Started</a>
					<a href="{{ route('register') }}" class="success-btn header-btn text-uppercase">Register with Us</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Vision and Mission -->
	<section class="" id="introduction">
		<div class="container">
			<div class="section-top-border">
				<h3 class="mb-30">Our Vision</h3>
				<div class="row">
					<div class="col-lg-12">
						<blockquote class="generic-blockquote">
							“To create the world where every person can obtain healthy longevity and ageing control through innovative technologies.”
						</blockquote>
					</div>
				</div>
				<h3 class="mb-30">Our Mission</h3>
				<div class="row">
					<div class="col-lg-12">
						<blockquote class="generic-blockquote">
							“To promote the advancement of healthy longevity for all people through scientific research of ageing biology, development of new drugs and therapies, their fast implementation, improvement of public health policy in the field of ageing control, and education.”
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Services -->
	<section class="cat-area section-gap bg-white" id="feature">
		<div class="container">
			<h3 class="mb-20 text-center">What we are all about</h3>
			<div class="row">
				<div class="col-lg-4">
					<div class="single-cat d-flex flex-column">
						<span class="hb-sm-margin mx-auto d-block">
							<span class="hb hb-sm inv hb-facebook-inv">
								<span class="lnr lnr-rocket"></span>
							</span>
						</span>
						<h4 class="mb-20" style="margin-top: 23px;">Communication</h4>
						<p>
							We disseminate the most up-to-date information on promising geroprotective drugs, therapies, and diagnostic methods
						</p>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="single-cat">
						<span class="hb-sm-margin mx-auto d-block">
							<span class="hb hb-sm inv hb-facebook-inv">
								<span class="lnr lnr-earth"></span>
							</span>
						</span>
						<h4 class="mt-40 mb-20">Networking</h4>
						<p>
							We are networking within the research community, the decision makers and the public sectors to join forces all over the world
						</p>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="single-cat">
						<span class="hb-sm-margin mx-auto d-block">
							<span class="hb hb-sm inv hb-facebook-inv">
								<span class="lnr lnr-volume-high"></span>
							</span>
						</span>
						<h4 class="mt-40 mb-20">Innovation</h4>
						<p>
							We initiate public dialogue to improve regulation of fundamental and translational research for aging prevention
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Blog Posts -->
	<section class="blog-area section-gap" id="blog">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12 pb-30 header-text">
					<h1>Latest posts from our Blog</h1>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut <br> labore  et dolore magna aliqua.
					</p>
				</div>
			</div>
			<div class="row">
				@foreach($posts as $post)

					<div class="single-blog col-lg-4 col-md-4">
						<div class="thumb">
							<img class="f-img img-fluid mx-auto" src="{{ asset("images/posts/$post->featured_image") }}">
						</div>
						<div class="bottom d-flex justify-content-between align-items-center flex-wrap">
							<div>
								<img class="img-fluid" src="{{ asset('images/posts/$post->featured_image') }}" alt="">
							 </div>

							<div class="meta">
								{{$post->created_at}}
								<!-- <span class="fa fa-heart"></span> 15 -->
								<span class="fa fa-comment"></span> {{$post->comments_count}}
							</div>
						</div>

						<a href="/organization/{{$post->organization_id}}/post/{{$post->id}}">
							<h4>{{$post->title}} </h4>
						</a>

						<p>
							{{ strip_tags(substr($post->content,0,150))	}}
						</p>
					</div>
				@endforeach
			</div>

			<div class="row justify-content-center">
				<a href="/organization/1" class="primary-btn">Show More</a>
			</div>
		</div>
	</section>

	<!-- Donation Panel -->
	<section class="home-about-area section-gap bg-white" id="donations">
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-lg-8 col-md-12 home-about-left">
					<h6>The best financial contribution for long and healthy lives</h6>
					<h1>
						Donations
					</h1>
					<p class="sub">Why donate to the ILA?</p>
					<p class="pb-20 text-justify">
						After one year of investigation for the best financing structure, the ILA fund was registered as a not-for-profit "fonds de dotation" dedicated to research towards improving lives: a specific structure in France that allows worldwide optimal fiscal advantages for donations. As indicated when donating below, depending on the country you live in, instead of donating to ILA directly you can donate to an ILA branch to have tax deductions. Also regarding Paypal donations, Paypal has accepted to use apply fees for ILA donations. We are taking action to continuously increase such advantages in order to attract worldwide donations for life-saving research. Would you represent an official, not-for-profit structure from another country whose goal is aligned with the ILA, or would you like to suggest some other advantage and try to implement it, please contact us at info@longevityalliance.org
					</p>
					<a class="primary-btn" href="{{ route('donate') }}">Read More</a>
				</div>
				<div class="col-lg-4 col-md-12 home-about-right relative">
					<form class="form-wrap" action="#">
						<h4 class="text-white pb-20">Quickly Donate Unanimously</h4>

						<div class="form-group">
							<a href="{{ route('donate') }}" class="primary-btn">Proceed to Donate</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
@endsection
