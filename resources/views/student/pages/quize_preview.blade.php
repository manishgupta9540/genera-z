<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="col-xl-7 col-lg-8 col-md-10">
        <div class="account-wrap">
            <div class="account-main text-center">
                <h3 class="account-title mb-2 ">Congratulations! </h3>
                <p style="font-weight: 500;color: #000;">You've completed the
                    quize process. </p>
                <img src="https://ils.intercambio.org/assets/img/congra.png" style="max-width:100px;"
                    class="d-block mx-auto mb-4 mt-5">

                <p style="font-weight: 500;color: #000;">Score
                    <br><b class="result-space">{{ $accurate_answer }} out of {{ $total_question }}</b>
                </p>

                <p style="color: #000000a8;font-size: 13px;line-height: 20px;">Thank you for your
                    interest. We will contact you by email once we have found a teacher for you.</p>
            </div>
        </div>

    </div>
</body>
</html>