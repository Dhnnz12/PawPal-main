@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2" style="max-width: 800px; margin: 0 auto;">
        <div class="mb-4">
            <a href="{{ route('owner.dashboard') }}" class="text-decoration-none" style="color: var(--primary); font-weight: 600;">← Kembali ke Dashboard</a>
            <h1 class="h3 mt-2 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">👤 Profil Saya</h1>
            <p class="text-muted small" style="font-family: 'Outfit', sans-serif;">Kelola dan perbarui informasi profil pribadi Anda.</p>
        </div>

        <div class="row g-4">
            {{-- Profile Info --}}
            <div class="col-12 col-md-6">
                <div class="pet-card p-4">
                    <h2 class="h5 mb-3" style="font-family: 'Fraunces', serif; font-weight: 700;">📋 Informasi Pribadi</h2>
                    
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1 d-block">Nama Lengkap</label>
                        <p class="fw-bold" style="color: var(--ink); font-size: 1.05rem;">{{ Auth::user()->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1 d-block">Email</label>
                        <p class="fw-bold" style="color: var(--ink);">{{ Auth::user()->email }}</p>
                    </div>

                    @if(Auth::user()->phone)
                        <div class="mb-3">
                            <label class="small fw-semibold text-muted mb-1 d-block">Nomor Telepon</label>
                            <p class="fw-bold" style="color: var(--ink);">{{ Auth::user()->phone }}</p>
                        </div>
                    @endif

                    @if(Auth::user()->bio)
                        <div class="mb-3">
                            <label class="small fw-semibold text-muted mb-1 d-block">Bio</label>
                            <p style="color: var(--ink);">{{ Auth::user()->bio }}</p>
                        </div>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="pet-btn pet-btn-primary w-100 mt-4">✏️ Edit Profil</a>
                </div>
            </div>

            {{-- Account Settings --}}
            <div class="col-12 col-md-6">
                <div class="pet-card p-4">
                    <h2 class="h5 mb-3" style="font-family: 'Fraunces', serif; font-weight: 700;">🔐 Keamanan Akun</h2>
                    
                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1 d-block">Tipe Akun</label>
                        <p class="fw-bold" style="color: var(--ink);">
                            @if(Auth::user()->isPetOwner())
                                🐾 Pet Owner
                            @else
                                {{ Auth::user()->roles->first()?->name ?? 'User' }}
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1 d-block">Bergabung Sejak</label>
                        <p class="fw-bold" style="color: var(--ink);">{{ Auth::user()->created_at->format('d M Y') }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="small fw-semibold text-muted mb-1 d-block">Status Verifikasi</label>
                        @if(Auth::user()->is_verified)
                            <span class="pet-badge pet-badge-sage">✓ Verified</span>
                        @else
                            <span class="pet-badge">Pending Verification</span>
                        @endif
                    </div>

                    <a href="{{ route('profile.edit') }}" class="pet-btn pet-btn-outline w-100 mt-4">🔑 Edit Password</a>
                </div>
            </div>

            {{-- Addresses Summary --}}
            <div class="col-12">
                <div class="pet-card p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h2 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700;">📍 Alamat Tersimpan</h2>
                        <a href="{{ route('addresses.index') }}" class="pet-btn pet-btn-outline py-2 px-3" style="font-size: 0.85rem;">Kelola Semua →</a>
                    </div>
                    
                    @if(Auth::user()->addresses->count() > 0)
                        <div class="row g-3">
                            @foreach(Auth::user()->addresses->take(3) as $address)
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div style="padding: 12px 16px; border: 1.5px solid var(--color-warm-border); border-radius: 16px; background-color: var(--bg-peach);">
                                        <p class="small fw-bold mb-1" style="color: var(--ink);">{{ $address->label }}</p>
                                        <p class="small mb-0 text-muted" style="font-size: 0.85rem;">{{ Str::limit($address->address_line, 40) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted small">Belum ada alamat tersimpan. <a href="{{ route('addresses.create') }}" style="color: var(--primary);">Tambah alamat</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
