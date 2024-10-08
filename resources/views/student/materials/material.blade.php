<!DOCTYPE html>
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
    <link href="{{ asset('student/css/material.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
          video{
               width: 95%;
          }
    </style>
</head>

<body>
     <section class="certificate-header">
          <div class="container-fluid">
               <div class="container">
                    <div class="row">
                         <div class="col-md-12">
                              <p class="mb-0 py-3">
                                   <i class="fa-solid fa-house text-primary"></i>
                                   >
                                   <a href="{{ route('home') }}"> Home </a>
                                   >
                                   <a href="{{ route('student.course.show', urlencode(base64_encode($material->sub_module->module->course->id))) }}">
                                        {{ $material->sub_module->module->course->title }} </a>
                                   >
                                   <a href="{{ route('student.material.show', urlencode(base64_encode($material->id))) }}">{{ $material->name }}</a>
                              </p>
                         </div>
                    </div>
               </div>
          </div>
     </section>
     <section class="pb-4">
          <div class="container-fluid">
               <div class="container">
                    <div class="row">
                         <div class="col-md-12">
                         <h1><strong>Reading resource: {{ $material->name }}</strong></h1>
                         </div>
                    </div>
                    <div class="row">
                         <div class="col-md-12">
                              @if ($material->reading==1)
                                  {!! $material->content !!}
                              @elseif ( $material->reading == 2)
                                  <div class="iframe-container" style="width: 100%; overflow: hidden; padding-top: 56.25%;">
                                      <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode(asset('uploads/PPT/'.$material->ppt)) }}"
                                              width="100%" height="100%" frameborder="0" style="position: absolute; top: 0; left: 0;">
                                      </iframe>
                                  </div>
                              @else
                                  <video id="myVideo" controls controlsList="nodownload" style="width: 100%; height: auto;">
                                      <source src="{{ asset('uploads/materialVideo/'.$material->content) }}" type="video/mp4">
                                      Your browser does not support the video playback.
                                  </video>
                              @endif
                          </div>
                    </div>
                    <div class="d-flex align-items-center mt-4">
                         @php
                              $userMaterial = $auth->userMaterials->where('material_id', $material->id)->first();
                         @endphp
                         @if ($userMaterial and $userMaterial->completed)
                              @php
                                   $next = $material->sub_module->materials->where('id', '>', $material->id)->first();
                                   $ass = $material->sub_module->assignments->whereNotIn('id',$auth->userAssignments->pluck('assignment_id'))->first();

                                   $questionCheck = DB::table('questions')
                                                    ->where('assignment_id', $ass->id)
                                                    ->exists();
                                                    //dd($questionCheck);
                              @endphp
                                   <p class="mb-0 px-4 para1"><i class="fa-solid fa-check"></i> Completed</p>
                                @if ($next)
                                   <a href="{{ route('student.material.show',urlencode(base64_encode($next->id))) }}" class="btn item-btn px-5 py-3 mr-4">Go to next
                                        item</a>
                                @elseif ($ass)
                                    @if ($questionCheck)
                                        <a href="{{ route('student.assignment.show',urlencode(base64_encode($ass->id))) }}" class="btn item-btn px-5 py-3 mr-4">Go to next
                                            item</a>
                                    @else
                                        <a href="{{ route('student.course.show', urlencode(base64_encode($material->sub_module->module->course->id))) }}" class="btn item-btn px-5 py-3 mr-4">
                                            Go to next item </a>
                                    @endif

                                @else
                                    <a href="{{ route('student.course.show', urlencode(base64_encode($material->sub_module->module->course->id))) }}" class="btn item-btn px-5 py-3 mr-4">
                                        Go to next item </a>
                              @endif
                         @else
                              <form action="{{ route('student.material.markAsCompleted', urlencode(base64_encode($material->id))) }}" id="markAsCompleted" method="post">
                                   @csrf
                                   @if ($material && $material->reading && !$material->is_completed)
                                        <button type="submit" id="markAsCompletedBtn"
                                            href="{{ route('student.material.markAsCompleted', urlencode(base64_encode($material->id))) }}"
                                            class="btn item-btn px-5 py-3 mr-4">
                                            Mark As Completed
                                        </button>
                                    @endif
                              </form>
                         @endif
                    </div>


               </div>
          </div>
     </section>

     <section id="responseSection">

     </section>
    <script type="text/javascript" src="https://demo.dashboardpack.com/architectui-html-free/assets/scripts/main.js">
    </script>

    <!-- partial -->
    <script src="{{ asset('student/js/material.js') }}"></script>
</body>

</html>
