@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-4 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Histori Rekam Medis 🏥</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif; max-width: 500px;">Lihat semua riwayat pemeriksaan kesehatan dan rekam medis hewan peliharaan Anda.</div>
            </div>
            <div>
                <a class="pet-btn pet-btn-outline" href="{{ route('owner.dashboard') }}">← Kembali ke Dashboard</a>
            </div>
        </div>

        @forelse($petsMedicalRecords as $petName => $records)
            <div class="mb-4">
                <h4 class="h5 mb-3" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">🐾 {{ $petName }}</h4>
                
                <div class="row g-3">
                    @forelse($records as $record)
                        <div class="col-12 col-md-6">
                            <div class="pet-card p-4 h-100">
                                <div class="mb-3">
                                    <span class="pet-badge pet-badge-sage">{{ $record->visit_date->format('d M Y') }}</span>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="small fw-semibold text-muted mb-1 d-block">Dokter Hewan</label>
                                    <div class="fw-bold" style="color: var(--ink);">Dr. {{ $record->vet->name ?? 'Unknown' }}</div>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-semibold text-muted mb-1 d-block">Diagnosis</label>
                                    <p class="small mb-0" style="color: var(--ink);">{{ $record->diagnosis }}</p>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-semibold text-muted mb-1 d-block">Tindakan Medis</label>
                                    <p class="small mb-0" style="color: var(--ink);">{{ $record->treatment }}</p>
                                </div>

                                @if($record->notes)
                                    <div class="mb-3">
                                        <label class="small fw-semibold text-muted mb-1 d-block">Catatan Tambahan</label>
                                        <p class="small mb-0" style="color: var(--ink);">{{ $record->notes }}</p>
                                    </div>
                                @endif

                                @if($record->pdf_path)
                                    <div>
                                        <label class="small fw-semibold text-muted mb-1 d-block">Lampiran</label>
                                        <a href="{{ asset('storage/' . $record->pdf_path) }}" target="_blank" class="pet-btn pet-btn-outline py-2 px-3" style="font-size: 0.85rem;">
                                            📎 Unduh Berkas PDF
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="pet-card p-4 text-center text-muted small">
                                Belum ada rekam medis untuk hewan ini
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="pet-card p-4">
                <div class="text-center text-muted py-5">
                    <span class="fs-2 d-block mb-2">🏥</span>
                    <p class="mb-0">Belum ada rekam medis kesehatan untuk hewan peliharaan Anda</p>
                </div>
            </div>
        @endforelse
    </div>
@endsection
