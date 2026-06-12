@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 border-bottom pb-3">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">Edit Layanan</h1>
                <div class="small text-muted">Perbarui detail layanan Anda.</div>
            </div>
            <a class="pet-btn pet-btn-outline" href="{{ route('admin.services.index') }}">← Kembali</a>
        </div>

        <div class="pet-card p-4" style="border-radius: 22px; border: 1.5px solid var(--color-warm-border);">
            <form method="POST" action="{{ route('services.update', $service) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold small text-muted">Nama Layanan <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control pet-input" value="{{ old('name', $service->name) }}" required>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold small text-muted">Tipe Tenaga Klinik <span class="text-danger">*</span></label>
                        <select name="provider_type" class="form-control pet-input" required>
                            <option value="groomer" {{ old('provider_type', $service->provider_type) === 'groomer' ? 'selected' : '' }}>✨ Groomer (Grooming)</option>
                            <option value="veterinarian" {{ old('provider_type', $service->provider_type) === 'veterinarian' ? 'selected' : '' }}>🩺 Dokter Hewan</option>
                        </select>
                        @error('provider_type')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold small text-muted">Deskripsi (Opsional)</label>
                        <textarea name="description" class="form-control pet-input" rows="4">{{ old('description', $service->description) }}</textarea>
                        @error('description')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold small text-muted">Harga (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control pet-input" value="{{ old('price', $service->price) }}" min="0" step="0.01" required>
                        @error('price')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold small text-muted">Durasi (Menit) <span class="text-danger">*</span></label>
                        <input type="number" name="duration_minutes" class="form-control pet-input" value="{{ old('duration_minutes', $service->duration_minutes) }}" min="1" required>
                        @error('duration_minutes')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="d-flex gap-2 justify-content-end mt-1">
                            <a class="pet-btn pet-btn-outline" href="{{ route('admin.services.index') }}">Batal</a>
                            <button type="submit" class="pet-btn pet-btn-primary" style="padding-left: 18px; padding-right: 18px;">
                                <span class="d-inline-flex align-items-center gap-2"><span>💾</span><span>Simpan Perubahan</span></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

