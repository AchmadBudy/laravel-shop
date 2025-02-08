<div class="container pt-5 mt-5">
    @error('stockCount')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @enderror
    <div class="row g-5">
        <!-- Gallery Produk -->
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded-3" alt="Produk" />
        </div>

        <!-- Info Produk -->
        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>
            <div class="mb-4">
                <div class="d-inline">
                    <a href="#" class="border badge bg-light text-dark me-2">Elektronik</a>
                    <a href="#" class="border badge bg-light text-dark me-2">Gadget</a>
                </div>
            </div>

            <!-- Rating -->
            <div class="mb-3 d-flex align-items-center">
                {{-- <div class="rating-stars">
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star text-warning"></i>
                </div>
                <span class="text-muted ms-2">(4.0/5 dari 890 ulasan)</span> --}}
                <span class="text-muted ms-3">
                    <i class="bi bi-cart-check"></i> Terjual {{ $product->detail_transactions_count }}
                </span>
            </div>

            <!-- Harga -->
            <div class="mb-4">
                <!-- Kondisi Diskon -->
                @if ($product->discount)
                    <div class="d-flex align-items-center">
                        <h2 class="mb-0 text-danger">Rp {{ Number::format($product->price, locale: 'id') }}</h2>
                        <del class="text-muted ms-3">Rp
                            {{ Number::format($product->original_price, locale: 'id') }}</del>
                        <span class="badge bg-danger ms-2">{{ ($product->discount / $product->original_price) * 100 }}%
                            OFF</span>
                    </div>
                @else
                    <h2 class="text-dark">Rp {{ Number::format($product->price, locale: 'id') }}</h2>
                @endif
            </div>

            <!-- Garansi -->
            @if ($product->guarantee)
                <div class="mb-4 card border-success">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-shield-check text-success"></i>
                            Garansi
                        </h5>
                        <ul class="list-unstyled">

                            @foreach ($product->guarantee as $guarantee)
                                <li>
                                    <i class="bi bi-check2-circle me-2"></i>{{ $guarantee['option'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @else
                <div class="mb-4 card border-danger">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-shield-x text-danger"></i>
                            Garansi
                        </h5>
                        <ul class="list-unstyled">
                            <li>
                                Produk ini tidak memiliki garansi
                            </li>
                        </ul>
                    </div>
                </div>
            @endif


            <!-- Form Beli -->
            <div class="mb-4 card">
                <div class="card-body">
                    @if ($product->quantity > 0)
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label class="col-form-label">Jumlah:</label>
                            </div>
                            @if ($product->type == \App\Enums\ProductTypeEnum::Download)
                                <div class="col-auto">
                                    <input type="number" class="form-control" value="1" disabled />
                                </div>
                            @else
                                <div class="col-auto">
                                    <div class="input-group" x-data="{ stockCount: $wire.entangle('stockCount') }">
                                        <button class="btn btn-outline-secondary" type="button"
                                            x-bind:disabled="stockCount <= 1" @click="stockCount--">
                                            -
                                        </button>
                                        <input type="number" class="text-center form-control" x-model="stockCount"
                                            min="1" max="{{ $product->quantity }}"
                                            wire:model.blur='stockCount' />
                                        <button class="btn btn-outline-secondary" type="button"
                                            x-bind:disabled="stockCount >= {{ $product->quantity }}"
                                            @click="stockCount++">
                                            +
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button class="py-2 mt-3 btn btn-primary w-100" wire:click="addToCart"
                            wire:loading.attr="disabled">
                            <i class="bi bi-cart"></i> Tambah ke Keranjang
                        </button>
                    @else
                        <button class="py-2 btn btn-secondary w-100" disabled>
                            Stok Habis
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Deskripsi -->
    <div class="my-5 row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mb-4">Deskripsi Produk</h4>
                    <p>
                        {{ $product->description }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
