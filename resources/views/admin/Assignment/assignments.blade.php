@extends('admin.master.index')

@section('title', 'Course Materials')

@push('head-scripts')
    <link rel="stylesheet" href="{{ asset('admin/assets/bundles/summernote/summernote-bs4.css') }}">
    <script src="{{ asset('admin/assets/bundles/summernote/summernote-bs4.js') }}"></script>
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
                                <h4 class="border-bottom pb-2">Assignments for Sub-Module : {{ $subModule->name }}
                                </h4>
                                @php $questionTypes =config('constants.questionType'); @endphp
                                <select class="form-control" onchange="getQuestionType(this)">
                                    <option>Select Assignments Type</option>
                                    @foreach ($questionTypes as $key => $questionype)
                                        <option value="{{ $questionype['id'] }}"
                                            {{ isset($type) && $type != $questionype['id'] ? 'style=display:none;' : '' }}>
                                            {{ $questionype['name'] }}
                                        </option>
                                    @endforeach

                                </select>
                                <form action="{{ route('assignmentsStore', urlencode(base64_encode($subModule->id))) }}"
                                    method="post" id="updatedmaterialFrm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="type" id="assignment_id">
                                    <div class="row">
                                        <div class="col-sm-12 addGrandParent" id="shortQuestionForm" style="display: none;">
                                            <div class=" d-flex justify-content-between align-items-center py-2">
                                                <h5 class="form-control-label font-weight-bold">Sub Module : Assignments
                                                </h5>
                                                <button type="button" class="btn btn-success addComponent mt-2"
                                                    pid="{{ config('addPages.shortAssignment.id') }}"><i
                                                        class="fa fa-plus mx-2"></i>Add New</button>
                                            </div>
                                            <div class="accordion p-3 border rounded addParent_{{ config('addPages.shortAssignment.id') }}"
                                                id="assignmentAddParent">
                                                @foreach ($subModule->assignmentShort as $value)
                                                    @include('admin.components.shortAssignment', $value)
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="col-sm-12 addGrandParent" id="mcqQuestionForm" style="display:none " >
                                            <div class=" d-flex justify-content-between align-items-center py-2">
                                                <h5 class="form-control-label font-weight-bold">Sub Module : Assignments
                                                </h5>
                                                <button type="button" class="btn btn-success addComponent mt-2"
                                                    pid="{{ config('addPages.assignment.id') }}"><i
                                                        class="fa fa-plus mx-2"></i>Add New</button>
                                            </div>
                                            <div class="accordion p-3 border rounded addParent_{{ config('addPages.assignment.id') }}"
                                                id="assignmentAddParent">
                                                @foreach ($subModule->assignmentMcq as $value)
                                                    @include('admin.components.assignment', $value)
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="card-footer text-center">

                                            <button class="btn btn-primary py-2 px-4 submit" type="submit"
                                                style="display:none; " id="submitBtn">Submit</button>

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
    <script src="{{ asset('admin/assets/js/page/assignments.js') }}"></script>

    <script>
        $(document).on('click', '.deleteAccordion', function() {
            var accordionId = $(this).data('id');
            $('#assignment_' + accordionId).remove();
        });

        function getQuestionType(select) {
            var selectedValue = select.value;
            var shortForm = document.getElementById('shortQuestionForm');
            var mcqForm = document.getElementById('mcqQuestionForm');
            var submitBtn = document.getElementById('submitBtn');
            var questionType = document.getElementById('assignment_id');

            let checkShort = "{{ $subModule->assignmentShort }}";
            let checkMcq = "{{ $subModule->assignmentMcq }}";

            let isShortEmpty = checkShort === '' || checkShort === '[]';
            let isMcqEmpty = checkMcq === '' || checkMcq === '[]';

            shortForm.style.display = "none";
            mcqForm.style.display = "none";

            if (selectedValue == "{{ $questionTypes['short']['id'] }}") {
                shortForm.style.display = "block";
                questionType.value =selectedValue;
            } else if (selectedValue == "{{ $questionTypes['mcq']['id'] }}") {
                mcqForm.style.display = "block";
                questionType.value =selectedValue;
            }

            submitBtn.style.display = (!isShortEmpty || !isMcqEmpty) ? "block" : "none";
        }
    </script>
@endpush
