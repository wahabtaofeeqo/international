@extends('layouts.main')

@section('title', 'Longevity Reporter — International Longevity Alliance')
@section('activeProjects', 'menu-active')

@section('content')
	<section class="banner-area relative" id="home">	
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row d-flex align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<h1 class="text-white">
						Longevity Reporter			
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
				A weekly newsletter about the science of longevity. Written in a way to be short, catchy and amenable to every environment.
				<p>Website: http://www.longevityreporter.org</p>
				<p>Facebook page: http://www.facebook.com/LongevityReporter</p>

				<h4>Project description and previous releases</h4>
				<p>Various research teams around the world try to give us additional years of healthy life. They conduct experiments publish their results in the scientific press. However, in connection with the conceptual bias of thinking that aging is uncontrollable, research results hardly leak to the media. As a result, the possibilities to achieve breakthroughs are underestimated and are overlooked in the general population and potential investors.</p>
				<p>One of the priorities of the International Longevity Alliance is to support educational activities. Therefore, in 2014 in the framework of the International Longevity Alliance in collaboration with Heales the project "The Longevity Reporter" was created to regularly cover recent advances in science among supporters of healthy life extension, and among all other interested parties.</p>
				<p>
					Releases of the publication can be found here:
					<ul class="unordered-list">
						<li>
							<span>More recent ones: please <a href="http://www.longevityreporter.org/">go to the website</a>, or better, register below to receive the weekly newsletter by email (free!)</span>
						</li>
						<li>
							<span>February 14th, 2015: Would You Rather Die Sooner Than Take a Daily Pill?; How Does the Pharmaceutical Industry Really Work?; Overpopulation and Technological Immortality; Fountain of Youth?; and more.</span>
						</li>
						<li>
							<span>February 7th, 2015:   There Is a Longevity Pill Backed by Five Nobel Prize Winners; Gene Therapy's Big Comeback; Robot Scientist to Discover Drugs Dramatically Faster; Screening for Disease in People Without Symptoms; and more</span>
						</li>
						<li>
							<span>January 31st, 2015: How Do I Know If This Treatment Can Help Me?; President Obama Unveils Precision Medicine Initiative; European Commission Reviews Growing Global Initiatives To Extend Our Lives; Google is Making Human Skin; and more</span>
						</li>
						<li>
							<span>January 24th, 2015: Can We Find Cures For 7,000 Diseases?; The 2015 White House Conference On Aging; How Doctors Die; Counting The Cost Of Cancer; and more</span>
						</li>
						<li>
							<span>January 17th, 2015: Top Health And Fitness Tech From CES 2015; Widespread Cancer Screening Does Little To Prevent Deaths; Cyborg' Implant Delivers Electric Shocks And Drugs; Living Longer, Dying Differently; and more</span>
						</li>
						<li>
							<span>January 10th, 2015: Old Whales - Good Genes; Can We Use An Anti-Diabetic Drug To Treat Cancer?; Google Ventures Shifts Focus To Health Care; Could Meal-In-A-Pill 'Trick' Body Into Losing Weight?; and more</span>
						</li>
						<li>
							<span>January 3rd, 2015: The Necessity Of Longevity; How To Read Health News; How The Promise of Immunotherapy Is Transforming Oncology; When The Doctor’s Away, The Patient Is More Likely To Survive; and more</span>
						</li>
						<li>
							<span>December 27th, 2014: Longevity Reporter’s Best Articles in 2014 - How We Die: Then And Now; Google X Project Aims To Describe A Healthy Human; The Causes Of Cancer You Can Control; Everyday Drugs Could Give Extra Years Of Life; and more</span>
						</li>
						<li>
							<span>December 20th, 2014: Life Expectancy Increases Globally As Death Toll Falls From Major Diseases; The Man Investing Google's Billions Says We Shouldn't Be Afraid To Live Forever; The Seven Deadly Sins Of Health And Science Reporting; Bacteria Shrink Tumors In Humans, Dogs; and more</span>
						</li>
						<li>
							<span>December 13th, 2014: How Vaccines Have Changed Our World, In One Graphic; The Dirty Little Secret of Cancer Research; Can a pill cure binge drinking and dementia?; Gene Therapy Could Help With Blindness; and more</span>
						</li>
						<li>
							<span>December 6th, 2014: Why Everything You Think About Aging May Be Wrong; Immortality Has a Funding Problem; 3-D printing is revolutionizing medicine;  Drug Found To Help Repair Spinal Cord Injuries; and more</span>
						</li>
						<li>
							<span>November 29th, 2014: U.S. has the Most Expensive, Least Effective Health Care System; The Need to Promote Research of Aging; Biotechnology maybe A fanciful approach at curing aging; Silicon Valley joins quest to ‘cure’ aging, and more</span>
						</li>
						<li>
							<span>November 22nd, 2014: Nature’s Guide to Immortality;  An organ shortage is killing people, Lab-Grown Organs may Help;   How to Use Statistics to Live Longer; A Plutocratic Proposal to Accelerate Drug Development; and more</span>
						</li>
						<li>
							<span>November 15th, 2014: The Science of Getting Old, IBM's Watson Will Give You Health Advice Based On Your DNA; 3D Bioprinted Thyroid Gland by 2015 & Kidney by 2018; This Woman's Futuristic Startup Could Change 900,000 Surgeries A Year; and more</span>
						</li>
						<li>
							<span>November 8th, 2014: Our Attitudes Towards Aging, Google Wants to Store Your Genome, Stem Cells Could Repair Parkinson's Damage, Researchers Have Just Found A Better Way To Edit DNA, and more</span>
						</li>
						<li>
							<span>November 1st, 2014: A Beautiful Death - How we want to Die; Watch What Happens to Your Body When You Die: The Chemistry of Death; Live Forever or Die Rich --- How Calico, InSilico Medicine and Human Longevity Inc. are Betting On Big Data to Beat Aging; and more</span>
						</li>
						<li>
							<span>October 18th, 2014: Which cancers kill the most?; Stem cells allow nearly blind patients to see; The billionaires who want to live forever; Google test free doctor-patient video chats; and more</span>
						</li>
						<li>
							<span>October 11th, 2014: Watch Lab-Grown Heart Tissue Beat On Its Own; Can science deliver immortality?;  "The Future of Medicine" with Richard Barker;  U.S. Life Expectancy Continues To Tick Upward; and more</span>
						</li>
						<li>
							<span>October 3rd, 2014: Aging isn’t fixed: we can manipulate it to live longer; Everyday drugs could give us extra years of life; Current healthcare system has a cost problem, Paralyzed rats and humans walk again, and more</span>
						</li>
						<li>
							<span>September 27th, 2014: Living Longer: Peter Diamandis provides evidence of abundance; Peter Thiel: the billionaire tech entrepreneur on a mission to cheat death; Dr. Ilia Stambler’s new book on ‘A History Of Life-Extensionism In The Twentieth Century’; The 7 Most Important Fitness Tracker Measurements; and more</span>
						</li>
						<li>
							<span>September 20th, 2014: How and When We Die - Death Rates from the Major Diseases of Aging; Immortality, Sponsored By Mark Zuckerberg, Sergey Brin And Yuri Milner; $1 million prize offered in scientific contest to find fountain of youth, and more</span>
						</li>
						<li>
							<span>September 13th, 2014: We map the World’s oldest populations; we discover that ‘IBM Watson now answers your questions before you ask, especially medical ones’, we wonder ‘Is it possible to control cancer without killing it?’, we take note of ‘The seven deadly sins of health and science reporting’ and we listen to Dr. George Church talk about ‘The Future Without Limits’; and more</span>
						</li>
						<li>
							<span>September 6th, 2014: We calculate ‘How To Live 10 Years Longer’,  we learn about Google’s Project To ‘Cure Death’, we are elated that a 'Remarkable' new heart drug will cut deaths by 20%, we ponder about ‘How Will Society Adapt When We Are All Living To 150’, and we agree with Aubrey de Grey that ‘Technological Miniaturisation Could Increase Our Lifespans’, and more</span>
						</li>
						<li>
							<span>August 30th, 2014: We understand why ‘Viral Memes & Celebrities Shouldn't Dictate Funding For Diseases’, we are excited about ‘Unlocking The Mystery Of Limb Regeneration’, delighted that a ‘ Whole Organ Grown Inside An Animal For The First Time’, and fascinated by ‘The Man Who Grew Eyes’ and more</span>
						</li>
						<li>
							<span>August 23th, 2014: We checkout the 'Scientific Evidence For Popular Nutritional Supplements'; we eagerly await for 'Young Blood To Be Used In Ultimate Rejuvenation Trial', we wonder about 'Why Are You Not Dead Yet?' and we are glad that 'Extreme Human Longevity Won't Destroy the Planet', and more</span>
						</li>
						<li>
							<span>August 16th, 2014: We analyse 'Just How Long Can People Live?'; We agree that 'Aging revolution must benefit us all', We learn about 'What is Cancer?' and whether 'Daily Aspirin Use Could Reduce Cancer Risk', and more</span>
						</li>
						<li>
							<span>August 8th, 2014:  The Health Hazards of Sitting; A Short Film about 'Who Wants to Live for Ever'; A Gameplan to End Age-related Disease; Bats Could Help Us Live Longer; Cryonic Critique, and more</span>
						</li>
						<li>
							<span>August 1st, 2014: The End of the Age Pyramid, The Economist Explains 'How to Live For Ever', Geraldine Hamilton explains 'How to make Body parts on a Chip', Dr. Bill Andrews talks about ‘How Telomere Research is Turning Back the Aging Clock’ and more</span>
						</li>
						<li>
							<span>July 25th, 2014: Researchers call for action to prevent chronic diseases by treating aging, Google X project aims to describe a healthy human, Human Longevity Inc. uses microbes and metabolites to solve aging diseases, and more</span>
						</li>
						<li>
							<span>July 18th, 2014: Learn about The Causes Of Cancer You Can Control, Researchers Invent An Inexpensive Multi-Cancer Diagnostic, The Failure Rate Of Clinical Trials For Alzheimer’s Is 99.6%. How Can We Improve This Situation?, and more</span>
						</li>
						<li>
							<span>July 12th, 2014: Still alpha testing, but this weeks ILA Newletter is now available here</span>
						</li>
						<li>
							<span>July 1st, 2014: Hello everyone, We at the International Logevity Alliance have created our first Ending Aging Newsletter. You are the first people to see this. Could you please provide feedback about how we can make this better? Cheers, Avi Roy</span>
						</li>
					</ul>
We plan to roll out new releases every week (maybe a little less at first, until the project find its routine speed and logistics) and invite everyone to sign up for free by providing their e-mail.
 
Project Manager: Avi Roy, active member of the International Longevity Alliance. E-mail: avi@longevityalliance.org
 
If you want to share an interesting material, which may be included in the next issue of the publication, please submit a summary of the article and a link to the original article editor to ilanewslettersubmit@gmail.com (language spoken - English).
 
A project team is currently being built (based on volunteering):
 
- Scientific editors - experts in the field of gerontology / medicine / genetics / biology, which can on a regular basis (once a week) to recommend the most interesting articles published in the edition to be published
 
- Amateur journalists - specialists / medical students who attend scientific conferences and can write short notes on them, and to recommend measures such announcements for publication
 
- IT-specialist / content manager - to help with the layout and placement of publication
 
Non-mandatory but still important: good knowledge of English.
 
If you are willing to contribute to the acceleration of the emergence of technologies of control aging, we look forward to seeing you in the project team. Write your ideas and suggestions to the project manager by e-mail or bring like-minded people in!
			</p>
		</div>
	</section>
@endsection
