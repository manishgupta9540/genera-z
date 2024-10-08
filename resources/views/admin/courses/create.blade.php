@extends('admin.master.index')

@section('title', 'Course Create')

@section('content')

<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4> Add Course </h4>
              </div>
                <form action="{{ route('course-create') }}" method="post" id="createCourseFrm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h5>Basic Details</h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Course Title<span class="text-danger">*</span></label>
                                    <input type="text" name="course_title"  class="form-control" placeholder="Course Title">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-course_title"></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Rating<span class="text-danger">*</span></label>
                                    <input type="number" name="rating" min="1" max="5" step="0.1" class="form-control" placeholder="Rating">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-rating"></p>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Course Overview<span class="text-danger">*</span></label>
                                    <textarea name="course_overview" id="" class="summernote form-control" cols="30" rows="10"></textarea>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-course_overview"></p>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Short Description<span class="text-danger">*</span></label>
                                    <textarea name="short_description" id="" class="summernote form-control" cols="30" rows="10"></textarea>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-short_description"></p>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Short Overview<span class="text-danger">*</span></label>
                                    <textarea name="short_overview" id="" class="summernote form-control" cols="30" rows="10"></textarea>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-short_overview"></p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Category<span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-control" id="role_id">
                                        <option value="">Select Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach

                                    </select>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-category_id"></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Image<span class="text-danger">*</span></label>
                                    <input type="file" name="image"  class="form-control" placeholder="Image">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-image"></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Skill Name<span class="text-danger">*</span></label>
                                    <select name="skill_id[]" id="skills" multiple="" class="select2 form-control">
                                        <option value="">-Select Skills-</option>
                                        @foreach ($skills as $item)
                                            <option value="{{ $item->id }}">{{ $item->skills_name }}</option>
                                        @endforeach
                                    </select>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-skill_id"></p>
                                </div>
                            </div>
                        </div>
                        <h5>Scheduling</h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Course Duration<span class="text-danger">*</span></label>
                                    <input type="text" name="course_duration"  class="form-control" placeholder="Course Duration">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-course_duration"></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Total Modules<span class="text-danger">*</span></label>
                                    <input type="number" name="total_modules"  class="form-control" placeholder="Total Modules">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-total_modules"></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Course Type<span class="text-danger">*</span></label>
                                    <select name="course_type" id="course_type" class="course_type form-control">
                                        <option value="">-Select Course-</option>
                                        <option value="one time">One Time</option>
                                        <option value="subscription">Subscription</option>
                                    </select>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-course_type"></p>
                                </div>
                            </div>
                            <div class="price_show col-sm-6 d-none"  id="price">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Pricing<span class="text-danger">*</span></label>
                                    <input type="number" name="pricing[]"  class="form-control" placeholder="Pricing">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-pricing"></p>
                                </div>
                            </div>

                            <div class="price_show col-sm-12 d-none"  id="plan_details">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Plan Details<span class="text-danger">*</span></label>
                                    <textarea class="summernote form-control content" name="plan_details" id="content" placeholder="Enter the Plan Details"></textarea>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-plan_details"></p>
                                </div>
                            </div>
                        </div>

                        <div class="subscription d-none">
                            <h5>Subscription & Pricing</h5>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="role" class="form-control-label font-weight-300">Subscription Plan<span class="text-danger">*</span></label>
                                        <input type="text" name="subscription_plan[]" class="form-control" placeholder="Subscription Plan">
                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-subscription_plan"></p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="role" class="form-control-label font-weight-300">Pricing<span class="text-danger">*</span></label>
                                        <input type="number" name="pricing[]"  class="form-control" placeholder="Pricing">
                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-pricing"></p>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="role" class="form-control-label font-weight-300">Subscription Details<span class="text-danger">*</span></label>
                                        <textarea class="summernote form-control content" name="subscription_details[]" id="content" placeholder="Enter the Description"></textarea>
                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-subscription_details"></p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="role" class="form-control-label font-weight-300">Access Duration<span class="text-danger">*</span></label>
                                        <select name="access_duration[]" id="" class="form-control">
                                            <option value="">-Select Access Duration-</option>
                                            <option value="30 Days">30 Days</option>
                                            <option value="90 Days">90 Days</option>
                                        </select>
                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-access_duration"></p>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success add-area-btn1 mt-2" data-id="Aaddress" id="add1"><i class="fa fa-plus"></i></button>
                        </div>
                        <div id="subs">

                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

@endsection


@push('customjs')

    <script>
        // type selected
        var i = 0;
        $("#add1").click(function() {
                ++i;
            $("#subs").append(`<div  class="subscription row" id="row${i}">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="role" class="form-control-label font-weight-300">Subscription Plan<span class="text-danger">*</span></label>
                        <input type="text" name="subscription_plan[]"  class="form-control" placeholder="Subscription_Plan">
                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-subscription_plan"></p>
                    </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="role" class="form-control-label font-weight-300">Pricing<span class="text-danger">*</span></label>
                            <input type="number" name="pricing[]"  class="form-control" placeholder="Pricing">
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-pricing"></p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="role" class="form-control-label font-weight-300">Subscription Details<span class="text-danger">*</span></label>
                            <textarea class="summernote form-control content" id="content${i}" placeholder="Enter the Description"name="subscription_details[]"></textarea>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-subscription_details"></p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="role" class="form-control-label font-weight-300">Access Duration<span class="text-danger">*</span></label>
                            <select name="access_duration[]" id="" class="form-control">
                                <option value="">-Select Access Duration-</option>
                                <option value="30 Days">30 Days</option>
                                <option value="90 Days">90 Days</option>
                            </select>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-access_duration"></p>
                        </div>
                    </div>
                    <div class="col-md-4 pt-2">
                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-Answer"></p>
                        <button type="button" name="remove" id="${i}" class="btn btn-danger btn_remove"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>`);

                    $(`#content${i}`).summernote({
                        height: 150, // Set editor height
                        minHeight: null, // Set minimum height of editor
                        maxHeight: null, // Set maximum height of editor
                        focus: true // Set focus to area after initializing Summernote
                    });
            });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
        });


        $(document).on('change','.course_type',function() {
            var form_value = $('.course_type option:selected').val();
            if (form_value == 'subscription') {
                $(".subscription").removeClass('d-none');
                $(".subscription").show();
                $('#price').hide();
                $('#plan_details').hide();

            }
            else if(form_value == 'one time') {
                $(".subscription").hide();
                $('#price').show();
                $('#plan_details').show();
            }
        });

        $(document).on('change','.course_type',function() {
            var form_value = $('.course_type option:selected').val();
            if (form_value == 'one time') {
                $(".price_show").removeClass('d-none');
                $(".price_show").show();
            }
        });

        //form submit
        $(document).on('submit', 'form#createCourseFrm', function (event) {
            event.preventDefault();
            //clearing the error msg
            $('p.error_container').html("");

            var form = $(this);
            var data = new FormData($(this)[0]);
            var url = form.attr("action");
            var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
            $('.submit').attr('disabled',true);
            $('.form-control').attr('readonly',true);
            $('.form-control').addClass('disabled-link');
            $('.error-control').addClass('disabled-link');
            if ($('.submit').html() !== loadingText) {
                $('.submit').html(loadingText);
            }
                $.ajax({
                    type: form.attr('method'),
                    url: url,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        window.setTimeout(function(){
                            $('.submit').attr('disabled',false);
                            $('.form-control').attr('readonly',false);
                            $('.form-control').removeClass('disabled-link');
                            $('.error-control').removeClass('disabled-link');
                            $('.submit').html('Save');
                        },2000);
                        console.log(response);
                        if(response.success==true) {
                            toastr.success("Course Creted Successfully");
                            window.setTimeout(function() {
                                window.location.href = "{{URL::to('course')}}"
                            }, 2000);
                        }
                        //show the form validates error
                        if(response.success==false ) {
                            for (control in response.errors) {
                            var error_text = control.replace('.',"_");
                            $('#error-'+error_text).html(response.errors[control]);
                            // $('#error-'+error_text).html(response.errors[error_text][0]);
                            // console.log('#error-'+error_text);
                            }
                            // console.log(response.errors);
                        }
                    },
                    error: function (response) {
                        // alert("Error: " + errorThrown);
                        console.log(response);
                    }
                });
                event.stopImmediatePropagation();
                return false;
        });

    </script>
@endpush

