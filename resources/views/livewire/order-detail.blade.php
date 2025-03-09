<div class="container pt-5 mt-5">
    <!-- Header Pesanan -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h3>Detail Pesanan #{{ $transaction->invoice_number }}</h3>
            <p class="mb-0 text-muted">
                Tanggal Pesanan Dibuat: {{ $transaction->created_at->isoFormat('D MMMM Y HH:mm') }} WIB
            </p>
            <p class="text-muted small">
                Tanggal Pesanan Diupdate: {{ $transaction->updated_at->isoFormat('D MMMM Y HH:mm') }} WIB
            </p>
        </div>
        <div class="text-end">
            <span
                class="badge bg-{{ $transaction->payment_status->getBootstrapColor() }}">{{ $transaction->payment_status->getLabel() }}</span>
            <p class="mt-1 mb-0 text-muted small">ID: {{ $transaction->invoice_number }}</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Konten Utama -->
        <div class="col-md-8">
            <!-- Informasi Pembayaran -->
            <div class="mb-4 shadow-sm card">
                <div class="card-body">
                    <h5 class="mb-4">
                        <i class="bi bi-receipt"></i> Pembayaran
                    </h5>
                    <dl class="row">
                        <dt class="col-sm-3">Metode</dt>
                        <dd class="col-sm-9">QRIS</dd>

                        <dt class="col-sm-3">Total</dt>
                        <dd class="col-sm-9">Rp {{ Number::format($transaction->total_payment, locale: 'id') }}</dd>

                        <dt class="col-sm-3">Status</dt>
                        <dd class="col-sm-9">
                            <span
                                class="badge bg-{{ $transaction->payment_status->getBootstrapColor() }}">{{ $transaction->payment_status->getLabel() }}</span>
                        </dd>
                    </dl>
                </div>
            </div>
            @if ($transaction->payment_status == \App\Enums\OrderStatusEnum::Completed)
                @forelse ($transaction->transactionDetails as $detail)
                    @if ($detail->product_type == \App\Enums\ProductTypeEnum::Private)
                        <!-- Tipe 1: Akunprivate  Premium -->
                        <div class="mb-4 shadow-sm card">
                            <div class="card-body">
                                <h5 class="mb-4">
                                    <i class="bi bi-person-badge"></i> Akun Private Premium
                                </h5>

                                <div class="mb-4 row">
                                    <div class="col-md-12">
                                        <label class="form-label">Data Akun</label>
                                        @php
                                            $items = '';
                                            foreach ($detail->productPrivate as $item) {
                                                $items .= $item->item . PHP_EOL;
                                            }
                                        @endphp
                                        <textarea class="form-control" rows="10" readonly>{{ $items }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @elseif ($detail->product_type == \App\Enums\ProductTypeEnum::Shared)
                        <!-- Tipe 1: Akun shared Premium -->
                        <div class="mb-4 shadow-sm card">
                            <div class="card-body">
                                <h5 class="mb-4">
                                    <i class="bi bi-person-badge"></i> Akun Shared Premium
                                </h5>

                                <div class="mb-4 row">
                                    <div class="col-md-12">
                                        <label class="form-label">Data Akun</label>
                                        @php
                                            $items = '';
                                            foreach ($detail->productShared as $item) {
                                                $items .=
                                                    $item->item .
                                                    ' | Batasan Penggunaan : ' .
                                                    $item->pivot->used_count .
                                                    PHP_EOL;
                                            }
                                        @endphp
                                        <textarea class="form-control" rows="10" readonly>{{ $items }}</textarea>
                                    </div>
                                </div>


                            </div>
                        </div>
                    @elseif ($detail->product_type == \App\Enums\ProductTypeEnum::Download)
                        <!-- Tipe 1: File Download -->
                        <div class="mb-4 shadow-sm card" id="accountType">
                            <div class="card-body">
                                <h5 class="mb-4">
                                    <i class="bi bi-person-badge"></i> Link Download File
                                </h5>

                                {{-- note  --}}
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Pastikan anda menggunakan Email <span
                                        class="fw-bold">{{ $transaction->email }}</span> untuk mengakses link
                                    download
                                </div>

                                @foreach ($detail->productDownload as $productDownload)
                                    <div class="mb-4 row">
                                        <div class="col-md-12">
                                            <label class="form-label">Link Download</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    value="{{ $productDownload->file_url }}" readonly />
                                                <button class="btn btn-outline-secondary" onclick="copyContent(this)">
                                                    <i class="bi bi-link -45deg"></i>
                                                </button>
                                                <a href="{{ $productDownload->file_url }}" class="btn btn-success">
                                                    <i class="bi bi-download"></i>
                                                    Download
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                    @elseif ($detail->product_type == \App\Enums\ProductTypeEnum::Manual)
                        <div class="mb-4 shadow-sm card">
                            <div class="card-body">
                                <h5 class="mb-4">
                                    <i class="bi bi-person-badge"></i> Manual Produk
                                </h5>

                                <div class="mb-4 row">
                                    <div class="col-md-12">
                                        <label class="form-label">Data Item</label>
                                        @php
                                            $items = '';
                                            foreach ($detail->productManual as $item) {
                                                $items .= $item->item . PHP_EOL;
                                            }
                                        @endphp
                                        <textarea class="form-control" rows="10" readonly>{{ $items }}</textarea>
                                    </div>
                                </div>


                            </div>
                        </div>
                    @endif

                    {{-- <!-- Tipe 2: File Private -->
                    <div class="mb-4 shadow-sm card" id="fileType">
                        <div class="card-body">
                            <h5 class="mb-4">
                                <i class="bi bi-file-earmark-lock"></i> Akses
                                File
                            </h5>

                            <div class="mb-4 row">
                                <div class="col-md-12">
                                    <label class="form-label">Secure Download Link</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                            value="https://secure.link/file-62401" readonly />
                                        <button class="btn btn-outline-secondary" onclick="copyContent(this)">
                                            <i class="bi bi-link-45deg"></i>
                                        </button>
                                        <a href="#" class="btn btn-success">
                                            <i class="bi bi-download"></i>
                                            Download
                                        </a>
                                    </div>
                                    <div class="mt-2 text-muted small">
                                        <span class="me-3"><i class="bi bi-download"></i>
                                            Tersisa 3x download</span>
                                        <span><i class="bi bi-clock"></i>
                                            Kadaluarsa: 24 Juli 2024</span>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i> Link
                                ini bersifat pribadi dan rahasia
                            </div>
                        </div>
                    </div> --}}
                @empty
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> Tidak ada informasi yang ditemukan
                    </div>
                @endforelse
            @endif

        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Aksi Cepat -->
            <div class="mb-4 shadow-sm card">
                <div class="card-body">
                    <h5 class="mb-4">
                        <i class="bi bi-lightning"></i> Aksi
                    </h5>
                    <div class="gap-2 d-grid">
                        @if ($transaction->payment_status == \App\Enums\OrderStatusEnum::Completed)
                            <button class="btn btn-outline-primary">
                                <i class="bi bi-receipt"></i> Invoice
                            </button>
                        @elseif ($transaction->payment_status == \App\Enums\OrderStatusEnum::Unpaid)
                            {{-- show qr code --}}
                            <div class="text-center">
                                <img src="{{ $transaction->payment_qr_url }}" alt="QR Code" class="mb-3 img-fluid" />
                            </div>
                            <a class="btn btn-outline-primary" href="{{ $transaction->payment_url }}">
                                <i class="bi bi-credit-card"></i> Bayar
                            </a>
                        @endif
                        <button class="btn btn-outline-danger">
                            <i class="bi bi-question-circle"></i>
                            Bantuan
                        </button>
                        <a href="{{ route('orders') }}" class="btn btn-outline-secondary" wire:navigate>
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>

            @if ($transaction->payment_status == \App\Enums\OrderStatusEnum::Completed)
                <!-- Informasi Keamanan -->
                <div class="shadow-sm card">
                    <div class="card-body">
                        <h5 class="mb-4">
                            <i class="bi bi-shield-lock"></i> Keamanan
                        </h5>
                        <ul class="small">
                            <li>Jangan bagikan akses ke siapapun</li>
                            <li>Simpan informasi dengan aman</li>
                            <li>Segera lapor jika ada masalah</li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
