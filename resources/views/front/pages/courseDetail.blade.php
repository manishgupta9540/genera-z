
@push('styles')
    <style>
        .eye-btn{
            width: 50px;
        }

        .inactive {
            background-color: rgb(181, 47, 144);
            border-radius: 6px;
            color: white
        }

        .certificate-span {
            background-color: rgb(240, 239, 239);
        }

        #outcome {
            margin-top: 5rem;
            margin-bottom: 8rem;
        }

        .box3 img {
            height: 180px;
            position: relative;
            top: 0rem;
            display: block;
            filter: drop-shadow(0 5px 10px rgba(0, 0, 0, 0.5));
        }

        .nav-pills .nav-link.active {
            background: #40999d;
        }

        .show-btn {
            border: 2px solid #b52f90;
            color: #b52f90;
        }

        .btn-bg {
            background: #40999d;
            color: white;
        }

        .effect-img {
            opacity: 0.4;
        }

        .instructor-img {
            width: 30px;
            border: 2px solid white;
        }

        .course-box {
            position: relative;
            top: -75px;
            border-radius: 10px;
        }

        .social-icon3 {
            font-size: 25px;
        }

        .card-link:hover {
            background-color: #ddfdff78;
        }


        .btn-bg {
            background-color: #40999d;
            color: white;
        }

        span.show-hide-password {
            position: absolute;
            top: 32px;
            right: 10%;
            font-size: 19px;
            color: #748a9c;
            cursor: pointer;
            z-index: 6;
        }

        .course-h {
            color: #b4379194;
        }

        .nav-tabs {
            border-bottom: none;
        }

        .nav-tabs .nav-link.active,
        .nav-tabs .nav-item.show .nav-link {
            color: white;
            background-color: #40999d;
            border: 1px solid #40999d;
        }

        .nav-tabs .nav-link {
            background-color: white;
            color: #40999d;
            border: 1px solid #40999d;
        }

        .btn-bg {
            background-color: #40999d;
            color: white;
        }

        .box {
            border: 1px solid #dee2e6;
            padding: 50px;
            border-radius: 0.25rem;
        }

        .box img {
            border-radius: 6px;
        }

        .login-form .form-control {
            height: 50px;
        }

        .check-icon {
            color: #40999d;
        }

        .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
        }

        .box2 {
            height: 150px;
        }

        .subs-tab {
            background-color: rgb(230, 230, 230);
        }

        .bold-tags {
            font-size: 20px;
        }

        .nav-tabs .nav-link {
            background-color: white;
            color: #40999d;
            border: 1px solid #40999d;
        }

        .btn-bg {
            background-color: #40999d;
            color: white;
        }


        .certificate h2 {
            font-size: 40px;
            font-weight: bold;
        }

    </style>
@endpush
@extends('front.master')
@section('content')
    <section class="certificate-header pt-3">
        <div class="container">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">
                            <i class="fa-solid fa-house"></i> Home
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $course->title }}</li>
                </ol>
            </nav>
        </div>
    </section>
    <section class="certificate pb-5">
        <div class="container-fluid pb-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="mt-3">
                            {{ $course->title }}
                            <p class="">{!! $course->headline !!}</p>
                        </h2>
                        <button id="enrol-btn" data-target="{{ route('enrolModal', urlencode(base64_encode($course->id))) }}"
                            class="btn btn-theme2 enrol px-5 py-2">
                            Enroll
                        </button>
                    </div>
                    <div class="col-md-4 text-center text-md-start">
                        <img src="{{ Storage::url('uploads/course/' . $course->image) }}" alt="{{ $course->title }}"
                            class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section>
        <div class="container">
            <div class="row">
                <div class="box bg-white rounded shadow-lg p-4 course-box w-100">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-6 border-right">
                            <h6>{{ isset($course->total_modules) ? $course->total_modules : 'NA' }}
                                module(s) series</h6>
                            <span class="mb-0">{!! $course->overview !!}</span>
                        </div>
                        <div class="col-md-4 text-center">
                            <h6><b>{{ $course->rating }}<i class="fa-solid fa-star ml-2"></i></b></h6>
                        </div>
                        {{-- <div class="col-md-3 border-right border-left">
                            <h6>{{ $course->duration }}</h6>
                            <p class="mb-0">Approx. 10 hours a week Self-paced, no deadlines</p>
                        </div> --}}
                        <div class="col-md-2">
                            <h6><b>Earn a Certificate</b></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-4">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav border-bottom pb-4">
                            <li class="nav-item">
                                <a class="nav-link px-5 py-3 innerPageLink inactive" href="#about">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-5 py-3 innerPageLink" href="#outcome">Outcomes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-5 py-3 innerPageLink" href="#course">Module</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link px-5 py-3 innerPageLink" href="#testimonial">Recommendations</a>
                            </li>
                        </ul>

                        <div id="about" class="mt-4">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 class="mb-4"><b>What you'll learn</b></h5>
                                        <p>{!! $course->description !!}</p>
                                        <div class="row">
                                            @foreach ($course->objectives as $value)
                                                <div class="col-md-6 d-flex">
                                                    <i class="fa-solid fa-check py-1 px-2"></i>
                                                    <p>{{ $value->content }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="">
                                            <h5 class="mb-4 mt-5"><b>Skills you'll gain</b></h5>
                                            <div class="row">
                                                <div class="col-md-12 d-flex flex-wrap">
                                                    @if (count($course->skills))
                                                        @foreach ($course->skills as $skill)
                                                            <p class="certificate-span p-2 rounded mx-1">
                                                                {{ $skill->name }}
                                                            </p>
                                                        @endforeach
                                                    @else
                                                        <p>No skills found.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="outcome">
                            <div class="container">
                                <div class="d-flex align-items-center px-5 box2 border shadow rounded mt-5">
                                    <div class="col-md-9">
                                        <h5><b>Earn a certificate</b></h5>
                                        <p class="my-2">Complete the course to earn your certificate, available for viewing and download</p>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box3">
                                            <img src="{{ asset('front/img/w004e_21_e10.jpg') }}" class=""
                                                alt="ABC">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="course" class="mt-5">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="mb-3"><b>There is/are {{ $course->total_modules }} module(s) in this
                                                course</b></h5>
                                        <span class="text-black-50">{!! $course->summary !!}</span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12 px-0">
                                        <div class="box bg-white p-3 border rounded">
                                            <div id="accordionParent">
                                                @if (count($course->modules->where('status', '1')))
                                                    @foreach ($course->modules as $module)
                                                    <div class="card mb-2">
                                                        <div class="card-body">
                                                            <p class="card-text">{{ $module->name }}</p>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @endif
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="testimonial" class="my-5 w-100">
                            <div class="container">
                                <div class="box rounded">
                                    <h5 class="mb-5"><b>Recommended Courses </b></h5>
                                    <div class="row">
                                        @if (isset($course->category))
                                            @foreach ($course->category->courses as $item)
                                                @if ($item->id != $course->id && $item->status == 1)
                                                    <div class="col-md-3">
                                                        <div class="card rounded shadow-none border" style="width: 250px;">
                                                            <img class="card-img-top p-2 rounded" src="{{ Storage::url('uploads/course/' . $item->image) }}" alt="Card image"
                                                                style="width: 100%; height: 150px; object-fit: cover;">
                                                            <div class="card-body">
                                                                <h4 class="card-title"><a href="#"><b>{{ $item->title }}</b></a></h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @else
                                            <p>No Recommended Courses found</p>
                                        @endif
                                    </div>

                                    <button class="btn px-5 py-3 show-btn mt-5">Show more</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- register modal end -->
    <script type="text/javascript" src="https://demo.dashboardpack.com/architectui-html-free/assets/scripts/main.js">
    </script>
@endsection
@push('custom-scripts')
    <!-- partial -->
    <script src="{{ asset('front/js/script.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--toaster js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
    <script src="{{ asset('front/js/courseDetail.js') }}"></script>

    @if (session('enrolModal'))
        <script>
            $(document).ready(function() {
                $('#enrol-btn').trigger('click');
            });
        </script>
    @endif

@endpush
