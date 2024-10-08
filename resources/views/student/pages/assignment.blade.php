<!DOCTYPE html>
<html lang="en">

<head>
    <title>Assignment: {{ $assignment->title }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--Font-Family-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('admin/assets/bundles/summernote/summernote-bs4.css') }}">
    <style>
        body {
            font-family: "Open Sans", sans-serif;
            font-size: 16px;
            color: rgb(119, 119, 119);
        }

        .point {
            background-color: #e5e7e8;
            border-radius: 6px;
        }

        .question-content p {
            display: inline;
        }
    </style>
</head>

<body class="addGrandParent">
    <section class="mcq">
        <form id="test"
            action="{{ route('student.assignment.submit', urlencode(base64_encode($assignment->id))) }}" method="post">
            @csrf
            <div class="container-fluid my-2">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-10">
                                    <p>Answer the questions that follow to test your understanding of the process.
                                        Remember that you can refer to the previous lesson items if required.</p>
                                </div>
                                <div class="col-md-2">
                                    <h5 class="text-danger">Time Left</h5>
                                    <h5 id="timer">
                                        0.00
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4 justify-content-center">
                        <div class="col-md-8 addParent_{{ config('addPages.assignmentTest.id') }}"
                            id="addParent_{{ config('addPages.assignmentTest.id') }}">

                        </div>
                    </div>
                    <div class="row mt-5 justify-content-center">
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-outline-success py-2 px-4">Submit</button>
                            <a href="{{ route('student.course.show',urlencode(base64_encode($assignment->sub_module->module->course->id))) }}" class="btn btn-outline-danger py-2 px-4">Cancel</a >
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <div class="modal fade notShowing" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="{{ route('student.assignment.start', urlencode(base64_encode($assignment->id))) }}"
            method="post">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Start Assignment</h1>
                    </div>
                    <div class="modal-body">
                        <h1>Multiple Choice Questions</h1>

                        <div class="instructions">
                            <p><strong>Instructions:</strong></p>
                            <ol>
                                <li>Read each question carefully.</li>
                                <li>Select the best answer from the options provided.</li>
                                <li>Only one answer is correct per question.</li>
                                <li>If you are unsure, eliminate the obviously incorrect answers to improve your
                                    chances.</li>
                                <li>Review your answers before submitting the form.</li>
                                <li>Assignment Time: {{ $assignment->duration }} minutes.</li>
                            </ol>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="StartTest" class="btn btn-primary">Confirm</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>

<script src="{{ asset('admin/assets/bundles/summernote/summernote-bs4.js') }}"></script>


<script class="notShowing">
    $(document).ready(function() {
        $('#exampleModal').modal({
            backdrop: 'static',
            keyboard: false
        }).modal('show');

        $('#StartTest').on('click', function() {
            var form = $(this).closest('form');
            $.ajax({
                url: form.attr('action'),
                type: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(response) {
                    $(response.parent).html(response.html);
                    $('#exampleModal').modal('hide')
                    startTimer(response.time)
                    $('.notShowing').remove();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        })
    });

    
    function startTimer(minutes) {
        var time = minutes * 60;
        var timer = setInterval(function() {
            time--;
            var displayMinutes = Math.floor(time / 60);
            var seconds = time % 60;

            $('#timer').text(
                `${displayMinutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`
            );

            // Show alert when only 5 minutes are left
            if (time === 5 * 60) {
                alert("Only 5 minutes left!");
            }

            // Submit the form when time is up
            if (time <= 0) {
                clearInterval(timer);
                $('#test').submit();
            }
        }, 1000);
    }

</script>







</html>
