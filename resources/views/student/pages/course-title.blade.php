<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Additional resources</title>
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
          .item-btn {
               background-color: rgb(181, 47, 144);
               color: white;
          }
          .item-btn:hover {
               background-color: #40999d;
               color: white;
          }
          .para1 {
               color: #1d7c50;
          }
          .para1 .fa-check {
               font-size: 20px;
          }
     </style>
</head>
<body>
     <section class="certificate-header">
          <div class="container-fluid">
               <div class="container">
                    <div class="row">
                         <div class="col-md-12">
                              <p class="mb-0 py-3"><i class="fa-solid fa-house"></i> > <a href="#"> Home </a>> </i> <a href="#"> Module1 </a>> </i> <a href="#"> additional resources</a></p>
                         </div>
                    </div>
               </div>
          </div>
     </section>
     <section>
          <div class="container-fluid">
               <div class="container">
                    <div class="row">
                         <div class="col-md-12">
                              <h1><strong>{{ $courseData->material_name }}</strong></h1>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-12">
                              {{-- <h4 class="mt-4"><strong>Introduction</strong></h4> --}}
                              <p>{!! $courseData->reading_material !!}</P>
                              <div class="d-flex align-items-center mt-4">
                                   <a href="#" class="btn item-btn px-5 py-3 mr-4">Go to next item</a>
                                   <p class="mb-0 para1"><i class="fa-solid fa-check"></i> Completed</p>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </section>
<script type="text/javascript" src="https://demo.dashboardpack.com/architectui-html-free/assets/scripts/main.js"></script>
</body>
</html>
<!-- partial -->
<script src="{{asset('front/js/script.js')}}"></script>
</body>

</html>
