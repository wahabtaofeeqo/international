@extends('layouts.main')

@section('title', 'Advisory Board — International Longevity Alliance')
@section('activeAbout', 'menu-active')

@section('content')
	<section class="banner-area relative" id="home">	
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row d-flex align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<h1 class="text-white">
						Board of Advisors
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

	<section class="whole-wrap">
		<div class="container">
			<div class="section-top-border">
				<h3 class="mb-30">Aubrey de Grey, Ph.D.</h3>
				<div class="row">
					<div class="col-md-3">
						<img class="img-fluid" alt="" src="{{ asset('images/pages/aubrey.jpg') }}">
					</div>
					<div class="col-md-9 mt-sm-20">
						<p>Dr. de Grey is the biomedical gerontologist who researched the idea for and founded SENS Research Foundation. He received his BA in Computer Science and Ph.D. in Biology from the University of Cambridge in 1985 and 2000, respectively. Dr. de Grey is Editor-in-Chief of Rejuvenation Research, is a Fellow of both the Gerontological Society of America and the American Aging Association, and sits on the editorial and scientific advisory boards of numerous journals and organizations. </p>
					</div>
				</div>
			</div>

			<div class="section-top-border">
				<h3 class="mb-30">	Dr. Alexey Moskalev</h3>
				<div class="row">
					<div class="col-md-3">
						<img class="img-fluid" alt="" src="{{ asset('images/pages/alexey.jpg') }}">
					</div>
					<div class="col-md-9 mt-sm-20">
						<p>
							Head of the Laboratory of Molecular Radiobiology and Gerontology Institute of Biology, Komi Science Center of RAS. Author and co-author of many scientific articles covering wide range of topics, from genetics of aging to nutrigenomics. Author of the books "Aging and genes" (2008, in Russian), "120 years of life is just a beginning. How to defeat aging?" (2014, in Rissian), "How to overcome your age? 8 unique methods to reach healthy longevity" (2015, in Russian), "Potential geroprotectors" (2016, in Russian), co-author of the book "Lessons from Drosophila" (2015, in English).
						</p>
					</div>
				</div>
			</div>

			<div class="section-top-border">
				<h3 class="mb-30">Michael Conboy, Ph.D.</h3>
				<div class="row">
					<div class="col-md-3">
						<img class="img-fluid" alt="" src="{{ asset('images/pages/conboy.jpg') }}">
					</div>
					<div class="col-md-9 mt-sm-20">
						<p>
							Michael earned his Ph.D at the the Department of Biological Sciences, Stanford University, CA, in 2000. He has worked in University of California, Berkeley, CA, since 2007 researching immortal DNA, aging and regeneration in mammalian stem cells. He has been instrumental in a number of key studies in regenerative medicine as well as teaching graduate stem cell theory and practice at UCB.
						</p>
					</div>
				</div>
			</div>

			<div class="section-top-border">
				<h3 class="mb-30">Joao Pedro de Megalhaes, Ph.D.</h3>
				<div class="row">
					<div class="col-md-3">
						<img class="img-fluid" alt="" src="{{ asset('images/pages/joao.jpg') }}">
					</div>
					<div class="col-md-9 mt-sm-20">
						<p>
							Dr. de Magalhaes graduated in Microbiology in 1999 from the Escola Superior de Biotecnologia , Portugal, and obtained his PhD in 2004 from the University of Namur, Belgium. Following a postdoc with genomics pioneer Professor George Church at Harvard Medical School in Boston, USA, in 2008 Dr de Magalhaes was recruited to the University of Liverpool in the UK to develop his own group on genomic approaches to aging. 
							<p>Now a senior lecturer, Dr de Magalhaes leads the Integrative Genomics of Ageing Group which focuses on understanding the genetic, cellular, and molecular mechanisms of aging. His research team are world-leaders in employing genomics and bioinformatics to study aging with pioneering work in studying gene networks of aging and in sequencing and analyzing genomes from long-lived species.</p>
						</p>
					</div>
				</div>
			</div>

			<div class="section-top-border">
				<h3 class="mb-30">Dr. Natasha Vita-More</h3>
				<div class="row">
					<div class="col-md-3">
						<img class="img-fluid" alt="" src="{{ asset('images/pages/natasha.jpg') }}">
					</div>
					<div class="col-md-9 mt-sm-20">
						<p>
							Dr. Natasha Vita-More is an author, humanitarian, and innovator whose work focuses on longevity and regenerative generations. As a motivational speaker, she focuses on causes and solutions, while fostering meaningful acknowledgement of others' works who have aspired to identify human potential.
							<p>“An early adapter of revolutionary changes” (Wired, 2000)</p>
							<p>“Advocates the ethical use of technology to expand human capacities” (Politico, 2017).</p>
							<p>Natasha was the Lead Scientific Researcher on the Memory Project, which scientific breakthrough concerns long-term memory of C.elegans and cryonics (2015). As a proponent for mitigating aging, Natasha introduced the seminal field of human enhancement for longevity in academics. Her expertise in the field of ethics has produced high-level scholarship for undergrad and graduate students in the fields of computer science, cybersecurity, robotics, gaming, and business fields. As an entrepreneur, her experience within the domain of foresight studies has established principles and practices for assessing humanity's potential futures. She was the producer and Chair of the Progress Action Summit (2004) that hosted 10 renown experts to strategize a new burden of proof, which became "The Proactionary Principle". In 1997, Natasha originated the first whole-body prosthetic, a seminal innovation comprised of nanomedicine, AI, and robotics that spearheaded alternative bodies to biological degeneration.</p>
							<p>Currently, she is a Senior Professor of Innovation, Entrepreneurship, and Ethics, and serves as the Executive Director of Humanity+. She is also a Fellow at the Institute for Ethics and Emerging Technologies, and author of numerous academic articles and books. </p>
							<p>https://www.natashavita-more.com</p>
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
