@extends('admin.master.index')

@section('title', 'Categories Create')

@section('content')
<link rel="stylesheet" href="{{asset('admin/assets/bundles/summernote/summernote-bs4.css')}}">
<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4> Add Categories </h4>
              </div>
                <form action="{{ route('category-create') }}" method="post" id="createCategoryFrm">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Categories Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control">
                            <p id="name_error" class="text-danger error-p"></p>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" id="" class="summernote form-control" cols="30" rows="10"></textarea>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-description"></p>
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
     $('.summernote').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });
  </script>
<script src="{{asset('admin/assets/bundles/summernote/summernote-bs4.js')}}"></script>
    <script>
            // $(document).on('submit', 'form#createCategoryFrm', function (event) {
            //     event.preventDefault();
            //     //clearing the error msg
            //     $('p.error_container').html("");

            //     var form = $(this);
            //     var data = new FormData($(this)[0]);
            //     var url = form.attr("action");
            //     var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
            //     $('.submit').attr('disabled',true);
            //     $('.form-control').attr('readonly',true);
            //     $('.form-control').addClass('disabled-link');
            //     $('.error-control').addClass('disabled-link');
            //     if ($('.submit').html() !== loadingText) {
            //         $('.submit').html(loadingText);
            //     }
            //     $.ajax({
            //         type: form.attr('method'),
            //         url: url,
            //         data: data,
            //         cache: false,
            //         contentType: false,
            //         processData: false,
            //         success: function (response) {
            //             window.setTimeout(function(){
            //                 $('.submit').attr('disabled',false);
            //                 $('.form-control').attr('readonly',false);
            //                 $('.form-control').removeClass('disabled-link');
            //                 $('.error-control').removeClass('disabled-link');
            //                 $('.submit').html('Save');
            //             },2000);
            //             console.log(response);
            //             if(response.success==true) {
            //                 toastr.success("Category Creted Successfully");
            //                 window.setTimeout(function() {
            //                     window.location.href = "{{URL::to('category')}}"
            //                 }, 2000);
            //             }
            //             //show the form validates error
            //             if(response.success==false ) {
            //                 for (control in response.errors) {
            //                 var error_text = control.replace('.',"_");
            //                 $('#error-'+error_text).html(response.errors[control]);
            //                 // $('#error-'+error_text).html(response.errors[error_text][0]);
            //                 // console.log('#error-'+error_text);
            //                 }
            //                 // console.log(response.errors);
            //             }
            //         },
            //         error: function (response) {
            //             // alert("Error: " + errorThrown);
            //             console.log(response);
            //         }
            //     });
            //     event.stopImmediatePropagation();
            //     return false;
            // });

    </script>
@endpush

