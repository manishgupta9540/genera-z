@extends('admin.master.index')
@section('title', $title)
<style>
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #000000 !important;
    border: 1px solid #aaa;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 0 5px;
}
</style>
@section('content')
    <link rel="stylesheet" href="{{ asset('admin/assets/bundles/summernote/summernote-bs4.css') }}">
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4> {{ $title }} </h4>
                            </div>
                            <form action="{{ route('course.store') }}" method="post" id="editCourseFrm" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="hidden" name="id"
                                                    value="{{ isset($courseData->id) ? urlencode(base64_encode($courseData->id)) : '' }}">
                                                <label for="role" class="form-control-label font-weight-300">Title<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="title"
                                                    value="{{ isset($courseData->title) ? $courseData->title : '' }}"
                                                    class="form-control" placeholder="Course Title">
                                                    <p id="title_error" class="text-danger error-p"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="rating" class="form-control-label font-weight-300">Rating<span
                                                        class="text-danger">*</span></label>
                                                <input type="number" id="rating" name="rating" min="1"
                                                    max="5" step="0.1"
                                                    value="{{ isset($courseData->rating) ? number_format($courseData->rating, 1) : '' }}"
                                                    class="form-control" placeholder="Rating">
                                                    <p id="rating_error" class="text-danger error-p"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="headline"
                                                    class="form-control-label font-weight-300">Headline<span
                                                        class="text-danger">*</span></label>
                                                <textarea name="headline" id="headline" class="summernote form-control" cols="30" rows="10" maxlength="255">{{ isset($courseData->headline) ? $courseData->headline : '' }}</textarea>
                                                <p id="headline_error" class="text-danger error-p"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="role"
                                                    class="form-control-label font-weight-300">Course Overview<span
                                                        class="text-danger">*</span></label>
                                                <textarea name="overview" id="" class="summernote form-control" cols="30" rows="10">{{ isset($courseData->overview) ? $courseData->overview : '' }}</textarea>
                                                <p id="overview_error" class="text-danger error-p"></p>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="role" class="form-control-label font-weight-300">What You’ll Learn<span class="text-danger">*</span></label>
                                                <textarea name="description" id="" class="summernote form-control" cols="30" rows="10">{{ isset($courseData->description) ? $courseData->description : '' }}</textarea>
                                                <p id="description_error" class="text-danger error-p"></p>
                                            </div>
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="role"
                                                    class="form-control-label font-weight-300">Module Summary<span
                                                        class="text-danger">*</span></label>
                                                <textarea name="summary" id="" class="summernote form-control" cols="30" rows="10">{{ isset($courseData->summary) ? $courseData->summary : '' }}</textarea>
                                                <p id="summary_error" class="text-danger error-p"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            @include('components.select', [
                                                'id' => 'category_id',
                                                'name' => 'category_id',
                                                'class' => '',
                                                'label' => 'Category',
                                                'mandatory' => true,
                                                'multiple' => false,
                                                'disabled' => false,
                                                'default' => '',
                                                'options' => $categories,
                                                'selected' => isset($courseData->category_id)
                                                    ? $courseData->category_id
                                                    : '',
                                            ])
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="role"
                                                    class="form-control-label font-weight-300">Image<span
                                                        class="text-danger">*</span></label>
                                                <input type="file" name="image" class="form-control" placeholder="Image">
                                                <p id="image_error" class="text-danger error-p"></p>
                                            </div>
                                        </div>

                                        @if (isset($courseData['image']))
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <a href="{{ Storage::url('uploads/course/' . $courseData['image']) }}"
                                                        target="_blank">
                                                        <img src="{{ Storage::url('uploads/course/' . $courseData['image']) }}"
                                                            width="100px" height="100px">
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row">

                                        {{-- <div class="col-sm-12 addGrandParent">
                                            <div class=" d-flex justify-content-between align-items-center py-2">
                                                <span class="form-control-label font-weight-bold">Objectives</span>
                                                <button type="button" class="btn btn-success addComponent mt-2"
                                                    pid="{{ config('addPages.objective.id') }}"><i
                                                        class="fa fa-plus mx-2"></i>Add New</button>
                                            </div>
                                            <div class="addParent_{{ config('addPages.objective.id') }}">
                                                @if (isset($objectives) && count($objectives))
                                                    @foreach ($objectives as $value)
                                                        @include('admin.components.objective', $value)
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div> --}}
                                        <div class="col-sm-12">
                                            @include('components.select', [
                                                'id' => 'skills',
                                                'name' => 'skills[]',
                                                'class' => 'select2',
                                                'label' => 'Skills',
                                                'mandatory' => true,
                                                'multiple' => true,
                                                'disabled' => false,
                                                'default' => '',
                                                'options' => $skills,
                                                'selected' =>
                                                    isset($courseData->skills) && count($courseData->skills)
                                                        ? $courseData->skills->pluck('id')->toArray()
                                                        : [],
                                            ])
                                        </div>
                                    </div>
                                    <h5>Scheduling</h5>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="role" class="form-control-label font-weight-300">Course
                                                    Duration<span class="text-danger">*</span></label>
                                                <input type="number" min="1" name="duration" value="{{ isset($courseData->duration) ? $courseData->duration : '' }}"
                                                    class="form-control" placeholder="Course Duration">
                                                    <p id="duration_error" class="text-danger error-p"></p>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="role" class="form-control-label font-weight-300">Total
                                                    Modules<span class="text-danger">*</span></label>
                                                <input type="number" name="total_modules"
                                                    value="{{ isset($courseData->rating) ? $courseData->total_modules : '' }}"
                                                    class="form-control" placeholder="Total Modules">
                                                    <p id="total_modules_error" class="text-danger error-p"></p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            @include('components.select', [
                                                'id' => 'one_time',
                                                'name' => 'one_time',
                                                'class' => 'type',
                                                'label' => 'Course Type',
                                                'mandatory' => true,
                                                'multiple' => false,
                                                'disabled' => false,
                                                'default' => '',
                                                'options' => config('constants.courseTypes'),
                                                'selected' => isset($courseData->one_time)
                                                    ? $courseData->one_time
                                                    : '',
                                            ])
                                        </div>
                                        <div class="col-sm-6 afterPriceOption" id="price"
                                            style="{{ isset($courseData->one_time) && !$courseData->one_time ? 'display: none;' : '' }}">
                                            @include('components.input', [
                                                'id' => 'price',
                                                'name' => 'price',
                                                'label' => 'Course Price',
                                                'type' => 'number',
                                                'class' => '',
                                                'mandatory' => true,
                                                'readonly' => false,
                                                'min' => 0,
                                                'value' => isset($courseData->price) ? $courseData->price : '',
                                                'placeholder' => 'Enter Course Price',
                                                'otherattr' => '',
                                            ])
                                        </div>
                                        <div class="afterPriceOption col-sm-12" id="plan_info"
                                            style="{{ isset($courseData->one_time) && !$courseData->one_time ? 'display: none;' : '' }}">
                                            <div class="form-group">
                                                <label for="role" class="form-control-label font-weight-300">Plan
                                                    Details<span class="text-danger">*</span></label>
                                                <textarea class="summernote form-control content" name="plan_info" id="content"
                                                    placeholder="Enter the Plan Details">{{ isset($courseData->plan_info) ? $courseData->plan_info : '' }}</textarea>
                                                    <p id="plan__error" class="text-danger error-p"></p>
                                            </div>
                                        </div>

                                    </div>
                                    <div id="pricingOptionsDiv" style="{{ isset($courseData->one_time) && !$courseData->one_time ? '' : 'display: none;' }}">
                                        <div class="col-sm-12 addGrandParent">
                                            <div class=" d-flex justify-content-between align-items-center py-2">
                                                <h5 class="form-control-label font-weight-bold">Pricing Options</h5>
                                                <button type="button" class="btn btn-success addComponent mt-2"
                                                    pid="{{ config('addPages.priceOption.id') }}"><i
                                                        class="fa fa-plus mx-2"></i>Add New</button>
                                            </div>
                                            <div class="addParent_{{ config('addPages.priceOption.id') }}" id="priceOptionsList">
                                                @if (isset($courseData->priceOptions) && count($courseData->priceOptions))
                                                    @foreach ($courseData->priceOptions as $value)
                                                        @include('admin.components.priceOption', $value)
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>

                        <div class="card-footer text-center">
                            <button class="btn btn-lg submit btn-primary" type="submit">
                                {{ isset($courseData->id) ? 'Update' : 'Submit' }}
                            </button>
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
    <script src="{{ asset('admin/assets/bundles/summernote/summernote-bs4.js') }}"></script>
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
    <script>
        const courseTypes = @json(config('constants.courseTypes'));
        $('body').on('change', '#one_time', function() {
            var selected = $(this).val();
            if (selected == courseTypes.one_time.id) {
                $('#pricingOptionsDiv').hide();
                $('.afterPriceOption').show();
            } else {
                $('.afterPriceOption').hide();
                $('#pricingOptionsDiv').show();
            }
        });
    </script>
    <script>
        $(document).ready( function(){
            $(document).on('click', '.deleteBtn', function() {
            var _this = $(this);
            var id = $(this).data('id');
            alert(id);
            var table = 'courses';
            swal({
                    // icon: "warning",
                    type: "warning",
                    title: "Are You Sure You Want to Delete?",
                    text: "",
                    dangerMode: true,
                    showCancelButton: true,
                    confirmButtonColor: "#007358",
                    confirmButtonText: "YES",
                    cancelButtonText: "CANCEL",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function(e) {
                    if (e == true) {
                        _this.addClass('disabled-link');
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "{{ route('course-delete') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': id,
                                'table_name': table
                            },
                            success: function(response) {
                                console.log(response);
                                window.setTimeout(function() {
                                    _this.removeClass('disabled-link');
                                }, 2000);

                                if (response.success==true ) {
                                    window.setTimeout(function() {
                                        window.location.reload();
                                    }, 2000);
                                }
                            },
                            error: function(response) {
                                console.log(response);
                            }
                        });
                        swal.close();
                    } else {
                        swal.close();
                    }
                }
            );
        });
        })
    </script>
@endpush
