@extends('admin.master.index')

@section('title', 'Assignment Edit')

@section('content')
    <link rel="stylesheet" href="{{ asset('admin/assets/bundles/summernote/summernote-bs4.css') }}">
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header p-3 border-bottom">
                                <h5 class="m-0">Edit Assignment</h5>
                            </div>
                            <form action="{{ route('assignment-update') }}" method="post" id="assignmentUpdateFrm"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <input type="hidden" name="id" id="id" value="{{ base64_encode($assignment->id) }}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @include('components.input', [
                                                'id' => 'title',
                                                'name' => 'title',
                                                'label' => 'Title',
                                                'type' => 'text',
                                                'mandatory' => true,
                                                'class' => '',
                                                'readonly' => false,
                                                'maxlength' => '255',
                                                'value' => isset($assignment->title) ? $assignment->title : '',
                                                'placeholder' => 'Title',
                                            ])
                                        </div>
                                        <div class="col-md-3">
                                            @include('components.input', [
                                                'id' => 'attempts',
                                                'name' => 'attempts',
                                                'label' => 'Number of Attempts',
                                                'type' => 'number',
                                                'mandatory' => true,
                                                'class' => 'unsignedNumber',
                                                'readonly' => false,
                                                'maxlength' => '255',
                                                'value' => isset($assignment->attempts)
                                                    ? $assignment->attempts
                                                    : '',
                                                'placeholder' => 'Attempts',
                                            ])
                                        </div>
                                        <div class="col-md-3">
                                            @include('components.input', [
                                                'id' => 'duration',
                                                'name' => 'duration',
                                                'label' => 'Duration(In Minutes)',
                                                'type' => 'number',
                                                'mandatory' => true,
                                                'class' => 'unsignedNumber',
                                                'readonly' => false,
                                                'maxlength' => '255',
                                                'value' => isset($assignment->duration)
                                                    ? $assignment->duration
                                                    : '',
                                                'placeholder' => 'Duration(In Minutes)',
                                            ])
                                        </div>

                                        @if($assignment->type !=0)
                                        <div class="col-md-3">
                                            @include('components.input', [
                                                'id' => 'pass_score',
                                                'name' => 'pass_score',
                                                'label' => 'Passing Score',
                                                'type' => 'number',
                                                'mandatory' => true,
                                                'class' => 'unsignedNumber',
                                                'readonly' =>isset($assignment->pass_score)
                                                    ?false
                                                    : true,
                                                'maxlength' => '255',
                                                'value' => isset($assignment->pass_score)
                                                    ? $assignment->pass_score
                                                    : '',
                                                'placeholder' => 'Passing Score',
                                            ])
                                        </div>
                                        <div class="col-md-3">
                                            @include('components.input', [
                                                'id' => 'max_score',
                                                'name' => 'max_score',
                                                'label' => 'Maximum Score',
                                                'type' => 'number',
                                                'mandatory' => true,
                                                'class' => 'unsignedNumber',
                                                'readonly' =>isset($assignment->max_score)?false:true,
                                                'maxlength' => '255',
                                                'value' => isset($assignment->max_score)
                                                    ? $assignment->max_score
                                                    : '',
                                                'placeholder' => 'Maximum Score',
                                            ])
                                        </div>
                                        @endif
                                        <input type="hidden" name="assignment_id" value="{{$assignment->type}}">
                                        {{-- <div class="col-md-12">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" class="summernote" cols="30" rows="10">{!! $assignment->description ?? '' !!}</textarea>
                                            <span class="error-p text-danger" id="description_error"></span>
                                        </div> --}}
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
    <script src="{{ asset('admin/assets/bundles/summernote/summernote-bs4.js') }}"></script>
    <script>
        // function reinitializeSummernote() {
        //     $('.summernote').summernote({
        //         tabsize: 2,
        //         height: 200
        //     });
        // }

        // $(document).ready(function() {
        //     reinitializeSummernote();
        // })

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
@endpush
