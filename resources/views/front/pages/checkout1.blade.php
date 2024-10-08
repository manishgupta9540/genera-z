<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="{{asset('front/style.css')}}">
</head>
<body>
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
            
            .nav-tabs .nav-link {
                background-color: white;
                color: #40999d;
                border: 1px solid #40999d;
            }
            .btn-bg {
                background-color: #40999d;
                color: white;
            }
        </style>

        <!-- sweet alert link -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css" rel="stylesheet"/>

      <!-- toaster link -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    </head>

    <body>
    <section>
     <div class="container-fluid">
          <div class="container">
               <div class="row mt-4">
                    <div class="col-md-12">
                         <div class="d-flex justify-content-between border-bottom pb-2 align-items-center">
                              <h5 class="mb-0"><b>Checkout</b></h5>
                              <div class="d-flex align-items-center">
                                   <i class="fa-solid fa-cart-shopping mr-3"></i>
                                   <div class="dropdown">
                                        <a href="#" class="dropdown-toggle rounded-circle py-3" data-toggle="dropdown"><img src="{{asset('front/img/profile.png')}}" alt=""></a>
                                        <div class="dropdown-menu">
                                          <a class="dropdown-item" href="#">My Learning</a>
                                          <a class="dropdown-item" href="#">My Purchases</a>
                                          <a class="dropdown-item" href="#">My Accomplishments</a>
                                          <a class="dropdown-item" href="{{ route('logout')}}">Logout</a>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>

               <form action="{{ route('checkout-save')}}" method="post" id="checkoutfrm">
                    @csrf
                    <div class="row mt-5">
                         <div class="col-md-8">
                              <div class="box11 mt-5">
                                   <div class="row mt-5">
                                        <div class="col-md-12">
                                             <div class="box22 px-5 w-75 mx-auto">
                                                  <p>By continuing to payment, I agree to the <a href="#">Terms of Use</a>, <a href="#">Refund Policy</a>, and <a href="#">Privacy Policy</a>.</p>
                                                  <button type="submit" class="btn btn-bg px-5 py-3 submit">Continue to payment</button>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    
                         <div class="col-md-4">
                              <div class="box bg-white shadow rounded p-4">
                              @if (count($plan_data) > 0)
                                   @php
                                        $totalPrice = 0; // Initialize total price
                                   @endphp
                              
                              @foreach ($plan_data as $item)
                                   <div class="border-bottom pb-4">
                                   <div class="row">
                                        <input type="hidden" name="course_id[]" value="{{ $item->course_id }}">
                                        <input type="hidden" name="price" value="{{ $item->pricing }}">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? ""}}">
                                        @php
                                             $courseId = $item->course_id;
                                             $course = DB::table('courses')->where('id',$courseId)->first();
                                        @endphp
                                        

                                        <div class="col-md-4">
                                             <img src="{{asset('uploads/course/'.$course->image)}}" class="w-100">
                                        </div>
                                        <div class="col-md-8">
                                             <h6>{{ $course->course_title ?? ""}}</h6>
                                             <a href="#" class="remove_cart" data-id="{{ base64_encode($item->id) }}">Remove from cart</a>
                                        </div>
                                   </div>
                                   </div>  
                                   <div class="row mt-4">
                                   @if (!empty($item->subscription_plan))
                                        <div class="col-md-12">
                                             <div class="d-flex justify-content-between">
                                                  <p>{{ $item->subscription_plan }} of Access:</p>
                                                  <p>₹ {{ $item->pricing }}</p>
                                             </div>
                                        </div>
                                   @else
                                        <div class="col-md-12">
                                             <div class="d-flex justify-content-between">
                                                  {{-- <p>No subscription plan available</p> --}}
                                                  <p style="padding-left: 242px;">₹ {{ $item->pricing }}</p>
                                             </div>
                                        </div>
                                   @endif
                                   <div class="col-md-12">
                                        <div class="d-flex justify-content-between">
                                             <p><b>Total:</b></p>
                                             <p><b>₹ {{ $item->pricing }}</b></p>
                                        </div>
                                   </div>
                                   </div>
                              
                                   @php
                                   $totalPrice += $item->pricing; // Accumulate total price
                                   @endphp
                              @endforeach
                              <input type="hidden" name="total_pricing" value="{{ $totalPrice }}">
                              <hr>
                              <b>Total Price : </b><p style="padding-left: 242px; margin-top: -20px;"> ₹ {{ $totalPrice }}</p>
                              
                              @else
                                   <h3>Your Cart is Empty</h3>
                              @endif
                                   
                              </div>
                         </div>
                    </div>
               </form>
          </div>
     </div>
    </section>
    <script type="text/javascript" src="https://demo.dashboardpack.com/architectui-html-free/assets/scripts/main.js"></script>
    </body>
    </html>
    <!-- partial -->
    <script src="{{asset('front/js/script.js')}}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

     <!--toaster js -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    
     <!-- sweet alert -->
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>

    <script>
          $(document).ready(function(){
          // delete button 
               $(document).on('click', '.remove_cart', function() {
                    var _this = $(this);
                    var id = $(this).data('id');
                    
                    var table = 'plan_purchases';
                    swal({
                              // icon: "warning",
                              type: "warning",
                              title: "Are You Sure You Want to Delete Cart?",
                              text: "",
                              dangerMode: true,
                              showCancelButton: true,
                              confirmButtonColor: "#007358",
                              confirmButtonText: "YES",
                              cancelButtonText: "CANCEL",
                              closeOnConfirm: false,
                              closeOnCancel: false
                         },
                         function(e) {
                              if (e == true) {
                              _this.addClass('disabled-link');
                              $.ajax({
                                   type: "POST",
                                   dataType: "json",
                                   url: "{{ route('remove_plan_purchase') }}",
                                   data: {
                                        "_token": "{{ csrf_token() }}",
                                        'id': id,
                                        'table_name': table
                                   },
                                   success: function(response) {
                                        console.log(response);
                                        window.setTimeout(function() {
                                             _this.removeClass('disabled-link');
                                        }, 2000);

                                        if (response.success==true ) {
                                             toastr.success("Subscription Plan Deleted Successfully");
                                             window.setTimeout(function() {
                                                  window.location.href = "{{URL::to('checkout')}}"
                                             }, 2000);
                                        }
                                   },
                                   error: function(response) {
                                        console.log(response);
                                   }
                              });
                              swal.close();
                              } else {
                              swal.close();
                              }
                         }
                    );
               });

          // checkout plan purchase
               $(document).on('submit', 'form#checkoutfrm', function(event) {
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
                              $('.submit').html('Proceed to Buy');
                              }, 2000);
                              console.log(response);
                         
                              if (response.success == true) {
                                   var ids = btoa(response.ids); 
                                   console.log(ids)
                                   window.setTimeout(function() {
                                        window.location.href = "{{ URL::to('stripe_payment') }}/" + ids;
                                   }, 2000);
                              }

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