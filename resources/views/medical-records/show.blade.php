@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2" style="max-width: 700px; margin: 0 auto;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
             <div>
                 <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">🏥 Detail Rekam Medis</h1>
                 <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Pemeriksaan kesehatan terperinci untuk hewan peliharaan Anda.</div>
             </div>
             <div>
                 <a class="pet-btn pet-btn-outline" href="{{ url()->previous() ?: route('medical-records.index') }}">← Kembali</a>
             </div>
        </div>

        <div class="pet-card p-4">
            <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                <div>
                    <h3 class="h5 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">🐾 {{ $record->pet->name ?? '-' }}</h3>
                    <p class="small text-muted mb-0">Spesies: {{ $record->pet->type ?? '-' }}</p>
                </div>
                <div class="text-end">
                    <span class="pet-badge pet-badge-sage">{{ $record->visit_date ? $record->visit_date->format('d M Y') : now()->format('d M Y') }}</span>
                </div>
            </div>

            <div class="mb-4">
                <label class="small fw-semibold text-muted mb-1 d-block">Dokter Hewan Pemeriksa</label>
                <p class="fw-bold fs-6" style="color: var(--ink);">Dr. {{ $record->vet->name ?? 'Unknown' }}</p>
            </div>

            <div class="mb-4">
                <label class="small fw-semibold text-muted mb-1 d-block">Diagnosis Penyakit</label>
                <div class="p-3 rounded" style="background-color: #faf6f0; border: 1.5px solid var(--color-warm-border); line-height: 1.6;">
                    {{ $record->diagnosis }}
                </div>
            </div>

            <div class="mb-4">
                <label class="small fw-semibold text-muted mb-1 d-block">Tindakan Medis / Pengobatan</label>
                <div class="p-3 rounded" style="background-color: #faf6f0; border: 1.5px solid var(--color-warm-border); line-height: 1.6;">
                    {{ $record->treatment }}
                </div>
            </div>

            @if($record->notes)
                <div class="mb-4">
                    <label class="small fw-semibold text-muted mb-1 d-block">Rekomendasi & Catatan Tambahan</label>
                    <p class="mb-0" style="color: var(--ink);">{{ $record->notes }}</p>
                </div>
            @endif

            @if($record->pdf_path)
                <div class="mb-4">
                    <label class="small fw-semibold text-muted mb-1 d-block">Dokumen Lampiran</label>
                    <div class="p-3 rounded d-flex align-items-center justify-content-between" style="background-color: var(--bg-gold); border: 1.5px solid var(--color-warm-border);">
                        <span class="small" style="font-weight: 600; color: #925c27;">📎 Hasil Laboratorium / Rekomendasi (PDF)</span>
                        <a href="{{ asset('storage/' . $record->pdf_path) }}" target="_blank" class="pet-btn pet-btn-primary py-1 px-3" style="font-size: 0.85rem;">Unduh PDF</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
