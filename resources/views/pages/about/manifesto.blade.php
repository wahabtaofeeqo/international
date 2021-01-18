@extends('layouts.main')

@section('title', 'Manifesto — International Longevity Alliance')
@section('activeAbout', 'menu-active')

@section('content')
	<section class="banner-area relative" id="home">	
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row d-flex align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<h1 class="text-white">
						Manifesto			
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
				We, the members of the International Longevity Alliance, believe that, through evidence based innovative biotechnologies, it is desirable and feasible to prevent degenerative ageing processes, thereby extending the active and healthy human lifespan.
			</p>
			<p class="sample-text">
				We recognize that the degenerative and destructive processes known collectively as biological ageing are the main cause of the development of age-related diseases and frailty in older age (including cancers, dementias, heart failures, strokes and diabetes), causing suffering for  millions of people globally;
			</p>
			<p class="sample-text">
				We note that science is developing the ability to slow and eradicate those degenerative ageing processes - and by doing so, to prevent, delay and compensate for age-related diseases, as extending healthspan and lifespan through innovative biotechnologies has proven to be successful in animal testing, and promising in some studies in humans;
			</p>
			<p class="sample-text">
				We acknowledge health as a human right and we promote an understanding of the ageing process as a medical condition requiring treatment;
			</p>
			<p class="sample-text">
				We emphasize that healthy life extension technologies can reduce the cost of social protection and health care systems by extending healthy activity into advanced years, benefitting the global economy and enhancing individual financial well-being;
			</p>
			<p class="sample-text">
				We are concerned that there is a deficit of information among decision-makers which, combined with continuing regulatory barriers and a lack of funding of fundamental and translational research, unnecessarily hinders progress in this most important field;
			</p>
			<p class="sample-text">
				International Longevity Alliance members are committed to work actively to facilitate faster development and implementation of life-extending technologies to ensure healthy longevity for all.
			</p>
			<p>
				We work in the following areas to achieve this goal:
				<ol class="ordered-list">
					<li>
						<span>Initiating and developing ILA’s research projects and facilitating research projects by other teams and institutions in the areas of biology of ageing and the development of geroprotective drugs, therapies and diagnostic methods;</span>
					</li>
					<li>
						<span>Facilitating professional networking within the research community, building connections with decision makers in business and the public sectors to join forces all over the world to develop and implement therapies to control biological ageing;</span>
					</li>
					<li>
						<span>Initiating public dialogue to improve regulation of fundamental and translational research to prevent and treat the degenerative ageing processes, as well as developing proposals to amend regulation at the national and global levels;</span>
					</li>
					<li>
						<span>Broadly disseminating the most up-to-date information on research into the biology of ageing and the development of promising geroprotective drugs, therapies, and diagnostic methods.</span>
					</li>
				</ol>
			</p>
			<p class="sample-text">
				We, the International Longevity Alliance members, believe that these goals are of the utmost importance to all. Our collective action will bring closer safe and effective biomedical technologies which will allow people to control the ageing processes, to prevent the development of age-related diseases, and to give people more years of healthy and active life.
			</p>
			<p class="sample-text">
				We call on people from all over the world to join forces in the fight against degenerative ageing processes.
			</p>
		</div>
	</section>
@endsection
