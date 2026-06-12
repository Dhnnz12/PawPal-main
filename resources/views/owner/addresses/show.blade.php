@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2" style="max-width: 600px; margin: 0 auto;">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Detail Alamat 📍</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Informasi lengkap alamat Anda.</div>
            </div>
            <a class="pet-btn pet-btn-outline" href="{{ route('addresses.index') }}">← Kembali</a>
        </div>

        <div class="pet-card p-4">
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <h4 class="h5 mb-0" style="color: var(--ink); font-weight: 700;">{{ $address->label }}</h4>
                @if($address->is_primary)
                    <span class="pet-badge pet-badge-sage">Alamat Utama</span>
                @endif
            </div>

            <hr style="border-color: var(--color-warm-border);">

            <div class="mb-3">
                <label class="small text-muted fw-bold d-block mb-1">Alamat Lengkap</label>
                <p class="mb-0" style="color: var(--ink);">{{ $address->address_line }}</p>
            </div>

            <div class="mb-3">
                <label class="small text-muted fw-bold d-block mb-1">Kota / Kabupaten</label>
                <p class="mb-0" style="color: var(--ink);">{{ $address->city }}</p>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-6">
                    <label class="small text-muted fw-bold d-block mb-1">Latitude</label>
                    <p class="mb-0" style="color: var(--ink);">{{ $address->latitude ?? '-' }}</p>
                </div>
                <div class="col-6">
                    <label class="small text-muted fw-bold d-block mb-1">Longitude</label>
                    <p class="mb-0" style="color: var(--ink);">{{ $address->longitude ?? '-' }}</p>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('addresses.edit', $address) }}" class="pet-btn pet-btn-primary flex-grow-1 text-center text-decoration-none">✏️ Edit Alamat</a>
                <form action="{{ route('addresses.destroy', $address) }}" method="POST" class="flex-grow-1 m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="pet-btn w-100" style="background-color: #ffe5e5; color: #d32f2f; border: none;" onclick="return confirm('Yakin ingin menghapus alamat ini?')">🗑️ Hapus</button>
                </form>
            </div>
        </div>
    </div>
@endsection
