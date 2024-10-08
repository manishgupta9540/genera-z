@extends('admin.master.index')

@section('title', 'Question Create')

@section('content')
    <link rel="stylesheet" href="{{ asset('admin/assets/bundles/summernote/summernote-bs4.css') }}">
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header p-3 border-bottom">
                                <h5 class="m-0">Edit Assignment Question</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('question-quize-update') }}" method="POST" id="editQuestion"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="question_id" value="{{ ($question->id) }}">
                                    <input type="hidden" name="type" value="{{ ($question->type) }}">
                                    <input type="hidden" name="assignment_id" value="{{ ($question->assignment_id) }}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="content">Question Content</label>
                                            <textarea name="content" id="content" class="summernote" cols="30" rows="10">{!! $question->content ?? '' !!}</textarea>
                                            <span class="error-p text-danger" id="content_error"></span>
                                        </div>
                                        <div class="col-md-12 py-2">
                                            <input type="file" name="image" class="form-control" id="image" placeholder="Video Material">
                                            <span class="error-p text-danger" id="image_error"></span>
                                            @if (isset($question->image) && $question->image && file_exists(public_path('uploads/questionImages/' . $question->image)))
                                                <div class="form-group">
                                                    <a href="{{ asset('uploads/questionImages/' . $question->image) }}" target="_blank">
                                                        <img src="{{ asset('uploads/questionImages/' . $question->image) }}" width="100px" height="100px">
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                        @if($question->type=='1')
                                        <div class="col-md-12 addGrandParent">
                                            <div class="d-flex justify-content-between align-items-center py-2">
                                                <h5 class="form-control-label font-weight-bold">Question : Options</h5>
                                                <button type="button" class="btn btn-success addComponent mt-2"
                                                    pid="{{ config('addPages.questionEditOption.id') }}">
                                                    <i class="fa fa-plus mx-2"></i>Add Option
                                                </button>
                                            </div>
                                            <div class="row">
                                                <span id="options"></span>
                                                <span class="error-p text-danger" id="options_error"></span>
                                            </div>
                                            <div class="accordion p-3 border rounded addParent_{{ config('addPages.questionEditOption.id') }}">

                                                @if (isset($question->options))
                                                    @foreach ($question->options as $option)
                                                    {{-- {{dd($question->options)}} --}}
                                                        @include('admin.components.questionEditOption', [
                                                            'id' => $option->id,
                                                            'question_id' => $question->id,
                                                            'option' => $option,
                                                        ])
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="row">
                                                <span id="answer"></span>
                                                <span class="error-p text-danger" id="answer_error"></span>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row mb-3 text-center">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary submit mt-2">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
@endpush
