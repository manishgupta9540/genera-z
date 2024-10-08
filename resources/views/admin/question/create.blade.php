@extends('admin.master.index')

@section('title', 'Question Create')

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
            <div class="card-body">
                <h5 class="card-title"></h5>
                <form action="{{ route('question-quize-save')}}" method="POST" id="addQuestion" enctype="multipart/form-data">
                    @csrf
                    <label class="col-sm-12 col-form-label"><b>Add New Questions</b></label>
                    <input type="hidden" name="assign_id" value="{{ base64_encode($assignData->id) }}">
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Question Type</label>
                        <div class="col-sm-6">
                            <select class="form-select course form-control" id="course" name="question_type">
                                <option value="">Select option</option>
                                <option value="multiple_choice">Multiple Choice</option>
                                <option value="short_answer">Short Answer</option>
                            </select>
                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-course"></p>
                        </div>
                    </div>

                    <div id="multiple_choice_content" style="display: none;">
                        <!-- Content for Multiple Choice -->
                        <div class="questions-container">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3 justify-content-end">
                                        <label for="inputText" class="col-sm-2 col-form-label">Question</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="question_id1[]" class="form-control" value="0">
                                            <textarea class="summernote form-control question1" id="question_0" name="question1[]" class="form-control" placeholder="Enter Question" style="height: 100px;"></textarea>
                                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-question_0"></p>
                                        </div>
                                        <button type="button" class="btn btn-info add-area-btn1 mt-2 float-right" data-id="Aaddress" id="add1"><i class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="questions2">
                                        <div class="row mb-3">
                                            <label for="inputText" class="col-sm-2 col-form-label">Option A</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="option" name="option1[0][]" class="form-control" placeholder="Enter Option">
                                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-option"></p>
                                                <button type="button" data-id="0" class="btn btn-success add-option-btn mt-2"data-id="Aaddress" id="add2"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Answer</label>
                                        <div class="col-sm-8">
                                            <select class="form-select form-control" name="answer1[]" aria-label="Default select example">
                                                <option value="">Select Answer</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>
                                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-Answer"></p>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            
                    <div id="short_answer_content" style="display: none;">
                        <div class="questions-container4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <label for="inputText"
                                            class="col-sm-2 col-form-label">Question</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="question_id4[]" class="form-control" value="0">
                                            <textarea class="summernote form-control question4" id="question_0" name="question4[]" class="form-control" placeholder="Enter Question" style="height: 100px;"></textarea>
                                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-question"></p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Answer</label>
                                        <div class="col-sm-8">

                                            <textarea type="text" id="answer" name="answer4[]" class="form-control" placeholder="Enter answer"></textarea>
                                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-Answer"></p>
                                            <button type="button" class="btn btn-success add-area-btn1 mt-2" data-id="Aaddress" id="add4"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 text-center">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary submit mt-2" id="saveButton" style="display:none;">Save</button>
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

<script src="{{asset('admin/assets/bundles/summernote/summernote-bs4.js')}}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var courseSelect = document.getElementById('course');
            var saveButton = document.getElementById('saveButton');

            courseSelect.addEventListener('change', function() {
                if (this.value !== "") {
                    saveButton.style.display = 'block';
                } else {
                    saveButton.style.display = 'none';
                }
            });
        });

        $(document).ready(function() {
            $('#course').change(function() {
                var selectedOption = $(this).val();

                // Hide all content divs
                $('#multiple_choice_content, #short_answer_content')
                    .hide();

                // Show the selected content div based on the selected option
                $('#' + selectedOption + '_content').show();
             });

            var i = 0;
            $(document).on('click','#add1',function(){ 
                ++i;
                $(".questions-container").append(`
                    <div class="question-set">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <label for="question_${i}" class="col-sm-2 col-form-label">Question</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="question_id1[]" class="form-control" value="${i}">
                                        <textarea class="summernote form-control question1" id="question_${i}" name="question1[]" class="form-control" placeholder="Enter Question"></textarea>
                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-question_${i}"></p>
                                    </div>
                                </div>
                                <div class="questions2">
                                    <div class="row mb-3">
                                        <label for="option_${i}" class="col-sm-2 col-form-label">Option A</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="option_${i}" name="option1[${i}][]" class="form-control" placeholder="Enter Option">
                                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-option_${i}"></p>
                                            <button type="button" class="btn btn-success add-option-btn mt-2"  data-id="${i}"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Answer</label>
                                    <div class="col-sm-8">
                                        <select class="form-select form-control" name="answer1[]" aria-label="Default select example">
                                            <option selected="">Select Answer</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-Answer_${i}"></p>
                                        <button type="button" name="remove" class="btn btn-danger btn_remove mt-2"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`);

                $('.question1').summernote({
                    height: 200
                });
            });

            $(document).on('click', '.btn_remove', function() {
                $(this).closest('.question-set').remove();
            });

            $(document).on('click', '.add-option-btn', function() {
                var qid = $(this).attr('data-id');
                var $questionContainer = $(this).closest('.questions2'); // Get the specific question container
                var s_len = $questionContainer.find('.question-ans').length; 
                if(s_len + 1 > 3)
                {
                    swal({
                            title: "You Can Include Maximum 4 Answer !!",
                            text: '',
                            type: 'warning',
                            buttons: true,
                            dangerMode: true,
                            confirmButtonColor:'#003473'
                        });
                }
                else
                {
                    var i = s_len; 
                    var optionLabel = String.fromCharCode(66 + s_len); // 
                    $(this).closest('.questions2').append(`
                        <div class="question-ans">
                            <div class="row mb-3">
                                <label for="ans_${i}" class="col-sm-2 col-form-label">Option ${optionLabel}</label>
                                <div class="col-sm-4">
                                    <input type="text" id="option_${i}" name="option1[${qid}][]" class="form-control" placeholder="Enter Option">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-option_${i}"></p>
                                    <button type="button" name="remove" class="btn btn-danger btn_remove3 mt-2"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                        </div>`);
                    }
            });
           

            $(document).on('click', '.btn_remove3', function() {
                $(this).closest('.question-ans').remove();
            });


            $("#add-2").click(function() {
                ++i;
                $(".questions-container2").append(`
                    <div class="question-set2">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <label for="question_${i}" class="col-sm-2 col-form-label">Question</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="question_id2[]" class="form-control" value="${i}">
                                        <textarea class="form-control question2" id="question_${i}" name="question2[]" class="form-control" placeholder="Enter Question"></textarea>
                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-question_${i}"></p>
                                    </div>
                                </div>
                            <button type="button" name="remove" class="btn btn-danger btn_remove-2 mt-2"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    </div>`);

                $('.question2').summernote({
                    height: 200
                });

            });

            $(document).on('click', '.btn_remove-2', function() {
                $(this).closest('.question-set2').remove();
            });


            $("#add3").click(function() {
                ++i;
                $(".questions-container3").append(`
                    <div class="question-set3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <label for="question_${i}" class="col-sm-2 col-form-label">Question</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="question_id3[]" class="form-control" value="${i}">
                                        <textarea class="form-control question3"  id="question_${i}" name="question3[]" class="form-control" placeholder="Enter Question"></textarea >
                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-question_${i}"></p>
                                    </div>
                                </div>
                                <div class="questions3">
                                    <div class="row mb-3">
                                        <label for="option_${i}" class="col-sm-2 col-form-label">Option</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="option_${i}" name="option3_first[${i}][]" class="form-control" placeholder="Enter Option">
                                            <input type="text" id="option_${i}" name="option3_second[${i}][]" class="form-control" placeholder="Enter Option">
                                            <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-option_${i}"></p>
                                            <button type="button" class="btn btn-success add-option-btn-3 mt-2"  data-id="${i}"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>

                                        <button type="button" name="remove" class="btn btn-danger btn_remove3 mt-2"><i class="fa fa-minus"></i></button>
                                </div>
                        </div>
                    </div>`);
                $('.question3').summernote({
                    height: 200
                });
            });

            $(document).on('click', '.btn_remove3', function() {
                $(this).closest('.question-set3').remove();
            });

            $(document).on('click', '.add-option-btn-3', function() {
                var qid3 = $(this).attr('data-id');
                ++i;
                var optionLabel = String.fromCharCode(65 + i);
                $(this).closest('.questions3').append(`
                    <div class="question-ans3">
                        <div class="row mb-3">
                            <label for="ans_${i}" class="col-sm-2 col-form-label">Option ${optionLabel}</label>
                            <div class="col-sm-4">
                                 <input type="text" id="option_${i}" name="option3_first[${qid3}][]" class="form-control" placeholder="Enter Option">
                                <input type="text" id="option_${i}" name="option3_second[${qid3}][]" class="form-control" placeholder="Enter Option">
                                    <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-option_${i}"></p>
                                <button type="button" name="remove" class="btn btn-danger btn_remove-3 mt-2"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                    </div>`);

            });

            $(document).on('click', '.btn_remove-3', function() {
                $(this).closest('.question-ans3').remove();
            });
            $("#add4").click(function() {
                ++i;
                $(".questions-container4").append(`
                    <div class="question-set4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <label for="question_${i}" class="col-sm-2 col-form-label">Question</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="question_id4[]" class="form-control" value="${i}">
                                        <textarea class="form-control question4" id="question_${i}" name="question4[]" class="form-control" placeholder="Enter Question"></textarea>
                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-question_${i}"></p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Answer</label>
                                    <div class="col-sm-8">
                                        <textarea type="text" id="answer" name="answer4[]"
                                        class="form-control" placeholder="Enter answer"></textarea>
                                        <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-Answer_${i}"></p>
                                        <button type="button" name="remove" class="btn btn-danger btn_remove-4 mt-2"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`);
                $('.question4').summernote({
                    height: 200
                });
            });

            $(document).on('click', '.btn_remove-4', function() {
                $(this).closest('.question-set4').remove();
            });

            $(document).on('submit', 'form#addQuestion', function(event) {
                event.preventDefault();
                $('p.error_container').html("");

                var form = $(this);
                var data = new FormData($(this)[0]);
                var url = form.attr("action");
                var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';

                $('.submit').attr('disabled', true).html(loadingText);
                $('.form-control').attr('readonly', true).addClass('disabled-link');

                $.ajax({
                    type: form.attr('method'),
                    url: url,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success("Question Saved successfully!");
                            setTimeout(() => {
                                window.location.href = "{{ url('/') }}" + "/question-list";
                            }, 2000);
                        } else {
                            $('.submit').attr('disabled', false).html('Save');
                            $('.form-control').attr('readonly', false).removeClass(
                                'disabled-link');
                            for (var control in response.errors) {
                                var error_text = control.replace('.', "_");
                                $('#error-' + error_text).html(response.errors[control]);
                            }
                        }
                    },
                    error: function(response) {
                        console.log(response);
                    }
                });
            });
        });

        $(document).ready(function() {
            $('.question1').summernote({
                height: 200
            });
            $('.question2').summernote({
                height: 200
            });
            $('.question3').summernote({
                height: 200

            });
            $('.question4').summernote({
                height: 200
            });
        });
    </script>
@endpush

