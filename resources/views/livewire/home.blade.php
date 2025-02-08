<div>
    <!-- Hero Section -->
    <div class="container pt-5 mt-5">
        <div class="p-5 mb-4 bg-light rounded-3">
            <div class="py-5 container-fluid">
                <h1 class="display-5 fw-bold">Selamat Datang di {{ config('app.name') }}</h1>
                <p class="col-md-8 fs-4">
                    Tempat belanja online terpercaya dengan berbagai produk
                    berkualitas
                </p>
            </div>
        </div>
    </div>

    <!-- Kategori Produk -->
    <div class="container py-5">
        <h2 class="mb-4 text-center">Kategori Produk</h2>
        <div class="row g-4">
            <!-- Kategori dengan link -->
            @foreach ($categories as $category)
                <div class="col-6 col-md-3">
                    <a href="kategori.html" class="text-decoration-none">
                        <div class="shadow-sm card h-100 card-hover">
                            <div class="text-center card-body">
                                <img src="{{ 'storage/' . $category->icon }}" alt="{{ $category->name }}"
                                    class="mb-3 category-icon" style="height: 60px; width: auto; object-fit: contain;">
                                <h5 class="mt-3 card-title">{{ $category->name }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
            <!-- Ulangi kategori lainnya -->
        </div>
    </div>

    <!-- Daftar Produk -->
    <div class="container py-5">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h2>Produk Terbaru</h2>
            <a href="{{ route('products') }}" class="btn btn-link" wire:navigate>Lihat Semua Produk <i
                    class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row g-4">
            <!-- Product Card -->
            @foreach ($products as $product)
                <div class="col-6 col-md-3">
                    <a href="{{ route('product.detail', $product->slug) }}" class="text-decoration-none" wire:navigate>
                        <div class="shadow-sm card h-100 card-hover">
                            <div class="top-0 m-2 position-absolute start-0">
                                @if ($product->discount)
                                    <span
                                        class="badge bg-danger">{{ ($product->discount / $product->original_price) * 100 }}%</span>
                                @endif

                                <span class="badge bg-primary">{{ $product->type->getLabel() }}</span>
                            </div>
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="Produk" />
                            <div class="card-body">
                                <div class="mb-2 category-tags">
                                    @foreach ($product->categories as $category)
                                        <small
                                            class="border badge bg-light text-dark me-1">{{ $category->name }}</small>
                                    @endforeach
                                </div>
                                <h6 class="card-title text-dark">
                                    {{ $product->name }}
                                </h6>
                                <div class="mb-2 d-flex align-items-center">
                                    {{-- <div class="rating-stars">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-half text-warning"></i>
                                    </div>
                                    <small class="text-muted ms-2">(4.5)</small> --}}
                                </div>
                                @if ($product->discount)
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-danger">Rp
                                            {{ Number::format($product->price, locale: 'id') }}</span>
                                        <small class="text-muted"><del>Rp
                                                {{ Number::format($product->original_price, locale: 'id') }}</del></small>
                                    </div>
                                @else
                                    <div class="mb-2">
                                        <span class="mb-0 h5 text-dark">Rp
                                            {{ Number::format($product->price, locale: 'id') }}</span>
                                    </div>
                                @endif
                                <small class="mt-2 text-muted d-block">
                                    <i class="bi bi-cart-check"></i>
                                    Terjual {{ $product->detail_transactions_count }}
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach


            {{-- <div class="col-6 col-md-3">
                <a href="produk-detail.html" class="text-decoration-none">
                    <div class="shadow-sm card h-100 card-hover">
                        <!-- Label Diskon -->
                        <div class="top-0 m-2 position-absolute start-0">
                            <span class="badge bg-danger">30% OFF</span>
                        </div>
                        <img src="https://picsum.photos/150/150" class="card-img-top" alt="Produk" />
                        <div class="card-body">
                            <div class="mb-2 category-badges">
                                <small class="border badge bg-light text-dark me-1">Software</small>
                                <small class="border badge bg-light text-dark me-1">Produktivitas</small>
                            </div>
                            <h5 class="card-title text-dark">
                                Smartphone X
                            </h5>

                            <!-- Rating -->
                            <div class="mb-2 d-flex align-items-center">
                                <div class="rating-stars">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                </div>
                                <small class="text-muted ms-2">(4.5)</small>
                            </div>

                            <!-- Harga -->
                            <div class="d-flex align-items-center">
                                <span class="mb-0 h5 text-danger">Rp 3.500.000</span>
                                <small class="text-muted ms-2 text-decoration-line-through">Rp 5.000.000</small>
                            </div>

                            <!-- Terjual -->
                            <small class="mt-2 text-muted d-block">
                                <i class="bi bi-cart-check"></i> Terjual
                                250+
                            </small>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Product Card Lainnya -->
            <div class="col-6 col-md-3">
                <a href="produk-detail.html" class="text-decoration-none">
                    <div class="shadow-sm card h-100 card-hover">
                        <img src="https://picsum.photos/150/150" class="card-img-top" alt="Produk" />
                        <div class="card-body">
                            <h5 class="card-title text-dark">
                                Kemeja Casual
                            </h5>

                            <!-- Rating -->
                            <div class="mb-2 d-flex align-items-center">
                                <div class="rating-stars">
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star text-warning"></i>
                                </div>
                                <small class="text-muted ms-2">(4.0)</small>
                            </div>

                            <!-- Harga Normal -->
                            <div class="mb-2">
                                <span class="mb-0 h5 text-dark">Rp 199.000</span>
                            </div>

                            <!-- Terjual -->
                            <small class="text-muted d-block">
                                <i class="bi bi-cart-check"></i> Terjual
                                1.2rb+
                            </small>
                        </div>
                    </div>
                </a>
            </div> --}}

            <!-- Tambahkan 14 product card lainnya -->
        </div>
    </div>
</div>
