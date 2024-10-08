@extends('admin.master.index')

@section('title', 'Edit Certification')

@section('content')

<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                {{-- <h4> Edit Certification </h4> --}}
              </div>
                <form action="{{ route('certification-update') }}" method="post" id="editCertiFrm">
                    @csrf
                    <div class="card-body">
                        <h4> Certification details </h4>
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="{{base64_encode($certification->id)}}">
                                    <label for="role" class="form-control-label font-weight-300">Certification Title<span class="text-danger">*</span></label>
                                    <input type="text" name="certification_title" value="{{ $certification->certification_title}}" class="form-control" placeholder="Certification Title">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-certification_title"></p>
                                </div>
                            </div>
                           
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Issuing Organization<span class="text-danger">*</span></label>
                                    <input type="text" name="issuing_organization" value="{{ $certification->issuing_organization }}" class="form-control" placeholder="Issuing Organization">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-issuing_organization"></p>
                                </div>
                            </div>
                            <div class="col-sm-12   ">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Course<span class="text-danger">*</span></label>
                                    <select name="course_id" class="form-control" id="course_id">
                                        <option value="">Select Course</option>
                                        @foreach ($courses as $course)
                                            <option value="{{$course->id}}" {{ $course->id == $certification->course_id ? 'selected' : '' }}>{{$course->course_title}}</option>
                                        @endforeach
                                     
                                    </select>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-course_id"></p>
                                </div>
                            </div>
                            
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Description<span class="text-danger">*</span></label>
                                    {{-- <input type="text" name="description"  class="form-control" placeholder="Description"> --}}
                                    <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $certification->description }}</textarea>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-description"></p>
                                </div>
                            </div>
                        </div>
                        <h4> Eligibility Criteria</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Completion Requirements<span class="text-danger">*</span></label>
                                    <input type="text" name="completion" value="{{ $certification->completion}}" class="form-control" placeholder="Completion Requirements">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-completion"></p>
                                </div>
                            </div>
                           
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Minimum Grade<span class="text-danger">*</span></label>
                                    <input type="text" name="minimum_grade" value="{{ $certification->minimum_grade}}" class="form-control" placeholder="Minimum Grade">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-minimum_grade"></p>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Certificate Design<span class="text-danger">*</span></label>
                                    <input type="file" name="certificate_design"  class="form-control" placeholder="Certificate Design">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-certificate_design"></p>
                                </div>
                            </div>

                            @if($certification->certificate_design!=NULL && file_exists(public_path('uploads/certification/'.$certification->certificate_design)))
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <a href="{{asset('uploads/certification/'.$certification->certificate_design)}}" target="_blank">
                                        <img src="{{asset('uploads/certification/'.$certification->certificate_design)}}" width="100px" height="100px">
                                    </a>
                                </div>
                            </div>
                        @endif
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
          $(document).on('submit', 'form#editCertiFrm', function (event) {
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
                                toastr.success("Certificate Update Successfully");
                                window.setTimeout(function() {
                                    window.location.href = "{{URL::to('certification')}}"
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

