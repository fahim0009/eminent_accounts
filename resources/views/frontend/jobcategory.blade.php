@extends('frontend.layouts.master')

@section('css')
@endsection

@section('content')



<!-- CONTENT START -->
<div class="page-content">

    <!-- INNER PAGE BANNER -->
    <div class="wt-bnr-inr overlay-wraper bg-center" style="background-image:url({{ asset('assets/images/banner/1.jpg')}});">
        <div class="overlay-main site-bg-white opacity-01"></div>
        <div class="container">
            <div class="wt-bnr-inr-entry">
                <div class="banner-title-outer">
                    <div class="banner-title-name">
                        <h2 class="wt-title">The Most Exciting Jobs</h2>
                    </div>
                </div>
                <!-- BREADCRUMB ROW -->                            
                
                    <div>
                        <ul class="wt-breadcrumb breadcrumb-style-2">
                            <li><a href="{{ route('homepage')}}">Home</a></li>
                            <li>Job Category</li>
                        </ul>
                    </div>
                
                <!-- BREADCRUMB ROW END -->                        
            </div>
        </div>
    </div>
    <!-- INNER PAGE BANNER END -->


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

            </div>

        </div>

    </div>   
    <!-- JOBS CATEGORIES SECTION END -->
  
    

</div>
<!-- CONTENT END -->



@endsection

@section('scripts')
@endsection