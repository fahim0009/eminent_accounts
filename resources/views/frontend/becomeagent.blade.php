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
                                <h2 class="wt-title">Become an agent</h2>
                            </div>
                        </div>
                        <!-- BREADCRUMB ROW -->                            
                        
                            <div>
                                <ul class="wt-breadcrumb breadcrumb-style-2">
                                    <li><a href="{{ route('homepage')}}">Home</a></li>
                                    <li>Become an agent</li>
                                </ul>
                            </div>
                        
                        <!-- BREADCRUMB ROW END -->                        
                    </div>
                </div>
            </div>
            <!-- INNER PAGE BANNER END -->


            <!-- OUR BLOG START -->
            <div class="section-full  p-b90 site-bg-white">
                

                <div class="container">
                    <div class="row">

                        <div class="col-xl-12 col-lg-8 col-md-12 m-b30">
                            <!--Filter Short By-->
                            <div class="twm-right-section-panel site-bg-gray">
                                <h5 class="txt-secondary pb-3 mt-5 pb-3 text-capitalize">
                                    Please Leave Us A Message
                                    @if(session()->has('message'))
                                    <div class="alert alert-success" id="successMessage">{{ session()->get('message') }}</div>
                                    @endif
                                 </h5>
                                 <form  action="{{ route('becomeagent.store') }}" method="post">
                                    @csrf
                                    
                
                                    <!--Basic Information-->
                                    <div class="panel panel-default">
                                        <div class="panel-body wt-panel-body p-a20 m-b30 ">
                                            <div class="row">

                                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                                        <div class="twm-s-map mb-5">
                                                            <div class="twm-s-map-iframe">
                                                                <div class="twm-media-bg">
                                                                    <img src="{{ asset('assets/images/banner.jpeg')}}" alt="#">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                                
                                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                                        <div class="form-group">
                                                            <label>Name</label>
                                                            <div class="ls-inputicon-box"> 
                                                                <input class="form-control" name="name" type="text" placeholder="Devid Smith">
                                                                <i class="fs-input-icon fa fa-building"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xl-6 col-lg-6 col-md-12">
                                                        <div class="form-group">
                                                            <label>Phone</label>
                                                            <div class="ls-inputicon-box"> 
                                                                <input class="form-control" name="phone" type="text" placeholder="(251) 1234-456-7890">
                                                                <i class="fs-input-icon fa fa-phone-alt"></i>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12 col-lg-12 col-md-12">
                                                        <div class="form-group city-outer-bx has-feedback">
                                                            <label>Full Address</label>
                                                            <div class="ls-inputicon-box">  
                                                                <input class="form-control" name="address" type="text" placeholder="1363-1385 Sunset Blvd Angeles, CA 90026 ,USA">
                                                                <i class="fs-input-icon fas fa-map-marker-alt"></i>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                
                                                                                                                
                                                    <div class="col-lg-12 col-md-12">                                   
                                                        <div class="text-left">
                                                            <button type="submit" class="site-button">Save Changes</button>
                                                        </div>
                                                    </div> 
                                                                                        
                                                
                                            </div>
                                                    
                                        </div>
                                    </div>
                
                                    
                                    
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>   
            <!-- OUR BLOG END -->
          
            
     
        </div>
        <!-- CONTENT END -->



@endsection

@section('scripts')
@endsection