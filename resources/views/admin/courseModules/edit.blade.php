@extends('admin.master.index')

@section('title', 'Edit Module')

@section('content')

<div class="main-content">
    <section class="section">
      <div class="section-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <div class="card-header p-3 border-bottom">
                <h5 class="m-0">Course Module Edit</h5>
              </div>
                <form action="{{ route('course-module_update') }}" method="post" id="createsubeditFrm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="row g-4">
                            <!-- First Module Input -->
                            <div class="col-md-8">
                                <div class="row g-2">
                                    <div class="col-md-8">
                                        <input type="hidden" name="id" value="{{ encrypt($moduleData->id) }}">
                                        <input type="hidden" name="course_id" value="{{$moduleData->course_id}}">
                                        <div class="">
                                            <label for="name">Module Name<b class="text-danger">*</b></label>
                                            <input type="text" id="name" value="{{ $moduleData->name }}" name="name" class="form-control" placeholder="Module Name">
                                            <span class="error-p text-danger" id="module_name_error"></span>
                                            {{-- <p id="error-name" class="text-danger error-p"></p> --}}
                                        </div>
                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-name"></p>
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


