@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Cari Tenaga Klinik 🐾</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Pilih tipe tenaga klinik terbaik untuk kebutuhan hewan peliharaan Anda.</div>
            </div>
            <div class="d-flex gap-2">
                <span class="pet-badge pet-badge-peach">{{ ucfirst($type) }}</span>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="pet-card p-4">
                    <h2 class="h5 mb-3" style="font-family: 'Fraunces', serif; font-weight: 700;">Filter Pencarian</h2>
                    <form method="GET" action="{{ route('booking.search') }}">
                        <div class="mb-4">
                            <label class="form-label fw-semibold small text-muted">Kategori Tenaga Klinik</label>
                            <select class="form-select pet-input w-100" name="type" style="height: 50px;">
                                <option value="groomer" {{ $type==='groomer'?'selected':'' }}>Groomer (Perawatan Bulu)</option>
                                <option value="veterinarian" {{ $type==='veterinarian'?'selected':'' }}>Veterinarian (Dokter Hewan)</option>
                            </select>
                        </div>
                        <button class="pet-btn pet-btn-primary w-100 py-3" type="submit">Cari Sekarang ✨</button>
                    </form>
                </div>
            </div>

            <div class="col-12 col-md-8">
                <div class="pet-card p-4">
                    <h2 class="h5 mb-3" style="font-family: 'Fraunces', serif; font-weight: 700;">Daftar Tenaga Klinik 🧡</h2>
                    <div class="list-group list-group-flush" style="font-family: 'Outfit', sans-serif;">
                        @forelse($providers as $p)
                            <div class="list-group-item d-flex align-items-center justify-content-between gap-3 bg-transparent py-3 border-0 border-bottom">
                                <div>
                                    <div class="fw-bold fs-6" style="color: var(--ink);">{{ $p->name }}</div>
                                    <div class="small text-muted">{{ ucfirst($p->provider_type ?? $type) }}</div>
                                </div>
                                <a class="pet-btn pet-btn-primary py-2 px-4" href="{{ route('booking.create', $p) }}" style="font-size: 0.9rem;">Booking</a>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <span class="fs-1 d-block mb-2">🐶</span>
                                Penyedia layanan belum tersedia untuk kategori ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


