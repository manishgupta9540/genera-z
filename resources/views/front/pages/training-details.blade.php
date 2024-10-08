@extends('front.master')

@section('title', 'training details')

@section('content')

<section class="campus-visit-area" style="padding-top:150px">
    <div class="container">
        <div class="campus-visit-wrapper">
            <div class="campus-image-col">
                <div class="campus-image" style="padding-bottom:0">
                    <div class=" single-campus">
                        <img src="{{asset('uploads/course/'.$course_details->image)}}" alt="">
                    </div>
                </div>
            </div>
            <div class="campus-content-col">
                <div class="campus-content">
                    <div class="section-title-2 trainingDetail text-center" style="margin-bottom:30px">
                        <h2 class="title" style="color:black">
                           {{ $course_details->title ?? "" }}
                        </h2>
                        <span class="line"></span>
                    </div>
                    <p>
                        {{ $course_details->overview ?? "" }}
                    </p>
                    <div style="text-align:center">
                        <a href="{{ route('lms-details-page') }}"  class="main-btn" style="margin-top:20px">Enquiry Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection