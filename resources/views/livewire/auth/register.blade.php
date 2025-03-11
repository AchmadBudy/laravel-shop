<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6 col-lg-5">
            <div class="shadow-sm card">
                <div class="p-4 card-body">
                    <!-- Logo -->
                    <div class="mb-4 text-center">
                        <h2 class="fw-bold text-primary">{{ config('app.name') }}</h2>
                        <p class="text-muted">Buat akun baru</p>
                    </div>

                    <!-- Form Register -->
                    <form wire:submit="register">
                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                placeholder="nama@email.com" required wire:model="email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text"
                                class="form-control form-control-lg @error('name') is-invalid @enderror"
                                placeholder="Nama Lengkap" required wire:model="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    placeholder="••••••••" id="regPassword" required wire:model="password">
                                <button class="btn btn-outline-secondary" type="button" onclick="toggleRegPassword()">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password"
                                class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                placeholder="••••••••" required wire:model="password_confirmation"
                                id="password_confirmation">
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="mb-3 btn btn-primary btn-lg w-100" wire:loading.attr="disabled">
                            <i class="bi bi-person-plus"></i> Daftar
                        </button>

                        <!-- Login Link -->
                        <div class="text-center">
                            <span class="text-muted">Sudah punya akun?</span>
                            <a href="{{ route('login') }}" class="text-decoration-none" wire:navigate>Masuk disini</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleRegPassword() {
        const password = document.getElementById('regPassword');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
    }

    function toggleRegPasswordConfirmation() {
        const password = document.getElementById('password_confirmation');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
    }
</script>
