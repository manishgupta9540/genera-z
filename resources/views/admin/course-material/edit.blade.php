@extends('admin.master.index')

@section('title', 'Course Material Updated')

@section('content')
    <link rel="stylesheet" href="{{ asset('admin/assets/bundles/summernote/summernote-bs4.css') }}">
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header p-3 border-bottom">
                                <h5 class="m-0">Edit Course material</h5>
                            </div>
                            <form action="{{ route('course-material-update') }}" method="post" id="updatedmaterialFrm" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <input type="hidden" name="id" id="id" value="{{ base64_encode($materials->id) }}">
                                        <div class="col-md-4">
                                            @include('components.input', [
                                                'id' => 'name',
                                                'name' => 'name',
                                                'label' => 'Material Name',
                                                'type' => 'text',
                                                'mandatory' => true,
                                                'value' => isset($materials->name) ? $materials->name : '',
                                                'placeholder' => 'Enter Material Name',
                                            ])
                                        </div>
                                        <div class="col-md-4">
                                            @include('components.select', [
                                                'id' => 'reading',
                                                'name' => 'reading',
                                                'class' => 'materialType',
                                                'mandatory' => true,
                                                'label' => 'Material Type',
                                                'options' => config('constants.materialTypes'),
                                                'selected' => isset($materials->reading) ? $materials->reading : '',
                                            ])
                                        </div>
                                        <div class="col-md-4">
                                            @include('components.input', [
                                                'id' => 'duration',
                                                'name' => 'duration',
                                                'label' => 'Duration (In Minutes)',
                                                'type' => 'number',
                                                'mandatory' => true,
                                                'readonly' => isset($materials->reading) && !$materials->reading,
                                                'value' => isset($materials->duration) ? $materials->duration : '',
                                                'placeholder' => 'Enter Duration in Minutes',
                                            ])
                                        </div>
                                        <div class="col-md-12 py-2">
                                            <div class="d-flex ms-1 justify-content-between align-items-center">
                                                <label for="content"
                                                    class="mb-1 {{ isset($materials->mandatory) && $materials->mandatory == true ? 'mandatory-field' : '' }}">
                                                    Material Content
                                                </label>
                                            </div>
                                            @if (isset($materials->reading) && !$materials->reading && file_exists(public_path('uploads/materialVideo/' . $materials->content)))
                                                <input type="file" name="content" class="form-control material" id="content" placeholder="Video Material" accept="video/*">
                                                <div class="form-group ">
                                                    <video width="320" height="240" controls>
                                                        <source src="{{ asset('uploads/materialVideo/' . $materials->content) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                            @else
                                                @if(isset($materials->ppt))
                                                    <input type="file" name="ppt" class="form-control material" id="ppt" accept=".ppt,.pptx">
                                                    <br>
                                                    <a href="{{ asset('uploads/PPT/' . $materials->ppt) }}" target="_blank">
                                                        <img src="{{ asset('admin/assets/img/ppt_icon.png') }}" height="80px" width="80px" alt="PPT File">
                                                    </a>
                                                @else
                                                    <textarea name="content" class="summernote form-control material" id="content" placeholder="Reading Material">{!! $materials->content ?? '' !!}</textarea>
                                                @endif
                                            @endif
                                            <p id="content_error" class="text-danger error-p"></p>
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
    <script src="{{ asset('admin/assets/bundles/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('admin/assets/js/page/courseMaterial.js') }}"></script>
@endpush
