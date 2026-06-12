@extends('layouts.app')

@section('content')
    <div class="py-2" style="max-width: 600px; margin: 0 auto;">
        <div class="mb-4">
            <a href="{{ route('addresses.index') }}" class="text-decoration-none" style="color: var(--primary); font-weight: 600;">← Kembali ke Alamat</a>
            <h1 class="h3 mt-2 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">✏️ Edit Alamat</h1>
            <p class="text-muted small" style="font-family: 'Outfit', sans-serif;">Perbarui data alamat Anda.</p>
        </div>

        <div class="pet-card p-4">
            <form method="POST" action="{{ route('addresses.update', $address) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: var(--ink);">Label Alamat *</label>
                    <input class="form-control pet-input" type="text" name="label" value="{{ old('label', $address->label) }}" required placeholder="Contoh: Rumah, Kantor">
                    @error('label')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: var(--ink);">Alamat Lengkap *</label>
                    <textarea class="form-control pet-input" name="address_line" required rows="3">{{ old('address_line', $address->address_line) }}</textarea>
                    @error('address_line')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Kota</label>
                        <input class="form-control pet-input" type="text" name="city" value="{{ old('city', $address->city) }}">
                        @error('city')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Provinsi</label>
                        <input class="form-control pet-input" type="text" name="province" value="{{ old('province', $address->province) }}">
                        @error('province')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: var(--ink);">Kode Pos</label>
                    <input class="form-control pet-input" type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code) }}">
                    @error('postal_code')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Latitude *</label>
                        <input class="form-control pet-input" type="text" name="latitude" value="{{ old('latitude', $address->latitude) }}" required>
                        @error('latitude')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Longitude *</label>
                        <input class="form-control pet-input" type="text" name="longitude" value="{{ old('longitude', $address->longitude) }}" required>
                        @error('longitude')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default', $address->is_default) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="is_default" style="color: var(--ink);">
                            Jadikan sebagai alamat utama
                        </label>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button class="pet-btn pet-btn-primary flex-grow-1 py-3" type="submit">💾 Simpan Perubahan</button>
                    <a href="{{ route('addresses.index') }}" class="pet-btn pet-btn-outline flex-grow-1 py-3">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
