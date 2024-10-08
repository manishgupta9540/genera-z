@extends('admin.master.index')

@section('title', 'Edit sub Module')

@section('content')

<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header p-3 border-bottom">
                <h5 class="m-0">Edit Sub Module</h5>
              </div>
                <form action="{{ route('sub-module_update') }}" method="post" id="editsubModuleFrm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <!-- First Module Input -->
                            <input type="hidden" name="module_id" value="{{ base64_encode($subModule->module_id) }}">
                            <div class="col-md-6">
                                <label for="">Sub 111Module Name</label>
                                <input type="text" name="name" value="{{ $subModule->name }}" class="form-control">
                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-name"></p>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button class="btn btn-primary mr-1 submit" type="submit">Submit</button>
                        </div>
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


    // $(document).on('submit', 'form#editsubModuleFrm', function (event) {
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
    //         $.ajax({
    //             type: form.attr('method'),
    //             url: url,
    //             data: data,
    //             cache: false,
    //             contentType: false,
    //             processData: false,
    //             success: function (response) {
    //                 window.setTimeout(function(){
    //                     $('.submit').attr('disabled',false);
    //                     $('.form-control').attr('readonly',false);
    //                     $('.form-control').removeClass('disabled-link');
    //                     $('.error-control').removeClass('disabled-link');
    //                     $('.submit').html('Submit');
    //                 },2000);
    //                 console.log(response);
    //                 if(response.success==true) {
    //                     toastr.success(response.message);
    //                     window.setTimeout(function() {
    //                         window.location.href = "{{URL::to('sub-module-list')}}"
    //                     }, 2000);
    //                 }
    //                 //show the form validates error
    //                 if(response.success==false ) {
    //                     for (control in response.errors) {
    //                     var error_text = control.replace('.',"_");
    //                     $('#error-'+error_text).html(response.errors[control]);
    //                     // $('#error-'+error_text).html(response.errors[error_text][0]);
    //                     // console.log('#error-'+error_text);
    //                     }
    //                     // console.log(response.errors);
    //                 }
    //             },
    //             error: function (response) {
    //                 // alert("Error: " + errorThrown);
    //                 console.log(response);
    //             }
    //         });
    //         event.stopImmediatePropagation();
    //         return false;
    // });


    </script>
@endpush

