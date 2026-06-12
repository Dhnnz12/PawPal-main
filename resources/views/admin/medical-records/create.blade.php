@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2" style="max-width: 800px; margin: 0 auto;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Input Rekam Medis Baru 🏥</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Catat riwayat pemeriksaan kesehatan, tindakan medis, rekomendasi, dan lampiran berkas PDF.</div>
            </div>
            <div>
                <a class="pet-btn pet-btn-outline" href="{{ route('admin.medical-records.index') }}">← Kembali</a>
            </div>
        </div>

        <div class="pet-card p-4">
            <form method="POST" action="{{ route('medical-records.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: var(--ink);">Pilih Hewan Peliharaan</label>
                            <select class="form-select pet-input w-100" name="pet_id" required style="height: 50px;">
                                <option value="">-- Pilih Hewan --</option>
                                @foreach($pets as $pet)
                                    <option value="{{ $pet->id }}" {{ old('pet_id') == $pet->id ? 'selected' : '' }}>
                                        {{ $pet->name }} ({{ $pet->type }}) — Pemilik: {{ $pet->owner->name ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: var(--ink);">Pilih Booking / Kunjungan (opsional)</label>
                            <select class="form-select pet-input w-100" name="booking_id" style="height: 50px;">
                                <option value="">-- Tidak Terikat Booking --</option>
                                @foreach($bookings as $booking)
                                    <option value="{{ $booking->id }}" {{ old('booking_id') == $booking->id ? 'selected' : '' }}>
                                        Booking #{{ $booking->id }} — {{ $booking->booking_date }} ({{ $booking->service->name ?? 'Layanan' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: var(--ink);">Diagnosis Penyakit</label>
                    <textarea class="form-control pet-input w-100" name="diagnosis" rows="3" required placeholder="Tuliskan diagnosis pemeriksaan fisik, gejala, dan kondisi hewan...">{{ old('diagnosis') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color: var(--ink);">Tindakan Medis / Pengobatan</label>
                    <textarea class="form-control pet-input w-100" name="treatment" rows="3" required placeholder="Tuliskan tindakan yang diberikan, obat-obatan, resep, atau terapi...">{{ old('treatment') }}</textarea>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: var(--ink);">Rekomendasi & Catatan Tambahan (opsional)</label>
                            <textarea class="form-control pet-input w-100" name="notes" rows="3" placeholder="Saran pakan, jadwal kontrol kembali, pantangan...">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: var(--ink);">Lampiran PDF (Hasil Lab/Rontgen, opsional)</label>
                            <input class="form-control pet-input w-100" type="file" name="pdf_attachment" accept="application/pdf" style="height: 50px; padding: 10px;">
                            <span class="small text-muted d-block mt-1">Maksimal ukuran file PDF: 5 MB</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="pet-btn pet-btn-primary w-100 py-3" type="submit">Simpan Rekam Medis ✅</button>
                </div>
            </form>
        </div>
    </div>
@endsection
