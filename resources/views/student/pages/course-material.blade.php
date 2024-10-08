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
          .box1 {
               position: relative;
               top: 180px;
               color: white;
               z-index: 99;
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
               <div class="container mt-5">
                    <div class="row">
                         <div class="col-md-12 justify-content-center" id="videoContainer">
                              <video id="myVideo" width="100%" height="240" controls>
                                  <source src="{{ asset('uploads/materialVideo/' . $material->content) }}" type="video/mp4">
                                  Your browser does not support the video tag.
                              </video>
                              <h1><strong>{{ $material->name ?? "" }}</strong></h1>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
     $(document).ready(function() {
        var video = document.getElementById('myVideo');
        
        video.onended = function() {
            var htmlContent = `
            <div class="col-md-12 mt-4">
                <div class="box1 d-flex justify-content-center">
                    <p class="mr-2"><i class="fa-solid fa-book-open rounded-circle"></i></p>
                    <div>
                        <p class="mb-1">Up Next</p>
                        <h5>Generative AI Technology</h5>
                        <p class="mb-1">10 min</p>
                        <p class="mb-1">Start in 5 second</p>
                        <p class="mb-1"><a href="#" class="text-decoration-none text-white">Start</a> <a href="#" class="text-decoration-none text-white">Cancel</a></p>
                    </div>
                </div>
            </div>`;
            $('#videoContainer').prepend(htmlContent);
        };
    });
</script>

</body>

</html>