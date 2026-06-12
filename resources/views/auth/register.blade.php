@extends('layouts.app')

@section('content')
    <div class="py-5 d-flex align-items-center justify-content-center">
        <div class="pet-card p-5 shadow-sm" style="max-width: 520px; width: 100%; border-radius: 28px; background-color: #ffffff;">
            <div class="text-center mb-4">
                <span class="fs-1 mb-2 d-inline-block">🐾</span>
                <h2 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">Daftar Akun PawPal</h2>
                <p class="text-muted small">Buat akun baru untuk memulai menggunakan PawPal.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: #4e3629;">Nama Lengkap</label>
                    <input class="form-control pet-input w-100" type="text" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap" style="height: 50px;">
                    @error('name')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: #4e3629;">Email atau No. Telepon</label>
                    <input class="form-control pet-input w-100" type="email" name="email" value="{{ old('email') }}" required placeholder="Masukkan email atau nomor" style="height: 50px;">
                    @error('email')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: #4e3629;">Password</label>
                    <input class="form-control pet-input w-100" type="password" name="password" required placeholder="Buat password" style="height: 50px;">
                    @error('password')
                        <small class="text-danger mt-1 d-block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: #4e3629;">Konfirmasi Password</label>
                    <input class="form-control pet-input w-100" type="password" name="password_confirmation" required placeholder="Ulangi password" style="height: 50px;">
                </div>

                <input type="hidden" name="role" value="pet_owner">

                <button class="pet-btn pet-btn-primary w-100 py-3 mt-2" type="submit" style="font-size: 1.05rem;">
                    Daftar
                </button>
            </form>

            <div class="text-center mt-3 pt-3 border-top">
                <p class="small mb-0 text-muted">
                    Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #d48c6a;">Masuk di sini</a>
                </p>
            </div>
        </div>
    </div>
@endsection
