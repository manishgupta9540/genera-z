@extends('student.master')

@section('title', 'My Learning')

@section('content')
    <style>
        .box {
            margin-bottom: 20px;
        }

        .modal {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1050;
            display: none;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0;
            background: #00000078;
        }

        .modal-backdrop {
            display: none;
        }

        .modal-content {
            top: 80px;
            position: relative;
            display: flex;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, .2);
            border-radius: 0.3rem;
            outline: 0;
        }

        .my-learning-nav .nav-item {
            margin-right: 30px;
        }
    </style>

    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="container-fluid my-5">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <h3><b>My Learning</b></h3>
                    </div>
                    <div class="col-md-12">
                        <ul class="nav my-learning-nav nav-tabs p-3">
                            <li class="nav-item">
                                <a class="nav-link active rounded-pill px-4 py-2 mr-4" data-toggle="tab" href="#home">In
                                    Progress</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link rounded-pill px-4 py-2" data-toggle="tab" href="#menu1">Completed</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <!-- In Progress Tab -->
                            <div class="tab-pane active mx-0 px-0" id="home">
                                @php
                                    $inProgressCourses = $userCourses->filter(function ($course) {
                                        return $course->completed == 0; // Filter in-progress courses
                                    });
                                @endphp
                                @if ($inProgressCourses->count())
                                    @foreach ($inProgressCourses as $userCourse)
                                        <div class="box bg-white shadow-sm">
                                            <div class="row px-4 align-items-center">
                                                <div class="col-md-2">
                                                    <img src="{{ Storage::url('uploads/course/' . $userCourse->course->image) }}"
                                                        class="w-100">
                                                </div>
                                                <div class="col-md-6">
                                                    <p> {{ $userCourse->course->category->name }}</p>
                                                    <h5 class="couse-h mb-0"><b>{{ $userCourse->course->title }}</b></h5>
                                                </div>
                                                <div class="col-md-4 border-left">
                                                    <div class="div text-center py-4">
                                                        <a href="{{ route('student.course.show', urlencode(base64_encode($userCourse->course->id))) }}"
                                                            class="btn btn-bg px-5 py-3">Go To Course</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <h3 class="text-center">No Course available</h3>
                                @endif
                            </div>

                            <!-- Completed Tab -->
                            <div class="tab-pane fade mx-0 px-0" id="menu1">
                                @php
                                    $completedCourses = $userCourses->filter(function ($course) {
                                        return $course->completed == 1; // Filter completed courses
                                    });
                                @endphp
                                @if ($completedCourses->count())
                                    @foreach ($completedCourses as $userCourse)
                                        <div class="box bg-white">
                                            <div class="row p-4 align-items-center">
                                                <div class="col-md-2">
                                                    <img src="{{ Storage::url('uploads/course/' . $userCourse->course->image) }}"
                                                        class="w-100">
                                                </div>
                                                <div class="col-md-6">
                                                    <p>{{ $userCourse->course->category->name }}</p>
                                                    <h5 class="couse-h mb-0"><b>{{ $userCourse->course->title }}</b></h5>
                                                </div>
                                                <div class="col-md-4 border-left">
                                                    <div class="div text-center">
                                                        <a
                                                            href="{{ route('student.generate_certificate') }}?course_id=<?= base64_encode($userCourse->course->id) ?>&type=download"><button
                                                                class="btn btn-bg px-5 py-3 mb-2">Download
                                                                Certificate</button></a><br>
                                                                @if($userCourse->review =='')
                                                        <a href="javascript:void(0)" data-id="{{ $userCourse->id }}"
                                                            onclick="getId(this)" class="mt-2" data-toggle="modal"
                                                            data-target="#modal0">Review</a>
                                                            @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <h3 class="text-center">No Course Completed available</h3>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal0" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered shadow-none" role="document">
            <div class="modal-content">
                <div class="modal-header bg-white py-4 px-5">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Your Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-4 px-5">
                    <form action="{{ route('rating') }}" class="rate-form" id="rating">
                        <h4>Your Review</h4>
                        <div class="form-group mt-4">
                            <textarea name="review"  class="form-control" cols="5" rows="5"></textarea>
                           <span id="review_error" class="text-danger"></span>
                            <input type="hidden" name="id" id="course_user_id">
                        </div>
                        <p>By clicking Submit, I agree that my feedback may be viewed by the Coursera community, in
                            compliance with the Coursera <a href="#">Terms of Use</a> and My Profile privacy settings.
                        </p>

                </div>
                <div class="modal-footer bg-white border-0 text-center d-block">
                    <button type="submit" class="btn btn-bg px-5 py-3 w-50">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://demo.dashboardpack.com/architectui-html-free/assets/scripts/main.js">
    </script>
@endsection
@push('student-js')
    <script>
        function getId(elem) {
            let id = $(elem).data('id');
            $('#course_user_id').val(id);
        }
        $('form#rating').on('submit', function(e) {
            e.preventDefault();
            var actionUrl = $(this).attr('action');
            var formData = $(this).serialize();
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success == true) {
                        toastr.success(response.msg);
                        $('#modal0').modal('hide')
                        location.reload();
                    } else {
                        toastr.error(response.msg);
                    }
                },
                error: function(error) {
                    if (error.status === 422) {
                            $('#loading').css('display','none');
                            var error = $.parseJSON(error.responseText);
                            $.each(error.errors, function(key, val) {
                                $("#" + key + "_error").text(val);
                            });
                        }

                },
                complete: function() {
                    console.log('AJAX request completed.');
                }
            });
        });
    </script>
@endpush
