@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2" style="max-width: 700px; margin: 0 auto;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">🗓️ Detail Booking Layanan</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Informasi lengkap booking layanan Anda</div>
            </div>
            <div>
                <a class="pet-btn pet-btn-outline" href="{{ auth()->user()->isAdmin() ? route('admin.bookings.index') : route('bookings.index') }}">← Kembali</a>
            </div>
        </div>

        <div class="pet-card p-4 mb-4">
            <div class="d-flex align-items-start justify-content-between mb-4">
                <div>
                    <h3 class="h5 mb-2" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">{{ $booking->service->name }}</h3>
                    <p class="small text-muted mb-0">Booking ID: #{{ $booking->id }}</p>
                </div>
                @if($booking->status === 'completed')
                    <span class="pet-badge pet-badge-sage">✓ Selesai</span>
                @elseif($booking->status === 'scheduled')
                    <span class="pet-badge pet-badge-peach">📅 Terjadwal</span>
                @elseif($booking->status === 'pending')
                    <span class="pet-badge">⏳ Pending</span>
                @elseif($booking->status === 'cancelled')
                    <span class="pet-badge" style="background-color: #fcece6; color: #c06c48;">❌ Dibatalkan</span>
                @else
                    <span class="pet-badge">{{ ucfirst($booking->status) }}</span>
                @endif
            </div>

            <hr style="border-color: var(--color-warm-border);">

            {{-- Booking Details Grid --}}
            <div class="row g-4 mb-4">
                <div class="col-6">
                    <label class="small fw-semibold text-muted mb-2 d-block">Tanggal Kunjungan</label>
                    <p class="h6 mb-0" style="color: var(--ink);">📅 {{ $booking->booking_date }}</p>
                </div>
                <div class="col-6">
                    <label class="small fw-semibold text-muted mb-2 d-block">Jam Kunjungan</label>
                    <p class="h6 mb-0" style="color: var(--ink);">🕐 {{ $booking->start_time }} - {{ $booking->end_time }}</p>
                </div>
                <div class="col-6">
                    <label class="small fw-semibold text-muted mb-2 d-block">Tenaga Klinik</label>
                    <p class="h6 mb-0" style="color: var(--ink);">{{ $booking->provider->name }}</p>
                    <p class="small text-muted mb-0">{{ ucfirst($booking->provider->provider_type ?? '') }}</p>
                </div>
                <div class="col-6">
                    <label class="small fw-semibold text-muted mb-2 d-block">Hewan Peliharaan</label>
                    <p class="h6 mb-0" style="color: var(--ink);">🐾 {{ $booking->pet->name }}</p>
                    <p class="small text-muted mb-0">{{ $booking->pet->type }} • {{ $booking->pet->age }} tahun</p>
                </div>
            </div>

            {{-- Alamat Lokasi --}}
            <hr style="border-color: var(--color-warm-border);">
            
            <div class="mb-4">
                <label class="small fw-semibold text-muted mb-2 d-block">📍 Lokasi Layanan</label>
                <div class="bg-light p-3 rounded" style="border-radius: 15px;">
                    <p class="mb-1" style="color: var(--ink); font-weight: 600;">{{ $booking->address->label ?? 'Lokasi' }}</p>
                    <p class="small text-muted mb-0">{{ $booking->address->address_line ?? '-' }}</p>
                    @if($booking->address && $booking->address->latitude && $booking->address->longitude)
                        <div class="mt-2 small text-muted">
                            📌 Koordinat: {{ $booking->address->latitude }}, {{ $booking->address->longitude }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Catatan --}}
            @if($booking->notes)
                <div class="mb-4">
                    <label class="small fw-semibold text-muted mb-2 d-block">📝 Catatan Kunjungan Pet Owner</label>
                    <p style="color: var(--ink);">{{ $booking->notes }}</p>
                </div>
            @endif

            {{-- Completion Notes / Groomer Notes --}}
            @if($booking->completion_notes)
                <div class="mb-4 p-3 rounded-4 bg-light border" style="border-radius: 15px;">
                    <label class="small fw-bold text-success mb-2 d-block">✨ Catatan Penyelesaian Groomer</label>
                    <p class="small mb-0" style="color: var(--ink);">{{ $booking->completion_notes }}</p>
                </div>
            @endif

            {{-- Medical Record Details --}}
            @if($booking->medicalRecord)
                <div class="mb-4 p-3 rounded-4 bg-light border" style="border-radius: 15px; border-color: #eadacb !important; background-color: #faf6f0 !important;">
                    <label class="small fw-bold text-primary mb-3 d-block">🩺 Hasil Rekam Medis Dokter Hewan</label>
                    <div class="row g-3">
                        <div class="col-12">
                            <span class="small fw-semibold text-muted d-block">Diagnosis</span>
                            <p class="small mb-0" style="color: var(--ink); white-space: pre-line;">{{ $booking->medicalRecord->diagnosis }}</p>
                        </div>
                        <div class="col-12">
                            <span class="small fw-semibold text-muted d-block">Tindakan Medis</span>
                            <p class="small mb-0" style="color: var(--ink); white-space: pre-line;">{{ $booking->medicalRecord->treatment }}</p>
                        </div>
                        <div class="col-12">
                            <span class="small fw-semibold text-muted d-block">Rekomendasi Perawatan</span>
                            <p class="small mb-0" style="color: var(--ink); white-space: pre-line;">{{ $booking->medicalRecord->recommendation }}</p>
                        </div>
                        @if($booking->medicalRecord->notes)
                            <div class="col-12">
                                <span class="small fw-semibold text-muted d-block">Catatan Dokter</span>
                                <p class="small mb-0" style="color: var(--ink); white-space: pre-line;">{{ $booking->medicalRecord->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Review Details (Completed Only) --}}
            @if($booking->status === 'completed')
                <div class="mb-4 p-3 rounded-4 bg-light border" style="border-radius: 15px; border-color: #f5e7db !important; background-color: #faf6f0 !important;">
                    <label class="small fw-bold text-muted mb-2 d-block">⭐ Ulasan Pelayanan</label>
                    @if($booking->review)
                        <div class="d-flex align-items-center gap-1 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <span style="font-size: 1.1rem; color: {{ $i <= $booking->review->rating ? '#ffb300' : '#ddd' }}">★</span>
                            @endfor
                            <span class="ms-2 small fw-bold text-dark">({{ $booking->review->rating }} / 5)</span>
                        </div>
                        <p class="small mb-0" style="color: var(--ink); font-style: italic;">
                            "{{ $booking->review->comment ?? 'Tidak ada ulasan tertulis.' }}"
                        </p>
                    @else
                        <p class="small text-muted mb-0">Pet owner belum me-review pelayanan ini.</p>
                    @endif
                </div>
            @endif

            {{-- Provider Info Card --}}
            <hr style="border-color: var(--color-warm-border);">
            
            <div class="mb-4">
                <label class="small fw-semibold text-muted mb-3 d-block">Informasi Tenaga Klinik</label>
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="h6 mb-1" style="color: var(--ink);">{{ $booking->provider->name }}</p>
                        <p class="small text-muted mb-1">📞 {{ $booking->provider->phone ?? 'N/A' }}</p>
                        <p class="small text-muted mb-0">{{ $booking->provider->bio ?? 'Tenaga medis / groomer profesional kami' }}</p>
                    </div>
                    <div>
                        @if($booking->provider->is_verified)
                            <span class="pet-badge pet-badge-sage">✓ Terverifikasi</span>
                        @else
                            <span class="pet-badge">Belum Verifikasi</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <hr style="border-color: var(--color-warm-border);">
            
            <div class="d-flex gap-2 mt-4">
                @if($booking->status === 'completed' && !$booking->review && auth()->user()->isPetOwner())
                    <a href="{{ route('reviews.create', $booking) }}" class="pet-btn pet-btn-primary flex-grow-1 py-2">⭐ Beri Rating & Review</a>
                @endif
                
                @if($booking->status === 'pending' || $booking->status === 'scheduled')
                    <form method="POST" action="{{ route('booking.updateStatus', $booking) }}" class="flex-grow-1">
                        @csrf
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="pet-btn pet-btn-outline w-100 py-2" onclick="return confirm('Yakin ingin membatalkan booking ini?')">Batalkan Booking</button>
                    </form>
                @endif
                
                <a href="{{ auth()->user()->isAdmin() ? route('admin.bookings.index') : route('bookings.index') }}" class="pet-btn pet-btn-outline flex-grow-1 py-2">← Kembali</a>
            </div>
        </div>
    </div>
@endsection
