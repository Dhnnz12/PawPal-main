@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2" style="max-width: 680px; margin: 0 auto;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Edit Alamat: {{ $address->label }} 📍</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Perbarui detail alamat dan koordinat penjemputan/layanan.</div>
            </div>
            <div>
                <a class="pet-btn pet-btn-outline" href="{{ route('addresses.index') }}">⬅️ Daftar Alamat</a>
            </div>
        </div>

        <div class="pet-card p-4">
            <form method="POST" action="{{ route('addresses.update', $address) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: var(--ink);">Label Alamat</label>
                    <input class="form-control pet-input w-100" type="text" name="label" value="{{ old('label', $address->label) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: var(--ink);">Alamat Lengkap</label>
                    <textarea class="form-control pet-input w-100" name="address_line" rows="3" required>{{ old('address_line', $address->address_line) }}</textarea>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: var(--ink);">Kota</label>
                            <input class="form-control pet-input w-100" type="text" name="city" value="{{ old('city', $address->city) }}" required>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: var(--ink);">Latitude</label>
                            <input class="form-control pet-input w-100" type="text" name="latitude" value="{{ old('latitude', $address->latitude) }}">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: var(--ink);">Longitude</label>
                            <input class="form-control pet-input w-100" type="text" name="longitude" value="{{ old('longitude', $address->longitude) }}">
                        </div>
                    </div>
                </div>

                <div class="mb-4 form-check py-2">
                    <input type="checkbox" class="form-check-input" name="is_primary" id="is_primary" value="1" {{ old('is_primary', $address->is_primary) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold small" for="is_primary" style="color: var(--ink); margin-left: 8px;">Jadikan alamat utama pengiriman</label>
                </div>

                <button class="pet-btn pet-btn-primary w-100 py-3" type="submit">Perbarui Alamat ✨</button>
            </form>

            <form method="POST" action="{{ route('addresses.destroy', $address) }}" class="mt-3" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alamat ini?');">
                @csrf
                @method('DELETE')
                <button class="pet-btn pet-btn-secondary w-100 py-3" type="submit" style="background-color: #fcece6; color: #c06c48; border-color: transparent;">Hapus Alamat Ini 🗑️</button>
            </form>
        </div>
    </div>
@endsection
