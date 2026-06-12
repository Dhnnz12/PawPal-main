@extends('layouts.dashboard')

@section('dashboard_content')
    @php
        $cart = session()->get('cart', []);
        $cartTotal = 0;
        foreach($cart as $it) {
            $cartTotal += $it['price'] * $it['quantity'];
        }
    @endphp

    <div class="py-2">
        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 border-bottom pb-3">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">Marketplace Produk 🛒</h1>
                <div class="small text-muted">Beli pakan berkualitas, vitamin sehat, dan perlengkapan peliharaan terlengkap.</div>
            </div>
            <a class="pet-btn pet-btn-outline d-lg-none" href="{{ route('marketplace.cart') }}">🛒 Lihat Cart ({{ count($cart) }})</a>
        </div>

        <div class="row g-4">
            {{-- Products Area (Left) --}}
            <div class="col-12 col-lg-8">
                {{-- Categories list (Horizontal) --}}
                <div class="d-flex gap-2 overflow-x-auto pb-3 mb-4 scrollbar-hidden" style="white-space: nowrap; user-select: none; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none;">
                    <a href="#" class="pet-btn pet-btn-primary py-2 px-3 text-nowrap" style="font-size: 0.85rem; user-select: none;">📦 Semua Produk</a>
                    <a href="#" class="pet-btn pet-btn-outline py-2 px-3 text-nowrap" style="font-size: 0.85rem; user-select: none;">🍗 Makanan</a>
                    <a href="#" class="pet-btn pet-btn-outline py-2 px-3 text-nowrap" style="font-size: 0.85rem; user-select: none;">💊 Vitamin</a>
                    <a href="#" class="pet-btn pet-btn-outline py-2 px-3 text-nowrap" style="font-size: 0.85rem; user-select: none;">🧼 Perawatan</a>
                    <a href="#" class="pet-btn pet-btn-outline py-2 px-3 text-nowrap" style="font-size: 0.85rem; user-select: none;">🧣 Aksesoris</a>
                    <a href="#" class="pet-btn pet-btn-outline py-2 px-3 text-nowrap" style="font-size: 0.85rem; user-select: none;">🧶 Mainan</a>
                    <a href="#" class="pet-btn pet-btn-outline py-2 px-3 text-nowrap" style="font-size: 0.85rem; user-select: none;">🏡 Kandang</a>
                </div>

                {{-- Products Grid --}}
                <div class="row g-3">
                    @forelse($products as $p)
                        <div class="col-12 col-md-6">
                            <div class="pet-card p-3 h-100 d-flex flex-column justify-content-between bg-white">
                                <div>
                                    <div class="mb-2 d-flex justify-content-between align-items-center">
                                        <span class="pet-badge pet-badge-peach" style="font-size: 0.75rem;">{{ $p->seller->name ?? 'Seller' }}</span>
                                        <button class="btn btn-sm p-0 border-0 favorite-btn" onclick="toggleFavorite(this, {{ $p->id }})" style="font-size: 1.25rem; background: none; transition: transform 0.2s;" type="button">
                                            🤍
                                        </button>
                                    </div>
                                    <div class="nb-photo-mask bg-light mb-3 d-flex align-items-center justify-content-center" style="height: 140px; border-radius: 16px;">
                                        @if(!empty($p->image))
                                            <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <span class="fs-1 text-muted">📦</span>
                                        @endif
                                    </div>
                                    <h3 class="h6 mb-2" style="font-family: 'Outfit', sans-serif; font-weight: 700; color: #4e3629;">{{ $p->name }}</h3>
                                    <p class="small text-muted mb-2 text-truncate">{{ $p->description }}</p>
                                </div>

                                <div>
                                    <div class="d-flex align-items-center justify-content-between gap-2 border-bottom pb-2 mb-2" style="font-size: 0.85rem;">
                                        <span class="text-muted">Harga</span>
                                        <span class="fw-bold text-danger">Rp {{ number_format((float)$p->price, 0, ',', '.') }}</span>
                                    </div>
                                    
                                    <form method="POST" action="{{ route('marketplace.cart.add', $p) }}">
                                        @csrf
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <label class="small text-muted text-nowrap">Qty:</label>
                                            <input class="form-control pet-input py-1 text-center" type="number" name="quantity" min="1" max="{{ $p->stock }}" value="1" required style="max-width: 65px; height: 35px; padding: 4px;">
                                            <span class="small text-muted ms-auto">Stok: {{ $p->stock }}</span>
                                        </div>
                                        <button class="pet-btn pet-btn-primary w-100 py-2" type="submit" {{ $p->stock <= 0 ? 'disabled' : '' }} style="font-size: 0.85rem;">
                                            + Keranjang 🛒
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="pet-card p-4 text-center text-muted">Produk belum tersedia saat ini 🐶</div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Shopping Cart Summary Sidebar (Right) --}}
            <div class="col-12 col-lg-4">
                <div class="pet-card p-3 bg-white" style="border-radius: 20px; border: 1.5px solid var(--color-warm-border);">
                    <label class="fw-bold mb-3 d-block text-dark">🛍️ Keranjang Saya</label>
                    
                    @if(empty($cart))
                        <div class="text-center text-muted py-4 small">
                            Keranjang kosong.
                        </div>
                    @else
                        <div class="d-flex flex-column gap-3 mb-3" style="max-height: 240px; overflow-y: auto;">
                            @foreach($cart as $id => $item)
                                <div class="d-flex align-items-start justify-content-between gap-2 pb-2 border-bottom">
                                    <div style="flex-grow: 1;">
                                        <div class="fw-bold small text-dark text-truncate" style="max-width: 140px;">{{ $item['name'] }}</div>
                                        <div class="small text-muted">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                                    </div>
                                    <form method="POST" action="{{ route('marketplace.cart.remove', $id) }}" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm p-0 text-danger" type="submit" style="font-size: 0.9rem;">🗑️</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4 pt-2 border-top">
                            <span class="small fw-semibold">Subtotal</span>
                            <span class="fw-bold text-danger">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                        </div>

                        {{-- Direct Checkout CTA (use cart page so payment_proof field is available) --}}
                        <a href="{{ route('marketplace.cart') }}" class="pet-btn pet-btn-secondary w-100 py-2.5 text-center" style="font-size: 0.9rem;">
                            Checkout ➔
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const favorites = JSON.parse(localStorage.getItem('fav_products') || '[]');
            document.querySelectorAll('.favorite-btn').forEach(btn => {
                const idMatch = btn.getAttribute('onclick').match(/\d+/);
                if (idMatch && favorites.includes(idMatch[0])) {
                    btn.innerText = '❤️';
                }
            });
        });

        function toggleFavorite(btn, id) {
            let favorites = JSON.parse(localStorage.getItem('fav_products') || '[]');
            const idStr = id.toString();
            if (favorites.includes(idStr)) {
                favorites = favorites.filter(fid => fid !== idStr);
                btn.innerText = '🤍';
                btn.style.transform = 'scale(1)';
            } else {
                favorites.push(idStr);
                btn.innerText = '❤️';
                btn.style.transform = 'scale(1.2)';
                setTimeout(() => btn.style.transform = 'scale(1)', 200);
            }
            localStorage.setItem('fav_products', JSON.stringify(favorites));
        }
    </script>
@endsection
