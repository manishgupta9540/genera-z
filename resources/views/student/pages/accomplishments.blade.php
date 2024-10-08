@extends('student.master')

@section('title', 'Accomplishments')
<style>
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
        border-color: none;
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

    .btn-bg2 {
        background-color: #b4379194;
        color: white;
    }

    .box {
        border-radius: 6px;
    }

    .box img {
        border-radius: 6px;
    }

    .dropdown-menu {
        position: absolute;
        will-change: transform;
        top: 15px !important;
        left: 0px;
        transform: translate3d(-196px, 20px, 0px);
    }

    .incm-cretificate {
        filter: hue-rotate(85deg);
    }
</style>
@section('content')

    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container-fluid my-5">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <h3><b>My Courses</b></h3>
                    </div>
                </div>
                <div class="row">
                    @if (count($courses))
                        @foreach ($courses as $course)
                            <div class="box bg-white w-100 m-2 shadow-sm">
                                <div class="row p-4 align-items-center">
                                    <div class="col-md-2">
                                        <img src="{{ Storage::url('uploads/course/' . $course->image) }}" class="w-100">
                                    </div>
                                    <div class="col-md-7">
                                        <h5 class="couse-h mb-2"><b>{{ $course->title }}</b></h5>
                                        <p>{{ $course->category->name }}</p>
                                        {{-- @foreach ($assignments as $assignment)
                                            @if ($assignment->assignment->sub_module->module->course_id == $course->id)
                                                <p>Grade Achieved: {{ number_format($assignment['percentage'], 2) }}%</p>
                                            @endif
                                        @endforeach --}}
                                    </div>
                                    <div class="col-md-3 border-left">
                                        <div class="div text-center d-flex justify-content-between py-5">
                                            <a target="_blank"
                                                href="{{ route('student.generate_certificate') }}?course_id=<?= base64_encode($course->id) ?>&type=view"><i
                                                    class="fa fa-eye mr-2" aria-hidden="true"></i> View</a>

                                            <a
                                                href="{{ route('student.generate_certificate') }}?course_id=<?= base64_encode($course->id) ?>&type=download"><i
                                                    class="fa fa-download mr-2" aria-hidden="true"></i> Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row">
                            <div class="box bg-white w-100 py-5">
                                <div class="row p-4 align-items-center justify-content-center">
                                    <div class="col-md-6 text-center">
                                        <h5><strong>"Your certificates are waiting! Complete your course to earn them
                                                today!"</strong></h5>
                                        <img src="{{ asset('front/img/incm-cretificate.png') }}"
                                            class="w-50 incm-cretificate">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

@endsection
