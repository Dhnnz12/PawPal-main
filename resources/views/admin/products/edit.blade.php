@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2" style="max-width: 800px; margin: 0 auto;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Edit Produk 🛍️</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Perbarui data, stok, dan harga produk marketplace PawPal.</div>
            </div>
            <div>
                <a class="pet-btn pet-btn-outline" href="{{ route('admin.products.index') }}">← Kembali</a>
            </div>
        </div>

        <div class="pet-card p-4 mb-4">
            <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Nama Produk</label>
                        <input class="form-control pet-input w-100" type="text" name="name" value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Harga (Rp)</label>
                        <input class="form-control pet-input w-100" type="number" name="price" value="{{ old('price', $product->price) }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Stok</label>
                        <input class="form-control pet-input w-100" type="number" name="stock" value="{{ old('stock', $product->stock) }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Gambar Baru (opsional)</label>
                        <input class="form-control pet-input w-100" type="file" name="image" accept="image/*">
                    </div>

                    @if($product->image)
                        <div class="col-12">
                            <label class="form-label d-block fw-semibold" style="color: var(--ink);">Gambar Saat Ini</label>
                            <div class="nb-photo-mask bg-light" style="max-width: 200px; height: 120px; border-radius: 12px; overflow: hidden; border: 1.5px solid var(--color-warm-border);">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>
                    @endif

                    <div class="col-12">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Deskripsi Produk</label>
                        <textarea class="form-control pet-input w-100" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button class="pet-btn pet-btn-primary flex-grow-1 py-3" type="submit">Perbarui Produk ✅</button>
                </div>
            </form>
        </div>

        <div class="pet-card p-4 mt-4" style="border: 1.5px solid #f5d7cb; background-color: #fcece6; border-radius: 22px;">
            <h3 class="h6 fw-bold text-danger mb-2">⚠️ Hapus Produk</h3>
            <p class="small text-muted mb-3">Tindakan ini akan menghapus produk secara permanen dari marketplace.</p>
            <form method="POST" action="{{ route('products.destroy', $product) }}" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="pet-btn pet-btn-danger py-2 px-3">Hapus Produk 🗑️</button>
            </form>
        </div>
    </div>
@endsection
