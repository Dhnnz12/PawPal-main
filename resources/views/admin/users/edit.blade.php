@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">📝 Edit Pengguna</h1>
                <div class="small text-muted">Ubah informasi akun dan pengaturan peran untuk pengguna: <strong>{{ $user->name }}</strong>.</div>
            </div>
            <a class="pet-btn pet-btn-outline" href="{{ route('admin.users.index') }}">← Kembali</a>
        </div>

        {{-- Error feedback --}}
        @if ($errors->any())
            <div class="alert alert-danger border-0 mb-4" style="background-color: #fcece6; color: #b05634; border-radius: 16px; font-weight: 500;">
                <h5 class="h6 fw-bold mb-2">⚠️ Harap perbaiki kesalahan berikut:</h5>
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Edit Form --}}
        <div class="pet-card p-4">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    {{-- 1. Nama & Email --}}
                    <div class="col-12 col-md-6 d-flex flex-column">
                        <label for="name" class="small fw-semibold text-muted mb-2">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="pet-input" placeholder="Masukkan nama lengkap" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="col-12 col-md-6 d-flex flex-column">
                        <label for="email" class="small fw-semibold text-muted mb-2">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="pet-input" placeholder="contoh@petcare.com" value="{{ old('email', $user->email) }}" required>
                    </div>

                    {{-- 2. Password & Telepon --}}
                    <div class="col-12 col-md-6 d-flex flex-column" id="password_container">
                        <label for="password" class="small fw-semibold text-muted mb-2">Kata Sandi (Password)</label>
                        <input type="password" name="password" id="password" class="pet-input" placeholder="Biarkan kosong jika tidak diubah">
                    </div>
                    <div class="col-12 col-md-6 d-flex flex-column">
                        <label for="phone" class="small fw-semibold text-muted mb-2">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone" class="pet-input" placeholder="Contoh: 081234567890" value="{{ old('phone', $user->phone) }}" required>
                    </div>

                    {{-- 3. Bio --}}
                    <div class="col-12 d-flex flex-column">
                        <label for="bio" class="small fw-semibold text-muted mb-2">Bio / Deskripsi Profil</label>
                        <textarea name="bio" id="bio" rows="3" class="pet-input" style="border-radius: 18px;" placeholder="Tuliskan bio atau catatan tambahan...">{{ old('bio', $user->bio) }}</textarea>
                    </div>

                    {{-- 4. Role Selection --}}
                    <div class="col-12 col-md-6 d-flex flex-column">
                        <label for="role" class="small fw-semibold text-muted mb-2">Peran Pengguna (Role) <span class="text-danger">*</span></label>
                        <select name="role" id="role" class="pet-input" required onchange="toggleRoleFields(this.value)">
                            <option value="pet_owner" {{ old('role', $user->role) === 'pet_owner' ? 'selected' : '' }}>🐾 Pet Owner</option>
                            <option value="service_provider" {{ old('role', $user->role) === 'service_provider' ? 'selected' : '' }}>🛠️ Tenaga Klinik</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>🛡️ Admin</option>
                        </select>
                    </div>

                    {{-- 5. Avatar --}}
                    <div class="col-12 col-md-6 d-flex flex-column">
                        <label for="avatar" class="small fw-semibold text-muted mb-2">Foto Profil (Avatar)</label>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Current Avatar" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 1.5px solid #eadacb;">
                                <span class="small text-muted">Akan menggantikan foto saat ini.</span>
                            @else
                                <div style="width: 50px; height: 50px; border-radius: 50%; background-color: var(--bg-peach); border: 1.5px solid #eadacb; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">👤</div>
                                <span class="small text-muted">Belum ada foto profil.</span>
                            @endif
                        </div>
                        <input type="file" name="avatar" id="avatar" class="pet-input" accept="image/*">
                    </div>

                    {{-- Dynamically Shown: Service Provider Fields --}}
                    <div class="col-12" id="provider_fields" style="display: none;">
                        <div class="p-3 mb-2 rounded-4" style="background-color: var(--bg-peach); border: 1.5px solid #eadacb;">
                            <h3 class="h6 mb-3 fw-bold" style="color: var(--ink);">🛠️ Form Wajib Khusus Tenaga Klinik</h3>
                            <div class="row g-3">
                                <div class="col-12 col-md-6 d-flex flex-column">
                                    <label for="provider_type" class="small fw-semibold text-muted mb-2">Tipe Layanan <span class="text-danger">*</span></label>
                                    <select name="provider_type" id="provider_type" class="pet-input" onchange="toggleCertField(this.value)">
                                        <option value="groomer" {{ old('provider_type', $user->provider_type) === 'groomer' ? 'selected' : '' }}>✨ Groomer (Grooming)</option>
                                        <option value="veterinarian" {{ old('provider_type', $user->provider_type) === 'veterinarian' ? 'selected' : '' }}>🩺 Dokter Hewan</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 d-flex flex-column" id="certification_field" style="display: none;">
                                    <label for="certification" class="small fw-semibold text-muted mb-2">Dokumen Sertifikasi / Izin Praktek</label>
                                    @if($user->certification)
                                        <div class="mb-2">
                                            <a href="{{ asset('storage/' . $user->certification) }}" target="_blank" class="small fw-bold text-decoration-none" style="color: var(--secondary);">
                                                📄 Lihat Sertifikat Saat Ini
                                            </a>
                                        </div>
                                    @endif
                                    <input type="file" name="certification" id="certification" class="pet-input">
                                    <div class="small text-muted mt-1">Format: PDF, JPG, PNG (maks. 5MB).</div>
                                </div>
                                <div class="col-12 col-md-6 d-flex flex-column">
                                    <label for="is_verified" class="small fw-semibold text-muted mb-2">Status Verifikasi <span class="text-danger">*</span></label>
                                    <select name="is_verified" id="is_verified" class="pet-input">
                                        <option value="1" {{ old('is_verified', $user->is_verified ? '1' : '0') === '1' ? 'selected' : '' }}>Verified (Terverifikasi)</option>
                                        <option value="0" {{ old('is_verified', $user->is_verified ? '1' : '0') === '0' ? 'selected' : '' }}>Unverified (Belum Terverifikasi)</option>
                                    </select>
                                    <div class="small text-muted mt-1">Tenaga klinik memerlukan verifikasi admin untuk menerima booking.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 6. Statuses: Active Only for all roles --}}
                    <div class="col-12 col-md-6 d-flex flex-column">
                        <label for="is_active" class="small fw-semibold text-muted mb-2">Status Keaktifan Akun <span class="text-danger">*</span></label>
                        <select name="is_active" id="is_active" class="pet-input" required>
                            <option value="1" {{ old('is_active', $user->is_active ? '1' : '0') === '1' ? 'selected' : '' }}>Aktif (Enabled)</option>
                            <option value="0" {{ old('is_active', $user->is_active ? '1' : '0') === '0' ? 'selected' : '' }}>Nonaktif (Suspended / Disabled)</option>
                        </select>
                        <div class="small text-muted mt-1">Akun yang dinonaktifkan tidak dapat login atau melakukan pemesanan.</div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex gap-3 justify-content-end">
                    <a href="{{ route('admin.users.index') }}" class="pet-btn pet-btn-outline">Batal</a>
                    <button type="submit" class="pet-btn pet-btn-primary">Perbarui Pengguna</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script untuk mengontrol tampilan input dinamis --}}
    <script>
        function toggleRoleFields(role) {
            const providerFields = document.getElementById('provider_fields');
            const passwordContainer = document.getElementById('password_container');
            if (role === 'service_provider') {
                providerFields.style.display = 'block';
                if (passwordContainer) {
                    passwordContainer.classList.add('d-none');
                    passwordContainer.classList.remove('d-flex');
                }
                // Trigger type change check
                toggleCertField(document.getElementById('provider_type').value);
            } else {
                providerFields.style.display = 'none';
                if (passwordContainer) {
                    passwordContainer.classList.remove('d-none');
                    passwordContainer.classList.add('d-flex');
                }
            }
        }

        function toggleCertField(type) {
            const certField = document.getElementById('certification_field');
            if (type === 'veterinarian') {
                certField.style.display = 'block';
            } else {
                certField.style.display = 'none';
            }
        }

        // Initialize display state on load
        document.addEventListener('DOMContentLoaded', function() {
            toggleRoleFields(document.getElementById('role').value);
        });
    </script>
@endsection
