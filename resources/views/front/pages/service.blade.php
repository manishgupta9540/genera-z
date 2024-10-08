@extends('front.master')

@section('title', 'Service')

@section('content')

    <section class="campus-visit-area-2" style="background-color: #e7f1f1;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-content text-center">
                        <h2 class="about-title" style="color:black">Tailored Solutions for Your <br> Individual Needs </h2>
                        <span class="line"></span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="campus-image-2">
                        <div class="image-1">
                            <img src="{{asset('front/bo.generationz.education/Uploads/ServiceGeneral/GenZ%20(Website%20Icons)_Services.png')}}" width="585" height="308" alt="campus">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="event-area" id="services">
        <div class="container">
            <div class="event-title-tab-menu">
                <div class="event-tab-menu" style="display:flex">
                        <ul class="nav nav-tabs-services" role="tablist" style="margin:auto">


                                    <li><a class="active" arial-controls="Investors" role="tab" data-bs-toggle="tab" href="#Investors">Investors</a></li>
                                    <li><a arial-controls="Educators" role="tab" data-bs-toggle="tab" href="#Educators">Educators</a></li>
                                    <li><a arial-controls="Parents" role="tab" data-bs-toggle="tab" href="#Parents">Parents</a></li>
                        </ul>
                </div>
            </div>
                <div class="tab-content event-tab-items wow fadeInUpBig" data-wow-duration="1s" data-wow-delay="0.2s">



                            <div class="tab-pane fade show active" role="tabpanel" id="Investors">
                                <div class="row">
                                        <div class="col-lg-3 col-sm-6 mt-30 services">
                                            <div class="single-event investors">
                                                <a href="ServiceDetail/Setup-Your-Educational-Organization.html" style="width:100%">
                                                    <div class="trainingHeight" style="height:80px;display:flex">
                                                        <h4 class="event-title servicesTitle" style="margin:auto">Setup Your Educational Organization</h4>
                                                    </div>
                                                        <div style="text-align:right">
                                                            <p class="more" style="margin-bottom:0">Learn More <i class="far fa-chevron-right"></i></p>
                                                        </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 mt-30 services">
                                            <div class="single-event investors">
                                                <a href="ServiceDetail/Reform%2c-Restructure%2c-and-Support-Your-Educational-Organization.html" style="width:100%">
                                                    <div class="trainingHeight" style="height:80px;display:flex">
                                                        <h4 class="event-title servicesTitle" style="margin:auto">Reform, Restructure, and Support Your Educational Organization</h4>
                                                    </div>
                                                        <div style="text-align:right">
                                                            <p class="more" style="margin-bottom:0">Learn More <i class="far fa-chevron-right"></i></p>
                                                        </div>
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" role="tabpanel" id="Educators">
                                <div class="row">
                                        <div class="col-lg-3 col-sm-6 mt-30 services">
                                            <div class="single-event investors">
                                                <a href="ServiceDetail/Teachers%e2%80%99-Support.html" style="width:100%">
                                                    <div class="trainingHeight" style="height:80px;display:flex">
                                                        <h4 class="event-title servicesTitle" style="margin:auto">Teachers’ Support</h4>
                                                    </div>
                                                        <div style="text-align:right">
                                                            <p class="more" style="margin-bottom:0">Learn More <i class="far fa-chevron-right"></i></p>
                                                        </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 mt-30 services">
                                            <div class="single-event investors">
                                                <a href="ServiceDetail/Web-3-Courses-for-Young-Learners-and-Adults.html" style="width:100%">
                                                    <div class="trainingHeight" style="height:80px;display:flex">
                                                        <h4 class="event-title servicesTitle" style="margin:auto">Web 3 Courses for Young Learners and Adults</h4>
                                                    </div>
                                                        <div style="text-align:right">
                                                            <p class="more" style="margin-bottom:0">Learn More <i class="far fa-chevron-right"></i></p>
                                                        </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 mt-30 services">
                                            <div class="single-event investors">
                                                <a href="Training.html" style="width:100%">
                                                    <div class="trainingHeight" style="height:80px;display:flex">
                                                        <h4 class="event-title servicesTitle" style="margin:auto">Continuous Professional Development</h4>
                                                    </div>
                                                        <div style="text-align:right">
                                                            <p class="more" style="margin-bottom:0">Learn More <i class="far fa-chevron-right"></i></p>
                                                        </div>
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" role="tabpanel" id="Parents">
                                <div class="row">
                                        <div class="col-lg-3 col-sm-6 mt-30 services">
                                            <div class="single-event investors">
                                                <a href="ServiceDetail/Web-3-Courses-for-Young-Learners-and-Adults.html" style="width:100%">
                                                    <div class="trainingHeight" style="height:80px;display:flex">
                                                        <h4 class="event-title servicesTitle" style="margin:auto">Web 3 Courses for Young Learners and Adults</h4>
                                                    </div>
                                                        <div style="text-align:right">
                                                            <p class="more" style="margin-bottom:0">Learn More <i class="far fa-chevron-right"></i></p>
                                                        </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-sm-6 mt-30 services">
                                            <div class="single-event investors">
                                                <a href="ServiceDetail/Education-Consultancy-for-Families.html" style="width:100%">
                                                    <div class="trainingHeight" style="height:80px;display:flex">
                                                        <h4 class="event-title servicesTitle" style="margin:auto">Education Consultancy for Families</h4>
                                                    </div>
                                                        <div style="text-align:right">
                                                            <p class="more" style="margin-bottom:0">Learn More <i class="far fa-chevron-right"></i></p>
                                                        </div>
                                                </a>
                                            </div>
                                        </div>
                                </div>
                            </div>
                </div>
        </div>
    </section>

    <section class="slider-area slider-03 slider-active" style="background-color: #e7f1f1;direction:ltr">
            <div class="single-slider d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8" style="margin:auto;direction:ltr">
                            <div class="testimonial-wrapper-2">
                                <div class="section-title-2 text-center">
                                    <h2 class="title" style="color:black">Testimonials</h2>
                                    <span class="line"></span>
                                </div>
                                <div class="testimonials-content">
                                    <div class="single-testimonial-content">
                                            <div class="content-text">
                                                <i class="fas fa-quote-left"></i>
                                                <div style="display:flex;min-height:277px">
                                                    <p style="margin:auto">Generation Z Education Training Solutions supported us in improving the quality of our services thus meeting the required criteria set by the authorizing bodies in Dubai, United Arab Emirates. The team is very approachable and helped enhance the operations through weekly observations and constructive feedback done regularly.</p>
                                                </div>
                                            </div>
                                            <div class="content-meta" style="text-align:end">
                                                <p class="name" style="margin-bottom:0">Saira Rizwan</p>
                                                <p class="designation">Owner <span style="font-family:Arial">&amp;</span> CEO, Green Roots Early Childhood Center</p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-slider d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8" style="margin:auto;direction:ltr">
                            <div class="testimonial-wrapper-2">
                                <div class="section-title-2 text-center">
                                    <h2 class="title" style="color:black">Testimonials</h2>
                                    <span class="line"></span>
                                </div>
                                <div class="testimonials-content">
                                    <div class="single-testimonial-content">
                                            <div class="content-text">
                                                <i class="fas fa-quote-left"></i>
                                                <div style="display:flex;min-height:277px">
                                                    <p style="margin:auto">It was a pleasure working with the Generation Z Education Training Solutions team, their contribution is impacting our centres positively and fruitfully. They have guided our teachers in their weekly and day<span style="font-family:Arial">-</span>to<span style="font-family:Arial">-</span>day work and supported our centres in all other aspects including marketing, operations, health and safety measures, and classroom management.</p>
                                                </div>
                                            </div>
                                            <div class="content-meta" style="text-align:end">
                                                <p class="name" style="margin-bottom:0">Little Wonders</p>
                                                <p class="designation">Owner <span style="font-family:Arial">&</span> CEO, Little Wonder Early Childhood Centres</p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-slider d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8" style="margin:auto;direction:ltr">
                            <div class="testimonial-wrapper-2">
                                <div class="section-title-2 text-center">
                                    <h2 class="title" style="color:black">Testimonials</h2>
                                    <span class="line"></span>
                                </div>
                                <div class="testimonials-content">
                                    <div class="single-testimonial-content">
                                            <div class="content-text">
                                                <i class="fas fa-quote-left"></i>
                                                <div style="display:flex;min-height:277px">
                                                    <p style="margin:auto">The Generation Z team were responsive, courteous and very knowledgeable. They helped us cover several training points needed for our team <span style="font-family:Arial">(</span>teachers and assistants<span style="font-family:Arial">)</span> efficiently and altered the content of the training to match our centre<span style="font-family:Arial">'</span>s needs and staff<span style="font-family:Arial">'</span>s language requirements.                                             I was not sure of the outcome and how well my team would benefit from the training sessions. However, the Generation Z team followed up on this and made sure they measured the results and offered mentoring services afterwards. This was very practical. Thank you for your support.</p>
                                                </div>
                                            </div>
                                            <div class="content-meta" style="text-align:end">
                                                <p class="name" style="margin-bottom:0">Racha Arafeh</p>
                                                <p class="designation">Nursery Manager, Le Petit Poucet Nursery <span style="font-family:Arial">&</span> Kindergarten</p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-slider d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8" style="margin:auto;direction:ltr">
                            <div class="testimonial-wrapper-2">
                                <div class="section-title-2 text-center">
                                    <h2 class="title" style="color:black">Testimonials</h2>
                                    <span class="line"></span>
                                </div>
                                <div class="testimonials-content">
                                    <div class="single-testimonial-content">
                                            <div class="content-text">
                                                <i class="fas fa-quote-left"></i>
                                                <div style="display:flex;min-height:277px">
                                                    <p style="margin:auto">Our team at Delma Nursery found the training workshops given by the wonderful team of Generation Z really beneficial. All the information that was given was up to date and relevant to our setting and curriculum. It was also a really interesting session for us<span style="font-family:Arial">!</span> Thank you<span style="font-family:Arial">!</span></p>
                                                </div>
                                            </div>
                                            <div class="content-meta" style="text-align:end">
                                                <p class="name" style="margin-bottom:0">Team</p>
                                                <p class="designation">Delma</p>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <section class="campus-visit-area-3">
        <div class="container">
            <div class="campus-visit-wrapper">
                <div class="campus-content-col" style="display:flex">
                    <div class="campus-content" style="margin:auto">
                        <div class="text-center lineTitle">
                            <h2 class="campus-title" style="color:black">Over 30 years of experience</h2>
                            <span class="line"></span>
                        </div>
                        <p style="text-align:center">We<span style="font-family:Arial">'</span>re here to guide you along the way <span style="font-family:Arial">!</span>
                        </p>
                        
                    </div>
                </div>
                <div class="campus-image-col">
                    <div class="campus-image" style="direction:ltr">
                    <video autoplay loop muted>
                                <source src="{{asset('front/Content/Assets/GenerationZImages/Find%20the%20right%20school%20for%20your%20children%21(1).mp4')}}" type="video/mp4" />
                    </video>
                    </div>
                </div>

                
            </div>
        </div>
    </section>


@endsection