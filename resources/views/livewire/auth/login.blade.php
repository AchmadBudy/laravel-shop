<div class="container">
    <div class="row justify-content-center min-vh-100 align-items-center">
        <div class="col-md-6 col-lg-5">
            <div class="shadow-sm card">
                <div class="p-4 card-body">
                    <!-- Logo -->
                    <div class="mb-4 text-center">
                        <h2 class="fw-bold text-primary">{{ config('app.name') }}</h2>
                        <p class="text-muted">Masuk ke akun Anda</p>
                    </div>

                    <!-- Alert -->
                    @error('email')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @enderror

                    <!-- Form Login -->
                    <form wire:submit="login">
                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" class="form-control form-control-lg" placeholder="nama@email.com"
                                required wire:model="email">
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg" placeholder="••••••••"
                                    id="password" required wire:model="password">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" wire:model="remember">
                                <label class="form-check-label" for="remember">Ingat saya</label>
                            </div>
                            <a href="#" class="text-decoration-none">Lupa password?</a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="mb-3 btn btn-primary btn-lg w-100">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk
                        </button>

                        <!-- Register Link -->
                        <div class="text-center">
                            <span class="text-muted">Belum punya akun?</span>
                            <a href="{{ route('register') }}" class="text-decoration-none" wire:navigate>Daftar
                                sekarang</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('password');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
    }
</script>
