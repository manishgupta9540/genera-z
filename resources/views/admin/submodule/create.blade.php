@extends('admin.master.index')

@section('title', 'Create Module')

@section('content')

<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4> Add Sub Module </h4>
              </div>
                <form action="{{ route('sub-module-store') }}" method="post" id="createsubModuleFrm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            <input type="hidden" name="module_id" value="{{ base64_encode($courseModule->id) }}">
                            <div class="col-md-12">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="">
                                            <label for="name">Sub Module Name<b class="text-danger">*</b></label>
                                            <input type="text" id="name" name="name[0]" class="form-control" placeholder="Sub Module Name">
                                            <p id="name_0_error" class="text-danger error-p"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-center">
                                        <button type="button" class="btn btn-primary add-area-btn1" data-id="Aaddress1" id="add1"><i class="fa fa-plus"></i></button>
                                    </div>

                                </div>
                                <div id="mt12">
                                    <!-- Additional content can be added here -->
                                </div>
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

     // module name
     var i = 0;

    $("#add1").click(function() {
        ++i;
        $("#mt12").append(`
            <div class="row g-4" id="row${i}">
                <div class="col-md-6 pt-2">
                    <div class="">
                        <label for="name_${i}">Sub Module Name<b class="text-danger">*</b></label>
                        <input type="text" id="name_${i}" name="name[${i}]" class="form-control" placeholder="Sub Module Name">
                        <p id="name_${i}_error" class="text-danger error-p"></p>
                    </div>
                </div>
                <div class="col-md-4 pt-2">
                    <button type="button" name="remove" id="${i}" class="btn btn-danger btn_remove"><i class="fa fa-minus"></i></button>
                </div>
            </div>
        `);
    });

    $(document).on('click', '.btn_remove', function() {
        var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
    });



    // $(document).on('submit', 'form#createsubModuleFrm', function (event) {
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
    //                     toastr.success("Course sub Module Creted Successfully");
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

