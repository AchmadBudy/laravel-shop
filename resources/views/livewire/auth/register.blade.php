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
                    <form>
                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" class="form-control form-control-lg" placeholder="nama@email.com"
                                required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-lg" placeholder="••••••••"
                                    id="regPassword" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="toggleRegPassword()">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control form-control-lg" placeholder="••••••••" required>
                        </div>

                        <!-- Terms -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    Saya setuju dengan <a href="#" class="text-decoration-none">Syarat &
                                        Ketentuan</a>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="mb-3 btn btn-primary btn-lg w-100">
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

<script></script>
