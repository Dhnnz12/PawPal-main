@extends('layouts.app')

@section('content')
    <div class="py-5 d-flex align-items-center justify-content-center">
        <div class="pet-card p-5 shadow-sm" style="max-width: 480px; width: 100%; border-radius: 28px; background-color: #ffffff;">
            <div class="text-center mb-4">
                <span class="fs-1 mb-2 d-inline-block">🐾</span>
                <h2 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">Masuk ke PawPal</h2>
                <p class="text-muted small">Selamat datang kembali! Silakan masuk ke akun Anda.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: #4e3629;">Email atau No. Telepon</label>
                    <input class="form-control pet-input w-100" type="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan email atau nomor" style="height: 50px;">
                    @error('email')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label fw-semibold mb-0" style="color: #4e3629;">Password</label>
                        <a href="#" class="small text-decoration-none" style="color: #d48c6a;">Lupa password?</a>
                    </div>
                    <input class="form-control pet-input w-100" type="password" name="password" required placeholder="Masukkan password" style="height: 50px;">
                    @error('password')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <button class="pet-btn pet-btn-primary w-100 py-3 mb-0" type="submit" style="font-size: 1.05rem;">
                    Masuk
                </button>
            </form>

            <div class="text-center mt-3 pt-3 border-top">
                <p class="small mb-0 text-muted">
                    Belum punya akun? <a href="{{ route('register') }}" class="fw-bold text-decoration-none" style="color: #d48c6a;">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>
@endsection
