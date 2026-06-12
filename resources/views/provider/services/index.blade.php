@extends('layouts.app')

@section('content')
    <div class="py-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 border-bottom pb-3">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">Katalog Layanan</h1>
                <div class="small text-muted">Kelola layanan yang tersedia untuk pelanggan.</div>
            </div>
            <a class="pet-btn pet-btn-primary" href="{{ route('services.create') }}">➕ Tambah Layanan</a>
        </div>

        {{-- Katalog layanan dihilangkan (menurut feedback). --}}
        <div class="pet-card p-4 text-muted small" style="border-radius: 18px;">
            Halaman ini sengaja tidak menampilkan katalog layanan.
        </div>
    </div>
@endsection

