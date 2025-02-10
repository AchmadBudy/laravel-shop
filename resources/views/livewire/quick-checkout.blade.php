<div class="container pt-5 mt-5">
    <div class="row g-5">
        <!-- Form Email -->
        <div class="col-md-6">
            <div class="p-2 shadow-sm card">
                <div class="card-body">
                    <!-- Di dalam section form email -->
                    <!-- Input email (tetap sama) -->
                    <div class="mb-4">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email"
                            placeholder="contoh@email.com" required wire:model.live.blur='email' />
                        <small class="text-muted">Nota pembelian akan dikirim ke email
                            ini</small>
                    </div>

                    <!-- Pilihan Metode Pembayaran -->
                    <div class="mb-4">
                        <h6 class="mb-3">
                            Pilih Metode Pembayaran
                        </h6>

                        <div class="row g-3">
                            <!-- QRIS -->
                            <div class="col-md-6">
                                <label class="w-100">
                                    <input type="radio" name="payment_method" value="qris" class="d-none"
                                        required />
                                    <div class="card payment-method-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <img src="qris-logo.png" alt="QRIS"
                                                    style="
                                                            height: 30px;
                                                            margin-right: 15px;
                                                        " />
                                                <h6 class="mb-0">
                                                    QRIS
                                                </h6>
                                            </div>
                                            <small class="text-muted">Scan QR code untuk
                                                pembayaran</small>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <!-- BCA Virtual Account -->
                            <div class="col-md-6">
                                <label class="w-100">
                                    <input type="radio" name="payment_method" value="bca" class="d-none"
                                        required />
                                    <div class="card payment-method-card">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <img src="bca-logo.png" alt="BCA"
                                                    style="
                                                            height: 25px;
                                                            margin-right: 15px;
                                                        " />
                                                <h6 class="mb-0">
                                                    Virtual Account
                                                    BCA
                                                </h6>
                                            </div>
                                            <small class="text-muted">Transfer ke Virtual
                                                Account</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('products', $product) }}" class="btn btn-outline-secondary" wire:navigate>
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button class="btn btn-primary" wire:click="checkout" wire:loading.attr="disabled">
                            Langsung Bayar
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ringkasan Pesanan -->
        <div class="col-md-6">
            <div class="shadow-sm card sticky-top" style="top: 100px">
                <div class="card-body">
                    <h4 class="">Ringkasan Pesanan</h4>
                    {{-- type product --}}
                    <h5 class="mb-4">Tipe Produk :
                        <span
                            class="badge bg-{{ $product->type->getBootstrapColor() }}">{{ $product->type->getLabel() }}</span>
                    </h5>

                    <!-- Daftar Produk -->
                    <div class="mb-4">
                        <div class="mb-3 d-flex">
                            <img src="{{ asset('storage/' . $product->image) }}" class="rounded-3 me-3" alt="Produk"
                                style="width:100px" />
                            <div class="flex-grow-1">
                                <h6>{{ $product->name }}</h6>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">{{ $stockCount }} x Rp
                                        {{ Number::format($product->original_price, locale: 'id') }}</small>
                                    @if ($product->type !== \App\Enums\ProductTypeEnum::Download)
                                        <div class="input-group" style="max-width: 120px;" x-data="{ stockCount: $wire.entangle('stockCount') }">
                                            <button class="btn btn-outline-secondary decrement"
                                                wire:click='decreaseStockCount' wire:loading.attr='disabled'
                                                x-bind:disabled="stockCount <= 1">-</button>
                                            <input type="number" class="text-center form-control quantity-input"
                                                wire:model='stockCount' min="1">
                                            <button class="btn btn-outline-secondary increment" type="button"
                                                wire:click='increaseStockCount' wire:loading.attr='disabled'
                                                x-bind:disabled="stockCount >= {{ $product->quantity }}">+</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Tambahkan produk lainnya -->
                    </div>

                    <!-- Total Pembayaran -->
                    <div class="pt-3 border-top">
                        <div class="mb-2 d-flex justify-content-between">
                            <span>Subtotal:</span>
                            <span>Rp {{ Number::format($product->original_price * $stockCount, locale: 'id') }}</span>
                        </div>
                        @if ($product->discount)
                            <div class="mb-3 d-flex justify-content-between">
                                <span>Diskon:</span>
                                <span class="text-danger">- Rp
                                    {{ Number::format($product->discount * $stockCount, locale: 'id') }}</span>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total:</span>
                            <span>Rp {{ Number::format($product->price * $stockCount, locale: 'id') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
