<div class="container pt-5 my-5">
    <div class="row g-4">
        <!-- Daftar Produk di Keranjang -->
        <div class="col-md-8">
            <h4 class="mb-4">Keranjang Belanja ({{ $totalQty }} items)</h4>

            <!-- Item Keranjang -->
            @foreach ($carts as $cart)
                <div class="mb-3 shadow-sm card">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="{{ asset('storage/' . $cart->product->image) }}" class="img-fluid rounded-start"
                                alt="Produk" />
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">{{ $cart->product->name }}</h5>
                                    <button class="btn btn-link text-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                                <div class="row align-items-center">
                                    <div class="col-6">
                                        @if ($cart->product->type == \App\Enums\ProductTypeEnum::Download)
                                            <input type="text" class="form-control" value="1" disabled />
                                        @else
                                            <div class="input-group" style="width: 120px">
                                                <button class="btn btn-outline-secondary"
                                                    wire:click="decreaseQuantity({{ $cart->id }})"
                                                    wire:loading.attr="disabled">
                                                    -
                                                </button>
                                                <input type="number" class="text-center form-control"
                                                    value="{{ $cart->quantity }}" min="1" />
                                                <button class="btn btn-outline-secondary"
                                                    wire:click="increaseQuantity({{ $cart->id }})"
                                                    wire:loading.attr="disabled">
                                                    +
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-6 text-end">
                                        <p class="mb-0 h5">Rp
                                            {{ Number::format($cart->product->price * $cart->quantity, locale: 'id') }}
                                        </p>
                                        <small class="text-muted">Rp
                                            {{ Number::format($cart->product->price, locale: 'id') }} per item</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach


            <!-- Item Keranjang Lainnya -->
            <!-- Ulangi card item sesuai kebutuhan -->

            <!-- Tombol Lanjut Belanja -->
            <div class="mt-4 d-flex justify-content-between">
                <a href="#" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Lanjut Belanja
                </a>
                <button class="btn btn-outline-danger">
                    <i class="bi bi-arrow-clockwise"></i> Perbarui
                    Keranjang
                </button>
            </div>
        </div>

        <!-- Ringkasan Belanja -->
        <div class="col-md-4">
            <div class="shadow-sm card sticky-top" style="top: 100px">
                <div class="card-body">
                    <h5 class="mb-4 card-title">Ringkasan Belanja</h5>
                    {{-- 
                    <div class="mb-2 d-flex justify-content-between">
                        <span>Subtotal ({{ $totalQty }} items)</span>
                        <span>Rp {{ Number::format($total, locale: 'id') }}</span>
                    </div> --}}

                    {{-- <div class="mb-2 d-flex justify-content-between">
                        <span>Diskon</span>
                        <span class="text-danger">- Rp 1.000.000</span>
                    </div> --}}

                    {{-- <div class="mb-4 d-flex justify-content-between">
                        <span>Biaya Pengiriman</span>
                        <span>Rp 20.000</span>
                    </div> --}}

                    {{-- <hr /> --}}

                    <div class="mb-4 d-flex justify-content-between">
                        <h5>Total</h5>
                        <h5>Rp {{ Number::format($total, locale: 'id') }}</h5>
                    </div>

                    {{-- <div class="mb-3">
                        <label class="form-label">Kode Promo</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Masukkan kode promo" />
                            <button class="btn btn-outline-secondary">
                                Terapkan
                            </button>
                        </div>
                    </div> --}}

                    <a href="#" class="py-2 btn btn-primary w-100">
                        <i class="bi bi-credit-card"></i> Lanjut ke
                        Pembayaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
