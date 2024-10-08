@extends('front.master')

@section('title', 'Generation Z Education')

@section('content')

    <section class="slider-area slider-03 slider-active" style="padding-top:110px">
        <div class="single-slider d-flex align-items-center bg_cover"
            style="background-image:url('Content/Assets/GenerationZImages/Arabesque%202%20(5.html).jpg'); height: 80vh">

            <div class="container">
                <div class="row">
                    <div class="col-lg-6 slider-content slider-content-3 text-center" style="position:relative;margin:auto">
                        <h2 class="title" data-animation="fadeInUp" data-delay="0.2s" style="color:black">Tomorrow’s
                            Education, Today </h2>
                        <ul class="slider-btn">
                            <li><a data-animation="fadeInUp" data-delay="1s" class="main-btn"
                                    href="{{ route('about') }}">Learn More</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <img
                            src="{{ asset('front/bo.generationz.education/Uploads/HomeGeneral/GenZ%20(Website%20Icons)_Home%20Banner1.png') }}" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="servicesSection"> 
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-6 iconBanner">
                    <a href="#">
                        <div class="single-event text-center">
                            <div style="display: flex">
                                <div style="display:flex;margin:auto">
                                    <img src="{{ asset('front/bo.generationz.education/Uploads/ServiceHome/Investors.png') }}"
                                        width="80" height="50" alt="" style="margin-right:15px">
                                    <h4 class="event-title" style="margin:auto">Investors</h4>
                                </div>
                            </div>
                            <div style="margin-top:10px">
                                <span class="time serviceHome">For those looking to establish an early childhood centre,
                                    school, and<span style="font-family:Arial">/</span>or educational organisation or those
                                    seeking to reform and restructure their running educational centres and
                                    organisations.</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6 iconBanner">
                    <a href="#">
                        <div class="single-event text-center">
                            <div style="display: flex">
                                <div style="display:flex;margin:auto">
                                    <img src="{{ asset('front/bo.generationz.education/Uploads/ServiceHome/Educators.png') }}"
                                        width="80" height="50" alt="" style="margin-right:15px">
                                    <h4 class="event-title" style="margin:auto">Educators</h4>
                                </div>
                            </div>
                            <div style="margin-top:10px">
                                <span class="time serviceHome">For those seeking to change their employment, find employment
                                    after relocating, or to improve their professional performance generally.</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6 iconBanner">
                    <a href="#">
                        <div class="single-event text-center">
                            <div style="display: flex">
                                <div style="display:flex;margin:auto">
                                    <img src="{{ asset('front/bo.generationz.education/Uploads/ServiceHome/Parents.png') }}"
                                        width="80" height="50" alt="" style="margin-right:15px">
                                    <h4 class="event-title" style="margin:auto">Parents</h4>
                                </div>
                            </div>
                            <div style="margin-top:10px">
                                <span class="time serviceHome">For those looking to switch schools, find new schools after
                                    relocating, or help their children improve their performance in the classroom.</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="about-area pt-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="about-content">
                        <div class="text-center lineTitle">
                            <h2 class="about-title" style="color:black">Our Unique <br> Vision</h2>
                            <span class="line"></span>
                        </div>
                        <p>Generation Z was established by a passionate group of educationalists to provide innovative
                            educational and training solutions with the goal of bridging the gap between traditional
                            approaches and the future of education. </p>
                        <a href="{{ route('about') }}" class="main-btn" style="margin-top:20px">Read More</a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="about-image">
                        <div class="single-image image-1">
                            <img src="{{ asset('front/bo.generationz.education/Uploads/HomeGeneral/GenZ%20(Website%20Icons)_About%20Section%20in%20the%20home%20page%20(2).png') }}"
                                width="290" height="290" alt="about">
                        </div>
                        <div class="single-image image-2">
                            <img src="{{ asset('front/bo.generationz.education/Uploads/HomeGeneral/AboutSection2.png') }}"
                                width="225" height="225" alt="about">
                        </div>
                        <div class="single-image image-3">
                            <img src="{{ asset('front/bo.generationz.education/Uploads/HomeGeneral/AboutSection3.png') }}"
                                width="190" height="190" alt="about">
                        </div>


                        <div class="about-icon icon-1">
                            <img src="{{ asset('front/Content/Assets/GenerationZImages/icon-1.png') }}" width="46"
                                height="46" alt="icon">
                        </div>
                        <div class="about-icon icon-2">
                            <img src="{{ asset('front/Content/Assets/GenerationZImages/icon-2.png') }}" width="46"
                                height="46" alt="icon">
                        </div>
                        <div class="about-icon icon-3">
                            <img src="{{ asset('front/Content/Assets/GenerationZImages/icon-3.png') }}" width="46"
                                height="46" alt="icon">
                        </div>
                        <div class="about-icon icon-4">
                            <img src="{{ asset('front/Content/Assets/GenerationZImages/icon-4.png') }}" width="46"
                                height="46" alt="icon">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-banner" style="padding-top:0">
        <div class="page-banner-bg bg_cover parallax"
            style="background-image: url('Content/Assets/GenerationZImages/Arabesque%201%20(5.html).jpg');">
            <div class="container">
                <div class="banner-content text-center">
                    <h2 class="title mb-40" style="color:black">Curated Courses for Academic and Professional Development
                    </h2>
                    <a data-animation="fadeInUp" data-delay="0.6s" class="main-btn main-btn-2"
                        href="{{ route('training') }}">Explore</a>
                </div>
            </div>
        </div>
    </section>

    <section class="features-area-2" style="background:#e7f1f1">
        <div class="container">
            <div class="row">
                <div class="section-title-2 text-center lineTitle">
                    <h2 class="title" style="color:black">Training</h2>
                    <span class="line"></span>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="features-image-2">
                        <img class="wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s"
                            src="{{ asset('front/bo.generationz.education/Uploads/HomeGeneral/TrainingSection.png') }}"
                            alt="Features">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="features-items">
                        <div class="features-items-wrapper">

                            <div class="single-features-item d-flex align-items-center wow fadeInUpBig"
                                data-wow-duration="1s" data-wow-delay="0.2s">
                                <div class="item-icon">
                                    <img src="{{ asset('front/bo.generationz.education/Uploads/TrainingHome/Courses.png') }}"
                                        width="100" height="100" alt="Icon">
                                </div>
                                <div class="item-content media-body">
                                    <p>50<span style="font-family:Arial">+</span> <br>Courses</p>
                                </div>
                            </div>
                            <div class="single-features-item d-flex align-items-center wow fadeInUpBig"
                                data-wow-duration="1s" data-wow-delay="0.2s">
                                <div class="item-icon">
                                    <img src="{{ asset('front/bo.generationz.education/Uploads/TrainingHome/Projects.png') }}"
                                        width="100" height="100" alt="Icon">
                                </div>
                                <div class="item-content media-body">
                                    <p>Skill Based <br>Projects</p>
                                </div>
                            </div>
                        </div>
                        <div class="features-items-wrapper">

                            <div class="single-features-item d-flex align-items-center wow fadeInUpBig"
                                data-wow-duration="1s" data-wow-delay="0.2s">
                                <div class="item-icon">
                                    <img src="{{ asset('front/bo.generationz.education/Uploads/TrainingHome/Trainers.png') }}"
                                        width="100" height="100" alt="Icon">
                                </div>
                                <div class="item-content media-body">
                                    <p>Expert <br>Trainers</p>
                                </div>
                            </div>
                            <div class="single-features-item d-flex align-items-center wow fadeInUpBig"
                                data-wow-duration="1s" data-wow-delay="0.2s">
                                <div class="item-icon">
                                    <img src="{{ asset('front/bo.generationz.education/Uploads/TrainingHome/Certificates.png') }}"
                                        width="100" height="100" alt="Icon">
                                </div>
                                <div class="item-content media-body">
                                    <p>After Course <br>Certification</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="text-align:center">
                    <a href="{{ route('training') }}" class="main-btn" style="margin-top:20px;width:260px">Explore Our
                        Courses</a>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="blog-page" style="padding:40px 0">
        <div class="container">
            <div class="row">
                <div class="section-title-2 text-center lineTitle">
                    <h2 class="title" style="color:black">Blogs</h2>
                    <span class="line"></span>
                </div>
            </div>
            <div class="row">
                @if (count($blogs) > 0)
                    @foreach ($blogs as $blog)
                        <div class="col-lg-4 col-md-6">
                            <div class="single-blog mobileBlog">
                                <div class="blog-image">
                                    <a href="{{ url('blog-details/'.base64_encode($blog->id)) }}">
                                        <img src="{{asset('uploads/blogs/'.$blog->image)}}" style="width:380px; height:250px;" alt="blog">
                                    </a>
                                </div>
                                <div class="blog-content text-center">
                                    <ul class="meta">
                                        <li>{{ $blog->created_at ? $blog->created_at->format('d/m/Y') : '' }}</li>
                                    </ul>
                                    <h4 class="blog-title" style="min-height:100px;display:flex">
                                        <a href="{{ url('blog-details/'.base64_encode($blog->id)) }}" >{{ $blog->title}}</a></h4>
                                        <a href="{{ url('blog-details/'.base64_encode($blog->id)) }}" class="more">Read More <i class="fa fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section> --}}
    <br>

    <section class="newsletter-area" style="background-color: #e7f1f1">
        <div class="container">
            <div class="newsletter-wrapper bg_cover wow zoomIn" data-wow-duration="1s" data-wow-delay="0.2s">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="section-title-2">
                            <h2 class="title" style="color:black">Join Our Community!</h2>
                            <span class="line"></span>
                            <p>Stay up to date on the latest news and developments in the world of education.</p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="newsletter-form mt-30">
                            <div id="success-form" class="mx-0 text-center alert alert-success" style="display:none;">
                                Thank you for your subscription</div>
                            <div id="error-form" class="mx-0 text-center alert alert-danger" style="display:none;">An
                                error occured, please try again later</div>
                            <div class="newsletter-form mt-30">
                                <form action="Javascript:void(0);" id="subscribenewsletter">
                                    <input type="text" placeholder="Enter your email here" id="email" required
                                        style="background-color: white !important;font-family:Arial;">
                                    <button class="main-btn main-btn-2" onclick="subcscibeNewsletter();">Subscribe
                                        Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
