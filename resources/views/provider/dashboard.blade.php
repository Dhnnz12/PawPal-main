@extends('layouts.app')

@section('content')
    <div class="py-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Dashboard Service Provider 🧑‍⚕️</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Kelola ketersediaan jadwal, pantau booking masuk, dan kelola produk marketplace Anda.</div>
            </div>
            <div class="d-flex gap-2">
                <span class="pet-badge pet-badge-sage">🌿 Aktif</span>
            </div>
        </div>

        <div class="row g-4">
            {{-- Bookings --}}
            <div class="col-12 col-lg-8">
                <div class="pet-card p-4 h-100">
                    <div class="mb-3">
                        <h2 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700;">📋 Booking Masuk</h2>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th style="min-width: 140px;">Waktu & Layanan</th>
                                    <th style="min-width: 140px;">Klien & Hewan</th>
                                    <th class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $b)
                                    <tr>
                                        <td>
                                            <div class="fw-bold" style="color: var(--ink);">{{ $b->booking_date }}</div>
                                            <div class="small text-muted mb-1">{{ $b->start_time }}</div>
                                            <span class="pet-badge" style="font-size: 0.75rem; padding: 3px 8px;">{{ $b->service->name ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $b->petOwner->name ?? '-' }}</div>
                                            <div class="small text-muted">Hewan: <span class="fw-bold text-dark">{{ $b->pet->name ?? '-' }}</span></div>
                                        </td>
                                        <td class="text-end">
                                            @if($b->status === 'completed')
                                                <span class="pet-badge pet-badge-sage">Selesai</span>
                                            @elseif($b->status === 'pending')
                                                <span class="pet-badge">Pending</span>
                                            @elseif($b->status === 'confirmed')
                                                <span class="pet-badge pet-badge-peach">Diterima</span>
                                            @elseif($b->status === 'cancelled')
                                                <span class="pet-badge" style="background-color: #fcece6; color: #c06c48;">Dibatalkan</span>
                                            @else
                                                <span class="pet-badge">{{ ucfirst($b->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-muted small py-3 text-center">Belum ada booking masuk.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Schedules --}}
            <div class="col-12 col-lg-4">
                <div class="pet-card p-4 h-100">
                    <div class="mb-3">
                        <h2 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700;">📅 Ketersediaan Jadwal</h2>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Waktu Operasional</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $s)
                                    <tr>
                                        <td class="fw-bold" style="color: var(--ink);">{{ $s->day_of_week }}</td>
                                        <td class="small">{{ $s->start_time }} - {{ $s->end_time }}</td>
                                        <td>
                                            @if($s->is_available)
                                                <span class="pet-badge pet-badge-sage">Buka</span>
                                            @else
                                                <span class="pet-badge" style="background-color: #fcece6; color: #c06c48;">Tutup</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-muted small py-3 text-center">Belum ada jadwal operasional.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection


