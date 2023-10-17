@extends('frontend.layouts.master')

@section('css')
@endsection

@section('content')



    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option spad" style="background-color: black">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center text-white">
                    <div class="bo-links">
                        {{-- <a href="{{route('homepage')}}"><i class="fa fa-home"></i> Home</a>
                        <span>About</span> --}}
                        <h1>About Snapcourtesy</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- About Section Begin -->
    <section class="about-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="about-pic set-bg" data-setbg="{{ asset('images/default/about/about-pic.jpg')}}">
                        <a href="https://www.youtube.com/watch?v=hxADTEJalRw&list=WL&index=49&t=0s" class="play-btn video-popup"><i class="fa fa-play"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 p-0">
                    <div class="about-text">
                        <div class="section-title">
                            <h2>Capturing the moments that captivate your heart</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing, tempor incididunt ut labore et dolore
                                magna aliqua. Risus commodo viverra maecenas accumsan lacus vel facilisis. All these
                                taglines are owned by their respective owners, and we do not have any copyright on them.
                            </p>
                        </div>
                        <div class="at-list">
                            <div class="al-item">
                                <div class="al-pic">
                                    <img src="{{ asset('images/default/about/list-1.png')}}" alt="">
                                </div>
                                <div class="al-text">
                                    <h5>Professionalism</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices
                                        gravida.</p>
                                </div>
                            </div>
                            <div class="al-item">
                                <div class="al-pic">
                                    <img src="{{ asset('images/default/about/list-2.png')}}" alt="">
                                </div>
                                <div class="al-text">
                                    <h5>Individual approach</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices
                                        gravida.</p>
                                </div>
                            </div>
                            <div class="al-item">
                                <div class="al-pic">
                                    <img src="{{ asset('images/default/about/list-3.png')}}" alt="">
                                </div>
                                <div class="al-text">
                                    <h5>Flexible Schedule</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices
                                        gravida.</p>
                                </div>
                            </div>
                            <div class="al-item">
                                <div class="al-pic">
                                    <img src="{{ asset('images/default/about/list-4.png')}}" alt="">
                                </div>
                                <div class="al-text">
                                    <h5>Experience</h5>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices
                                        gravida.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- Team Section Begin -->
    <section class="team-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="section-title">
                        <h2>Our team</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="right-btn">
                        <a href="#" class="primary-btn">Appointment</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item">
                        <img src="{{ asset('images/default/team/team-1.jpg')}}" alt="">
                        <div class="ti-text">
                            <h5>Alan walker</h5>
                            <span>Photographer</span>
                            <div class="ti-social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item">
                        <img src="{{ asset('images/default/team/team-2.jpg')}}" alt="">
                        <div class="ti-text">
                            <h5>Ava Max</h5>
                            <span>Director</span>
                            <div class="ti-social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item">
                        <img src="{{ asset('images/default/team/team-3.jpg')}}" alt="">
                        <div class="ti-text">
                            <h5>Anne-Marie</h5>
                            <span>Manager</span>
                            <div class="ti-social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="team-item">
                        <img src="{{ asset('images/default/team/team-4.jpg')}}" alt="">
                        <div class="ti-text">
                            <h5>Billie Eilish</h5>
                            <span>Assistant</span>
                            <div class="ti-social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->


@endsection

@section('scripts')
@endsection