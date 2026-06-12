@extends('layouts.dashboard')

@section('dashboard_content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2 class="mb-4">✏️ Edit Profil Saya</h2>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <form method="POST" action="/profile" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control rounded-3 @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control rounded-3 @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Nomor Telepon</label>
                            <input type="tel" class="form-control rounded-3 @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div class="mb-3">
                            <label for="bio" class="form-label fw-bold">Biodata</label>
                            <textarea class="form-control rounded-3 @error('bio') is-invalid @enderror" 
                                      id="bio" name="bio" rows="4">{{ old('bio', Auth::user()->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Avatar Upload -->
                        <div class="mb-4">
                            <label for="avatar" class="form-label fw-bold">Foto Profil</label>
                            <input type="file" class="form-control rounded-3 @error('avatar') is-invalid @enderror" 
                                   id="avatar" name="avatar" accept="image/*">
                            @if(Auth::user()->avatar)
                                <small class="text-muted d-block mt-2">Foto saat ini: {{ Auth::user()->avatar }}</small>
                            @endif
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Change Password Section -->
                        <hr class="my-4">
                        <h5 class="mb-3">🔐 Ubah Kata Sandi (Opsional)</h5>
                        <p class="text-muted small">Kosongkan jika tidak ingin mengubah kata sandi</p>

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold">Kata Sandi Saat Ini</label>
                            <input type="password" class="form-control rounded-3 @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Kata Sandi Baru</label>
                            <input type="password" class="form-control rounded-3 @error('password') is-invalid @enderror" 
                                   id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" class="form-control rounded-3" 
                                   id="password_confirmation" name="password_confirmation">
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-lg rounded-3 px-4 me-2" 
                                    style="background-color: #c06c48; color: white; border: none;">
                                💾 Simpan Perubahan
                            </button>
                            <a href="{{ route('profile.index') }}" class="btn btn-outline-secondary btn-lg rounded-3 px-4">
                                ❌ Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
