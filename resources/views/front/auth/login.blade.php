<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign In</title>
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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />

        <!-- sweet alert link -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>

        <!-- toaster link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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

            span.show-hide-password {
                position: absolute;
                top: 240px;
                right: 10%;
                font-size: 19px;
                color: #748a9c;
                cursor: pointer;
                z-index: 6;
            }
        </style>
    </head>

    <body>
       <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="box">
                        <h4 class="mb-4"><b>Sign-in to the Generation Z</b></h4>
                    <form action="{{ route('user_login') }}" method="post" id="loginFrm" class="login-form">
                        @csrf
                        <div class="form-group mt-2">
                          <label for="email">Your Email</label>
                          <input type="email" class="form-control" name="email" placeholder="Enter Your Email" id="email">
                          <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-email"></p>
                        </div>
                        <div class="form-group mt-2">
                          <label for="pwd">Your Password</label>
                          <input type="password" name="password" class="form-control"id="pwd">
                          <span class="show-hide-password js-show-hide has-show-hide"><i class="bi bi-eye-slash"></i></span>
                          <p style="margin-bottom: 2px;" class="text-danger error_container" id="error-password"></p>
                        </div>
                        <span style="" class="text-left text-danger error_container" id="wrong-credential"> </span>
                        <div class="form-group form-check mt-2 d-flex justify-content-between">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"> Remember me
                          </label>
                          <div>
                            {{-- <a href="#">Forgot Password?</a> --}}
                          </div>
                        </div>
                        <button type="submit" class="btn btn-bg py-3 w-100">Submit</button>
                        <div class="mt-4 text-center">
                            <p>Don't have an account? <a href="{{route('register')}}">Sign Up</a></p>
                        </div>
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
    <script src="{{asset('frontjs/script.js')}}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!--toaster js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- sweet alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>

    <script>
         $(document).ready(function() {
            //user login
            $(document).on('submit', 'form#loginFrm', function(event) {
                event.preventDefault();
                //clearing the error msg
                $("#wrong-credential").html("");
                $('p.error_container').html("");

                var form = $(this);
                var data = new FormData($(this)[0]);
                var url = form.attr("action");
                var loadingText = '<i class="fa fa-circle-o-notch fa-spin"></i> loading...';
                $('.login_submit').attr('disabled', true);
                $('.form-control').attr('readonly', true);
                $('.form-control').addClass('disabled-link');
                $('.error-control').addClass('disabled-link');
                if ($('.login_submit').html() !== loadingText) {
                    $('.login_submit').html(loadingText);
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
                            $('.login_submit').attr('disabled', false);
                            $('.form-control').attr('readonly', false);
                            $('.form-control').removeClass('disabled-link');
                            $('.error-control').removeClass('disabled-link');
                            $('.login_submit').html('Login');
                        }, 2000);
                        console.log(response);
                        if (response.success == true) {
                            toastr.success("You have Login Successfully");
                            window.setTimeout(function() {
                                window.location.href = "{{URL::to('student/dashboard')}}";

                            }, 2000);
                        }
                        //show the form validates error
                        if(response.success==false  ) {
                            if (response.error_type == 'validation') {
                                for (control in response.errors) {
                                    var error_text = control.replace('.', "_");
                                    $('#error-' + error_text).html(response.errors[control]);
                                }
                                return false;
                            }

                            if( response.error_type == 'wrong_email_or_password' ){
                                console.log(response);
                                $("#wrong-credential").html("");
                                $("#wrong-credential").html("Enter a valid email or password!");
                                return false;
                            }
                            if( response.error_type == 'account_deactivated' ){
                                toastr.error("Your Account is Deactivated Please Contact Admin!");
                                return false;
                            }
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


            //password hide and show
            $(document).on('click','.js-show-hide',function (e) {
                e.preventDefault();
                var _this = $(this);

                if (_this.hasClass('has-show-hide'))
                {
                    _this.parent().find('input').attr('type','text');
                    _this.html('<i class="fa fa-eye" aria-hidden="true"></i>');
                    _this.removeClass('has-show-hide');
                }
                else
                {
                    _this.addClass('has-show-hide');
                    _this.parent().find('input').attr('type','password');
                    _this.html('<i class="bi bi-eye-slash"></i>');
                }
            });

         });
    </script>
</body>

</html>
