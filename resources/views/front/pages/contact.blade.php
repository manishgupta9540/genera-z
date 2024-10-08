@extends('front.master')

@section('title', 'Contact')

@section('content')

<section class="contact-area" style="padding-top:150px">
    <div class="container">
        <div class="contact-form" style="padding-top:0">
            <div class="row justify-content-center lineTitle">
                <div class="col-lg-12">
                    <div class="contact-title text-center">
                        <h3 class="title">Leave a Message <br /> <span style="color: rgb(181,47,144)"> Here </span></h3>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="contact-form-wrapper">
                        <div id="success-contact-form" class="mx-0 col-12" style="font-size:20px;display:none;text-align:center; padding:10px;"></div>
                        <div id="error-contact-form" class="mx-0 col-12" style="font-size:20px;display:none;text-align:center; padding:10px;"></div>
                        <form action="{{ route('enquirysave')}}" method="post" id="contactfrm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="single-form">
                                        <input type="text" id="name" name="name" placeholder="Name">
                                        {{-- <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-name"></p> --}}
                                        <p id="name_error" class="text-danger error-p"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-form">
                                        <input type="email" id="email" name="email" placeholder="E-mail" style="font-family:Arial;">
                                        {{-- <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-email"></p> --}}
                                        <p id="email_error" class="text-danger error-p"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-form">
                                        <input type="text" id="phone" name="phone" placeholder="Phone" style="font-family:Arial;">
                                        {{-- <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-phone"></p> --}}
                                        <p id="phone_error" class="text-danger error-p"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="single-form">
                                        <input type="text" id="subject" name="subject" placeholder="Subject">
                                        {{-- <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-subject"></p> --}}
                                        <p id="subject_error" class="text-danger error-p"></p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="single-form">
                                        <textarea id="message" name="message" placeholder="Message"></textarea>
                                        {{-- <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-message"></p> --}}
                                        <p id="message_error" class="text-danger error-p"></p>
                                    </div>
                                </div>
                                <p class="form-message"></p>
                                <div class="col-md-12">
                                    <div class="single-form text-center">
                                        <button id="project-contact-us-button" type="submit" class="main-btn submit">Submit Now</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-contact-info mt-50">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <h5 class="title">Address</h5>
                            <p>Meydan Free Zone <span style='font-family: Arial'>-</span> Dubai, UAE</p>
                        </div>
                    </div>
                    <div class="single-contact-info mt-50">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-content">
                            <h5 class="title">Phone</h5>
                            <p><a href="tel:00971 52 731 0199"><span style='font-family: Arial'>+</span>971 52 731 0199 </a></p>
                        </div>
                    </div>
                    <div class="single-contact-info mt-50">
                        <div class="info-icon">
                            <i class="fa fa-globe"></i>
                        </div>
                        <div class="info-content">
                            <h5 class="title">E-mail</h5>
                            <p><a href="mailto:info&lt;span style=&#39;font-family: Arial&#39;&gt;@&lt;/span&gt;generationz.education)">info<span style='font-family: Arial'>@</span>generationz.education</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@push('custom-scripts')
    <script>
            // $(document).on('submit', 'form#contactfrm', function (event) {
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
            //                     toastr.success("Contact form submit Successfully");
            //                     window.setTimeout(function() {
            //                         window.location.href = "{{URL::to('contact')}}"
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
