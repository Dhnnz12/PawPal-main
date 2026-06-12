@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2" style="max-width: 760px; margin: 0 auto;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Detail Hewan 🐾</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Lihat informasi profil hewan peliharaan Anda.</div>
            </div>
            <div class="d-flex gap-2">
                <a class="pet-btn pet-btn-outline" href="{{ route('pets.index') }}">⬅️ Kembali</a>
                <a class="pet-btn pet-btn-primary" href="{{ route('pets.edit', $pet) }}">✏️ Edit</a>
            </div>
        </div>

        <div class="pet-card p-4">
            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="nb-photo-mask shadow-sm" style="height: 220px; border-radius: 24px;">
                        @if(!empty($pet->photo))
                            <img src="{{ asset('storage/' . $pet->photo) }}" alt="{{ $pet->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100" style="background:#f7f4ef; color: var(--muted);">
                                <span style="font-size: 48px;">🐶</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-12 col-md-8">
                    <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                        <div>
                            <h2 class="h4 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">{{ $pet->name }}</h2>
                            <div class="small" style="color: var(--muted); font-family: 'Outfit', sans-serif;">{{ $pet->type ?? '-' }}</div>
                        </div>
                        <span class="pet-badge pet-badge-peach">{{ $pet->breed ?? '—' }}</span>
                    </div>

                    <hr class="nb-hr my-4">

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="text-muted small">Usia</div>
                            <div class="fw-bold">{{ $pet->age ?? '-' }}</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="text-muted small">Berat</div>
                            <div class="fw-bold">{{ $pet->weight ?? '-' }}</div>
                        </div>
                        <div class="col-12">
                            <div class="text-muted small">Catatan Kesehatan</div>
                            <div class="fw-semibold">{{ $pet->health_notes ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a class="pet-btn pet-btn-primary w-100 py-3" href="{{ route('pets.edit', $pet) }}">Edit Profil Hewan 🧡</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

