@extends('front.master')

@section('title', 'Blog Details')

@section('content')

<section class="blog-details-page">
    <div class="container">
       
           
                <div class="row">
                    <div class="section-title-2 text-center" style="margin-bottom:30px">
                        <h2 class="title" style="color:black"> {{ $blogData->title }}</h2>
                        <span class="line"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-10" style="margin:auto">
                        <div class="blog-details-content">
                            <div class="details-content">
                                <img src="{{asset('uploads/blogs/'.$blogData->image)}}" alt="">
                                <ul class="meta">
                                    <li>Par: {{ $blogData->name ?? ""}}</li>
                                        <li style="float:right">
                                            <ul class="social">
                                                <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https://generationz.education/Choosing-the-Best-School-for-Your-Child"><i class="fab fa-facebook-f"></i></a></li>
                                                <li><a target="_blank" href="https://www.linkedin.com/sharing/share-offsite/?url=https://generationz.education/Choosing-the-Best-School-for-Your-Child"><i class="fab fa-linkedin-in"></i></a></li>
                                                <li><a target="_blank" href="https://twitter.com/intent/tweet?url=https://generationz.education/Choosing-the-Best-School-for-Your-Child"><i class="fab fa-x-twitter"></i></a></li>
                                            </ul>
                                        </li>

                                </ul>
                                {{ $blogData->description ?? "" }}
                            </div>
                        </div>
                    </div>
                </div>
            
       
    </div>
</section>

@endsection