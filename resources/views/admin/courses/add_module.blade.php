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
                <h4> Add Module </h4>
              </div>
                <form action="{{ route('course-module_create') }}" method="post" id="createsubModuleFrm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h5>Course Content</h5>
                        <p>Syllabus</p>
                        <div class="row g-4">
                            <!-- First Module Input -->
                            <div class="col-md-8">
                                <input type="hidden" id="course_id" value="{{ $courses->id}}" name="course_id">
                                <div class="row g-2">
                                    <div class="col-md-8">
                                        <div class="">
                                            <label for="module_name_0">Module Name<b class="text-danger">*</b></label>
                                            <input type="text" id="module_name_0" name="module_name[0]" class="form-control" placeholder="Module Name">
                                            <span class="error-p text-danger" id="module_name_0_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <button type="button" class="btn btn-primary add-area-btn1" data-id="Aaddress1" id="add1"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>

                                <div class="" id="mt12">

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

    $(document).ready(function() {

        // module name
        var i = 0;
        $("#add1").click(function() {
            ++i;
            $("#mt12").append(`<div class="row g-4" id="row${i}">
                <div class="col-md-8 pt-2">
                    <div class="">
                        <label for="module_name_${i}">Module Name<b class="text-danger">*</b></label>
                        <input type="text" id="module_name_${i}" name="module_name[${i}]" class="form-control">
                        <span class="error-p text-danger" id="module_name_${i}_error"></span>
                    </div>
                </div>
                <div class="col-md-4 pt-2">
                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-Answer"></p>
                    <button type="button" name="remove" id="${i}" class="btn btn-danger btn_remove"><i class="fa fa-minus"></i></button>
                </div>
            </div>`);
        });


        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
        });
    });



    </script>
@endpush

