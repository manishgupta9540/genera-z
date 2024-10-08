@extends('admin.master.index')

@section('title', 'Course Material Create')

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
            <form action="{{ route('course-material-store') }}" method="post" id="creatematerialFrm" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <h4> Add Course Material </h4>
                    <hr>
                    <div class="row">
                        <input type="hidden" name="sub_module_id" value="{{ $subModule->id }}">
                            {{-- <h4 style="margin-left:11px;">Multimedia and Resources</h4> --}}
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Video Name<span class="text-danger">*</span></label>
                                    <input type="text" name="video_name[]"  class="form-control" placeholder="Video Name">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-video_name"></p>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Lecture Video<span class="text-danger">*</span></label>
                                    <input type="file" name="leacture_video[]"  class="form-control" placeholder="Image">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-leacture_video"></p>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Material Name<span class="text-danger">*</span></label>
                                    <input type="text" name="material_name[]"  class="form-control" placeholder="Material Name">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-description"></p>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="role" class="form-control-label font-weight-300">Reading Material<span class="text-danger">*</span></label>
                                    {{-- <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea> --}}
                                    <textarea class="summernote form-control content" name="reading_material[]" id="content" placeholder="Enter the Description"></textarea>
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-description"></p>
                                </div>
                            </div>

                        </div>
                        <button type="button" class="btn btn-primary add-area-btn1" data-id="Aaddress1" id="add1"><i class="fa fa-plus"></i></button>
                    </div>

                    <div id="mt12">
                        <!-- Additional content can be added here -->
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
        // add course material name
            var i = 0;
            $("#add1").click(function() {
                    ++i;
                $("#mt12").append(`<div class="container row" id="row${i}">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="role" class="form-control-label font-weight-300">Video Name<span class="text-danger">*</span></label>
                            <input type="text" name="video_name[]"  class="form-control" placeholder="Video Name">
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-video_name"></p>
                        </div>
                    </div>
                     <div class="col-sm-12">
                        <div class="form-group">
                            <label for="role" class="form-control-label font-weight-300">Lecture Video<span class="text-danger">*</span></label>
                            <input type="file" name="leacture_video[]"  class="form-control" placeholder="Image">
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-leacture_video"></p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="role" class="form-control-label font-weight-300">Material Name<span class="text-danger">*</span></label>
                            <input type="text" name="material_name[]"  class="form-control" placeholder="Material Name">
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-material_name"></p>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="role" class="form-control-label font-weight-300">Reading Material<span class="text-danger">*</span></label>
                            <textarea class="summernote form-control content" name="reading_material[]" id="content${i}" placeholder="Enter the Description"></textarea>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-description"></p>
                        </div>
                            <button type="button" name="remove" id="${i}" class="btn btn-danger btn_remove"><i class="fa fa-minus"></i></button>
                    </div>`);

                    $(`#content${i}`).summernote({
                        height: 150, // Set editor height
                        minHeight: null, // Set minimum height of editor
                        maxHeight: null, // Set maximum height of editor
                        focus: true 
                    });
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                    $('#row' + button_id + '').remove();
            });
        // $(document).on('change','.module',function(){
        //     var id = $('#module_id option:selected').val();

        //         $.ajax({
        //         type:"post",
        //         url:"{{route('/sub-module-data')}}",
        //         data:{'module_id':id,"_token": "{{ csrf_token() }}"},
        //         success:function(data)
        //         {
        //             $("#sub_module_id").empty();
        //             $("#sub_module_id").html('<option>Select State</option>');
        //             $.each(data,function(key,value){
        //                 $("#sub_module_id").append('<option value="'+value.id+'">'+value.name+'</option>');
        //             });
        //         }
        //     });
        // });


        $(document).on('submit', 'form#creatematerialFrm', function (event) {
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
                            toastr.success("Course material Creted Successfully");
                            window.setTimeout(function() {
                                window.location.href = "{{URL::to('/course-material')}}"
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

