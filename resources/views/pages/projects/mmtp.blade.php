@extends('layouts.main')

@section('title', 'Major Mouse Testing Program — International Longevity Alliance')
@section('activeProjects', 'menu-active')

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
						Projects
					</p>
				</div>	
			</div>
		</div>
	</section>
	
	<section class="sample-text-area">
		<div class="container">
			<p class="sample-text">
				<h4>What is Aging?</h4>
				<p>According to modern science, aging is the accumulation of damage that the body cannot completely eliminate, due to the imperfections of its protection and repair system. As a result, bodily functions start to deteriorate, and the myriads of age-related diseases develop, such as cancer, type 2 diabetes, Alzheimer's disease, osteoarthritis, osteoporosis and others. Science is increasingly showing that we can address the processes behind aging and therefore prevent or slow down the manifestation of these diseases, but there are more than 200 promising interventions that have yet to be tested in robust animal trials before we humans can benefit from them.</p>
				<h4>So why is science to address this progressing so slowly?</h4>
				<p>The traditional model of research is one suffering from a lack of innovation and risk aversion, as a non profit organization the ILA has no such limitations. We are not limited by the restrictions of traditional grant applications where researchers can fall foul of politics nor do we have shareholders expecting a quick return on their investment which helped to create a risk averse culture.</p>
				<p>There is no reason, we have to accept the current situation!  We can work together to do something about it, now! And this is where you, the greater public have an opportunity to invoke real change and progress towards a better, healthier world for us all. We can afford to be much bolder, we can cut to the chase and run the kinds of groundbreaking experiments, that will power rapid progress. You can be a part of that, and help us to become a force for dramatic change!</p>
				<h4>What can we do to increase healthy lifespan?</h4>
				<p>Many experiments have shown that the rate of aging can be altered in vitro. Recent discoveries point towards certain compounds, i.e. geroprotectors, gene therapies and lifestyle interventions which are capable of slowing aging, postponing age-related diseases and even reversing some indicators of aging such as muscle loss and neurodegeneration. Such interventions could significantly extend the healthy and productive period of our lives. We review some of the more exciting achievements in lifespan and healthspan extension further down the page here.</p>
				<p>So far, only a few promising treatments have been tested in mammals, which slows down the development of new therapies for humans. We believe that a  large-scale scientific project, aimed at testing the effect of promising geroprotectors in mice, can significantly accelerate the progress. We also believe that crowdfunding is a good alternative strategy to the less flexible traditional research funding systems. This form of funding gives everyone the opportunity to support the projects they believe will deliver the most benefit to people’s  lives and health.</p>
				<h4>Why we decided to create the Major Mouse Testing Program</h4>
				<p>Currently, the progress in regenerative medicine is too slow, and a big reason for this is the lack of quality lifespan studies being conducted with promising interventions. Another reason for the painfully slow progress in the field is the lack of funding from traditional channels such as grants from the government. Another reason is that We decided to address this problem by creating the <a href="http://majormouse.org/">Major Mouse Testing Program (MMTP)</a>, with the intention of putting the power of change into the hands of the people.</p>
				<p>We believe that the general public would engage more with the exciting possibilities science has to offer, and the key to that engagement is providing opportunities for people to get actively involved and to support the science that excites them the most.</p>
				<p>This is why we believe the MMTP is the ideal project to speed up progress in aging research and make a significant contribution towards interventions that can positively affect our health and longevity. This could be the key to unlocking the fantastic potential of regenerative medicine for the benefit of all mankind!</p>
				<p>Support the project anytime by <a href="">donating to the ILA</a>, or invest in the scientific researh of longevity therapies during active crowdfunding campaigns!</p>
			</p>
		</div>
	</section>
@endsection
