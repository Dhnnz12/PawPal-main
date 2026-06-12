@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2" style="max-width: 700px; margin: 0 auto;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">📄 Detail Pesanan & Invoice</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Invoice dan riwayat pembayaran pesanan marketplace Anda</div>
            </div>
            <div>
                @if(Auth::user()->isAdmin())
                    <a class="pet-btn pet-btn-outline" href="{{ route('admin.transactions.index') }}">← Kembali</a>
                @else
                    <a class="pet-btn pet-btn-outline" href="{{ route('orders.index') }}">← Kembali</a>
                @endif
            </div>
        </div>

        <div class="pet-card p-4 mb-4">
            {{-- Order Header --}}
            <div class="d-flex align-items-start justify-content-between mb-4">
                <div>
                    <h3 class="h5 mb-2" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Order #{{ $order->id }}</h3>
                    <p class="small text-muted mb-0">{{ $order->created_at->format('d F Y \\p\\u\\k\\u\\l H:i') }}</p>
                </div>
                <div class="text-end">
                    @if($order->status === 'completed')
                        <span class="pet-badge pet-badge-sage">✓ Selesai</span>
                    @elseif($order->status === 'pending')
                        <span class="pet-badge">⏳ Pending</span>
                    @elseif($order->status === 'paid')
                        <span class="pet-badge pet-badge-peach">✓ Dibayar</span>
                    @else
                        <span class="pet-badge" style="background-color: #fcece6; color: #c06c48;">{{ ucfirst($order->status) }}</span>
                    @endif
                </div>
            </div>

            <hr style="border-color: var(--color-warm-border);">

            {{-- Items List --}}
            <div class="mb-4">
                <h4 class="h6 mb-3" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">🛍️ Produk Pesanan</h4>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr style="border-bottom: 2px solid #e8dcc8;">
                                <th>Produk</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Harga</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->items as $item)
                                <tr>
                                    <td>
                                        <div style="color: var(--ink); font-weight: 600;">{{ $item->product->name ?? 'Produk' }}</div>
                                        <div class="small text-muted">{{ $item->product->seller->name ?? 'Seller' }}</div>
                                    </td>
                                    <td class="text-center fw-semibold" style="color: var(--ink);">{{ $item->quantity }} pcs</td>
                                    <td class="text-end" style="color: var(--primary); font-weight: 600;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-end" style="color: var(--primary); font-weight: 700;">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Tidak ada produk</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <hr style="border-color: var(--color-warm-border);">

            {{-- Order Summary --}}
            <div class="mb-4">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="small fw-semibold text-muted mb-2 d-block">💳 Subtotal Produk</label>
                        <p class="h6" style="color: var(--primary);">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="small fw-semibold text-muted mb-2 d-block">🚚 Ongkos Kirim</label>
                        <p class="h6" style="color: var(--ink);">Rp 0</p>
                    </div>
                    <div class="col-12">
                        <div style="background-color: #faf6f0; padding: 12px 16px; border-radius: 15px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <label class="fw-semibold" style="color: var(--ink);">Total Pembayaran</label>
                                <p class="h5 mb-0" style="color: var(--primary); font-weight: 700;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr style="border-color: var(--color-warm-border);">

            {{-- Payment Status --}}
            <div class="mb-4">
                <h4 class="h6 mb-3" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">💰 Status Pembayaran</h4>
                <div class="p-3 rounded" style="background-color: #faf6f0; border-radius: 15px;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="small fw-semibold" style="color: var(--ink);">Status</span>
                        @if($order->status === 'pending')
                            <span class="pet-badge">⏳ Menunggu Verifikasi</span>
                        @elseif($order->status === 'paid')
                            <span class="pet-badge pet-badge-peach">✓ Sudah Dibayar</span>
                        @elseif($order->status === 'completed')
                            <span class="pet-badge pet-badge-sage">✓ Selesai</span>
                        @elseif($order->status === 'cancelled')
                            <span class="pet-badge" style="background-color: #fcece6; color: #c06c48;">❌ Dibatalkan</span>
                        @else
                            <span class="pet-badge">{{ ucfirst($order->status) }}</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="small fw-semibold" style="color: var(--ink);">Metode</span>
                        <span class="small" style="color: var(--ink);">Transfer Bank BCA (689067)</span>
                    </div>
                        @if($order->payment_proof)
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small fw-semibold" style="color: var(--ink);">Bukti Transfer</span>
                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="small fw-bold text-decoration-none" style="color: var(--primary);">
                                    📄 Lihat Bukti Transfer
                                </a>
                            </div>
                        @endif
                </div>
            </div>

            {{-- Invoice Download --}}
            <div class="mb-4">
                <h4 class="h6 mb-3" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">📥 Dokumen</h4>
                <button class="pet-btn pet-btn-outline w-100 py-2" onclick="window.open('{{ route('orders.invoice', $order) }}', '_blank')">
                    📥 Download Invoice PDF
                </button>
            </div>

            {{-- Action Buttons --}}
            <hr style="border-color: var(--color-warm-border);">
            
            <div class="d-flex gap-2 mt-4">
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.transactions.index') }}" class="pet-btn pet-btn-outline flex-grow-1 py-2">← Kembali ke Daftar</a>
                @else
                    <a href="{{ route('orders.index') }}" class="pet-btn pet-btn-outline flex-grow-1 py-2">← Kembali ke Daftar</a>
                @endif
            </div>
        </div>
    </div>
@endsection
