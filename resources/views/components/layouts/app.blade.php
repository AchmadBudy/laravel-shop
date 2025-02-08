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

        /* .card-hover .badge {
            transition: all 0.3s ease;
        } */

        /* .card-hover:hover .badge {
            transform: scale(1.1);
        } */

        .category-icon {
            display: inline-block;
            max-width: 100%;
            transition: transform 0.2s;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        window.addEventListener('addToCart', event => {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Menambahkan Produk',
                text: event.detail.message,
            });
        });
    </script>
</head>

<body>
    <!-- Navbar -->
    <livewire:layout.navbar />

    <div class="min-vh-100 d-flex flex-column">
        {{ $slot }}
    </div>





    <!-- Footer -->
    <livewire:layout.footer />
</body>

</html>
