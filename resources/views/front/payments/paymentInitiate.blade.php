<!DOCTYPE html>
<html>

<head>
    <title>Payment</title>
</head>

<body>

    <form method="post" name="redirect" action="{{ config('ccavenue.payment_url') }}">
        <input type=hidden name="encRequest" value="{{$encryptedData}}">
        <input type="hidden" name="access_code" id="access_code" value="{{ config('ccavenue.access_code') }}">
        <script language='javascript'>
            document.redirect.submit();
        </script>
    </form>

    <script></script>
</body>

</html>
