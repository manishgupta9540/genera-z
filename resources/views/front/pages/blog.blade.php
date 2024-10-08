@extends('front.master')

@section('title', 'blog')

@section('content')

<section class="blog-page" style="padding-top:150px;padding-bottom:40px">
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
                    <div class="col-lg-4 col-md-6" style="margin-bottom:40px">
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
                                <h4 class="blog-title" style="min-height:100px;display:flex"><a href="Choosing-the-Best-School-for-Your-Child.html" style="margin:auto">{{ $blog->title}}</a></h4>
                                    <a href="Choosing-the-Best-School-for-Your-Child.html" class="more">Read More <i class="fa fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

@endsection