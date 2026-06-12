@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">Dashboard Admin 📊</h1>
                <div class="small text-muted">Selamat datang! Kelola semua data, transaksi, dan verifikasi sistem PawPal.</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="fs-2">⚙️</span>
                <div>
                    <div class="fw-bold small text-dark">Administrator</div>
                    <div class="small text-muted">Online</div>
                </div>
            </div>
        </div>

        {{-- Statistics Row --}}
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="summary-widget widget-users">
                    <div>
                        <div class="value">{{ $totalUsers }}</div>
                        <div class="small text-muted fw-semibold">Total Pengguna</div>
                    </div>
                    <div class="fs-2">👥</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-widget widget-bookings">
                    <div>
                        <div class="value">{{ $totalBookings }}</div>
                        <div class="small text-muted fw-semibold">Total Booking</div>
                    </div>
                    <div class="fs-2">📅</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-widget widget-income">
                    <div>
                        <div class="value value-long">Rp {{ number_format($totalTransactions, 0, ',', '.') }}</div>
                        <div class="small text-muted fw-semibold mt-1">Pendapatan</div>
                    </div>
                    <div class="fs-2">💵</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="summary-widget widget-active">
                    <div>
                        <div class="value">{{ $allBookings->whereIn('status', ['pending', 'confirmed'])->count() }}</div>
                        <div class="small text-muted fw-semibold">Booking Aktif</div>
                    </div>
                    <div class="fs-2">⏳</div>
                </div>
            </div>
        </div>

        {{-- Verification & Latest Bookings --}}
        <div class="row g-4">
            {{-- Pemesanan Terbaru Table --}}
            <div class="col-12">
                <div class="pet-card p-4 bg-white h-100">
                    <h3 class="h5 mb-3" style="font-family: 'Fraunces', serif; font-weight: 700; color: #4e3629;">📅 Booking Terbaru</h3>
                    
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 50px; min-width: 50px;">#</th>
                                    <th>Pelanggan</th>
                                    <th>Layanan</th>
                                    <th style="width: 100px; min-width: 100px;">Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-end" style="width: 155px; min-width: 155px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($allBookings->take(5) as $b)
                                    <tr>
                                        <td><strong>#{{ $b->id }}</strong></td>
                                        <td>{{ $b->petOwner->name ?? '-' }}</td>
                                        <td>{{ $b->service->name ?? '-' }}</td>
                                        <td class="small text-muted">{{ $b->booking_date }}</td>
                                        <td>
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
                                        <td class="text-end">
                                            <div class="d-flex align-items-center justify-content-end gap-1">
                                                @if($b->status === 'pending')
                                                    <form method="POST" action="{{ route('booking.updateStatus', $b) }}" class="m-0">
                                                        @csrf
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button type="submit" class="btn btn-sm text-white py-1 px-2" style="background-color: var(--accent); border: none; border-radius: 8px; font-size: 0.8rem; white-space: nowrap;">Terima</button>
                                                    </form>
                                                    <form method="POST" action="{{ route('booking.updateStatus', $b) }}" class="m-0">
                                                        @csrf
                                                        <input type="hidden" name="status" value="cancelled">
                                                        <button type="submit" class="btn btn-sm text-white py-1 px-2" style="background-color: #c06c48; border: none; border-radius: 8px; font-size: 0.8rem; white-space: nowrap;" onclick="return confirm('Yakin ingin menolak booking ini?')">Tolak</button>
                                                    </form>
                                                @elseif($b->status === 'confirmed')
                                                    <a href="{{ route('admin.bookings.completeForm', $b) }}" class="btn btn-sm text-white py-1 px-2 text-decoration-none" style="background-color: var(--primary); border: none; border-radius: 8px; font-size: 0.8rem; white-space: nowrap;">Selesai</a>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4 small">Belum ada booking masuk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
