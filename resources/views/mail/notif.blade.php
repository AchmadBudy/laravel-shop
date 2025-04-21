<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Notification</h1>
        <p>{{ $messages }}</p>
        <hr>
        <p><small>This is an automated notification.</small></p>
    </div>
</body>
</html>