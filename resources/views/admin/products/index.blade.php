@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-4 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">🛒 Manajemen Produk Marketplace</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif; max-width: 500px;">Kelola produk yang dijual di marketplace, harga, stok, dan kelengkapan data.</div>
            </div>
            <div class="d-flex gap-2">
                <a class="pet-btn pet-btn-primary" href="{{ route('products.create') ?? '#' }}">+ Tambah Produk</a>
                <a class="pet-btn pet-btn-outline" href="{{ route('admin.dashboard') }}">← Dashboard</a>
            </div>
        </div>

        <div class="pet-card p-4">
            <div class="mb-3">
                <h2 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700;">📦 Daftar Produk</h2>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Seller</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <strong style="color: var(--ink);">{{ $product->name }}</strong>
                                    <div class="small text-muted">{{ Str::limit($product->description, 50) }}</div>
                                </td>
                                <td>{{ $product->seller->name ?? '-' }}</td>
                                <td>
                                    <strong style="color: var(--primary);">Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    @if($product->stock > 10)
                                        <span class="pet-badge pet-badge-sage">{{ $product->stock }} pcs</span>
                                    @elseif($product->stock > 0)
                                        <span class="pet-badge">{{ $product->stock }} pcs</span>
                                    @else
                                        <span class="pet-badge" style="background-color: #fcece6; color: #c06c48;">Habis</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="pet-badge pet-badge-sage">Active</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('products.edit', $product) ?? '#' }}" class="text-decoration-none fw-bold me-2" style="color: var(--primary); font-size: 0.9rem;">Edit</a>
                                    <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline-block m-0" onsubmit="return confirm('Hapus produk ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border-0 bg-transparent fw-bold p-0" style="color: #c06c48; font-size: 0.9rem; cursor: pointer;">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted small py-4">Belum ada produk</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
