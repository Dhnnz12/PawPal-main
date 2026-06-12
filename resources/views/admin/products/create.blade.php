@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2" style="max-width: 800px; margin: 0 auto;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Tambah Produk Baru 🛍️</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Tambahkan produk baru ke dalam inventori marketplace.</div>
            </div>
            <div>
                <a class="pet-btn pet-btn-outline" href="{{ route('admin.products.index') }}">← Kembali</a>
            </div>
        </div>

        <div class="pet-card p-4">
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Nama Produk</label>
                        <input class="form-control pet-input w-100" type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Royal Canin Cat Food">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Harga (Rp)</label>
                        <input class="form-control pet-input w-100" type="number" name="price" value="{{ old('price') }}" required placeholder="Contoh: 125000">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Stok Awal</label>
                        <input class="form-control pet-input w-100" type="number" name="stock" value="{{ old('stock', 10) }}" required placeholder="Contoh: 50">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Gambar Produk (opsional)</label>
                        <input class="form-control pet-input w-100" type="file" name="image" accept="image/*">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Deskripsi Produk</label>
                        <textarea class="form-control pet-input w-100" name="description" rows="4" placeholder="Tuliskan deskripsi lengkap produk, nutrisi, manfaat, atau cara penggunaan...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="pet-btn pet-btn-primary w-100 py-3" type="submit">Simpan Produk ✅</button>
                </div>
            </form>
        </div>
    </div>
@endsection
