@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-4 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">🏥 Manajemen Rekam Medis</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif; max-width: 500px;">Kelola, input, dan verifikasi rekam medis hewan peliharaan dari dokter hewan.</div>
            </div>
            <div class="d-flex gap-2">
                <a class="pet-btn pet-btn-primary" href="{{ route('medical-records.create') ?? '#' }}">+ Input Rekam Medis</a>
                <a class="pet-btn pet-btn-outline" href="{{ route('admin.dashboard') }}">← Dashboard</a>
            </div>
        </div>

        <div class="pet-card p-4">
            <div class="mb-3">
                <h2 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700;">📋 Daftar Rekam Medis</h2>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Hewan</th>
                            <th>Pemilik</th>
                            <th>Dokter Hewan</th>
                            <th>Tanggal Kunjungan</th>
                            <th>Diagnosis</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($medicalRecords as $record)
                            <tr>
                                <td><strong style="color: var(--ink);">{{ $record->pet->name ?? '-' }}</strong></td>
                                <td>{{ $record->pet->owner->name ?? '-' }}</td>
                                <td>Dr. {{ $record->vet->name ?? '-' }}</td>
                                <td>{{ $record->visit_date->format('d M Y') }}</td>
                                <td class="small text-muted">{{ Str::limit($record->diagnosis, 40) }}</td>
                                <td class="text-end">
                                    <a href="{{ route('medical-records.show', $record) ?? '#' }}" class="text-decoration-none fw-bold" style="color: var(--secondary); font-size: 0.9rem;">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted small py-4">Belum ada rekam medis</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
