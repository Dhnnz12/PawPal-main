@extends('layouts.app')

@section('content')
    <div class="py-2">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-4 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">📍 Mapa Lokasi & Alamat Tersimpan</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif; max-width: 500px;">Kelola alamat Anda untuk kemudahan pemesanan layanan berbasis lokasi.</div>
            </div>
            <div class="d-flex gap-2">
                <a class="pet-btn pet-btn-primary" href="{{ route('addresses.create') }}">+ Tambah Alamat Baru</a>
            </div>
        </div>

        <div class="row g-4">
            @forelse($addresses as $address)
                <div class="col-12 col-md-6">
                    <div class="pet-card p-4 h-100">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div>
                                <h3 class="h5 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">{{ $address->label }}</h3>
                                @if($address->is_default)
                                    <span class="pet-badge pet-badge-peach" style="font-size: 0.75rem;">✓ Alamat Utama</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="small mb-2" style="color: var(--ink);">{{ $address->address_line }}</p>
                            @if($address->city)
                                <p class="small text-muted mb-2">
                                    {{ $address->city }}
                                    @if($address->province)
                                        , {{ $address->province }}
                                    @endif
                                    @if($address->postal_code)
                                        {{ $address->postal_code }}
                                    @endif
                                </p>
                            @endif
                        </div>

                        @if($address->latitude && $address->longitude)
                            <div class="small text-muted mb-3 p-2" style="background-color: var(--bg-sage); border-radius: 12px;">
                                📍 Lat: {{ $address->latitude }}, Lon: {{ $address->longitude }}
                            </div>
                        @endif

                        <div class="d-flex gap-2">
                            <a href="{{ route('addresses.edit', $address) }}" class="pet-btn pet-btn-outline flex-grow-1 py-2" style="font-size: 0.85rem;">
                                ✏️ Edit
                            </a>
                            <form method="POST" action="{{ route('addresses.destroy', $address) }}" class="flex-grow-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="pet-btn pet-btn-outline w-100 py-2" style="font-size: 0.85rem; color: #c06c48;" onclick="return confirm('Hapus alamat ini?')">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="pet-card p-4">
                        <div class="text-center text-muted py-5">
                            <span class="fs-2 d-block mb-2">📍</span>
                            <p class="mb-3">Belum ada alamat tersimpan</p>
                            <a href="{{ route('addresses.create') }}" class="pet-btn pet-btn-primary">Tambah Alamat Pertama</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
