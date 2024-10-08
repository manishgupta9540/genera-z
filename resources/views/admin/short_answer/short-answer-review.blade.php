@extends('admin.master.index')

@section('title', 'Skill Create')
<style>
    .form-question {
        font-size: 20px !important;
        font-weight: 600;
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
                                <h4> {{ $assignamet_name }} </h4>
                            </div>
                            <form action="{{ route('short-answer-store') }}" method="post" id="createskillFrm"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="short_id" value="{{ $short_id }}">
                                <div class="card-body py-0 pt-4">
                                    @foreach ($answers as $key => $answer)
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group mb-0 form-question">
                                                    {{ $key + 1 }}. <label for="role"
                                                        class="form-control-label form-question mb-0 font-weight-300">{!! $answer['question'] !!}</label>
                                                </div>
                                                @if(!empty($answer['image']))
                                                <img src="{{ asset('uploads/questionImages/'.$answer['image'])}}" style="width: 710px; height:175px;">
                                                @endif
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="role"
                                                        class="form-control-label font-weight-300">Answer</label>
                                                    <div>{!! $answer['answer'] !!}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($status == 0)
                                    <div class="px-4">
                                        <input type="radio" name="check" value="1" required>
                                        <label>Pass</label>
                                        <input type="radio" name="check" value="2" required>
                                        <label class="ml-2">Fail</label>
                                    </div>
                                    <div class="card-footer text-left">
                                        <button class="btn btn-primary px-4 py-2 submit" type="submit">Submit</button>
                                    </div>
                                @endif

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
        // $(document).on('submit', 'form#createskillFrm', function (event) {
        //     event.preventDefault();
        //     //clearing the error msg
        //     $('p.error_container').html("");

        //     var form = $(this);
        //     var data = new FormData($(this)[0]);
        //     var url = form.attr("action");
        //     var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
        //     $('.submit').attr('disabled',true);
        //     $('.form-control').attr('readonly',true);
        //     $('.form-control').addClass('disabled-link');
        //     $('.error-control').addClass('disabled-link');
        //     if ($('.submit').html() !== loadingText) {
        //         $('.submit').html(loadingText);
        //     }
        //         $.ajax({
        //             type: form.attr('method'),
        //             url: url,
        //             data: data,
        //             cache: false,
        //             contentType: false,
        //             processData: false,
        //             success: function (response) {
        //                 window.setTimeout(function(){
        //                     $('.submit').attr('disabled',false);
        //                     $('.form-control').attr('readonly',false);
        //                     $('.form-control').removeClass('disabled-link');
        //                     $('.error-control').removeClass('disabled-link');
        //                     $('.submit').html('Submit');
        //                 },2000);
        //                 console.log(response);
        //                 if(response.success==true) {
        //                     toastr.success("Skills Creted Successfully");
        //                     window.setTimeout(function() {
        //                         window.location.href = "{{ URL::to('skills-list') }}"
        //                     }, 2000);
        //                 }
        //                 //show the form validates error
        //                 if(response.success==false ) {
        //                     for (control in response.errors) {
        //                     var error_text = control.replace('.',"_");
        //                     $('#error-'+error_text).html(response.errors[control]);
        //                     // $('#error-'+error_text).html(response.errors[error_text][0]);
        //                     // console.log('#error-'+error_text);
        //                     }
        //                     // console.log(response.errors);
        //                 }
        //             },
        //             error: function (response) {
        //                 // alert("Error: " + errorThrown);
        //                 console.log(response);
        //             }
        //         });
        //         event.stopImmediatePropagation();
        //         return false;
        // });
    </script>
@endpush
