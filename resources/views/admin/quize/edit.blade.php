@extends('admin.master.index')

@section('title', 'Quize Edit')

@section('content')
<link rel="stylesheet" href="{{asset('admin/assets/bundles/summernote/summernote-bs4.css')}}"> 
<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
            </div>
            <form action="{{ route('quize-update') }}" method="post" id="quizeFrm" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <h4> Edit Quiz </h4>
                    <hr>
                        <div class="row">
                            <input type="hidden" name="cours_m_id" value="{{ base64_encode($quize->sub_module_id) }}">
                            <input type="hidden" name="id" value="{{ base64_encode($quize->id) }}">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Title<span class="text-danger">*</span></label>
                                    <input type="text" name="title" value="{{ $quize->title }}" class="form-control">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-title"></p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Passing Score<span class="text-danger">*</span></label>
                                    <input type="text" name="passing_score" value="{{ $quize->passing_score }}" class="form-control">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-passing_score"></p>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Description<span class="text-danger">*</span></label>
                                    {{-- <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea> --}}
                                    <textarea class="summernote form-control content" id="content" placeholder="Enter the Description"name="description">{{ $quize->description}}</textarea>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-description"></p>
                                </div>
                            </div>

                           <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Start Date<span class="text-danger">*</span></label>
                                    <input type="date" id="dueDateTime" name="start_date" value="{{ $quize->start_date }}" class="form-control">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-start_date"></p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Start Time<span class="text-danger">*</span></label>
                                    <input type="time" id="dueDate" name="start_time" value="{{ $quize->start_time }}" class="form-control">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-start_time"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Default Marks for Each Question<span class="text-danger">*</span></label>
                                    <input type="text" name="default_marks" value="{{ $quize->default_marks }}" class="form-control">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-default_marks"></p>
                                </div>
                            </div>
                           
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Negative Marks (%)<span class="text-danger">*</span></label>
                                    <input type="text" name="negative_marks" value="{{ $quize->negative_marks }}" class="form-control">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-negative_marks"></p>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Time Limit (Minute)<span class="text-danger">*</span></label>
                                    <input type="time" name="time_limit" value="{{ $quize->time_limit }}" class="form-control">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-time_limit"></p>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1 submit" type="submit">Submit</button>
                       
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

<script src="{{asset('admin/assets/bundles/summernote/summernote-bs4.js')}}"></script>
    <script>

        // $(document).on('change','.scale_type',function() {

        //     var form_value = $('.scale_type option:selected').val();
        //     if (form_value == 'Numeric') {
        //         $(".score_show").removeClass('d-none');
        //         $(".score_show").show();
                
        //     }
        //     else if(form_value == 'Ungraded') {
        //         $(".score_show").hide();
               
        //     }
        // });


        $(document).on('submit', 'form#quizeFrm', function (event) {
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
                            $('.submit').html('Submit');
                        },2000);
                        console.log(response);
                        if(response.success==true) {   
                            toastr.success("Quiz Update Successfully");
                            window.setTimeout(function() {
                                window.location.href = "{{URL::to('/quize-list')}}"
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

