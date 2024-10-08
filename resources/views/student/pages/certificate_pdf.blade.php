<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generation Z</title>
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap"> -->
</head>
<style>
    body {
        font-family: 'Merriweather', serif;
    }
/*    @page
    {
        margin: 0px;
    }*/
</style>

<body>
    <table style="background-image:url({{ public_path('front/img/imgpsh.png') }}); border: 1px solid #888; background-size: cover; background-repeat: no-repeat; background-position: bottom bottom;   width: 1000px; height:99%; margin: 0px auto;">
        <tr>
            <td align="center">
            <p style="padding-top: 0rem; padding-bottom: 0rem;"><?= date('M d, Y',strtotime($course_info->complet_date)); ?></p>
            </td>
        </tr>
        <tr>
            <td align="center">
            <h3 style="padding-top: 0rem; font-size: 40px;  letter-spacing: 4px;">CERTIFICATE OF COMPLETION</h3>
            </td>
        </tr>
        <tr>
            <td align="center" style=" padding-top: 0rem; padding-bottom: 2em; font-size: 16px; color: #524949;  letter-spacing: 3px;"> This Is To Certify That: {{ $first_name??'' }} {{ $last_name??'' }}</td>
        </tr>
        <tr>
            <td align="center" style="background-color:#00000094; height: 0px; margin: 0px auto; width: 72%;   display: block;"></td>
            </td>
        </tr>

        <tr>
            <td align="center">
            <h3 style="padding-bottom: 0em; font-size: 20px; color: #605252;letter-spacing: 3px;"> has successfully completed their training session on
            </h3>
            </td>
        </tr>
        <tr>
            <td align="center">
            <p style="padding-bottom: 0rem;  font-size: 19px; color: #685858; letter-spacing: 2px;  font-weight: 600;"><i>{{ $course->title??'' }}</i>
            </p>
            </td>
        </tr>

        <tr align="center">
        <td style="padding-bottom: 3em;">
            <img src="{{ public_path('front/img/Sig.png') }}" width="12%" alt="" style="padding-bottom: 6rem;">
            <img src="{{ public_path('front/img/logo.png') }}" width="20%" alt="">
            <img src="{{ public_path('front/img/Stamp.png') }}" width="10%" alt="" style="padding-bottom: 8rem; width:15%;transform: rotate(-21deg);;">
        </td>
        </tr>

    </table>
</body>

</html>