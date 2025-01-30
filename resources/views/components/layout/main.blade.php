@props(['title' => null]);

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ? $title . ' - ' : '' }}{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" />
</head>

<body>
    <!-- Navbar -->
    <x-layout.navbar />

    {{ $slot }}

    <!-- Footer -->
    <x-layout.footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Styling untuk kondisi stok habis */
        .stock-disabled {
            position: relative;
            opacity: 0.7;
        }

        .stock-disabled::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.5);
        }

        .rating-stars {
            font-size: 1.1rem;
        }

        .badge {
            font-size: 0.9rem;
        }

        .card {
            border-radius: 10px;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .rating-stars {
            font-size: 0.9rem;
        }

        .card-hover .badge {
            transition: all 0.3s ease;
        }

        .card-hover:hover .badge {
            transform: scale(1.1);
        }
    </style>
</body>

</html>
