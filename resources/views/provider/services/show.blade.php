@extends('layouts.app')

@section('content')
    <div class="py-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 border-bottom pb-3">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">Detail Layanan</h1>
                <div class="small text-muted">Informasi lengkap layanan.</div>
            </div>
            <a class="pet-btn pet-btn-outline" href="{{ route('services.index') }}">← Kembali</a>
        </div>

        <div class="pet-card p-4" style="border-radius: 22px; border: 1.5px solid var(--color-warm-border);">
            <div class="row g-3">
                <div class="col-12">
                    <div class="fw-bold" style="color: var(--ink); font-size: 1.2rem;">{{ $service->name }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="small text-muted">Harga</div>
                    <div class="fw-semibold">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="small text-muted">Durasi</div>
                    <div class="fw-semibold">{{ $service->duration_minutes }} menit</div>
                </div>
                <div class="col-12">
                    <div class="small text-muted mb-1">Deskripsi</div>
                    <div>{{ $service->description ?: '-' }}</div>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end mt-4">
                <a class="pet-btn pet-btn-primary" href="{{ route('services.edit', $service) }}">Edit</a>
            </div>
        </div>
    </div>
@endsection

