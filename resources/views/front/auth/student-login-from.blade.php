<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Register</title>
    <link rel="stylesheet" href="{{asset('front/style.css')}}">

</head>

<body>
    <!-- partial:index.partial.html -->
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Language" content="en">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Generation Z</title>
        <meta name="viewport"
            content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
        <meta name="description" content="This is an example dashboard created using build-in elements and components.">
        <meta name="msapplication-tap-highlight" content="no">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
            integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="style.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

        <!-- sweet alert link -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>

        <!-- toaster link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

        <style>
            .course-h {
                color: #b4379194;
            }
            .nav-tabs {
                border-bottom: none;
            }
            .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
                color: white;
                background-color: #40999d;
                border: 1px solid #40999d;
            }
            .nav-tabs .nav-link {
                background-color: white;
                color: #40999d;
                border: 1px solid #40999d;
            }
            .btn-bg {
                background-color: #40999d;
                color: white;
            }
            .box {
                border-radius: 6px;
                box-shadow: 0px 0px 10px 0px lightgrey;
                padding: 50px;
            }
            .box img {
                border-radius: 6px;
            }
            .login-form .form-control {
                height: 50px;
            }
            .form-checks {
                width: 50px;
                height: 50px;
                position: relative;
                top: -15px;
                margin-right: 10px;
            }
            .genders {
                border: 1px solid #ced4da;
                border-radius: .25rem;
                height: 50px;
            }
            select {
                font-size: 1rem;
                font-weight: 400;
                color: #495057;
                padding: 0 8px;
            }

            /* .intl-tel-input{width:100%;}
            .select2-container .select2-selection--single .select2-selection__rendered {
                display: block;
                padding-left: 8px;
                padding-right: 200px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            } */
            .select2-selection--single {
                border: 1px solid #ced4da !important;
                border-radius: .25rem;
                height: 50px !important;
            }
            .select2-selection__rendered {
                padding-top: 10px !important;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 26px;
                position: absolute;
                top: 10px !important;
                right: 1px;
                width: 20px;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: #495057cf !important;
                line-height: 28px;
            }
        </style>

    </head>

    <body>
       <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="box">
                        <h4 class="mb-4"><b>Student Registration Form</b></h4>

                    <form action="{{ route('student-authenticate')}}" method="post" class="login-form" id="studentReg" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                              <div class="form-group mt-2 col-md-6">
                                    <input type="hidden" name="id" value="{{ $users->id }}" id="">
                                   <label for="fname">First Name *</label>
                                   <input type="text" name="name" value="{{ $users->name }}" class="form-control"id="fname" placeholder="Enter First Name">
                                   <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-name"></p>
                              </div>
                              <div class="form-group mt-2 col-md-6">
                                   <label for="lname">Last Name *</label>
                                   <input type="text" class="form-control" name="last_name" value="{{ $users->last_name }}" id="lname" placeholder="Enter Last Name">
                                   <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-last_name"></p>
                              </div>
                        </div>
                        <div class="row">
                             <div class="form-group mt-2 col-md-12">
                                  <label for="email">Your Email *</label>
                                  <input type="email" class="form-control" name="email" value="{{ $users->email}}" placeholder="Enter Your Email" id="email">
                                  <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-email"></p>
                             </div>
                        </div>
                        <div class="row">
                            <div class="form-group mt-2 col-md-12 d-flex justify-content-between">
                                 <input type="checkbox" class="form-control form-checks me-2" id="checkboxs">
                                 <label for="checkboxs">By checking the box below and providing your phone number, you consent to
                                    receiving text messages from Intercambio Uniting Communities. Message and data
                                    rates may apply. You should anticipate receiving 1-2 texts weekly, and you
                                    retain the ability to opt-out at any time by texting the word STOP. View our <a href="#">Privacy Policy</a></label>
                            </div>
                        </div>

                        <div class="row">
                              <div class="form-group mt-2 col-md-6">
                                   <label for="phones">Mobile Phone *</label>
                                   <input type="tel" class="form-control" name="phone_number" id="phones" placeholder="Enter Mobile Phone">
                                   <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-phone_number"></p>
                              </div>
                              <div class="form-group mt-2 col-md-6">
                                <label for="phones">Image*</label>
                                <input type="file" class="form-control" name="image" id="phones" placeholder="Enter your image">
                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-image"></p>
                           </div>
                        </div>

                        <div class="row">
                            <div class="form-group mt-2 col-md-6">
                                <label for="dates">Birthdate *</label>
                                <input type="date" class="form-control" name="dob" id="dates" placeholder="*****">
                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-dob"></p>
                           </div>
                           <div class="form-group mt-2 col-md-6">
                                <label for="genders">Gender *</label><br>
                                <select name="genders" id="genders" class="genders w-100 gender">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-genders"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mt-2 col-md-12">
                                 <label for="saddress">Street Address *</label>
                                 <input type="saddress" class="form-control" name="address" id="saddress" placeholder="Enter Street Address">
                                 <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-address"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mt-2 col-md-6">
                                <label for="citys">City *</label>
                                <input type="text" class="form-control" name="city" id="citys" placeholder="Enter City">
                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-city"></p>
                           </div>
                           <div class="form-group mt-2 col-md-6">
                                <label for="states">State *</label><br>
                                <select name="states_id" id="states" class="genders states w-100">
                                    <option value="">Select State</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name}}</option>
                                    @endforeach
                                </select>
                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-states_id"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mt-2 col-md-12">
                                <label for="zips">Zip Code *</label>
                                <input type="text" class="form-control" name="zip_code" id="zips" placeholder="Enter Zip Code">
                                <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-zip_code"></p>
                           </div>
                        </div>

                        <div class="row">
                            <div class="form-group mt-2 col-md-12">
                                 <label for="about">How did you hear about Generation Z? *</label>
                                 <select name="about_generation" id="about" class="genders w-100 about">
                                    <option value="">Select</option>
                                    <option value="friend">Friend/Family</option>
                                    <option value="facebook">Facebook/Social Media</option>
                                    <option value="event">Community Event</option>
                                    <option value="others">Others</option>
                                 </select>
                                 <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-about_generation"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mt-2 col-md-12">
                                 <label for="flang">What is your first language? *</label>
                                 <select name="language" id="flang" class="genders w-100 lng">
                                    <option value="">Select</option>
                                    <option value="english">English</option>
                                    <option value="hindi">Hindi</option>

                                 </select>
                                 <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-language"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group mt-2 col-md-12">
                                 <label for="corigin">Country of Origin *</label>
                                 <select name="country_id" id="corigin" class="genders w-100 country">
                                    <option value="">Select</option>
                                    @foreach ($countries as $countrie)
                                        <option value="{{ $countrie->id}}">{{ $countrie->name}}</option>
                                    @endforeach
                                 </select>
                                 <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-country_id"></p>
                            </div>
                        </div>
                              <button type="submit" class="btn btn-bg py-3 w-100 mt-2">Next</button>
                        <!-- <div class="mt-4 text-center">
                              <p>Don't have an account? <a href="#">Sign Ip</a></p>
                        </div> -->
                      </form>
                    </div>
                </div>
            </div>
       </div>
        <script type="text/javascript"
            src="https://demo.dashboardpack.com/architectui-html-free/assets/scripts/main.js"></script>
    </body>

    </html>
    <!-- partial -->
    <script src="{{asset('front/js/script.js')}}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <!--toaster js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".states").select2();
            $(".gender").select2();
            $(".about").select2();
            $(".lng").select2();
            $(".country").select2();
            //user register
            $(document).on('submit', 'form#studentReg', function(event) {
                event.preventDefault();
                //clearing the error msg
                $('p.error_container').html("");

                var form = $(this);
                var data = new FormData($(this)[0]);
                var url = form.attr("action");
                var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
                $('.submit').attr('disabled', true);
                $('.form-control').attr('readonly', true);
                $('.form-control').addClass('disabled-link');
                $('.error-control').addClass('disabled-link');
                if ($('.submit').html() !== loadingText) {
                    $('.submit').html(loadingText);
                }
                $.ajax({
                    type: form.attr('method'),
                    url: url,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        window.setTimeout(function() {
                            $('.submit').attr('disabled', false);
                            $('.form-control').attr('readonly', false);
                            $('.form-control').removeClass('disabled-link');
                            $('.error-control').removeClass('disabled-link');
                            $('.submit').html('To Register');
                        }, 2000);
                        console.log(response);
                        if (response.success == true) {
                            toastr.success("User Registered Successfully");
                            window.setTimeout(function() {
                                window.location.href = "{{URL::to('student/dashboard')}}"
                            }, 2000);
                        }

                        // if (response.success1 == false) {
                        //     $('#user_allready').html('Email id has already been taken');
                        //     // console.log(response.errors);
                        // }
                        //show the form validates error
                        if (response.success == false) {
                            //$('#user_allready').html('Email id has already been taken');
                            for (control in response.errors) {
                                var error_text = control.replace('.', "_");
                                $('#error-' + error_text).html(response.errors[control]);
                                // $('#error-'+error_text).html(response.errors[error_text][0]);
                                // console.log('#error-'+error_text);
                            }
                            // console.log(response.errors);
                        }
                    },
                    error: function(response) {
                        // alert("Error: " + errorThrown);
                        console.log(response);
                    }
                });
                event.stopImmediatePropagation();
                return false;
            });

        });
    </script>
</body>

</html>
