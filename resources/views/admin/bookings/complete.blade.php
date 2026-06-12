@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2" style="max-width: 800px; margin: 0 auto;">
        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">✅ Selesaikan Booking Layanan</h1>
                <div class="small text-muted">Isi laporan catatan akhir untuk merampungkan pesanan booking.</div>
            </div>
            <a class="pet-btn pet-btn-outline" href="{{ route('admin.dashboard') }}">← Batal</a>
        </div>

        {{-- Booking Summary Card --}}
        <div class="pet-card p-4 mb-4" style="border-radius: 22px; border: 1.5px solid var(--color-warm-border); background-color: #faf6f0;">
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <span class="small fw-semibold text-muted d-block">ID Booking</span>
                    <strong style="color: var(--ink);">#{{ $booking->id }}</strong>
                </div>
                <div class="col-6 col-md-3">
                    <span class="small fw-semibold text-muted d-block">Nama Hewan</span>
                    <strong style="color: var(--ink);">🐾 {{ $booking->pet->name ?? '-' }}</strong>
                </div>
                <div class="col-6 col-md-3">
                    <span class="small fw-semibold text-muted d-block">Layanan</span>
                    <strong style="color: var(--ink);">{{ $booking->service->name ?? '-' }}</strong>
                </div>
                <div class="col-6 col-md-3">
                    <span class="small fw-semibold text-muted d-block">Tenaga Klinik</span>
                    <strong style="color: var(--ink);">{{ $booking->provider->name ?? '-' }}</strong>
                </div>
            </div>
        </div>

        {{-- Complete Form --}}
        <div class="pet-card p-4">
            @php
                $serviceType = $booking->service->provider_type ?? '';
            @endphp

            <form method="POST" action="{{ route('admin.bookings.submitComplete', $booking) }}">
                @csrf

                @if($serviceType === 'veterinarian')
                    {{-- Dokter Hewan: Rekam Medis Wajib --}}
                    <div class="alert alert-warning border-0 p-3 mb-4" style="border-radius: 16px; background-color: #fff9f3; color: #b06948; font-size: 0.85rem;">
                        🩺 <strong>Layanan Dokter Hewan:</strong> Anda wajib mengisi detail rekam medis hewan peliharaan di bawah ini untuk menyelesaikan booking.
                    </div>

                    <div class="row g-4">
                        <div class="col-12 d-flex flex-column">
                            <label for="diagnosis" class="small fw-semibold text-muted mb-2">Diagnosis Medis <span class="text-danger">*</span></label>
                            <textarea name="diagnosis" id="diagnosis" rows="3" class="pet-input w-100" required placeholder="Tuliskan hasil diagnosis penyakit atau kondisi fisik hewan..."></textarea>
                            @error('diagnosis')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex flex-column">
                            <label for="treatment" class="small fw-semibold text-muted mb-2">Tindakan Medis <span class="text-danger">*</span></label>
                            <textarea name="treatment" id="treatment" rows="3" class="pet-input w-100" required placeholder="Tuliskan pengobatan, tindakan medis, suntikan, atau terapi yang diberikan..."></textarea>
                            @error('treatment')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex flex-column">
                            <label for="recommendation" class="small fw-semibold text-muted mb-2">Rekomendasi Perawatan <span class="text-danger">*</span></label>
                            <textarea name="recommendation" id="recommendation" rows="3" class="pet-input w-100" required placeholder="Tuliskan resep obat, jadwal kontrol ulang, atau pantangan makanan..."></textarea>
                            @error('recommendation')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex flex-column">
                            <label for="notes" class="small fw-semibold text-muted mb-2">Catatan Tambahan Dokter (Opsional)</label>
                            <textarea name="notes" id="notes" rows="2" class="pet-input w-100" placeholder="Tuliskan catatan opsional dari dokter jika ada..."></textarea>
                        </div>
                    </div>
                @else
                    {{-- Groomer / Lainnya: Catatan Sederhana --}}
                    <div class="alert alert-info border-0 p-3 mb-4" style="border-radius: 16px; background-color: #f0f7f4; color: #355e4e; font-size: 0.85rem;">
                        ✨ <strong>Layanan Grooming:</strong> Masukkan catatan hasil pengerjaan grooming (opsional, jika tidak ada silakan isi dengan "-").
                    </div>

                    <div class="row g-4">
                        <div class="col-12 d-flex flex-column">
                            <label for="notes" class="small fw-semibold text-muted mb-2">Catatan Pengerjaan Grooming <span class="text-danger">*</span></label>
                            <textarea name="notes" id="notes" rows="4" class="pet-input w-100" required placeholder="Contoh: Hewan sangat tenang, terdapat sedikit kutu di area telinga, bulu dipotong rapi. (Atau cukup isi '-' jika tidak ada catatan)"></textarea>
                            @error('notes')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="mt-4 pt-3 border-top d-flex gap-3 justify-content-end">
                    <a href="{{ route('admin.dashboard') }}" class="pet-btn pet-btn-outline">Batal</a>
                    <button type="submit" class="pet-btn pet-btn-primary py-2 px-4">Selesaikan & Simpan ✅</button>
                </div>
            </form>
        </div>
    </div>
@endsection
