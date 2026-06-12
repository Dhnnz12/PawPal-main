@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-4 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">📋 Riwayat Booking Selesai</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif; max-width: 500px;">Lihat semua riwayat booking pelayanan yang telah berstatus selesai serta review dari pelanggan.</div>
            </div>
            <div>
                <a class="pet-btn pet-btn-outline" href="{{ route('admin.dashboard') }}">← Dashboard</a>
            </div>
        </div>

        <div class="pet-card p-4">
            <div class="mb-3">
                <h2 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700;">🐾 Daftar Booking Selesai</h2>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th>Pelanggan</th>
                            <th>Hewan</th>
                            <th>Tenaga Klinik</th>
                            <th>Layanan</th>
                            <th>Tanggal & Waktu</th>
                            <th>Ulasan Pelanggan</th>
                            <th class="text-end" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $b)
                            <tr>
                                <td><strong>#{{ $b->id }}</strong></td>
                                <td>
                                    <div class="fw-bold" style="color: var(--ink);">{{ $b->petOwner->name ?? '-' }}</div>
                                    <div class="small text-muted">{{ $b->petOwner->phone ?? '-' }}</div>
                                </td>
                                <td>
                                    <span class="pet-badge pet-badge-peach">{{ $b->pet->name ?? '-' }}</span>
                                    <div class="small text-muted">{{ $b->pet->type ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold" style="color: var(--ink);">{{ $b->provider->name ?? '-' }}</div>
                                    <div class="small text-muted text-capitalize">{{ $b->provider->provider_type ?? '-' }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold" style="color: var(--primary);">{{ $b->service->name ?? '-' }}</div>
                                    <div class="small text-muted">Rp {{ number_format($b->total_price, 0, ',', '.') }}</div>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $b->booking_date }}</div>
                                    <div class="small text-muted">{{ $b->start_time }} - {{ $b->end_time }}</div>
                                </td>
                                <td>
                                    @if($b->review)
                                        <div class="d-flex align-items-center gap-1 mb-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span style="font-size: 0.95rem; color: {{ $i <= $b->review->rating ? '#ffb300' : '#ddd' }}">★</span>
                                            @endfor
                                            <span class="small fw-bold text-dark ms-1">({{ $b->review->rating }}/5)</span>
                                        </div>
                                        <div class="small text-muted text-truncate" style="max-width: 150px; font-style: italic;">
                                            "{{ $b->review->comment ?? 'Tidak ada komentar.' }}"
                                        </div>
                                    @else
                                        <span class="small text-muted" style="font-style: italic;">Belum direview</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('bookings.show', $b) }}" class="pet-btn pet-btn-outline py-1 px-3" style="font-size: 0.8rem;">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted small py-4">Belum ada booking dengan status selesai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
