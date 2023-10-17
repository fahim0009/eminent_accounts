<header  class="site-header header-style-3 mobile-sider-drawer-menu">

    <div class="sticky-header main-bar-wraper  navbar-expand-lg">
        <div class="main-bar">  
                            
            <div class="container-fluid clearfix"> 
        
                <div class="logo-header">
                    <div class="logo-header-inner logo-header-one">
                        <a href="{{ route('homepage')}}">
                        <img src="{{ asset('assets/images/eminentlogo.png')}}" alt="">
                        </a>
                    </div>
                </div>  
                
                <!-- NAV Toggle Button -->
                <button id="mobile-side-drawer" data-target=".header-nav" data-toggle="collapse" type="button" class="navbar-toggler collapsed">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar icon-bar-first"></span>
                    <span class="icon-bar icon-bar-two"></span>
                    <span class="icon-bar icon-bar-three"></span>
                </button> 

                <!-- MAIN Vav -->
                <div class="nav-animation header-nav navbar-collapse collapse d-flex justify-content-center">

                    <ul class=" nav navbar-nav">
                        <li class="has-child"><a href="{{ route('homepage')}}">Home</a></li>
                        <li class="has-child"><a href="{{ route('frontend.job')}}">Jobs</a></li>
                        <li class="has-child"><a href="{{ route('frontend.blog')}}">Blog</a>
                        <li class="has-child"><a href="{{ route('frontend.country')}}">Country</a></li>
                                                           
                        </li>
                    </ul>

                </div>
                
                <!-- Header Right Section-->
                <div class="extra-nav header-2-nav">
                    
                        
                </div>                            
            
                                            
                
            </div>    
        
        
        </div>

        <!-- SITE Search -->
        <div id="search"> 
            <span class="close"></span>
            <form role="search" id="searchform" action="/search" method="get" class="radius-xl">
                <input class="form-control" value="" name="q" type="search" placeholder="Type to search"/>
                <span class="input-group-append">
                    <button type="button" class="search-btn">
                        <i class="fa fa-paper-plane"></i>
                    </button>
                </span>
            </form>
        </div> 
    </div>
    
</header>