@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-4 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">💳 Verifikasi Transaksi Marketplace</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif; max-width: 500px;">Pantau, verifikasi, dan kelola transaksi pembayaran pembelian produk marketplace.</div>
            </div>
            <div>
                <a class="pet-btn pet-btn-outline" href="{{ route('admin.dashboard') }}">← Dashboard</a>
            </div>
        </div>

        <div class="row g-4">
            {{-- Transaction Stats --}}
            <div class="col-12 col-md-3">
                <div class="pet-card p-4 text-center">
                    <div class="fs-2 mb-2">💰</div>
                    <div class="h5" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Pending</div>
                    <div style="color: var(--primary); font-size: 1.5rem; font-weight: 700;">{{ $pendingCount }}</div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="pet-card p-4 text-center">
                    <div class="fs-2 mb-2">✓</div>
                    <div class="h5" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Paid</div>
                    <div style="color: var(--secondary); font-size: 1.5rem; font-weight: 700;">{{ $paidCount }}</div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="pet-card p-4 text-center">
                    <div class="fs-2 mb-2">📦</div>
                    <div class="h5" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Completed</div>
                    <div style="color: var(--primary); font-size: 1.5rem; font-weight: 700;">{{ $completedCount }}</div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="pet-card p-4 text-center">
                    <div class="fs-2 mb-2">💵</div>
                    <div class="h5" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Total</div>
                    <div style="color: var(--primary); font-size: 1.3rem; font-weight: 700;">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
                </div>
            </div>

            {{-- Transactions List --}}
            <div class="col-12">
                <div class="pet-card p-4">
                    <div class="mb-3">
                        <h2 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700;">📋 Daftar Transaksi</h2>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Pembeli</th>
                                    <th>Total</th>
                                    <th>Status Pembayaran</th>
                                    <th>Waktu</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td><strong style="color: var(--ink);">#{{ $order->id }}</strong></td>
                                        <td>{{ $order->user->name }}</td>
                                        <td><strong style="color: var(--primary);">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                                        <td>
                                            @if($order->status === 'pending')
                                                <span class="pet-badge">Pending</span>
                                            @elseif($order->status === 'paid')
                                                <span class="pet-badge pet-badge-peach">Paid</span>
                                            @else
                                                <span class="pet-badge pet-badge-sage">{{ ucfirst($order->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="small text-muted">{{ $order->created_at->format('d M Y H:i') }}</td>
                                        <td class="text-end">
                                            <div class="d-flex gap-2 justify-content-end">
                                                <a href="{{ route('orders.show', $order) ?? '#' }}" class="text-decoration-none fw-bold" style="color: var(--secondary); font-size: 0.9rem;">Detail</a>
                                                @if($order->status === 'pending')
                                                    <form method="POST" action="{{ route('admin.transactions.approve', $order) }}" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm text-white" style="background-color: var(--secondary); border: none; border-radius: 8px; font-size: 0.85rem; padding: 4px 12px;">✓ Approve</button>
                                                    </form>
                                                    <form method="POST" action="{{ route('admin.transactions.reject', $order) }}" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm text-white" style="background-color: #c06c48; border: none; border-radius: 8px; font-size: 0.85rem; padding: 4px 12px;">✗ Reject</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted small py-4">Belum ada transaksi</td>
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
