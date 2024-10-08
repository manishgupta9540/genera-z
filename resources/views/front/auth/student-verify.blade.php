<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verify Email</title>
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
        </style>
    </head>

    <body>
       <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="box text-center">
                        <img src="{{asset('front/img/verify.png')}}" alt="">
                        <h4 class="my-4"><b>Verify Your Email</b></h4>
                        <p class="mb-0">Your account has been succesfully created. Please check your email and click on the verification button to verify your email address</p>
                        <p class="my-5"><b>Didn't receive an email in inbox?</b></p>
                        <button class="btn btn-bg px-5 py-3 mb-4">Resend Email</button>
                        <p class="mb-0"><b>Note :</b> Please find your spam folder if you do not receive a verification email to your inbox.</p>
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
</body>

</html>