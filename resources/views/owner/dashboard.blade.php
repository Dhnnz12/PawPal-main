@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        {{-- Profile Greeting --}}
        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">Halo, {{ Auth::user()->name }}! 👋</h1>
                <div class="small text-muted">Apa yang ingin kamu lakukan hari ini?</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="fs-2">🐶</span>
                <div>
                    <div class="fw-bold small text-dark">Pet Owner</div>
                    <div class="small text-muted">Aktif</div>
                </div>
            </div>
        </div>

        {{-- Mockup Stat Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-widget widget-users">
                    <div>
                        <div class="value">{{ $pets->count() }}</div>
                        <div class="small text-muted fw-semibold">Hewan Saya</div>
                    </div>
                    <div class="fs-2">🐾</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-widget widget-bookings">
                    <div>
                        <div class="value">{{ $bookings->whereIn('status', ['pending', 'confirmed'])->count() }}</div>
                        <div class="small text-muted fw-semibold">Booking Aktif</div>
                    </div>
                    <div class="fs-2">⏳</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-widget widget-income">
                    <div>
                        <div class="value">{{ $orders->where('status', 'pending')->count() }}</div>
                        <div class="small text-muted fw-semibold">Menunggu Bayar</div>
                    </div>
                    <div class="fs-2">💳</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-widget widget-active">
                    <div>
                        <div class="value">{{ $orders->where('status', 'completed')->count() + $bookings->where('status', 'completed')->count() }}</div>
                        <div class="small text-muted fw-semibold">Transaksi Selesai</div>
                    </div>
                    <div class="fs-2">✓</div>
                </div>
            </div>
        </div>

        {{-- Layanan Cepat (Quick Access) --}}
        <div class="mb-5">
            <h3 class="h5 mb-3" style="font-family: 'Fraunces', serif; font-weight: 700; color: #4e3629;">⚡ Layanan Cepat</h3>
            <div class="row g-3 justify-content-center">
                <div class="col-12 col-sm-4">
                    <a href="{{ route('booking.search') }}?type=groomer" class="pet-card p-3 text-decoration-none d-flex align-items-center gap-3 bg-white" style="color: inherit;">
                        <span class="fs-2">🧼</span>
                        <div>
                            <div class="fw-bold small text-dark">Grooming</div>
                            <div class="small text-muted" style="font-size: 0.75rem;">Mandi & Potong</div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-4">
                    <a href="{{ route('booking.search') }}?type=veterinarian" class="pet-card p-3 text-decoration-none d-flex align-items-center gap-3 bg-white" style="color: inherit;">
                        <span class="fs-2">🩺</span>
                        <div>
                            <div class="fw-bold small text-dark">Vet Dokter</div>
                            <div class="small text-muted" style="font-size: 0.75rem;">Konsultasi Medis</div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-4">
                    <a href="{{ route('marketplace.index') }}" class="pet-card p-3 text-decoration-none d-flex align-items-center gap-3 bg-white" style="color: inherit;">
                        <span class="fs-2">🛒</span>
                        <div>
                            <div class="fw-bold small text-dark">Marketplace</div>
                            <div class="small text-muted" style="font-size: 0.75rem;">Belanja Produk</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        {{-- List Hewan Peliharaan --}}
        <div class="mb-5">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h3 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700; color: #4e3629;">🐾 Hewan Saya</h3>
                <a href="{{ route('pets.create') }}" class="small text-decoration-none fw-bold" style="color: var(--secondary);">➕ Tambah Hewan</a>
            </div>
            <div class="row g-3">
                @forelse($pets as $pet)
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="pet-card p-3 bg-white d-flex align-items-center gap-3">
                            <div style="width: 50px; height: 50px; border-radius: 12px; background-color: #f5ece2; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0; overflow: hidden;">
                                @if($pet->photo)
                                    <img src="{{ asset('storage/' . $pet->photo) }}" alt="{{ $pet->name }}" style="width: 100%; height: 100%; object-cover: cover;">
                                @else
                                    @if($pet->type === 'Dog') 🐶 @elseif($pet->type === 'Cat') 🐱 @else 🐾 @endif
                                @endif
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-bold text-dark text-truncate">{{ $pet->name }}</div>
                                <div class="small text-muted text-truncate">{{ $pet->breed ?? $pet->type }} • {{ $pet->age }} thn</div>
                            </div>
                            <a href="{{ route('pets.show', $pet) }}" class="small text-decoration-none fw-bold" style="color: var(--primary);">Detail</a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="p-4 text-center rounded-4 border border-dashed" style="background-color: #faf6f0;">
                            <span class="fs-3 d-block mb-1">🐾</span>
                            <div class="small text-muted">Belum ada hewan peliharaan terdaftar. <a href="{{ route('pets.create') }}" class="fw-bold text-decoration-none" style="color: var(--secondary);">Tambah sekarang</a></div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="row g-4">
            {{-- Pemesanan Terbaru --}}
            <div class="col-12 col-lg-7">
                <div class="pet-card p-4 bg-white h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700; color: #4e3629;">📅 Booking Terbaru</h3>
                        <a href="{{ route('bookings.index') }}" class="small text-decoration-none fw-bold" style="color: var(--secondary);">Lihat Semua</a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <tbody>
                                @forelse($bookings->take(3) as $b)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $b->service->name ?? 'Layanan' }}</div>
                                            <div class="small text-muted">{{ $b->booking_date }} - {{ $b->start_time }}</div>
                                        </td>
                                        <td>
                                            <span class="pet-badge pet-badge-peach">{{ $b->pet->name ?? '-' }}</span>
                                        </td>
                                        <td>
                                            @if($b->status === 'completed')
                                                <span class="pet-badge pet-badge-sage">Completed</span>
                                            @elseif($b->status === 'pending')
                                                <span class="pet-badge">Pending</span>
                                            @else
                                                <span class="pet-badge" style="background-color: #fcece6; color: #c06c48;">{{ ucfirst($b->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('bookings.show', $b) }}" class="small text-decoration-none fw-bold" style="color: var(--primary);">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-muted py-4 small">Belum ada booking terbaru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Marketplace Favorit --}}
            <div class="col-12 col-lg-5">
                <div class="pet-card p-4 bg-white h-100">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700; color: #4e3629;">❤️ Marketplace Favorit</h3>
                        <a href="{{ route('marketplace.index') }}" class="small text-decoration-none fw-bold" style="color: var(--secondary);">Belanja</a>
                    </div>

                    {{-- Local list placeholder --}}
                    <div id="favorites-dashboard-list" class="d-flex flex-column gap-2">
                        <div class="text-center text-muted py-4 small" id="no-favorites-dash">
                            Produk favorit belum disimpan.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const favorites = JSON.parse(localStorage.getItem('fav_products') || '[]');
            const container = document.getElementById('favorites-dashboard-list');
            const placeholder = document.getElementById('no-favorites-dash');
            
            // If favorites exist, mock display some items
            if (favorites.length > 0 && container) {
                placeholder.remove();
                
                // Let's display mock items since we don't have direct AJAX, or just retrieve them nicely
                // We'll create dynamic links for the first 3 favorites
                favorites.slice(0, 3).forEach((id, idx) => {
                    const item = document.createElement('div');
                    item.className = 'd-flex align-items-center justify-content-between p-2 rounded border mb-2';
                    item.style.backgroundColor = '#fff9f3';
                    item.innerHTML = `
                        <div class="d-flex align-items-center gap-2">
                            <span class="fs-4">📦</span>
                            <div>
                                <div class="fw-bold small text-dark">Produk Favorit #${id}</div>
                                <div class="small text-muted" style="font-size: 0.75rem;">Marketplace Item</div>
                            </div>
                        </div>
                        <a href="{{ route('marketplace.index') }}" class="pet-btn pet-btn-primary py-1 px-3" style="font-size: 0.75rem;">Beli</a>
                    `;
                    container.appendChild(item);
                });
            }
        });
    </script>
@endsection
