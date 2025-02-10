<div class="container pt-5 mt-5">
    <div class="row g-4">
        <!-- Sidebar Filter -->
        <div class="col-md-3">
            <div class="shadow-sm card">
                <div class="card-body">
                    <h5 class="mb-4">Filter Produk</h5>

                    <!-- Search Box -->
                    <div class="mb-4">
                        <input type="text" class="form-control" placeholder="Cari produk..." wire:model.blur="search" />
                    </div>

                    <!-- Kategori -->
                    <div class="mb-4">
                        <h6>Kategori</h6>
                        <div class="form-group">
                            <select class="form-select" wire:model.live="category">
                                <option value="" selected>All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tombol Reset -->
                    <button class="btn btn-outline-secondary w-100" wire:click="resetFilters">
                        Reset Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Daftar Produk -->
        <div class="col-md-9">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <h4>Menampilkan {{ $products->count() }} produk</h4>
                {{-- <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Urutkan berdasarkan
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="#">Harga Tertinggi</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Harga Terendah</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Terbaru</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Terlaris</a>
                        </li>
                    </ul>
                </div> --}}
            </div>


            <!-- Loading Indicator -->

            <div class="text-center" wire:loading wire:target="search,category,resetFilters">
                <div class="p-3 d-flex align-items-center justify-content-center">
                    <div class="spinner-border spinner-border-sm text-primary me-2">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span>Memuat data...</span>
                </div>
            </div>

            <div class="row g-4" wire:loading.remove wire:target="search,category,resetFilters">
                @forelse ($products as $product)
                    <div class="col-6 col-md-4">
                        <a href="{{ route('product.detail', $product->slug) }}" class="text-decoration-none"
                            wire:navigate>
                            <div class="shadow-sm card h-100 card-hover">
                                <div class="top-0 m-2 position-absolute start-0">
                                    @if ($product->discount)
                                        <span
                                            class="badge bg-danger">{{ ($product->discount / $product->original_price) * 100 }}%</span>
                                    @endif

                                    <span class="badge bg-primary">{{ $product->type->getLabel() }}</span>
                                </div>
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                    alt="Produk" />
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
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            Produk tidak ditemukan.
                        </div>
                    </div>
                @endforelse

                {{-- <!-- Ulangi product card lainnya -->
                <div class="col-6 col-md-4">
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
                                    <i class="bi bi-cart-check"></i>
                                    Terjual 1.2rb+
                                </small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="produk-detail.html" class="text-decoration-none">
                        <div class="shadow-sm card h-100 card-hover">
                            <div class="top-0 m-2 position-absolute start-0">
                                <span class="badge bg-danger">30%</span>
                            </div>
                            <img src="https://picsum.photos/150/150" class="card-img-top" alt="Produk" />
                            <div class="card-body">
                                <h6 class="card-title text-dark">
                                    Smartphone X
                                </h6>
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
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-danger">Rp 3.500.000</span>
                                    <small class="text-muted"><del>Rp 5.000.000</del></small>
                                </div>
                                <small class="mt-2 text-muted d-block">
                                    <i class="bi bi-cart-check"></i>
                                    Terjual 250
                                </small>
                            </div>
                        </div>
                    </a>
                </div> --}}
            </div>

            <!-- Pagination -->
            <nav class="mt-5">
                {{ $products->links() }}
            </nav>
        </div>
    </div>
</div>
