@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-4 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Riwayat Pembelian & Invoice 📄</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif; max-width: 500px;">Lihat semua transaksi pembelian produk marketplace dan unduh invoice PDF Anda.</div>
            </div>
            <div>
                <a class="pet-btn pet-btn-outline" href="{{ route('owner.dashboard') }}">← Kembali ke Dashboard</a>
            </div>
        </div>

        <div class="row g-4">
            @forelse($orders as $order)
                <div class="col-12 col-lg-6">
                    <div class="pet-card p-4 h-100">
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div>
                                <span class="pet-badge pet-badge-sage">Order #{{ $order->id }}</span>
                                <div class="small text-muted mt-1">{{ $order->created_at->format('d M Y H:i') }}</div>
                            </div>
                            <div class="text-end">
                                @if($order->status === 'completed')
                                    <span class="pet-badge pet-badge-sage">✓ Selesai</span>
                                @elseif($order->status === 'pending')
                                    <span class="pet-badge">Pending</span>
                                @elseif($order->status === 'paid')
                                    <span class="pet-badge pet-badge-peach">Dibayar</span>
                                @else
                                    <span class="pet-badge" style="background-color: #fcece6; color: #c06c48;">{{ ucfirst($order->status) }}</span>
                                @endif
                            </div>
                        </div>

                        <hr style="border-color: var(--color-warm-border);">

                        <div class="mb-3">
                            <label class="small fw-semibold text-muted mb-2 d-block">Produk yang Dipesan</label>
                            @forelse($order->items as $item)
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small" style="color: var(--ink);">{{ $item->product->name ?? 'Produk' }}</span>
                                    <span class="small fw-semibold" style="color: var(--ink);">
                                        {{ $item->quantity }}x Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            @empty
                                <p class="small text-muted mb-0">Tidak ada produk</p>
                            @endforelse
                        </div>

                        <div style="background-color: var(--bg-peach); padding: 12px 16px; border-radius: 16px; margin-bottom: 16px;">
                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold" style="color: var(--ink);">Total Pembayaran</span>
                                <span class="fw-bold" style="color: var(--primary); font-size: 1.1rem;">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        @if($order->payment_proof)
                            <div class="mb-3">
                                <label class="small fw-semibold text-muted mb-1 d-block">Bukti Pembayaran</label>
                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="pet-btn pet-btn-outline py-2 px-3" style="font-size: 0.85rem; width: 100%;">
                                    👁️ Lihat Bukti Pembayaran
                                </a>
                            </div>
                        @endif

                        <div class="d-flex gap-2">
                            <a href="{{ route('orders.show', $order) }}" class="pet-btn pet-btn-outline flex-grow-1 py-2" style="font-size: 0.85rem;">
                                Detail Pesanan
                            </a>
                            @if($order->status === 'paid' || $order->status === 'completed')
                                <button class="pet-btn pet-btn-primary flex-grow-1 py-2" style="font-size: 0.85rem;" onclick="window.open('{{ route('orders.invoice', $order) }}', '_blank')">
                                    📥 Download Invoice
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="pet-card p-4">
                        <div class="text-center text-muted py-5">
                            <span class="fs-2 d-block mb-2">📄</span>
                            <p class="mb-0">Belum ada riwayat pembelian produk marketplace</p>
                            <a href="{{ route('marketplace.index') }}" class="pet-btn pet-btn-primary mt-3">Mulai Belanja</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
