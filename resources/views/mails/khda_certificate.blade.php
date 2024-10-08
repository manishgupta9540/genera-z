<!DOCTYPE html>
<html>
<head>
    <title>Khda Certificate Successful!</title>
</head>
<body>
    <h1>Khda Certificate Successful!</h1>
    <p>Dear {{ $certificate->name_in_english }},</p>
    <p>Your certificate with order ID {{ $certificate->order_id }} has been successfully processed.</p>
    <p>Status: {{ $certificate->status ? 'Approved' : 'Pending' }}</p>
</body>
</html>
