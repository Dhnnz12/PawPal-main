@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2" style="max-width: 680px; margin: 0 auto;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Tambah Alamat Baru 📍</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Simpan koordinat dan alamat lengkap untuk memudahkan kunjungan provider.</div>
            </div>
            <div>
                <a class="pet-btn pet-btn-outline" href="{{ route('addresses.index') }}">⬅️ Daftar Alamat</a>
            </div>
        </div>

        <div class="pet-card p-4">
            <form method="POST" action="{{ route('addresses.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: var(--ink);">Label Alamat</label>
                    <input class="form-control pet-input w-100" type="text" name="label" value="{{ old('label') }}" required placeholder="Rumah Utama, Kantor, Villa, dll.">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: var(--ink);">Alamat Lengkap</label>
                    <textarea class="form-control pet-input w-100" name="address_line" rows="3" required placeholder="Tuliskan jalan, nomor rumah, blok, RT/RW...">{{ old('address_line') }}</textarea>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: var(--ink);">Kota</label>
                            <input class="form-control pet-input w-100" type="text" name="city" value="{{ old('city') }}" required placeholder="Jakarta Selatan">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: var(--ink);">Latitude (opsional)</label>
                            <input class="form-control pet-input w-100" type="text" name="latitude" value="{{ old('latitude') }}" placeholder="-6.2088">
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: var(--ink);">Longitude (opsional)</label>
                            <input class="form-control pet-input w-100" type="text" name="longitude" value="{{ old('longitude') }}" placeholder="106.8456">
                        </div>
                    </div>
                </div>

                <div class="mb-4 form-check py-2">
                    <input type="checkbox" class="form-check-input" name="is_primary" id="is_primary" value="1" {{ old('is_primary') ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold small" for="is_primary" style="color: var(--ink); margin-left: 8px;">Jadikan alamat utama pengiriman</label>
                </div>

                <button class="pet-btn pet-btn-primary w-100 py-3" type="submit">Simpan Alamat Baru ✨</button>
            </form>
        </div>
    </div>
@endsection
