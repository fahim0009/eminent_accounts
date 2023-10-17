@extends('frontend.layouts.master')

@section('css')
@endsection

@section('content')

@php
    $jobcat = \App\Models\JobCategory::where('id', $data->category_id)->first();
@endphp
<!-- CONTENT START -->
<div class="page-content">

    <!-- INNER PAGE BANNER -->
    <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url({{ asset('images/'.$jobcat->image)}});">
        <div class="overlay-main site-bg-white opacity-01"></div>
        <div class="container">
            <div class="wt-bnr-inr-entry">
                <div class="banner-title-outer">
                    <div class="banner-title-name">
                        <h2 class="wt-title">{{$jobcat->name}}</h2>
                    </div>
                </div>
                <!-- BREADCRUMB ROW -->                            
                
                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="{{ route('homepage')}}">Home</a></li>
                            <li>Job Detail</li>
                        </ul>
                    </div>
                
                <!-- BREADCRUMB ROW END -->                        
            </div>
        </div>
    </div>
    <!-- INNER PAGE BANNER END -->



    <!-- OUR BLOG START -->
    <div class="section-full  p-t120 p-b90 bg-white">
        <div class="container">
        
            <!-- BLOG SECTION START -->
            <div class="section-content">
                <div class="row d-flex justify-content-center">
                
                    <div class="col-lg-8 col-md-12">
                        <!-- Candidate detail START -->
                        <div class="cabdidate-de-info">
                            <div class="twm-job-self-wrap">
                                <div class="twm-job-self-info">
                                    <div class="twm-job-self-top">
                                        <div class="twm-media-bg">
                                            <img src="{{ asset('images/'.$data->banner_image)}}" alt="#">
                                            <div class="twm-jobs-category green">@if ($data->status == 0) <span class="twm-bg-brown">Inactive</span> @else <span class="twm-bg-green">Active</span> @endif</div>
                                        </div>
                                        
                                        
                                        <div class="twm-mid-content">

                                            <div class="twm-media">
                                                <img src="{{ asset('images/'.$data->image)}}" alt="#">
                                            </div>

                                            <h4 class="twm-job-title">{{$data->title}}<span class="twm-job-post-duration">/ 1 days ago</span></h4>
                                            <p class="twm-job-address"><i class="feather-map-pin"></i>{{$data->address}}, {{$data->location}}</p>
                                            <div class="twm-job-self-mid">
                                                <div class="twm-job-self-mid-left">
                                                    <div class="twm-jobs-amount">$2000 - $2500 <span>/ Month</span></div>
                                                </div>
                                                <div class="twm-job-apllication-area">Application ends:
                                                    <span class="twm-job-apllication-date">October 1, 2025</span>
                                                </div>
                                            </div>

                                            <div class="twm-job-self-bottom">
                                                <a class="site-button" data-bs-toggle="modal" href="#apply_job_popup" role="button">
                                                    Apply Now
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <h4 class="twm-s-title">Job Description:</h4>

                            {!! $data->description !!}

                            
                          
                            <h4 class="twm-s-title">Share Profile</h4>
                            <div class="twm-social-tags">
                                <a href="javascript:void(0)" class="fb-clr">Facebook</a>
                                <a href="javascript:void(0)" class="tw-clr">Twitter</a>
                                <a href="javascript:void(0)" class="link-clr">Linkedin</a>                                            
                                <a href="javascript:void(0)" class="whats-clr">Whatsapp</a>
                                <a href="javascript:void(0)" class="pinte-clr">Pinterest</a>
                            </div>

                            

                            

                            
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-12 rightSidebar">

                        <div class="side-bar mb-4">
                            <div class="twm-s-info2-wrap mb-5">
                                <div class="twm-s-info2">
                                    <h4 class="section-head-small mb-4">Job Information</h4>
                                    <ul class="twm-job-hilites">
                                        <li>
                                            <i class="fas fa-calendar-alt"></i>
                                            <span class="twm-title">Date Posted</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-eye"></i>
                                            <span class="twm-title">8160 Views</span>
                                        </li>
                                        <li>
                                            <i class="fas fa-file-signature"></i>
                                            <span class="twm-title">6 Applicants</span>
                                        </li>
                                    </ul>
                                    <ul class="twm-job-hilites2">

                                        <li>
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-calendar-alt"></i>
                                                <span class="twm-title">Date Posted</span>
                                                <div class="twm-s-info-discription">April 22, 2023</div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span class="twm-title">Location</span>
                                                <div class="twm-s-info-discription">Munchen, Germany</div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-user-tie"></i>
                                                <span class="twm-title">Job Title</span>
                                                <div class="twm-s-info-discription">Web Developer</div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-clock"></i>
                                                <span class="twm-title">Experience</span>
                                                <div class="twm-s-info-discription">3 Year</div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-suitcase"></i>
                                                <span class="twm-title">Qualification</span>
                                                <div class="twm-s-info-discription">Bachelor Degree </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twm-s-info-inner">
                                                <i class="fas fa-venus-mars"></i>
                                                <span class="twm-title">Gender</span>
                                                <div class="twm-s-info-discription">Both</div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="twm-s-info-inner">
                                                
                                                <i class="fas fa-money-bill-wave"></i>
                                                <span class="twm-title">Offered Salary</span>
                                                <div class="twm-s-info-discription">$2000-$2500 / Month</div>
                                            </div>
                                        </li>

                                    </ul>
                                    
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
<!-- CONTENT END -->



<!-- BUTTON TOP START -->
<button class="scroltop"><span class="fa fa-angle-up  relative" id="btn-vibrate"></span></button>

<!--apply job popup -->
<div class="modal fade" id="apply_job_popup" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
                <div class="modal-header">
                    <h4 class="modal-title" id="sign_up_popupLabel">Apply For This Job</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            
            <div class="modal-body">
                <div class="apl-job-inpopup">
                    <!--Basic Information-->
                    <div class="panel panel-default">
                        
                        <div class="panel-body wt-panel-body p-a20 ">

                            <div class="twm-tabs-style-1">
                                    
                                <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label>Your Name</label>
                                                <div class="ls-inputicon-box"> 
                                                    <input class="form-control" name="company_name" type="text" placeholder="Devid Smith">
                                                    <i class="fs-input-icon fa fa-user "></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label>Email Address</label>
                                                <div class="ls-inputicon-box"> 
                                                    <input class="form-control" name="company_Email" type="email" placeholder="Devid@example.com">
                                                    <i class="fs-input-icon fas fa-at"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Message</label>
                                                <textarea class="form-control" rows="3" placeholder="Message sent to the employer"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <label>Upload Resume</label>
                                                <form action="upload.php" class="dropzone dz-clickable"><div class="dz-default dz-message"><span><i class="sl sl-icon-plus"></i> Click here or drop files to upload</span></div></form>
                                                <small>If you do not have a resume document, you may write your brief professional profile <a class="site-text-primary" href="javascript:void(0);">here</a></small>
                                            </div>                                    
                                        </div>

                                    
                                                        
                                        <div class="col-xl-12 col-lg-12 col-md-12"> 
                                            <div class="text-left">
                                                <button type="submit" class="site-button">Send Application</button>
                                            </div>
                                        </div> 
                                        
                                    
                                        
                                </div>
                                
                            </div>  

                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    
</div>


@endsection

@section('scripts')
@endsection