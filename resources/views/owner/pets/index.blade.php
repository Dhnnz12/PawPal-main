@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">🐾 Data Hewan Peliharaan</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Kelola profil, riwayat rekam medis, dan vaksinasi hewan kesayangan Anda.</div>
            </div>
            <div>
                <a class="pet-btn pet-btn-primary" href="{{ route('pets.create') }}">➕ Tambah Hewan</a>
            </div>
        </div>

        <div class="row g-4">
            @forelse($pets as $pet)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="pet-card p-4 h-100 d-flex flex-column justify-content-between">
                        {{-- Pet Image/Avatar --}}
                        <div class="mb-3 d-flex justify-content-center">
                            <div style="width: 100px; height: 100px; border-radius: 20px; background-color: #f5ece2; display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">
                                @if($pet->type === 'Dog')
                                    🐶
                                @elseif($pet->type === 'Cat')
                                    🐱
                                @elseif($pet->type === 'Rabbit')
                                    🐰
                                @elseif($pet->type === 'Hamster')
                                    🐹
                                @elseif($pet->type === 'Sugar Glider')
                                    🦌
                                @else
                                    🐾
                                @endif
                            </div>
                        </div>

                        {{-- Pet Info --}}
                        <div class="mb-3 text-center">
                            <h3 class="h5 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">{{ $pet->name }}</h3>
                            <div class="d-flex justify-content-center gap-2 mb-2">
                                <span class="pet-badge pet-badge-peach">{{ $pet->type ?? '-' }}</span>
                                @if($pet->breed)
                                    <span class="pet-badge pet-badge-sage">{{ $pet->breed }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Pet Stats --}}
                        <div class="mb-3" style="background-color: #faf6f0; padding: 12px 16px; border-radius: 15px;">
                            <div class="row g-2 text-center">
                                <div class="col-6">
                                    <div class="small fw-semibold text-muted">Umur</div>
                                    <p class="small fw-bold mb-0" style="color: var(--ink);">{{ $pet->age ?? '-' }} tahun</p>
                                </div>
                                <div class="col-6">
                                    <div class="small fw-semibold text-muted">Berat</div>
                                    <p class="small fw-bold mb-0" style="color: var(--ink);">{{ $pet->weight ?? '-' }} kg</p>
                                </div>
                            </div>
                        </div>

                        {{-- Health Notes --}}
                        @if($pet->health_notes)
                            <div class="mb-3">
                                <label class="small fw-semibold text-muted mb-1 d-block">📝 Catatan Kesehatan</label>
                                <p class="small mb-0" style="color: var(--ink);">{{ $pet->health_notes }}</p>
                            </div>
                        @endif

                        {{-- Actions --}}
                        <div class="d-flex gap-2">
                            <a href="{{ route('pets.show', $pet) }}" class="pet-btn pet-btn-outline flex-grow-1 py-2" style="font-size: 0.85rem;">Detail</a>
                            <a href="{{ route('pets.edit', $pet) }}" class="pet-btn pet-btn-primary flex-grow-1 py-2" style="font-size: 0.85rem;">Edit</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="pet-card p-5 text-center">
                        <span class="fs-1 d-block mb-3">🐾</span>
                        <p class="mb-3" style="color: var(--ink); font-weight: 600;">Belum ada data hewan peliharaan</p>
                        <p class="small text-muted mb-4">Silakan tambahkan hewan peliharaan Anda terlebih dahulu untuk memulai</p>
                        <a href="{{ route('pets.create') }}" class="pet-btn pet-btn-primary">➕ Tambah Hewan Pertama Anda</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection


