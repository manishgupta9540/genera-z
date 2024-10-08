@extends('admin.master.index')

@section('title', 'Assignment Show')

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
            {{-- <form action="{{ route('assignment-update') }}" method="post" id="assignmentUpdateFrm" enctype="multipart/form-data">
                @csrf --}}
                <div class="card-body">
                    <h4> Show Assignment </h4>
                    <hr>
                        <div class="row">
                            <input type="hidden" name="cours_m_id" value="{{ base64_encode($assignments->sub_module_id) }}">
                            <input type="hidden" name="id" value="{{ base64_encode($assignments->id) }}" id="">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Title<span class="text-danger">*</span></label>
                                    <input type="text" name="title" value="{{ $assignments->title}}" class="form-control" readonly>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-title"></p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Assignment Files<span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control" disabled>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-image"></p>
                                </div>
                            </div>
                            @if($assignments->image!=NULL && file_exists(public_path('uploads/assignment/'.$assignments->image)))
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <a href="{{asset('uploads/assignment/'.$assignments->image)}}" target="_blank">
                                            <img src="{{asset('uploads/assignment/'.$assignments->image)}}" width="100px" height="100px">
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Description<span class="text-danger">*</span></label>
                                    {{-- <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea> --}}
                                    <textarea class="summernote form-control content" id="content" placeholder="Enter the Description"name="description" readonly>{{ $assignments->description }}</textarea>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-description"></p>
                                </div>
                            </div>

                           <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Due Date<span class="text-danger">*</span></label>
                                    <input type="date" id="dueDateTime" name="due_date" value="{{ $assignments->due_date }}" class="form-control" readonly>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-due_date"></p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Due Time<span class="text-danger">*</span></label>
                                    <input type="time" id="dueDate" name="due_time" value="{{ $assignments->due_time }}" class="form-control" readonly>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-due_time"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Scale Type<span class="text-danger">*</span></label>
                                    <select name="scale_type" id="scale_type" class="scale_type form-control" disabled>
                                        <option value="">-Select Type-</option>
                                        <option value="Ungraded" {{ $assignments->scale_type == 'Ungraded' ? 'selected' : '' }}>Ungraded</option>
                                        <option value="Numeric" {{ $assignments->scale_type == 'Numeric' ? 'selected' : '' }}>Numeric</option>
                                    </select>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-scale_type"></p>
                                </div>
                            </div>
                            <div class="score_show d-none col-sm-4">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Passing Score<span class="text-danger">*</span></label>
                                    <input type="text" name="passing_score" value="{{ $assignments->passing_score }}" class="form-control" readonly>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-passing_score"></p>
                                </div>
                            </div>
                            <div class="score_show d-none col-sm-4">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Max Score<span class="text-danger">*</span></label>
                                    <input type="text" name="max_score" value="{{ $assignments->max_score }}" class="form-control" readonly>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-max_score"></p>
                                </div>
                            </div>
                        </div>
                        <input type="checkbox" name="late_submission"  value="1" {{ $assignments->late_submission ? 'checked' : '' }} readonly>
                        <label for="">Allow Late Submissions</label>
                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-late_submission"></p>
                        <br>
                        <input type="checkbox" name="lock_submission" value="1" {{ $assignments->lock_submission ? 'checked' : '' }} readonly>
                        <label for="">Lock Submissions</label>
                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-lock_submission"></p>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('assignment-list')}}" class="btn btn-primary mr-1 submit">Back</a>
                </div>
            {{-- </form> --}}
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

        $('#content').summernote('disable');

        $(document).on('change','.scale_type',function() {
            var form_value = $('.scale_type option:selected').val();
            if (form_value == 'Numeric') {
                $(".score_show").removeClass('d-none');
                $(".score_show").show();
            }
            else if(form_value == 'Ungraded') {
                $(".score_show").hide();
            }
        });

        $(document).on('submit', 'form#assignmentUpdateFrm', function (event) {
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
                            toastr.success("Assignment Updated Successfully");
                            window.setTimeout(function() {
                                window.location.href = "{{URL::to('/assignment-list')}}"
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

