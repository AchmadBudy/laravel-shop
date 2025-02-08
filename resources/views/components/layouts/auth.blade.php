@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ? $title . ' - ' : '' }}{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" />

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 15px;
            border: none;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
        }

        .form-control-lg {
            padding: 0.75rem 1.25rem;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="min-vh-100 d-flex flex-column">
        {{ $slot }}
    </div>
</body>

</html>
