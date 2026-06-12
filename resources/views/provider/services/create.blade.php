@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 border-bottom pb-3">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">
                    Tambah Layanan 🧑‍⚕️
                </h1>
                <div class="small text-muted">Isi detail layanan yang akan ditampilkan di katalog.</div>
            </div>
            <a class="pet-btn pet-btn-outline" href="{{ route('admin.services.index') }}">← Kembali</a>
        </div>

        <div class="pet-card p-4" style="border-radius: 22px; border: 1.5px solid var(--color-warm-border);">
            <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
                <div>
                    <div class="pet-badge pet-badge-sage" style="display: inline-flex; align-items: center; gap: 8px;">✨ Form Layanan</div>
                    <div class="small text-muted mt-2">Buat layanan baru agar masuk ke katalog Anda.</div>
                </div>
                <div class="text-muted small" style="font-family: 'Outfit', sans-serif; font-weight: 600;">* Wajib diisi</div>
            </div>

            <form method="POST" action="{{ route('services.store') }}" class="mt-2">
                @csrf

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold small text-muted">Nama Layanan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: #f5f0e9; border-color: var(--color-warm-border);">🧑‍⚕️</span>
                            <input type="text" name="name" class="form-control pet-input" value="{{ old('name') }}" placeholder="Contoh: Grooming Medium" required>
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold small text-muted">Tipe Tenaga Klinik <span class="text-danger">*</span></label>
                        <select name="provider_type" class="form-control pet-input" required>
                            <option value="" disabled selected>Pilih Tipe Tenaga Klinik</option>
                            <option value="groomer" {{ old('provider_type') === 'groomer' ? 'selected' : '' }}>✨ Groomer (Grooming)</option>
                            <option value="veterinarian" {{ old('provider_type') === 'veterinarian' ? 'selected' : '' }}>🩺 Dokter Hewan</option>
                        </select>
                        @error('provider_type')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold small text-muted">Deskripsi (Opsional)</label>
                        <textarea name="description" class="form-control pet-input" rows="4" placeholder="Jelaskan layanan Anda...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold small text-muted">Harga (Rp) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: #f5f0e9; border-color: var(--color-warm-border);">Rp</span>
                            <input type="number" name="price" class="form-control pet-input" value="{{ old('price') }}" min="0" step="0.01" required placeholder="0">
                        </div>
                        @error('price')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold small text-muted">Durasi (Menit) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: #f5f0e9; border-color: var(--color-warm-border);">⏱️</span>
                            <input type="number" name="duration_minutes" class="form-control pet-input" value="{{ old('duration_minutes') }}" min="1" required placeholder="30">
                        </div>
                        @error('duration_minutes')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-2 justify-content-end mt-1">
                            <a class="pet-btn pet-btn-outline" href="{{ route('admin.services.index') }}">
                                Batal
                            </a>
                            <button type="submit" class="pet-btn pet-btn-primary" style="padding-left: 18px; padding-right: 18px;">
                                <span class="d-inline-flex align-items-center gap-2">
                                    <span>💾</span>
                                    <span>Simpan Layanan</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

