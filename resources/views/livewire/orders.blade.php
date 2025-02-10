<div class="container pt-5 mt-5">
    <div class="row g-4">
        <!-- Filter Pesanan -->
        <div class="col-md-3">
            <div class="shadow-sm card">
                <div class="card-body">
                    <h5 class="mb-4">Filter Pesanan</h5>

                    <!-- Cari Nomor Transaksi -->
                    <div class="mb-4">
                        <label class="form-label">Cari Nomor Transaksi</label>
                        <input type="text" class="form-control" placeholder="TRX-123456" />
                    </div>

                    <!-- Filter Tanggal -->
                    <div class="mb-4">
                        <label class="form-label">Rentang Tanggal</label>
                        <div class="mb-3 input-group">
                            <input type="date" class="form-control" aria-label="Dari tanggal"
                                wire:model.live='startDate' />
                        </div>
                        <div class="input-group">
                            <input type="date" class="form-control" aria-label="Sampai tanggal"
                                wire:model.live='endDate' />
                        </div>
                    </div>

                    <!-- Status Pesanan -->
                    <div class="mb-4">
                        <label class="form-label">Status Pesanan</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="status1" value="all"
                                wire:model.live='status' />
                            <label class="form-check-label" for="status1">Semua</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="status2" value="completed"
                                wire:model.live='status' />
                            <label class="form-check-label text-success" for="status2">Selesai</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="status3" value="all"
                                wire:model.live='status' />
                            <label class="form-check-label text-warning" for="status3">Proses</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" id="status4" value="all"
                                wire:model.live='status' />
                            <label class="form-check-label text-danger" for="status4">Dibatalkan</label>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100">
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </div>

        <!-- Daftar Pesanan -->
        <div class="col-md-9">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <h4>Daftar Pesanan</h4>
            </div>

            <div wire:loading wire:target="status,search,startDate,endDate">
                <div class="p-3 d-flex align-items-center justify-content-center">
                    <div class="spinner-border spinner-border-sm text-primary me-2">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span>Memuat data...</span>
                </div>
            </div>

            <div wire:target="status,search,startDate,endDate" wire:loading.remove>
                <!-- Pesanan 1 -->
                @forelse ($orders as $order)
                    <div class="mb-3 shadow-sm card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <small class="text-muted">No. Transaksi</small>
                                    <h6>{{ $order->invoice_number }}</h6>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted">Tanggal</small>
                                    <h6>{{ $order->created_at->format('d M Y') }}</h6>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted">Items</small>
                                    <div class="d-flex">
                                        @foreach ($order->transactionDetails as $detail)
                                            <img src="{{ asset('storage/' . $detail->product->image) }}"
                                                class="rounded me-2" alt="{{ $detail->product->name }}"
                                                style="width:50px" />
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <small class="text-muted">Total</small>
                                    <h6>Rp {{ Number::format($order->total_payment, locale: 'id') }}</h6>
                                </div>
                                <div class="col-md-2">
                                    <div class="d-flex flex-column align-items-end">
                                        <span
                                            class="badge bg-{{ $order->payment_status->getBootstrapColor() }}">{{ $order->payment_status->getLabel() }}</span>
                                        <a href="{{ route('order.detail', $order) }}" class="mt-2 btn btn-link"
                                            wire:navigate>Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        Tidak ada pesanan
                    </div>
                @endforelse
            </div>

            {{-- <!-- Pesanan 2 -->
            <div class="mb-3 shadow-sm card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <small class="text-muted">No. Transaksi</small>
                            <h6>TRX-23050102</h6>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">Tanggal</small>
                            <h6>02 Mei 2023</h6>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Items</small>
                            <div class="d-flex">
                                <img src="https://via.placeholder.com/50" class="rounded me-2" alt="Produk" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">Total</small>
                            <h6>Rp 750.000</h6>
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex flex-column align-items-end">
                                <span class="badge bg-warning text-dark">Proses</span>
                                <a href="detail-pesanan.html" class="mt-2 btn btn-link">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pesanan 3 -->
            <div class="mb-3 shadow-sm card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <small class="text-muted">No. Transaksi</small>
                            <h6>TRX-23050103</h6>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">Tanggal</small>
                            <h6>03 Mei 2023</h6>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted">Items</small>
                            <div class="d-flex">
                                <img src="https://via.placeholder.com/50" class="rounded me-2" alt="Produk" />
                                <img src="https://via.placeholder.com/50" class="rounded me-2" alt="Produk" />
                                <img src="https://via.placeholder.com/50" class="rounded me-2" alt="Produk" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted">Total</small>
                            <h6 class="text-danger">Rp 2.150.000</h6>
                        </div>
                        <div class="col-md-2 text-end">
                            <span class="badge bg-danger">Dibatalkan</span>
                            <a href="detail-pesanan.html" class="mt-2 btn btn-link">Detail</a>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                {{ $orders->links() }}
                {{-- <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Previous</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul> --}}
            </nav>
        </div>
    </div>
</div>
