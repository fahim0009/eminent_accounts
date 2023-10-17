@extends('frontend.layouts.master')

@section('css')
@endsection

@section('content')
<div class="page-content">

    <div class="twm-home2-banner-section site-bg-gray bg-cover" style="background-image:url({{ asset('assets/images/main-slider/slider2/e10.jpg')}});height:930px">
        <div class="row">
            
            <!--Left Section-->
            {{-- <div class="col-xl-6 col-lg-6 col-md-12">
                <div class="twm-bnr-left-section">
                    <div class="twm-bnr-title-small">We Have <span class="site-text-secondry">208,000+</span> Live Jobs</div>
                    <div class="twm-bnr-title-large">Your <span class="site-text-primary">Dream Job </span> in one place</div> 
                    <div class="twm-bnr-discription">Find jobs that match your interests with us. Jobzilla provides a place you to find your Job.</div>
                    <a href="job-list.html" class="site-button">Get Started</a>
                </div>
            </div> --}}

            <!--right Section-->
            {{-- <div class="col-xl-6 col-lg-6 col-md-12 twm-bnr-right-section">
                <div class="twm-bnr2-right-content">

                    <div class="twm-img-bg-circle-area2">
                        <div class="twm-outline-ring-wrap">
                            <div class="twm-outline-ring-dott-wrap">
                               <span class="outline-dot-1"></span>
                               <span class="outline-dot-2"></span>
                               <span class="outline-dot-3"></span>
                               <!--Samll Ring Left-->
                               <div class="twm-small-ring-l scale-up-center"></div>
                            </div>
                        </div>
                    </div>

                    <div class="twm-home-2-bnr-images">
                        <div class="bnr-image-1">
                            <img src="{{ asset('assets/images/main-slider/slider2/right-pic-1.jpg')}}" alt="">
                        </div>
                        <div class="bnr-image-2">
                            <img src="{{ asset('assets/images/main-slider/slider2/right-pic-2.jpg')}}" alt="">
                        </div>
                        <div class="twm-small-ring-2 scale-up-center"></div>
                    </div>

                    <!--icon-block-1-->
                    <div class="twm-bnr-blocks twm-bnr-blocks-position-1">
                        <div class="twm-icon">
                            <img src="{{ asset('assets/images/main-slider/slider2/icon-1.png')}}" alt="">
                        </div>
                        <div class="twm-content">
                            <div class="tw-count-number text-clr-sky">
                                <span class="counter">12</span>K+
                            </div>
                            <p class="icon-content-info">Companies Jobs</p>
                        </div>
                    </div>

                    <!--icon-block-2-->
                    <div class="twm-bnr-blocks twm-bnr-blocks-position-2">
                        <div class="twm-icon pink">
                            <img src="{{ asset('assets/images/main-slider/slider2/icon-2.png')}}" alt="">
                        </div>
                        <div class="twm-content">
                            <div class="tw-count-number text-clr-pink">
                                <span class="counter">98</span> +
                            </div>
                            <p class="icon-content-info">Job For Countries </p>
                        </div>
                    </div>

                    <!--icon-block-3-->
                    <div class="twm-bnr-blocks-3 twm-bnr-blocks-position-3">
                        <div class="twm-pics">
                            <span><img src="{{ asset('assets/images/main-slider/slider2/user/u-1.jpg')}}" alt=""></span>
                            <span><img src="{{ asset('assets/images/main-slider/slider2/user/u-2.jpg')}}" alt=""></span>
                            <span><img src="{{ asset('assets/images/main-slider/slider2/user/u-3.jpg')}}" alt=""></span>
                            <span><img src="{{ asset('assets/images/main-slider/slider2/user/u-4.jpg')}}" alt=""></span>
                            <span><img src="{{ asset('assets/images/main-slider/slider2/user/u-5.jpg')}}" alt=""></span>
                            <span><img src="{{ asset('assets/images/main-slider/slider2/user/u-6.jpg')}}" alt=""></span>
                        </div>
                        <div class="twm-content">
                            <div class="tw-count-number text-clr-green">
                                <span class="counter">3</span>K+
                            </div>
                            <p class="icon-content-info">Jobs Done</p>
                        </div>
                    </div>

                </div>
            </div> --}}

        </div>
        
    </div>
    <!--Search Bar-->
    <div class="twm-search-bar-2-wrap">
        <div class="container">
            <div class="twm-search-bar-2-inner">

                <div class="row">

                    <div class="col-lg-9 col-md-12">
                        <div class="twm-bnr-search-bar">
                            <form>
                                <div class="row">
                                    <!--Title-->
                                    

                                    <!--All Category-->
                                    <div class="form-group col-lg-4 col-md-6">
                                        <label>Type</label>
                                        <select class="wt-search-bar-select selectpicker"  data-live-search="true" title="" id="j-All_Category" data-bv-field="size">
                                            <option selected>All Category</option>
                                            <option>Web Designer</option>
                                            <option>Developer</option>
                                            <option>Acountant</option>
                                        </select>
                                    </div>

                                    <!--Location-->
                                    <div class="form-group col-lg-4 col-md-6">
                                        <label>Location</label>
                                        <div class="twm-inputicon-box">
                                            <select class="wt-search-bar-select selectpicker"  data-live-search="true" title="" id="j-All_Category" data-bv-field="size">
                                                <option selected>Select Location</option>
                                                <option>Web Designer</option>
                                                <option>Developer</option>
                                                <option>Acountant</option>
                                            </select>
                                            <i class="twm-input-icon fas fa-map-marker-alt"></i>
                                        </div>
                                    </div>

                                    <!--Find job btn-->
                                    <div class="form-group col-lg-4 col-md-6">
                                        <button type="button" class="site-button">Find Job</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <div class="twm-trusted-by-wrap">
                            <div class="twm-trusted-by-title">Trusted By :</div>
                            <div class="owl-carousel trusted-logo owl-btn-vertical-center">
                    
                                <div class="item">
                                    <div class="twm-trusted-logo">
                                        <a href="employer-list.html">
                                            <img src="{{ asset('assets/images/trusted/logo-1.png')}}" alt="">
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="item">
                                    <div class="twm-trusted-logo">
                                        <a href="employer-list.html">
                                            <img src="{{ asset('assets/images/trusted/logo-2.png')}}" alt="">
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="item">
                                    <div class="twm-trusted-logo">
                                        <a href="employer-list.html">
                                            <img src="{{ asset('assets/images/trusted/logo-3.png')}}" alt="">
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="item">
                                    <div class="twm-trusted-logo">
                                        <a href="employer-list.html">
                                            <img src="{{ asset('assets/images/trusted/logo-1.png')}}" alt="">
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="item">
                                    <div class="twm-trusted-logo">
                                        <a href="employer-list.html">
                                            <img src="{{ asset('assets/images/trusted/logo-2.png')}}" alt="">
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="item">
                                    <div class="twm-trusted-logo">
                                        <a href="employer-list.html">
                                            <img src="{{ asset('assets/images/trusted/logo-3.png')}}" alt="">
                                        </a>
                                    </div>
                                </div>
                                
                               
                                
                            </div>
                        </div>
                    </div>

                </div>

                
            </div>
        </div>
    </div>

    <!-- HOW IT WORK SECTION START -->
    <div class="section-full p-t120 p-b90 site-bg-white twm-how-it-work-area2">
                
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12">
                    <!-- TITLE START-->
                        <div class="section-head left wt-small-separator-outer">
                            <div class="wt-small-separator site-text-primary">
                            <div>How It Works </div>                                
                            </div>
                            <h2 class="wt-title">Follow our steps we will help you.</h2>
                            
                        </div>
                        <ul class="description-list">
                            <li>
                                <i class="feather-check"></i>
                                Trusted & Quality Job 
                            </li>
                            <li>
                                <i class="feather-check"></i>
                                International Job 
                            </li>
                            <li>
                                <i class="feather-check"></i>
                                No Extra Charge 
                            </li>
                            <li>
                                <i class="feather-check"></i>
                                Top Companies 
                            </li>
                        </ul>                  
                    <!-- TITLE END-->
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="twm-w-process-steps-2-wrap">
                        <div class="row">

                            @foreach (\App\Models\Work::orderby('id','DESC')->limit(4)->get() as $key => $work)
                                
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <div class="twm-w-process-steps-2">
                                            <div class="twm-w-pro-top bg-clr-{{$work->bg_color}}-light bg-{{$work->bg_color}}-light-shadow">
                                                <span class="twm-large-number text-clr-{{$work->bg_color}}">{{ $key + 1 }}</span>
                                                <div class="twm-media">
                                                    <span><img src="{{ asset('images/'.$work->image)}}" alt="icon1"></span>
                                                </div>
                                                <a href="{{ route('becomeanagent')}}"><h4 class="twm-title">{{$work->title}}</h4></a>
                                                {!! $work->description !!}
                                            </div>
                                            
                                        </div>
                                    </div>
                                
                            @endforeach
                            

                            {{-- <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="twm-w-process-steps-2">
                                    <div class="twm-w-pro-top bg-clr-yellow-light bg-yellow-light-shadow">
                                        <span class="twm-large-number text-clr-yellow">02</span>
                                        <div class="twm-media">
                                            <span><img src="{{ asset('assets/images/work-process/icon4.png')}}" alt="icon1"></span>
                                        </div>
                                        <h4 class="twm-title">Search <br>
                                            Your Job</h4>                                                
                                        <p>You need to create an account to find the best and preferred job.</p>
                                    </div>
                                
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="twm-w-process-steps-2">
                                    <div class="twm-w-pro-top bg-clr-pink-light bg-pink-light-shadow">
                                        <span class="twm-large-number text-clr-pink">03</span>
                                        <div class="twm-media">
                                            <span><img src="{{ asset('assets/images/work-process/icon3.png')}}" alt="icon1"></span>
                                        </div>
                                        <h4 class="twm-title">Apply <br>For Dream Job</h4>
                                        <p>You need to create an account to find the best and preferred job.</p>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="twm-w-process-steps-2">
                                    <div class="twm-w-pro-top bg-clr-green-light bg-clr-light-shadow">
                                        <span class="twm-large-number text-clr-green">04</span>
                                        <div class="twm-media">
                                            <span><img src="{{ asset('assets/images/work-process/icon3.png')}}" alt="icon1"></span>
                                        </div>
                                        <h4 class="twm-title">Upload <br>Your Resume</h4>
                                        <p>You need to create an account to find the best and preferred job.</p>
                                    </div>
                                    
                                </div>
                            </div> --}}

                        </div>
                    </div>
                </div>
            </div>

            

            <div class="twm-how-it-work-section">
                
            </div>                  
        </div>

    </div>   
    <!-- HOW IT WORK SECTION END -->

    <!-- JOBS CATEGORIES SECTION START -->
    <div class="section-full p-t120 p-b90 site-bg-gray twm-job-categories-area2">
        <!-- TITLE START-->
        <div class="section-head center wt-small-separator-outer">
            <div class="wt-small-separator site-text-primary">
               <div>Jobs by Categories</div>                                
            </div>
            <h2 class="wt-title">Choose Your Desire Category</h2>
        </div>                  
        <!-- TITLE END--> 
        
        <div class="container">

            <div class="twm-job-categories-section-2">
               
                <div class="job-categories-style1 m-b30">
                    <div class="row">
                    
                        <!-- COLUMNS 1 --> 
                        @foreach (\App\Models\JobCategory::orderby('id','DESC')->get(); as $key => $jobcat)
                        <div class="col-lg-3 col-md-6">
                            <div class="job-categories-block-2 m-b30">
                                <div class="twm-media">
                                    @if ($key==0)
                                    <div class="flaticon-dashboard"></div>
                                    @elseif ($key==1)
                                    <div class="flaticon-project-management"></div>
                                    @elseif ($key==2)
                                    <div class="flaticon-note"></div>
                                    @elseif ($key==3)
                                    <div class="flaticon-customer-support"></div>
                                    @elseif ($key==4)
                                    <div class="flaticon-bars"></div>
                                    @elseif ($key==5)
                                    <div class="flaticon-user"></div>
                                    @elseif ($key==6)
                                    <div class="flaticon-computer"></div>
                                    @else
                                    <div class="flaticon-coding"></div>
                                    @endif

                                </div>                                   
                                <div class="twm-content">
                                    <div class="twm-jobs-available">9,185 Jobs</div>
                                    <a href="#">{{ $jobcat->name }}</a>
                                </div>                               
                            </div>
                        </div>
                        @endforeach
                                                             

                    </div>
                </div>

                <div class="text-center job-categories-btn">
                    <a href="{{ route('frontend.jobcategory')}}" class=" site-button">All Categories</a>
                </div>

            </div>

        </div>

    </div>   
    <!-- JOBS CATEGORIES SECTION END -->

    <!-- EXPLORE NEW LIFE START -->
    <div class="section-full p-t120 p-b120 site-bg-white twm-explore-area2">
        <div class="container">

            <div class="section-content">
                <div class="twm-explore-content-2">
                    <div class="row">

                        <div class="col-lg-8 col-md-12">
                            <div class="twm-explore-content-outer2">
                                <div class="twm-explore-top-section">
                                    <div class="twm-title-small">For Employee</div>
                                    <div class="twm-title-large">
                                        <h2>We help you connect 
                                            with the organizer</h2>
                                        <p>Get paid easily and security. Use our resources to become
                                            independent and showcase your professional skills.</p>
                                    </div>
                                    <div class="twm-read-more">
                                        <a href="about-1.html" class="site-button">Read More</a>
                                    </div>
                                </div>

                                <div class="twm-explore-bottom-section">
                                    <div class="row">

                                        <!--block 1-->
                                        <div class="col-lg-4 col-md-6">
                                            <div class="counter-outer-two">
                                                <div class="icon-content">
                                                    <div class="tw-count-number text-clr-yellow-2">
                                                        <span class="counter">5</span>M+</div>
                                                    <p class="icon-content-info">Million daily active users</p>
                                                </div>
                                            </div>
                                        </div>
        
                                        <!--block 2-->
                                        <div class="col-lg-4 col-md-6">
                                            <div class="counter-outer-two">
                                                <div class="icon-content">
                                                    <div class="tw-count-number text-clr-green">
                                                        <span class="counter">9</span>K+</div>
                                                    <p class="icon-content-info">Open job positions</p>
                                                </div>
                                            </div>
                                        </div>
        
                                        <!--block 3-->
                                        <div class="col-lg-4 col-md-12">
                                            <div class="counter-outer-two">
                                                <div class="icon-content">
                                                    <div class="tw-count-number text-clr-pink">
                                                        <span class="counter">2</span>M+</div>
                                                    <p class="icon-content-info">Million stories shared</p>
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-12">
                            <div class="twm-explore-media-wrap2">
                                <div class="twm-media">
                                    <img src="{{ asset('assets/images/gir-large-2.png')}}" alt="">
                                </div>
                            </div>
                        </div>

                        

                    </div>
                </div>
            </div>
           
        </div>
    </div>
    <!-- EXPLORE NEW LIFE END -->

    <!-- JOB POST START -->
    <div class="section-full p-t120 p-b90 site-bg-gray twm-bg-ring-wrap2">
        <div class="twm-bg-ring-right"></div>
        <div class="twm-bg-ring-left"></div>
        <div class="container">

            <div class="wt-separator-two-part">
                <div class="row wt-separator-two-part-row">
                    <div class="col-xl-6 col-lg-6 col-md-12 wt-separator-two-part-left">
                        <!-- TITLE START-->
                        <div class="section-head left wt-small-separator-outer">
                            <div class="wt-small-separator site-text-primary">
                            <div>All Jobs Post</div>                                
                            </div>
                            <h2 class="wt-title">Find Your Career You Deserve it</h2>
                        </div>                  
                        <!-- TITLE END-->
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 wt-separator-two-part-right text-right">
                        <a href="{{ route('frontend.job')}}" class=" site-button">Browse All Jobs</a>
                    </div>
                </div>
            </div>
           
            <div class="section-content">
               <div class="twm-jobs-grid-wrap">
                   <div class="row">

                    @foreach (\App\Models\Job::orderby('id','DESC')->limit(9)->get() as $job)
                    <div class="col-lg-4 col-md-6">
                        <div class="twm-jobs-grid-style1  m-b30">
                            <div class="twm-media">
                                <img src="{{ asset('images/'.$job->image)}}" alt="#">
                            </div>
                            <div class="twm-jobs-category green"> @if ($job->status == 0) <span class="twm-bg-brown">Inactive</span> @else <span class="twm-bg-green">Active</span> @endif</div>
                            <div class="twm-mid-content">
                                <a href="{{ route('frontend.jobdtl', $job->id)}}" class="twm-job-title">
                                    <h4>{{ $job->title }}</h4>
                                </a>
                                <p class="twm-job-address">{{$job->address}}, {{$job->location}}</p>
                            </div>
                            <div class="twm-right-content">
                                <a href="{{ route('frontend.jobdtl', $job->id)}}" class="twm-jobs-browse site-text-primary">Browse Job</a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                        


                    </div>
                   
               </div>
            </div>
           
        </div>
    </div>
    <!-- JOB POST END -->

    <!-- FOR EMPLOYEE START -->
    <div class="section-full p-t120 p-b120 twm-for-employee-area site-bg-white">
        <div class="container">

            <div class="section-content">
                <div class="row">

                    <div class="col-lg-5 col-md-12">
                        <div class="twm-explore-media-wrap">
                            <div class="twm-media">
                                <img src="{{ asset('assets/images/boy-large.png')}}" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-12">
                        <div class="twm-explore-content-outer-3">

                            <div class="twm-explore-content-3">
                                <div class="twm-title-small">Explore New Life</div>
                                <div class="twm-title-large">
                                    <h2>Build your personal account profile</h2>
                                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry
                                        the standard dummy text ever since the  when an printer took. lorem Ipsum is 
                                        simply dummy text of the printing and typesetting industry.</p>
                                </div>
                                <div class="twm-upload-file">
                                    <button type="button" class="site-button">Upload Your Resume <i class="feather-upload"></i></button>
                                </div>
                                
                            </div>

                            <div class="twm-l-line-1"></div>
                            <div class="twm-l-line-2"></div>

                        </div>
                    </div>

                </div>
            </div>
           
        </div>
    </div>
    <!-- FOR EMPLOYEE END -->

    <!-- TESTIMONIAL SECTION START -->
    <div class="section-full p-t120 p-b90 site-bg-gray twm-testimonial-2-area">

        <!-- TITLE START-->
        <div class="section-head center wt-small-separator-outer">
            <div class="wt-small-separator site-text-primary">
               <div>Clients Testimonials</div>                                
            </div>
            <h2 class="wt-title">What Our Customers Say About Us</h2>
        </div>                  
        <!-- TITLE END--> 

        <div class="container">

            <div class="section-content"> 
                
                <div class="owl-carousel twm-testimonial-2-carousel owl-btn-bottom-center ">
                
                    <!-- COLUMNS 1 --> 
                    <div class="item ">
                        <div class="twm-testimonial-2">
                            <div class="twm-testimonial-2-content">
                                <div class="twm-testi-media">
                                    <img src="{{ asset('assets/images/testimonials/pic-1.png')}}" alt="#">
                                </div>
                                <div class="twm-testi-content">
                                    <div class="twm-quote">
                                        <img src="{{ asset('assets/images/quote-dark.png')}}" alt="">
                                    </div>
                                    <div class="twm-testi-info">I just got a job that I applied for via careerfy! I used the site all the time during my job hunt.</div>
                                    <div class="twm-testi-detail">
                                        <div class="twm-testi-name">Nikola Tesla</div>
                                        <div class="twm-testi-position">Accountant</div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <!-- COLUMNS 2 --> 
                    <div class="item ">
                        <div class="twm-testimonial-2">
                            <div class="twm-testimonial-2-content">
                                <div class="twm-testi-media">
                                    <img src="images/testimonials/pic-2.png" alt="#">
                                </div>
                                <div class="twm-testi-content">
                                    <div class="twm-quote">
                                        <img src="images/quote-dark.png" alt="">
                                    </div>
                                    <div class="twm-testi-info">I just got a job that I applied for via careerfy! I used the site all the time during my job hunt.</div>
                                    <div class="twm-testi-detail">
                                        <div class="twm-testi-name">Collis Pong</div>
                                        <div class="twm-testi-position">UI/UX Designer</div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <!-- COLUMNS 3 --> 
                    <div class="item ">
                        <div class="twm-testimonial-2">
                            <div class="twm-testimonial-2-content">
                                <div class="twm-testi-media">
                                    <img src="images/testimonials/pic-3.png" alt="#">
                                </div>
                                <div class="twm-testi-content">
                                    <div class="twm-quote">
                                        <img src="images/quote-dark.png" alt="">
                                    </div>
                                    <div class="twm-testi-info">I just got a job that I applied for via careerfy! I used the site all the time during my job hunt.</div>
                                    <div class="twm-testi-detail">
                                        <div class="twm-testi-name">Nikola Tesla</div>
                                        <div class="twm-testi-position">Accountant</div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <!-- COLUMNS 4 --> 
                    <div class="item ">
                        <div class="twm-testimonial-2">
                            <div class="twm-testimonial-2-content">
                                <div class="twm-testi-media">
                                    <img src="images/testimonials/pic-4.png" alt="#">
                                </div>
                                <div class="twm-testi-content">
                                    <div class="twm-quote">
                                        <img src="images/quote-dark.png" alt="">
                                    </div>
                                    <div class="twm-testi-info">I just got a job that I applied for via careerfy! I used the site all the time during my job hunt.</div>
                                    <div class="twm-testi-detail">
                                        <div class="twm-testi-name">Collis Pong</div>
                                        <div class="twm-testi-position">UI/UX Designer</div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

            
                </div>
                
            </div>                              
        </div>
        
    </div>
    <!-- TESTIMONIAL SECTION END -->
    
    <!-- OUR BLOG START -->
    <div class="section-full p-t120 p-b90 site-bg-gray bg-cover overlay-wraper" style="background-image:url({{ asset('assets/images/background/bg-2.jpg')}})">
        <div class="overlay-main site-bg-primary opacity-01"></div>
        <div class="container">
           
            <!-- TITLE START-->
            <div class="section-head center wt-small-separator-outer">
                <div class="wt-small-separator site-text-primary">
                   <div>Our Blogs</div>                                
                </div>
                <h2 class="wt-title site-text-white">Latest Article</h2>
                
            </div>                  
            <!-- TITLE END-->


            <div class="section-content">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-5 col-md-12 m-b30">
                        <!--Block one-->
                        <div class="blog-post twm-blog-post-2-outer">
                            <div class="wt-post-media">
                                <a href="blog-single.html"><img src="{{ asset('assets/images/blog/latest-2/l-1.jpg')}}" alt=""></a>
                            </div>                                    
                            <div class="wt-post-info">
                                <div class="wt-post-meta ">
                                    <ul>
                                        <li class="post-date">April 05, 2023</li>
                                    </ul>
                                </div>
                                                             
                            <div class="wt-post-title ">
                                <h4 class="post-title">
                                    <a href="blog-single.html">
                                        How to convince recruiters and get your 
                                        dream job. Get behind the wheel!
                                    </a>
                                </h4>
                            </div>
                           
                            <div class="wt-post-readmore ">
                                <a href="blog-single.html" class="site-button-link site-text-secondry">Read More</a>
                            </div>                                        
                        </div>                                
                        </div>
                    </div>
                    
                    <div class="col-lg-7 col-md-12">

                        <div class="twm-blog-post-wrap-right">
                            <!--Block two-->
                            <div class="blog-post twm-blog-post-1-outer shadow-none  m-b30">
                                <div class="wt-post-info">

                                    <div class="wt-post-meta ">
                                        <ul>
                                            <li class="post-date">March 05, 2023</li>
                                            <li class="post-author">By <a href="candidate-detail.html">David Wish</a></li>
                                        </ul>
                                    </div>
                                                                
                                    <div class="wt-post-title ">
                                        <h4 class="post-title">
                                            <a href="blog-single.html">5 things to know about the March
                                                2023 jobs report</a>
                                        </h4>
                                    </div>
                                    <div class="wt-post-text ">
                                        <p>
                                            New chip traps clusters of migrating tumor cells asperiortenetur, blanditiis.
                                        </p>
                                    </div>
                                    <div class="wt-post-readmore ">
                                        <a href="blog-single.html" class="site-button-link site-text-primary">Read More</a>
                                    </div> 

                                </div>                                
                            </div>

                            <!--Block three-->
                            <div class="blog-post twm-blog-post-1-outer shadow-none  m-b30">
                                <div class="wt-post-info">
                                    <div class="wt-post-meta ">
                                        <ul>
                                            <li class="post-date">March 05, 2023</li>
                                            <li class="post-author">By <a href="candidate-detail.html">Mike Doe</a></li>
                                        </ul>
                                    </div>
                                                                
                                <div class="wt-post-title ">
                                    <h4 class="post-title">
                                        <a href="blog-single.html">Job Board is the most important 
                                            sector in the world</a>
                                    </h4>
                                </div>
                                <div class="wt-post-text ">
                                    <p>
                                        New chip traps clusters of migrating tumor cells asperiortenetur, blanditiis.
                                    </p>
                                </div>
                                <div class="wt-post-readmore ">
                                    <a href="blog-single.html" class="site-button-link site-text-primary">Read More</a>
                                </div>                                        
                                </div> 
                            </div>

                            <!--Block four-->
                            <div class="blog-post twm-blog-post-1-outer shadow-none  m-b30">
                                <div class="wt-post-info">

                                    <div class="wt-post-meta ">
                                        <ul>
                                            <li class="post-date">March 05, 2023</li>
                                            <li class="post-author">By <a href="candidate-detail.html">David Wish</a></li>
                                        </ul>
                                    </div>
                                                                
                                <div class="wt-post-title ">
                                    <h4 class="post-title">
                                        <a href="blog-single.html">5 things to know about the March
                                            2023 jobs report</a>
                                    </h4>
                                </div>
                                <div class="wt-post-text ">
                                    <p>
                                        New chip traps clusters of migrating tumor cells asperiortenetur, blanditiis.
                                    </p>
                                </div>
                                <div class="wt-post-readmore ">
                                    <a href="blog-single.html" class="site-button-link site-text-primary">Read More</a>
                                </div>                                        
                                </div>                                
                            </div>
                        </div>

                    </div>                                                        
                                                
                </div>
            </div>
           
        </div>
    </div>
    <!-- OUR BLOG END -->


</div>

    
@endsection

@section('scripts')
@endsection