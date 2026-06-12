@extends('layouts.dashboard')

@section('dashboard_content')
    <style>
        /* Bintang kosong (abu-abu) tanpa warna */
        .star-rating label {
            color: #ddd !important;
        }

        /* Saat user klik/hover, baru nyala kuning */
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ffb300 !important;
        }

        /* Supaya checkbox radio tetap bisa dipakai tapi tidak terlihat */
        .star-rating input {
            display: none;
        }
    </style>

    <div class="py-2" style="max-width: 600px; margin: 0 auto;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">⭐ Berikan Rating & Review</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Bagikan pengalaman Anda dengan layanan {{ $booking->service->name ?? 'Layanan' }}</div>
            </div>
        </div>

        <div class="pet-card p-4 mb-4">
            <div class="mb-4">
                <h4 class="h6" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink); margin-bottom: 12px;">Detail Layanan</h4>

                <div class="row g-3 small mb-3">
                    <div class="col-6">
                        <label class="text-muted mb-1 d-block">Provider</label>
                        <p style="color: var(--ink); font-weight: 600;">{{ $booking->provider->name }}</p>
                    </div>
                    <div class="col-6">
                        <label class="text-muted mb-1 d-block">Layanan</label>
                        <p style="color: var(--ink); font-weight: 600;">{{ $booking->service->name }}</p>
                    </div>
                    <div class="col-6">
                        <label class="text-muted mb-1 d-block">Tanggal</label>
                        <p style="color: var(--ink); font-weight: 600;">{{ $booking->booking_date }}</p>
                    </div>
                    <div class="col-6">
                        <label class="text-muted mb-1 d-block">Hewan Peliharaan</label>
                        <p style="color: var(--ink); font-weight: 600;">{{ $booking->pet->name }}</p>
                    </div>
                </div>
            </div>

            <hr style="border-color: var(--color-warm-border);">

            <form method="POST" action="{{ route('reviews.store') }}" class="mt-4">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                <div class="mb-4">
                    <label class="form-label fw-semibold" style="color: var(--ink); font-size: 0.95rem;">Rating Kepuasan</label>

                    <div class="star-rating d-flex flex-row-reverse justify-content-end gap-1">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" class="visually-hidden" required>
                            <label for="rating-{{ $i }}" class="mb-0 px-1" style="cursor: pointer; font-size: 2rem; transition: all 0.2s;">★</label>
                        @endfor
                    </div>

                    <div class="small text-muted mt-2">Klik bintang untuk memberi rating (1-5)</div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold" style="color: var(--ink); font-size: 0.95rem;">Ulasan Anda</label>
                    <textarea class="form-control pet-input" name="comment" rows="4" placeholder="Ceritakan pengalaman Anda dengan layanan ini..." style="border: 1.5px solid #e8dcc8; border-radius: 20px; padding: 12px 16px; font-family: 'Outfit', sans-serif;" required></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold" style="color: var(--ink); font-size: 0.95rem;">Kualitas Layanan</label>
                    <div class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="quality-professional" name="qualities[]" value="professional">
                            <label class="form-check-label small" for="quality-professional" style="color: var(--ink);">✓ Profesional & Berpengalaman</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="quality-friendly" name="qualities[]" value="friendly">
                            <label class="form-check-label small" for="quality-friendly" style="color: var(--ink);">✓ Ramah & Perhatian</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="quality-clean" name="qualities[]" value="clean">
                            <label class="form-check-label small" for="quality-clean" style="color: var(--ink);">✓ Bersih & Rapi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="quality-timekeeper" name="qualities[]" value="timekeeper">
                            <label class="form-check-label small" for="quality-timekeeper" style="color: var(--ink);">✓ Tepat Waktu</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('bookings.index') }}" class="pet-btn pet-btn-outline flex-grow-1 py-2">← Kembali</a>
                    <button type="submit" class="pet-btn pet-btn-primary flex-grow-1 py-2">Kirim Review ⭐</button>
                </div>
            </form>
        </div>
    </div>
@endsection

