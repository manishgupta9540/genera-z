<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Additional resources</title>
    <link rel="stylesheet" href="{{ asset('front/style.css') }}">
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
            .start-btn {
                background-color: rgb(181, 47, 144);
                color: white;
            }

            .start-btn:hover {
                background-color: #40999d;
                color: white;
            }

            .para1 {
                color: #1d7c50;
            }

            .para1 .fa-check {
                font-size: 20px;
            }

            .box {
                border: 1px solid #40999d;
            }

            .fa-book-open {
                font-size: 50px;
                border: 2px solid black;
                padding: 15px;
            }

            table {
                border: none !important;
            }

            .box2 {
                background-color: #ddfdff78;
            }

            .box3 {
                border: 1px solid #40999d;
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
                                <a
                                    href="{{ route('student.course.show', urlencode(base64_encode($assignData->sub_module->module->course->id))) }}">{{ $assignData->title }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{-- @extends('student.master')

@section('title', 'My Learning')

@section('content') --}}
        <section class="">
            <div class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="px-4"><strong>{{ ucfirst($assignData->title) ?? '' }}</strong></h1>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box2 p-4 rounded">
                            <div class="p-2">
                                <h6><strong>Assignment Details</strong></h6>
                            </div>
                            <table class="w-100">
                                <tbody>
                                    <tr>
                                        <td class="p-2">
                                            <p class="mb-1"><strong>Total Attempts:</strong></p>
                                            <p class="mb-0">
                                                {{ $assignData->attempts }}
                                                {{ $assignData->total_attempts }}
                                            </p>
                                            <br>
                                            @if (!isset($shortStatus))
                                                <p><strong>Your Passing Score:</strong> {{ $passingScore ?? '' }}</p>
                                            @endif

                                            <br>
                                            @if (!empty($userAssign))
                                                <p><strong>Your Percentage Score:</strong>
                                                    {{ $userAssign->score ?? '' }}</p>
                                            @endif
                                        </td>
                                        @if (!is_null($passingScore))
                                            @if ($userAssign && $userAssign->score >= $passingScore)

                                                <td class="p-2">
                                                    <a href="#" class="btn px-5 py-3 start-btn">
                                                        <i class="fa-solid fa-check"></i> Pass
                                                    </a>
                                                </td>
                                            @else
                                                @if ($assignData->attempts > $count)
                                                    <td class="p-2">
                                                        <a href="{{ route('student.assignment.show', urlencode(base64_encode($assignData->id))) }}"
                                                            class="btn px-5 py-3 start-btn">
                                                            <i class="fa-solid fa-clock"></i> Start
                                                        </a>
                                                    </td>
                                                @else
                                                    <td class="p-2">
                                                        <button class="btn px-5 py-3 btn btn-success disabled-button"
                                                            aria-disabled="true" disabled>
                                                            <i class="fa-solid fa-check-circle"></i> Total Attempts
                                                            Exhausted
                                                        </button>

                                                    </td>
                                                @endif

                                            @endif
                                        @else
                                            @if (($shortStatus ?? 0) == 1)
                                                <td class="p-2">
                                                    <a href="#" class="btn px-5 py-3 start-btn">
                                                        <i class="fa-solid fa-check"></i> Pass
                                                    </a>
                                                </td>
                                            @else
                                                @if ($assignData->attempts > $count)
                                                    @if (($shortStatus ?? 0) == 0)
                                                        <td class="p-2">
                                                            <a href="#" class="btn px-5 py-3 start-btn">
                                                                <i class="fa-solid fa-clock"></i> Progress
                                                            </a>
                                                        </td>
                                                    @elseif(($shortStatus ?? 0) == 2)
                                                        <td class="p-2">
                                                            <a href="{{ route('student.assignment.show', urlencode(base64_encode($assignData->id))) }}"
                                                                class="btn px-5 py-3 start-btn">
                                                                <i class="fa-solid fa-clock"></i> Start
                                                            </a>
                                                        </td>
                                                    @else
                                                        <td class="p-2">
                                                            <a href="{{ route('student.assignment.show', urlencode(base64_encode($assignData->id))) }}"
                                                                class="btn px-5 py-3 start-btn">
                                                                <i class="fa-solid fa-clock"></i> Start
                                                            </a>
                                                        </td>
                                                    @endif
                                                @else
                                                    <td class="p-2">
                                                        <button class="btn px-5 py-3 btn btn-success disabled-button"
                                                            aria-disabled="true" disabled>
                                                            <i class="fa-solid fa-check-circle"></i> Total Attempts
                                                            Exhausted
                                                        </button>

                                                    </td>
                                                @endif

                                            @endif
                                        @endif
                                        <td class="p-2">
                                            <a href="{{ route('student.course.show', urlencode(base64_encode($assignData->sub_module->module->course->id))) }}"
                                                class="btn px-5 py-3 btn btn-success">
                                                <i class="fa-solid fa-check"></i> Go To Next
                                            </a>
                                        </td>

                                    </tr>

                                    <tr>
                                        <td class="p-2"></td>
                                        <td class="p-2">
                                            <p class="mb-1"><strong>Time limit</strong></p>
                                            <p class="mb-0">{{ $assignData->duration }} min per attempt</p>
                                        </td>
                                        <td class="p-2"></td>
                                    </tr>
                                    <tr>
                                        <td class="p-2"></td>
                                        <td class="p-2">
                                            <p class="mb-1"><strong>Submissions</strong></p>
                                            <p class="mb-0"> {{ $assignData->attempts - $count }} left
                                                ({{ $assignData->attempts }} total within the time limit)</p>
                                        </td>
                                        <td class="p-2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- <div class="box3 mt-4 p-4 rounded">
                              <h6 class="mb-0"><strong>Assignment details</strong></h6>
                              <p class="mb-0">3 left (3 attempts every 24 hours)</p>
                              <p class="mt-5 mb-0">-----</p>
                         </div> --}}
                    </div>
                </div>
            </div>
        </section>

        {{-- @endsection --}}
        <script type="text/javascript" src="https://demo.dashboardpack.com/architectui-html-free/assets/scripts/main.js">
        </script>
    </body>

    </html>
    <!-- partial -->
    <script src="{{ asset('front/js/script.js') }}"></script>
</body>

</html>
