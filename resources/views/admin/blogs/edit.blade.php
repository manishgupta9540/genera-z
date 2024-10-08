@extends('admin.master.index')

@section('title', 'Blogs Edit')

@section('content')

<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4> Edit Blogs </h4>
              </div>
                <form action="{{ route('blogs-update') }}" method="post" id="updateblogsFrm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="hidden" name="id" value="{{base64_encode($blogs->id)}}" id="">
                                    <label for="role" class="form-control-label font-weight-300">Title<span class="text-danger">*</span></label>
                                    <input type="text" name="title"  class="form-control" value="{{ $blogs->title}}" placeholder="Title">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-title"></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name"  class="form-control" value="{{ $blogs->name}}" placeholder="Name">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-name"></p>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Image<span class="text-danger">*</span></label>
                                    <input type="file" name="image"  class="form-control" placeholder="Image">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-image"></p>
                                </div>
                            </div>
                            @if($blogs->image!=NULL && file_exists(public_path('uploads/blogs/'.$blogs->image)))
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <a href="{{asset('uploads/blogs/'.$blogs->image)}}" target="_blank">
                                            <img src="{{asset('uploads/blogs/'.$blogs->image)}}" width="100px" height="100px">
                                        </a>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="role" class="form-control-label font-weight-300">Description<span class="text-danger">*</span></label>
                                <textarea name="description" id="" class="form-control" cols="30" rows="10">{{ $blogs->name}}</textarea>
                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-description"></p>
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
    <script>
            $(document).on('submit', 'form#updateblogsFrm', function (event) {
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
                                toastr.success("Blog Update Successfully");
                                window.setTimeout(function() {
                                    window.location.href = "{{URL::to('blogs-list')}}"
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

