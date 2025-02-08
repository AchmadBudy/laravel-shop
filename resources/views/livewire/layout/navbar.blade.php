<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('index') }}" wire:navigate>{{ config('app.name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Menu Navigasi -->
            <ul class="navbar-nav me-auto">
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Produk
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="#">Semua Produk</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Kategori</a>
                        </li>
                    </ul>
                </li> --}}

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('products') }}" wire:navigate>Semua Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Garansi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Kontak</a>
                </li>
            </ul>

            <!-- Right Navigation -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart') }}" wire:navigate>
                        <i class="bi bi-cart"></i>
                        <span class="badge bg-danger">{{ $cartCount }}</span>
                    </a>
                </li>
                <!-- Kondisi Sudah Login -->
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="#"><i class="bi bi-pencil-square"></i>
                                    Edit Profil</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"><i class="bi bi-box-seam"></i> Pesanan
                                    Saya</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" wire:click.prevent="logout">
                                    <i class="bi bi-box-arrow-right"></i>
                                    Keluar
                                </a>
                            </li>
                        </ul>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}" wire:navigate><i class="bi bi-person"></i> Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2" href="{{ route('register') }}" wire:navigate>Daftar</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
