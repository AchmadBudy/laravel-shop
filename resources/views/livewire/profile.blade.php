<div class="container pt-5 mt-5">
    <div class="row">
        <!-- Konten Utama -->
        <div class="mx-auto col-md-8">
            <div class="shadow-sm card">
                <div class="card-body">
                    <!-- Header Profil -->
                    <div class="mb-5 text-center">
                        {{-- <div class="mb-3 avatar">
                            <img src="https://via.placeholder.com/100" class="rounded-circle" alt="Foto Profil" />
                        </div> --}}
                        <h3>{{ auth()->user()->name }}</h3>
                        <p class="text-muted">Member sejak {{ auth()->user()->created_at->year }}</p>
                    </div>


                    @if ($errors->any())
                        <div class="mb-4 alert alert-danger alert-dismissible fade show" role="alert">
                            <h5 class="alert-heading d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Mohon Perhatian!
                            </h5>
                            <hr>
                            <ul class="mb-0 list-unstyled">
                                @foreach ($errors->all() as $error)
                                    <li class="mb-2 d-flex align-items-center">
                                        <i class="bi bi-dot me-2"></i>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Tabs Navigation -->
                    <ul class="mb-4 nav nav-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="email-tab" data-bs-toggle="tab" data-bs-target="#email"
                                type="button" role="tab" aria-controls="email" aria-selected="true">
                                <i class="bi bi-envelope"></i> Email
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="phone-tab" data-bs-toggle="tab" data-bs-target="#phone"
                                type="button" role="tab" aria-controls="phone" aria-selected="false">
                                <i class="bi bi-phone"></i> Nomor HP
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password"
                                type="button" role="tab" aria-controls="password" aria-selected="false">
                                <i class="bi bi-shield-lock"></i>
                                Password
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="profileTabsContent">
                        <!-- Tab Email -->
                        <div class="tab-pane fade show active" id="email" role="tabpanel"
                            aria-labelledby="email-tab">
                            {{-- <form> --}}
                            <div class="mb-3">
                                <label class="form-label">Email Saat Ini</label>
                                <input type="email" class="form-control" value="{{ auth()->user()->email }}"
                                    disabled />
                            </div>

                            {{-- <div class="mb-3">
                                    <label class="form-label">Email Baru</label>
                                    <input type="email" class="form-control" name="new_email" required />
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Simpan Perubahan
                                </button> --}}
                            {{-- </form> --}}
                        </div>

                        <!-- Tab Nomor HP -->
                        <div class="tab-pane fade" id="phone" role="tabpanel" aria-labelledby="phone-tab">
                            <form wire:submit='updatePhone'>
                                <div class="mb-3">
                                    <label class="form-label">Nomor HP Saat Ini</label>
                                    <input type="tel" class="form-control" value="{{ auth()->user()->phone }}"
                                        disabled />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nomor HP Baru</label>
                                    <input type="tel" class="form-control" name="new_phone" pattern="[0-9]{11,13}"
                                        title="Masukkan nomor HP yang valid" required wire:model='newPhone' />
                                    <small class="text-muted">Contoh: 081234567890</small>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Simpan Perubahan
                                </button>
                            </form>
                        </div>

                        <!-- Tab Password -->
                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <form wire:submit='updatePassword'>
                                <div class="mb-3">
                                    <label class="form-label">Password Saat Ini</label>
                                    <input type="password" class="form-control" name="current_password" required
                                        wire:model='oldPassword' />
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" name="new_password" minlength="8"
                                        required wire:model='newPassword' />
                                    <small class="text-muted">Minimal 8 karakter</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" name="confirm_password" required
                                        wire:model='newPassword_confirmation' />
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    Ubah Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
