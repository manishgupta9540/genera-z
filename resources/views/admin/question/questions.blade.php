@extends('admin.master.index')

@section('title', 'Assignment Questions')
@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('admin/assets/bundles/summernote/summernote-bs4.css') }}">
    <script src="{{ asset('admin/assets/bundles/summernote/summernote-bs4.js') }}"></script>

    <style>
        .answerRadio{
            width: 1.5em;
            height: 1.5em;
        }
    </style>
@endpush
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            {{-- <div class="card-header">
                            </div> --}}

                            <div class="card-body">
                                <h4 class="border-bottom pb-2">Questions for Assignment : {{ $assignment->title }}
                                </h4>
                               @php $questionTypes =config('constants.questionType'); @endphp
                                <select class="form-control" onchange="getQuestionType(this)">
                                    <option>Select Question Type</option>
                                    @foreach ($questionTypes as  $key=>$questionype)
                                    <option value="{{ $questionype['id'] }}" {{ isset($assignment->type) && $assignment->type != $questionype['id'] ? 'style=display:none;' : '' }}>
                                        {{ $questionype['name'] }}
                                    </option>
                                    @endforeach
                                </select>
                                <form action="{{ route('questionStore',urlencode(base64_encode($assignment->id))) }}"  method="post" id="updatedmaterialFrm"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" name="type" id="question_type">

                                        <div class="col-sm-12 addGrandParent" id="shortQuestionForm" style="display: none;">
                                            <div class=" d-flex justify-content-between align-items-center py-2">
                                                <h5 class="form-control-label font-weight-bold">Assignment: Short Questions</h5>
                                                <button type="button" class="btn btn-success addComponent mt-2"
                                                    pid="{{ config('addPages.shortQuestion.id') }}"><i
                                                        class="fa fa-plus mx-2"></i>Add Question</button>
                                            </div>
                                            <div class="row">
                                                <span id="data"></span>
                                                <span class="error-p text-danger" id="data_error"></span>
                                            </div>
                                            <div class="accordion p-3 border rounded addParent_{{ config('addPages.shortQuestion.id') }}" id="questionList">
                                                @foreach ($assignment->questionsShort as $question)
                                                    @include('admin.components.shortQuestion', [
                                                        'id' => $question->id,
                                                        'question'=>$question
                                                    ])
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-sm-12 addGrandParent" id="mcqQuestionForm" style="display: none;">
                                            <div class=" d-flex justify-content-between align-items-center py-2">
                                                <h5 class="form-control-label font-weight-bold">Assignment: MCQ Questions</h5>
                                                <button type="button" class="btn btn-success addComponent mt-2"
                                                    pid="{{ config('addPages.question.id') }}"><i
                                                        class="fa fa-plus mx-2"></i>Add Question</button>
                                            </div>
                                            <div class="row">
                                                <span id="data"></span>
                                                <span class="error-p text-danger" id="data_error"></span>
                                            </div>
                                            {{-- {{$assignment->questions}} --}}
                                            <div class="accordion p-3 border rounded addParent_{{ config('addPages.question.id') }}" id="questionList">
                                                @foreach ($assignment->questionsMcq as $question)
                                                    @include('admin.components.question', [
                                                        'id' => $question->id,
                                                        'question'=>$question
                                                    ])
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="text-right m-3">
                                        <button class="btn btn-primary mr-1 submit" type="submit" id="submitBtn" style="display:none; ">Submit</button>
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
    <script src="{{ asset('admin/assets/js/page/questions.js') }}"></script>
    <script>
        function getQuestionType(select) {
            var selectedValue = select.value;
            var shortForm = document.getElementById('shortQuestionForm');
            var mcqForm = document.getElementById('mcqQuestionForm');
             var submitBtn = document.getElementById('submitBtn');
            var questionType = document.getElementById('question_type');

            let checkShort = "{{ $assignment->questionsShort }}";
            let checkMcq = "{{ $assignment->questionsMcq }}";
            let isShortEmpty = checkShort === '' || checkShort === '[]';
            let isMcqEmpty = checkMcq === '' || checkMcq === '[]';

            shortForm.style.display = "none";
            mcqForm.style.display = "none";
            submitBtn.style.display='none';
            if (selectedValue == "{{ $questionTypes['short']['id'] }}") {
                shortForm.style.display = "block";
                submitBtn.style.display='none';
                questionType.value =selectedValue;
            } else if (selectedValue == "{{ $questionTypes['mcq']['id'] }}") {
                mcqForm.style.display = "block";
                submitBtn.style.display='none';
                questionType.value =selectedValue;
            }
            submitBtn.style.display = (!isShortEmpty || !isMcqEmpty) ? "block" : "none";
        }


    </script>
@endpush
