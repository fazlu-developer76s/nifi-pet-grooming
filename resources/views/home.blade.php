

@php
    $company = \App\Helpers\Global_helper::companyDetails();
@endphp
<!DOCTYPE html>
<html lang="en">
   <head>
      <!--website title-->
      <title>{{ @$company->name }}</title>
      <!--seo-meta-tag-->
      <meta charset="UTF-8">
      <meta name="description" content="Insurance Agency HTML Landing Page Template">
      <meta name="keywords" content="Insurance Agency HTML Landing Page Template">
      <meta name="author" content="rajesh-doot">
      <meta name="viewport" content="width=device-width,initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!--website-favicon-->
      @if(@$company->favicon)
      <link rel="icon" type="image/png" href="{{ asset('storage/'.$company->favicon) }}">
      @endif
      <!--plugin-scripts-->
      <link rel="stylesheet" href="{{ asset('website_assets/css/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ asset('website_assets/css/owl.carousel.min.css') }}">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
      <link href="{{ asset('website_assets/css/aos.css') }}" rel="stylesheet">
      <!--google-fonts-->
      <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">
      <!-- template-style-->
      <link rel="stylesheet" type="text/css" href="{{ asset('website_assets/css/style.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('website_assets/css/responsive.css') }}">
   </head>
   <body data-spy="scroll" data-target=".navbar" data-offset="100" class="ct1280">
      <!--Start Header -->
      <header class="top-header th2">
         <nav class="navbar navbar-expand-lg justify-content-between navbar-mobile fixed-top">
            <div class="container">
               <a class="navbar-brand" href="./">
                  @if(@$company->logo)
      <img src="{{ asset('storage/'.$company->logo) }}" alt="Logo" class="white-logo">
      <img src="{{ asset('storage/'.$company->logo) }}" alt="Logo" class="dark-logo">
      @endif
               </a>
               <div class="hide-desk">
                  <a class="mobile-btn btn-call" href="tel:123-456-7890"><i class="fas fa-phone-alt"></i> <span><span class="clltxt"></a>
                  <a class="mobile-btn btn-call getmob" href="#" data-toggle="modal" data-target="#modal_aside_right"> Get Quote</a>

               </div>
               <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbar4" aria-controls="navbar4" aria-expanded="false" aria-label="Toggle navigation">
               <span class="icon-bar top-bar"></span>
               <span class="icon-bar middle-bar"></span>
               <span class="icon-bar bottom-bar"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbar4">
                  <ul class="mr-auto"></ul>
                  <ul class="navbar-nav v-center">
                     <li class="nav-item"> <a class="nav-link" href="#home">Home</a></li>
                     <li class="nav-item"> <a class="nav-link" href="#about">About </a></li>
                     <li class="nav-item"> <a class="nav-link" href="#partners">Partners</a></li>
                     <li class="nav-item"> <a class="nav-link" href="#review">Reviews</a></li>
                     <li class="nav-item"> <a class="nav-link" href="#modal" data-toggle="modal" data-target="#modal_aside_right">Contact Us</a></li>
                     <li class="nav-item"> <a class="nav-link btn-call hide-mob" href="tel:{{ $company->mobile }}">
                        <i class="fas fa-phone-alt"></i> <span><span class="clltxt">Happy to Help you</span> +91 {{ $company->mobile }} </span>                     </a>

                  </li>
                  </ul>
               </div>
            </div>
         </nav>
      </header>
      <!--End Header -->
      <!--Start Hero-->
      <section class="hero-section-1  agency-bg" id="home">
         <div class="blur-bg-blocks">
            <aside class="blur-bg-set">
               <div class="blur-bg blur-bg-a"></div>
               <div class="blur-bg blur-bg-b"></div>
               <div class="blur-bg blur-bg-c"></div>
            </aside>
         </div>
         <div class="container">
            <div class="row justify-content-between">
               <div class="col-lg-5 v-center">
                  <div class="header-heading-1">
                     <h1 class="mb30" data-aos="zoom-out-up">Buy Insurance, <span class="fw3">The Smart Way.</span></h1>
                     <p data-aos="zoom-out-up" data-aos-delay="400">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse faucibus, risus sit amet auctor sodales, justo erat tempor eros.</p>
                     <a href="#modal" data-toggle="modal" data-target="#modal_aside_right" class="btnpora btn-rd2 mt30" data-aos="zoom-out-up" data-aos-delay="600">Get your Quote</a>
                  </div>
                  <div class="hero-feature" data-aos="zoom-out-up" data-aos-delay="800">
                     <div class="media v-center" >
                        <div class="icon-pora"><img src="website_assets/images/icons/fast-time.png" alt="icon" class="w-100"></div>
                        <div class="media-body">Quick, Easy &	Hassle Free</div>
                     </div>
                     <div class="media v-center">
                        <div class="icon-pora"><img src="website_assets/images/icons/customer-services.png" alt="icon" class="w-100"></div>
                        <div class="media-body">100% Claims Support</div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-5">
                  <div class="img-box m-mt60 text-center" data-aos="fade-In" data-aos-delay="400" data-aos-duration="3000"><img src="website_assets/images/hero/beautiful-curly-girl.png" alt="car" class="img-fluid">
                  </div>
               </div>
               </div>

               <div class="row">
                  <div class="col-12">
                     <div class="service-card">
                        <div class="servicecard up-hor">
                           <a href="#">
                              <img src="website_assets/images/icons/family.png" alt="icon">
                              <p>Family Health<br> Insurance</p>
                           </a>
                        </div>
                        <div class="servicecard up-hor">
                           <a href="#">
                              <img src="website_assets/images/icons/umbrella.png" alt="icon">
                              <p>Term Life<br> Insurance</p>
                           </a>
                        </div>
                        <div class="servicecard up-hor">
                           <a href="#">
                              <img src="website_assets/images/icons/heart.png" alt="icon">
                              <p>Health<br> Insurance</p>
                           </a>
                        </div>
                        <div class="servicecard up-hor">
                           <a href="#">
                              <img src="website_assets/images/icons/team.png" alt="icon">
                              <p>Group Health<br> Insurance</p>
                           </a>
                        </div>
                        <div class="servicecard up-hor">
                           <a href="#">
                              <img src="website_assets/images/icons/globe.png" alt="icon">
                              <p>Travel<br> Insurance</p>
                           </a>
                        </div>
                        <div class="servicecard up-hor">
                           <a href="#">
                              <img src="website_assets/images/icons/health-care.png" alt="icon">
                              <p>Life<br> Insurance </p>
                           </a>
                        </div>
                        <div class="servicecard up-hor">
                           <a href="#">
                              <img src="website_assets/images/icons/old.png" alt="icon">
                              <p>Retirement<br> Plans</p>
                           </a>
                        </div>
                        <div class="servicecard up-hor">
                           <a href="#">
                              <img src="website_assets/images/icons/baby-boy.png" alt="icon">
                              <p>Child Savings<br> Plans</p>
                           </a>
                        </div>
                        <div class="servicecard up-hor">
                           <a href="#">
                              <img src="website_assets/images/icons/bycicle.png" alt="icon">
                              <p>2 Wheeler<br> Insurance</p>
                           </a>
                        </div>
                        <div class="servicecard up-hor">
                           <a href="#">
                              <img src="website_assets/images/icons/car.png" alt="icon">
                              <p>Car<br> Insurance</p>
                           </a>
                        </div>
                        <div class="servicecard up-hor">
                           <a href="#">
                              <img src="website_assets/images/icons/invest.png" alt="icon">
                              <p>Investment<br> Plans</p>
                           </a>
                        </div>
                        <div class="servicecard up-hor">
                           <a href="#">
                              <img src="website_assets/images/icons/piggy-bank.png" alt="icon">
                              <p>Saving<br> Plans</p>
                           </a>
                        </div>
                        <div class="servicecard up-hor">
                           <a href="#">
                              <img src="website_assets/images/icons/homeloan.png" alt="icon">
                              <p>Home<br> Loan </p>
                           </a>
                        </div>
                        <div class="servicecard up-hor">
                           <a href="#">
                              <img src="website_assets/images/icons/building.png" alt="icon">
                              <p>Commercial<br> Loan </p>
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!--End Hero-->
      <!--why us start-->
      <div class="enquire-form pad-tb pora-bg1 text-white" id="contact">
         <div class="container">
            <div class="row">
               <div class="col-lg-12">
                  <div class="cta-heading text-center">
                     <span class="subhead" data-aos="fade-up" data-aos-delay="100">Why Choose Pora</span>
                     <h3 data-aos="fade-up" data-aos-delay="300">Live Your Best Life Today, Your Tomorrow Is Secured With Us</h3>
                  </div>
                  <div class="whyus mt60">
                     <div class="whyusbox" data-aos="fade-In" data-aos-delay="100">
                        <div class="imgbdr shadows"> <img src="website_assets/images/icons/student.png" alt="icon"> </div>
                        <p>Child's Education</p>
                     </div>
                     <div class="whyusbox" data-aos="fade-In" data-aos-delay="200">
                        <div class="imgbdr shadows"> <img src="website_assets/images/icons/oldman.png" alt="icon"> </div>
                        <p>Care-free Retirement</p>
                     </div>
                     <div class="whyusbox" data-aos="fade-In" data-aos-delay="300">
                        <div class="imgbdr shadows"> <img src="website_assets/images/icons/security.png" alt="icon"> </div>
                        <p>Financial Security</p>
                     </div>
                     <div class="whyusbox" data-aos="fade-In" data-aos-delay="400">
                        <div class="imgbdr shadows"> <img src="website_assets/images/icons/insurance.png" alt="icon"> </div>
                        <p>Family’s Protection</p>
                     </div>
                     <div class="whyusbox" data-aos="fade-In" data-aos-delay="500">
                        <div class="imgbdr shadows"> <img src="website_assets/images/icons/wealth.png" alt="icon"> </div>
                        <p>Wealth Creation</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--End why us-->
      <!--Start about-->
      <section class="about-bg-2 pad-tb" id="about">
         <div class="container">
            <div class="row m-text-c">
               <div class="col-lg-6 v-center">
                  <div class="about-company">
                     <h2 class="mb20" data-aos="fade-up" data-aos-delay="100">Save <em>Upto 90%</em> with Best <span class="fw3">Insurance Plans offered by insurers</span></h2>
                     <p data-aos="fade-up" data-aos-delay="300">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                     <a href="#" class="btnpora btn-rd2 mt40" data-aos="fade-up" data-aos-delay="600" data-toggle="modal" data-target="#modal_aside_right">Get your Quote</a>
                  </div>
               </div>
               <div class="col-lg-6 v-center">
                  <div class="img-box1 m-mt60" data-aos="fade-up" data-aos-delay="500"><img src="website_assets/images/common/agent.png" alt="feature-image" class="img-fluid"></div>
               </div>
            </div>
         </div>
      </section>
      <!--End about -->
      <!--Start partner-->
      <section class="about-bg pad-tb" id="partners">
         <div class="container">
            <div class="row justify-content-between">
               <div class="col-lg-6 v-center">
                  <div class="partner-company">
                     <h2 class="mb20" data-aos="fade-up" data-aos-delay="100">Our <em>Partners</em></h2>
                     <p data-aos="fade-up" data-aos-delay="100">We collaborate with the best and biggest in the banking & financial Lorem Ipsum has been the industry's standard dummy text.</p>
                  </div>
                  <div class="partnerlogo mt40"  data-aos="fade-In" data-aos-delay="500">
                     <a href="#"><img src="website_assets/images/logo/uilogos-1.png" alt="brand logo"> </a>
                     <a href="#"><img src="website_assets/images/logo/uilogos-2.png" alt="brand logo"> </a>
                     <a href="#"><img src="website_assets/images/logo/uilogos-3.png" alt="brand logo"> </a>
                     <a href="#"><img src="website_assets/images/logo/uilogos-4.png" alt="brand logo"> </a>
                     <a href="#"><img src="website_assets/images/logo/uilogos-5.png" alt="brand logo"> </a>
                     <a href="#"><img src="website_assets/images/logo/uilogos-6.png" alt="brand logo"> </a>
                     <a href="#"><img src="website_assets/images/logo/uilogos-7.png" alt="brand logo"> </a>
                     <a href="#"><img src="website_assets/images/logo/uilogos-8.png" alt="brand logo"> </a>
                     <a href="#"><img src="website_assets/images/logo/uilogos-9.png" alt="brand logo"> </a>
                     <a href="#"><img src="website_assets/images/logo/uilogos-10.png" alt="brand logo"> </a>
                     <a href="#"><img src="website_assets/images/logo/uilogos-11.png" alt="brand logo"> </a>
                     <a href="#"><img src="website_assets/images/logo/uilogos-12.png" alt="brand logo"> </a>
                  </div>
               </div>
               <div class="col-lg-5 v-center">
                  <div class="img-box1 m-mt60"  data-aos="fade-In" data-aos-delay="100"><img src="website_assets/images/common/parntership.png" alt="image" class="img-fluid"></div>
               </div>
            </div>
         </div>
      </section>
      <!--End partner -->

      <!--Start Loan Steps-->
      <section class="step-bg pt50 pb80">
         <div class="container">
            <div class="row">
               <div class="col-lg-5 v-center">
                  <div class="common-heading m-text-c pr50">
                     <h2 class="mb20" data-aos="fade-up" data-aos-delay="100">Choose and Apply for <em>personal credit</em> products on <span class="fw3">Pora Insurance</span></h2>
                     <p data-aos="fade-up" data-aos-delay="100">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                  </div>
               </div>
               <div class="col-lg-7 v-center m-mt60">
                  <div class="row divrightbdr">
                     <div class="col-lg-6">
                        <div class="steps-div  mt30" data-aos="fade-up" data-aos-delay="100">
                           <div class="steps-icons-1">	<img src="website_assets/images/icons/choice.png" alt="steps"> </div>
                           <h4 class="mb10">Wide Choice</h4>
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc aliquet ligula nec leo elementum semper. Mauris aliquet egestas metus.</p>
                        </div>
                        <div class="steps-div mt30" data-aos="fade-up" data-aos-delay="300">
                           <div class="steps-icons-1">	<img src="website_assets/images/icons/credit-card.png" alt="steps"> </div>
                           <h4 class="mb10">Easy Access to Credit</h4>
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc aliquet ligula nec leo elementum semper. Mauris aliquet egestas metus.</p>
                        </div>
                     </div>
                     <div class="col-lg-6 mt60 m-m0">
                        <div class="steps-div mt30" data-aos="fade-up" data-aos-delay="200">
                           <div class="steps-icons-1">	<img src="website_assets/images/icons/easy.png" alt="steps"> </div>
                           <h4 class="mb10">Safe & Secure</h4>
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc aliquet ligula nec leo elementum semper. Mauris aliquet egestas metus.</p>
                        </div>
                        <div class="steps-div mt30" data-aos="fade-up" data-aos-delay="500">
                           <div class="steps-icons-1">	<img src="website_assets/images/icons/customers.png" alt="steps"> </div>
                           <h4 class="mb10">Customer First</h4>
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc aliquet ligula nec leo elementum semper. Mauris aliquet egestas metus.</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!--End Loan Steps-->

      <!--Start CTA-->
      <div class="cta-section pad-tb bg-fixed-img" data-parallax="scroll" data-speed="0.5" data-image-src="website_assets/images/common/wideimg.png">
         <div class="container">
            <div class="row justify-content-center text-center">
               <div class="col-lg-8">
                  <div class="cta-heading">
                     <h2 class="mb20 text-w"  data-aos="fade-up" data-aos-delay="100">Request a Free Consultation!</h2>
                     <p class="text-w"  data-aos="fade-up" data-aos-delay="300">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc aliquet ligula nec leo elementum semper.</p>
                     <a href="#modal" data-toggle="modal" data-target="#modal_aside_right" class="btnpora btn-rd3 mt40 noshadow"  data-aos="fade-up" data-aos-delay="500"> Get your Quote</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--End CTA-->
      <!--Start Agent-->
      <section class="agent-section pad-tb" id="agent">
         <div class="container">
            <div class="row justify-content-center text-center">
               <div class="col-lg-6">
                  <div class="common-heading">
                     <h2 class="mb20" data-aos="fade-up" data-aos-delay="100">Meet The <em>Agents</em></h2>
                     <p data-aos="fade-up" data-aos-delay="300">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                  </div>
               </div>
            </div>
            <div class="row mt30">
               <div class="col-lg-3 col-6 mt30"  data-aos="fade-In" data-aos-delay="100">
                  <div class="full-image-card hover-scale">
                     <div class="image-div"><a href="#"><img src="website_assets/images/agents/team-1.jpg" alt="team" class="img-fluid"></a></div>
                     <div class="info-text-block">
                        <h5><a href="#">Shakita Daoust</a></h5>
                        <p>Insurance Agent</p>
                        <div class="social-links-">
                           <a href="#" target="blank"><i class="fab fa-facebook-f"></i> </a>
                           <a href="#" target="blank"><i class="fab fa-twitter"></i> </a>
                           <a href="#" target="blank"><i class="fab fa-linkedin-in"></i> </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-6 mt30"  data-aos="fade-In" data-aos-delay="300">
                  <div class="full-image-card hover-scale">
                     <div class="image-div"><a href="#"><img src="website_assets/images/agents/team-2.jpg" alt="team" class="img-fluid"></a></div>
                     <div class="info-text-block">
                        <h5><a href="#">Gerard Licari</a></h5>
                        <p>Insurance Agent</p>
                        <div class="social-links-">
                           <a href="#" target="blank"><i class="fab fa-facebook-f"></i> </a>
                           <a href="#" target="blank"><i class="fab fa-twitter"></i> </a>
                           <a href="#" target="blank"><i class="fab fa-linkedin-in"></i> </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-6 mt30"  data-aos="fade-In" data-aos-delay="500">
                  <div class="full-image-card hover-scale">
                     <div class="image-div"><a href="#"><img src="website_assets/images/agents/team-3.jpg" alt="team" class="img-fluid"></a></div>
                     <div class="info-text-block">
                        <h5><a href="#">Cary Montgomery</a></h5>
                        <p>Insurance Agent</p>
                        <div class="social-links-">
                           <a href="#" target="blank"><i class="fab fa-facebook-f"></i> </a>
                           <a href="#" target="blank"><i class="fab fa-twitter"></i> </a>
                           <a href="#" target="blank"><i class="fab fa-linkedin-in"></i> </a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-3 col-6 mt30"  data-aos="fade-In" data-aos-delay="700">
                  <div class="full-image-card hover-scale">
                     <div class="image-div"><a href="#"><img src="website_assets/images/agents/team-4.jpg" alt="team" class="img-fluid"></a></div>
                     <div class="info-text-block">
                        <h5><a href="#">Herman Running</a></h5>
                        <p>Insurance Agent</p>
                        <div class="social-links-">
                           <a href="#" target="blank"><i class="fab fa-facebook-f"></i> </a>
                           <a href="#" target="blank"><i class="fab fa-twitter"></i> </a>
                           <a href="#" target="blank"><i class="fab fa-linkedin-in"></i> </a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!--End Agent-->
      <!--Start Reviews-->
      <section class="reviews-section pad-tb review-bg2" id="review">
         <div class="container">
            <div class="row">
               <div class="col-lg-6">
                  <div class="comon-heading">
                     <h2 class="mb20">Our <em>Happy</em> Customers</h2>
                     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                  </div>
                  <h5 class="mt40">Thousands of unbiased reviews. Trusted by 10 Thousand+ customers.</h5>
                  <ul class="overallrating mt20">
                     <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                     <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                     <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                     <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                     <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star-half-alt"></i></a> </li>
                  </ul>
               </div>
               <div class="col-lg-6">
                  <div class="reviews-block owl-carousel m-mt60">
                     <div class="reviews-card">
                        <div class="-client-details-">
                           <div class="-reviewr">
                              <img src="website_assets/images/reviews/review-image-1.jpg" alt="Good Review" class="img-fluid">
                           </div>
                           <div class="reviewer-text">
                              <h5>Mario Speedwagon</h5>
                              <p>Business Owner</p>
                              <div class="star-rate">
                                 <ul>
                                    <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                                    <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                                    <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                                    <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                                    <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star-half-alt"></i></a> </li>
                                    <li> <a href="javascript:void(0)">4.2</a> </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="review-text pb0 pt30">
                           <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                        </div>
                     </div>
                     <div class="reviews-card">
                        <div class="-client-details-">
                           <div class="-reviewr">
                              <img src="website_assets/images/reviews/review-image-2.jpg" alt="Good Review" class="img-fluid">
                           </div>
                           <div class="reviewer-text">
                              <h5>Mario Speedwagon</h5>
                              <p>Business Owner</p>
                              <div class="star-rate">
                                 <ul>
                                    <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                                    <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                                    <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                                    <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                                    <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star-half-alt"></i></a> </li>
                                    <li> <a href="javascript:void(0)">4.2</a> </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="review-text pb0 pt30">
                           <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                        </div>
                     </div>
                     <div class="reviews-card">
                        <div class="-client-details-">
                           <div class="-reviewr">
                              <img src="website_assets/images/reviews/review-image-3.jpg" alt="Good Review" class="img-fluid">
                           </div>
                           <div class="reviewer-text">
                              <h5>Mario Speedwagon</h5>
                              <p>Business Owner</p>
                              <div class="star-rate">
                                 <ul>
                                    <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                                    <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                                    <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                                    <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star" aria-hidden="true"></i></a> </li>
                                    <li> <a href="javascript:void(0)" class="chked"><i class="fas fa-star-half-alt"></i></a> </li>
                                    <li> <a href="javascript:void(0)">4.2</a> </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="review-text pb0 pt30">
                           <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!--End Reviews-->
      <!--Start Faqs-->
      <section class="faq-section pad-tb ">
         <div class="container">
            <div class="row justify-content-center text-center">
               <div class="col-lg-8">
                  <div class="common-heading">
                     <h2  data-aos="fade-up" data-aos-delay="100">Frequently Asked Questions</h2>
                  </div>
               </div>
            </div>
            <div class="row justify-content-center mt60">
               <div class="col-lg-8">
                  <div id="accordion3" class="accordion">
                     <div class="card-2">
                        <div class="card-header" id="acc1">
                           <button class="btn btn-link btn-block text-left acc-icon" type="button" data-toggle="collapse" data-target="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
                           What Is Pora Insurance?
                           </button>
                        </div>
                        <div id="collapse-1" class="card-body p0 collapse show" aria-labelledby="acc1" data-parent="#accordion3">
                           <div class="data-reqs">
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's specimen book. Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           </div>
                        </div>
                     </div>
                     <div class="card-2 mt10">
                        <div class="card-header" id="acc2">
                           <button class="btn btn-link btn-block text-left acc-icon collapsed" type="button" data-toggle="collapse" data-target="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
                           What kind of insurance policies does Pora Insurance offer?
                           </button>
                        </div>
                        <div id="collapse-2" class="card-body p0 collapse" aria-labelledby="acc2" data-parent="#accordion3">
                           <div class="data-reqs">
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's specimen book. Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           </div>
                        </div>
                     </div>
                     <div class="card-2 mt10">
                        <div class="card-header" id="acc3">
                           <button class="btn btn-link btn-block text-left acc-icon collapsed" type="button" data-toggle="collapse" data-target="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
                           How long does it take to buy an Insurance Policy on Pora Insurance?
                           </button>
                        </div>
                        <div id="collapse-3" class="card-body p0 collapse" aria-labelledby="acc3" data-parent="#accordion3">
                           <div class="data-reqs">
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's specimen book. Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!--End Faqs-->
      <!--Start Footer-->
      <footer>
        <div class="container">
           <div class="row">
              <div class="col-lg-4">
                 <div class="footer- mt30 mb30">
                    @if(@$company->logo)
                    <a href="javascript:void(0)"><img src="{{ asset('storage/'.$company->logo) }}" alt="logo"></a>
                   @endif
                 </div>
                 <p>{{ @$company->name }} is a smarter auto insurance company. We save you money by only talking to you about insurance in moments that matter.</p>
              </div>
              <div class="col-lg-4 col-md-6">
                 <h4 class="mt30 mb30 text-w">Contact Us</h4>
                 <ul class="footer-address-list">
                    <li><i class="fas fa-map-marker-alt"></i> {{ @$company->address }}</li>
                    <li><i class="fas fa-phone-alt"></i> <a href="tel:+91{{ @$company->mobile }}">+91 {{ @$company->mobile }} </a></li>
                    <li><i class="fas fa-envelope"></i> <a href="mailto:{{ @$company->email }}">{{ @$company->email }}</a></li>
                 </ul>
              </div>
              <div class="col-lg-4 col-md-6">
                 <h4 class="mt30 mb30 text-w">Keep in Touch </h4>
                 <div class="footer-social-media-icons">
                    <a href="{{ @$company->facebook }}" target="blank" class="facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{ @$company->twitter }}" target="blank" class="twitter"><i class="fab fa-twitter"></i></a>
                    <a href="{{ @$company->instagram }}" target="blank" class="instagram"><i class="fab fa-instagram"></i></a>
                    <a href="{{ @$company->linkedin }}" target="blank" class="linkedin"><i class="fab fa-linkedin-in"></i></a>
                 </div>
              </div>
           </div>
        </div>
        <div class="copyright">
           <div class="container">
              <div class="row">
                 <div class="col-lg-12">
                    <div class="footer-ft">
                       <p>Copyright © 2021 {{ @$company->name }}. All rights reserved. Powered By <a href="https://nerasoft.app/n/" target="blank">{{ @$company->name }}</a></p>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </footer>
      <!--End Footer-->

      <!--contact popup start-->
      <div id="modal_aside_right" class="modal fixed-left fade" tabindex="-1" role="dialog">
         <div class="modal-dialog modal-dialog-aside" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Express Your Interest!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="form-block border0 noshadow mt30">
                     <form role="form" id="contactForm" data-toggle="validator" class="shake">
                        <div class="row">
                           <div class="form-group col-sm-12">
                              <input type="text" class="form-control" id="name" placeholder="Enter name" required data-error="Please fill Out">
                              <div class="help-block with-errors"></div>
                           </div>
                           <div class="form-group col-sm-12">
                              <input type="email" class="form-control" id="email" placeholder="Enter email" required>
                              <div class="help-block with-errors"></div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="form-group col-sm-12">
                              <input type="text" class="form-control" id="mobile" placeholder="Enter mobile" required data-error="Please fill Out">
                              <div class="help-block with-errors"></div>
                           </div>
                           <div class="form-group col-sm-12">
                              <select name="Dtype" id="Dtype" class="form-control" required>
                                 <option value="">Select Requirement</option>
                                 <option value="op1">Option 1</option>
                                 <option value="op2">Option 2</option>
                                 <option value="op3">Option 3</option>
                              </select>
                              <div class="help-block with-errors"></div>
                           </div>
                        </div>
                        <div class="form-group">
                           <textarea id="message" class="form-control" rows="5" placeholder="Enter your message" required></textarea>
                           <div class="help-block with-errors"></div>
                        </div>
                        <button type="submit" id="form-submit" class="btn-rd w-100">Submit</button>
                        <p class="trm"><i class="fas fa-lock"></i>We hate spam, and we respect your privacy.</p>
                        <div id="msgSubmit" class="h3 text-center hidden"></div>
                        <div class="clearfix"></div>
                     </form>
                     <div class="form-btm-set">
                        <h5>We Deliver</h5>
                        <div class="icon-setss mt20">
                           <div class="icon-rows">
                              <div class="icon-imgg"><img src="website_assets/images/icons/money.svg" alt="#"></div>
                              <div class="icon-txt">
                                 <p>Best Price</p>
                              </div>
                           </div>
                           <div class="icon-rows">
                              <div class="icon-imgg"><img src="website_assets/images/icons/quality.svg" alt="#"></div>
                              <div class="icon-txt">
                                 <p>Quality Service</p>
                              </div>
                           </div>
                           <div class="icon-rows">
                              <div class="icon-imgg"><img src="website_assets/images/icons/call-agent.svg" alt="#"></div>
                              <div class="icon-txt">
                                 <p>Good Support</p>
                              </div>
                           </div>
                           <div class="icon-rows">
                              <div class="icon-imgg"><img src="website_assets/images/icons/satisfaction.svg" alt="#"></div>
                              <div class="icon-txt">
                                 <p>Satisfaction</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--contact popup end-->

      <!-- Main script file -->
      <script src="{{ asset('website_assets/js/jquery.min.js') }}"></script>
      <script src="{{ asset('website_assets/js/bootstrap.min.js') }}"></script>
      <script src="{{ asset('website_assets/js/pora.js.plugin.js') }}"></script>
      <!-- contact from script file -->
      <script src="{{ asset('website_assets/js/validator.min.js') }}"></script>
      <script src="{{ asset('website_assets/js/form-scripts.js') }}"></script>
      <!--common script file-->
      <script src="{{ asset('website_assets/js/main.js') }}"></script>
   </body>
</html>
