<!DOCTYPE html>
<html lang="en">

<head>
    <title>MCQ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Font-Family-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    </style>
</head>

<body>
    <section class="mcq">
        <div class="container-fluid my-2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <p>Answer the questions that follow to test your understanding of the process. Remember that you
                            can refer to the previous lesson items if required. </p>
                    </div>
                </div>
                @php
                    $time = explode(':', $assignData->due_time);
                    $currentDate = \Carbon\Carbon::now()->format('Y-m-d');
                @endphp
                @if ($assignData->due_date >= $currentDate && !$canAttempt)
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <h5 class="text-left timer">{{ $assignData->due_time }}</h5>
                        </div>
                    </div>
                    <form action="{{ route('student-assignments-save') }}" method="post" id="quizeQuestion">
                        @csrf
                        @php
                            $questionNumber = 1;
                        @endphp
                        @if (isset($quezeQuestions))
                            @foreach ($quezeQuestions as $item)
                                <input type="hidden" name="assignment_id" value="{{ $assignData->id }}">
                                <input type="hidden" name="quiz_id[{{ $item->id }}]" value="{{ $item->id }}">
                                <div class="row mt-4 justify-content-center">
                                    <div class="col-md-8">
                                        <input type="hidden" name="questions[{{ $item->id }}][q_id]"
                                            value="{{ $item->id }}">
                                        <div class="d-flex">
                                            <p><b>{{ $questionNumber }}. </b> {!! $item->question !!}</p>
                                        </div>

                                        @php
                                            $options = $item->option;
                                            $arrayOptions = explode(',', $options);
                                        @endphp

                                        @foreach ($arrayOptions as $index => $option)
                                            <div class="form-check mt-2">
                                                <input type="radio" class="form-check-input"
                                                    id="check{{ $questionNumber }}_{{ $index + 1 }}"
                                                    name="questions[{{ $item->id }}][selected_option]"
                                                    value="{{ strtoupper(trim($option)) }}">
                                                <label class="form-check-label"
                                                    for="check{{ $questionNumber }}_{{ $index + 1 }}">{{ $option }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-2">
                                        <input type="hidden" name="questions[{{ $item->id }}][marks]"
                                            value="{{ $assignData->marks }}">
                                        <p class="point p-2 text-center"><b>{{ $assignData->marks }}</b></p>
                                    </div>
                                </div>
                                @php
                                    $questionNumber++;
                                @endphp
                            @endforeach
                        @endif


                        @if (isset($shortQuestions))
                            @php $i = 1; @endphp
                            @foreach ($shortQuestions as $index => $datas)
                                <input type="hidden" name="assignment_id" value="{{ $assignData->id }}">
                                <input type="hidden" name="quiz_id[{{ $datas->id }}]" value="{{ $datas->id }}">
                                <div class="row mb-2 w-100 mt-4 justify-content-center">
                                    <div class="col-md-8 mb-3">
                                        <div class="fs_16 fw_600 mb-2 d-flex">
                                            <input type="hidden" name="short_questions[{{ $datas->id }}][answers]"
                                                value="{{ $datas->id }}">
                                            <p><b>{{ $i++ }}</b>. {!! $datas->question !!}</p>
                                        </div>
                                        <textarea class="form-control" name="short_questions[{{ $datas->id }}][answer]" placeholder="Enter your answer"></textarea>
                                    </div>
                                    <div class="col-md-2">
                                        <p class="point p-2 text-center mb-0"><b>{{ $assignData->marks }} point</b></p>
                                    </div>
                                </div>
                            @endforeach
                        @endif


                        <div class="row mt-5 justify-content-center">
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-secondary px-5 py-3">Submit</button>
                                <button type="button" class="btn border-primary px-5 py-3 text-primary">Save
                                    draft</button>
                            </div>
                        </div>
                    </form>
                @elseif ($canAttempt)
                    <div class="col-md-6 mx-auto p-5 alert-warning shadow rounded">
                        <div class="alert alert-warning text-center border-0 mb-0">
                            <p class="mb-0">You have exceeded the maximum number of attempts for this quiz.</p>
                        </div>
                    </div>
                @else
                    <div class="col-md-6 mx-auto p-5 alert-danger shadow rounded">
                        <div class="alert alert-danger text-center border-0 mb-0">
                            <p class="mb-0">Quize Date is expire</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Assuming $time is an array like [hours, minutes]
            var time = @json($time);
            $('.timer').text(time[0] + ':' + (time[1] < 10 ? '0' : '') + time[1] + ":00 Left Time");
            var seconds = 60;
            var hours = parseInt(time[0]);
            var minutes = parseInt(time[1]);
            var timers = setInterval(() => {
                // Form submit when timer reaches 00:00:00
                if (hours == 0 && minutes == 0 && seconds == 0) {
                    clearInterval(timers);
                    $("#quizeQuestion").submit();
                }

                console.log(hours + "-:-" + minutes + "-:-" + seconds);

                // Timer logic
                if (seconds <= 0) {
                    if (minutes > 0 || hours > 0) {
                        minutes--;
                        seconds = 59;
                    }
                } else {
                    seconds--;
                }

                if (minutes < 0 && hours > 0) {
                    hours--;
                    minutes = 59;
                }

                if (hours < 0) {
                    hours = 0;
                    minutes = 0;
                    seconds = 0;
                }

                let timeHours = hours.toString().padStart(2, '0');
                let timeMinutes = minutes.toString().padStart(2, '0');
                let timeSeconds = seconds.toString().padStart(2, '0');

                $('.timer').text(timeHours + ':' + timeMinutes + ':' + timeSeconds + " Left Time");
            }, 1000);
        });
    </script>
</body>

</html>
