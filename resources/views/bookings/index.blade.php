@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-4 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">🗓️ Histori Booking Layanan</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif; max-width: 500px;">Lihat semua riwayat booking layanan grooming, dokter hewan, dan penitipan hewan Anda.</div>
            </div>
            <div>
                <a class="pet-btn pet-btn-outline" href="{{ route('owner.dashboard') }}">← Kembali ke Dashboard</a>
            </div>
        </div>

        @php
            $groupedBookings = $bookings->groupBy(function($booking) {
                return $booking->booking_date;
            })->sortByDesc(function($group) {
                return $group->first()->booking_date;
            });
        @endphp

        @forelse($groupedBookings as $date => $dateBookings)
            <div class="mb-4">
                <h3 class="h6 mb-3" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">
                    📅 {{ \Carbon\Carbon::parse($date)->format('d F Y') }}
                </h3>

                <div class="row g-3">
                    @foreach($dateBookings as $booking)
                        <div class="col-12 col-lg-6">
                            <div class="pet-card p-4 h-100">
                                <div class="d-flex align-items-start justify-content-between mb-3">
                                    <div>
                                        <h4 class="h6 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">
                                            {{ $booking->service->name ?? 'Layanan' }}
                                        </h4>
                                        <p class="small text-muted mb-0">
                                            {{ $booking->start_time }} - {{ $booking->end_time }}
                                        </p>
                                    </div>
                                    @if($booking->status === 'completed')
                                        <span class="pet-badge pet-badge-sage">✓ Selesai</span>
                                    @elseif($booking->status === 'scheduled')
                                        <span class="pet-badge pet-badge-peach">📅 Terjadwal</span>
                                    @else
                                        <span class="pet-badge">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </div>

                                <hr style="border-color: var(--color-warm-border); margin: 12px 0;">

                                <div class="row g-3 mb-3">
                                    <div class="col-6">
                                        <label class="small fw-semibold text-muted mb-1 d-block">Tenaga Klinik</label>
                                        <p class="small fw-bold" style="color: var(--ink);">{{ $booking->provider->name ?? '-' }}</p>
                                    </div>
                                    <div class="col-6">
                                        <label class="small fw-semibold text-muted mb-1 d-block">Hewan</label>
                                        <p class="small fw-bold" style="color: var(--ink);">{{ $booking->pet->name ?? '-' }}</p>
                                    </div>
                                </div>

                                @if($booking->notes)
                                    <div class="mb-3">
                                        <label class="small fw-semibold text-muted mb-1 d-block">Catatan</label>
                                        <p class="small" style="color: var(--ink);">{{ $booking->notes }}</p>
                                    </div>
                                @endif

                                <div class="d-flex gap-2 mt-3">
                                    <a href="{{ route('bookings.show', $booking) }}" class="pet-btn pet-btn-outline flex-grow-1 py-2" style="font-size: 0.85rem;">Detail</a>
                                    @if($booking->status === 'completed')
                                        @if($booking->review)
                                            <button class="pet-btn pet-btn-outline flex-grow-1 py-2" style="font-size: 0.85rem; cursor: not-allowed; border-color: #eadacb; color: #a49182;" disabled>✓ Telah Direview</button>
                                        @else
                                            <a href="{{ route('reviews.create', $booking) }}" class="pet-btn pet-btn-primary flex-grow-1 py-2" style="font-size: 0.85rem;">⭐ Review</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="pet-card p-4">
                <div class="text-center text-muted py-5">
                    <span class="fs-2 d-block mb-2">🗓️</span>
                    <p class="mb-3">Belum ada histori booking layanan</p>
                    <a href="{{ route('booking.search') }}" class="pet-btn pet-btn-primary">Mulai Booking Layanan</a>
                </div>
            </div>
        @endforelse
    </div>
@endsection
