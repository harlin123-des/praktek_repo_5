<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60; URL={{ url()->current() }}">
    <title>Auto Refresh</title>
</head>
<body>
    <h1>Watch the page reload itself in 60 seconds!</h1>
    <p>Tanggal dan Waktu sekarang adalah {{ now()->format('Y-m-d h:i:sa') }}</p>
</body>
</html>
