@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        {{-- Flash messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="background-color: var(--bg-sage); color: #43634f; border-radius: 16px; font-weight: 500;">
                ✨ {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="background-color: #fcece6; color: #b05634; border-radius: 16px; font-weight: 500;">
                ⚠️ {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 border-bottom pb-3">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">👤 Detail Pengguna</h1>
                <div class="small text-muted">Informasi pendaftaran, peran, sertifikat, dan data operasional pengguna.</div>
            </div>
            <div class="d-flex gap-2">
                <a class="pet-btn pet-btn-outline" href="{{ route('admin.users.index') }}">← Kembali</a>
                <a class="pet-btn pet-btn-secondary" href="{{ route('admin.users.edit', $user) }}">Edit Pengguna</a>
            </div>
        </div>

        <div class="row g-4">
            {{-- Left column: Avatar and Quick Status --}}
            <div class="col-12 col-md-4 text-center">
                <div class="pet-card p-4 bg-light h-100 d-flex flex-column align-items-center justify-content-center">
                    <div class="mb-3">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                 alt="{{ $user->name }}" 
                                 style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; border: 3px solid #eadacb; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                        @else
                            <div style="width: 130px; height: 130px; border-radius: 50%; background-color: #ffffff; border: 3px solid #eadacb; display: flex; align-items: center; justify-content: center; font-size: 4.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                                👤
                            </div>
                        @endif
                    </div>
                    
                    <h3 class="h5 mb-2" style="font-family: 'Fraunces', serif; font-weight: 700;">{{ $user->name }}</h3>
                    
                    <div class="d-flex flex-column gap-2 w-100 mt-2 align-items-center">
                        @if($user->isPetOwner())
                            <span class="pet-badge pet-badge-peach px-3 py-1">🐾 Pet Owner</span>
                        @elseif($user->isVet())
                            <span class="pet-badge pet-badge-sage px-3 py-1">🩺 Dokter Hewan</span>
                        @elseif($user->isGroomer())
                            <span class="pet-badge pet-badge-sage px-3 py-1">✨ Groomer</span>
                        @elseif($user->isAdmin())
                            <span class="pet-badge px-3 py-1" style="background-color: #e5e7eb; color: #374151; border-color: #d1d5db;">🛡️ Admin</span>
                        @else
                            <span class="pet-badge px-3 py-1">👤 Pengguna</span>
                        @endif

                        <div class="d-flex gap-2 mt-2">
                            @if($user->is_active ?? true)
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="border-radius: 6px; font-size: 0.8rem;">Akun Aktif</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" style="border-radius: 6px; font-size: 0.8rem;">Akun Dinonaktifkan</span>
                            @endif

                            @if($user->is_verified)
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="border-radius: 6px; font-size: 0.8rem;">Terverifikasi</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1" style="border-radius: 6px; font-size: 0.8rem;">Belum Verifikasi</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right column: Full Details & Admin Actions --}}
            <div class="col-12 col-md-8">
                <div class="pet-card p-4 h-100">
                    <h2 class="h5 mb-4" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink); border-bottom: 2px dashed #eadacb; padding-bottom: 10px;">📄 Informasi Lengkap</h2>
                    
                    <div class="row g-4 mb-4">
                        <div class="col-12 col-sm-6">
                            <label class="small fw-semibold text-muted d-block mb-1">Email</label>
                            <div class="fw-bold text-dark fs-5">{{ $user->email }}</div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="small fw-semibold text-muted d-block mb-1">Nomor Telepon</label>
                            <div class="fw-bold text-dark fs-5">{{ $user->phone ?? '-' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small fw-semibold text-muted d-block mb-1">Bio / Deskripsi Profil</label>
                            <p class="mb-0 text-dark" style="line-height: 1.6; background-color: #fafafa; padding: 12px; border-radius: 12px; border: 1px solid #f0f0f0;">
                                {{ $user->bio ?? 'Tidak ada deskripsi bio.' }}
                            </p>
                        </div>

                        {{-- Service Provider Specific Data --}}
                        @if($user->isServiceProvider())
                            <div class="col-12 col-sm-6">
                                <label class="small fw-semibold text-muted d-block mb-1">Tipe Provider</label>
                                <span class="pet-badge pet-badge-sage">{{ ucfirst($user->provider_type) }}</span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label class="small fw-semibold text-muted d-block mb-1">Koordinat Lokasi</label>
                                @if($user->latitude && $user->longitude)
                                    <div class="fw-semibold text-dark">
                                        📍 {{ $user->latitude }}, {{ $user->longitude }}
                                    </div>
                                @else
                                    <div class="text-muted small">Koordinat belum diatur</div>
                                @endif
                            </div>

                            @if(in_array($user->provider_type, ['veterinarian']))
                                <div class="col-12">
                                    <label class="small fw-semibold text-muted d-block mb-1">📄 Dokumen Sertifikasi</label>
                                    @if($user->certification)
                                        <div class="d-flex align-items-center gap-3 p-3 rounded-4" style="background-color: var(--bg-sage); border: 1.5px solid #c8dfd2;">
                                            <div class="fs-2">📄</div>
                                            <div>
                                                <div class="fw-bold" style="color: #43634f;">Dokumen Sertifikasi Tersedia</div>
                                                <a href="{{ asset('storage/' . $user->certification) }}" target="_blank" class="pet-btn pet-btn-primary py-1 px-3 mt-2" style="font-size: 0.85rem;">
                                                    Buka / Unduh Berkas
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="p-3 rounded-4 text-center text-muted small" style="background-color: #fcece6; border: 1.5px solid #f7dcd1;">
                                            ⚠️ Berkas sertifikasi belum diunggah.
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>

                    {{-- Admin actions panel --}}
                    @if(!$user->isAdmin())
                        <div class="p-3 rounded-4 mt-4" style="background-color: var(--bg-peach); border: 1.5px solid #eadacb;">
                            <h3 class="h6 mb-3 fw-bold" style="color: var(--ink);">⚙️ Panel Aksi Cepat Admin</h3>
                            
                            <div class="d-flex flex-wrap gap-2">
                                {{-- Verify buttons --}}
                                @if($user->isServiceProvider())
                                    @if(!$user->is_verified)
                                        <form method="POST" action="{{ route('admin.verifyProvider', $user) }}" class="m-0">
                                            @csrf
                                            <input type="hidden" name="action" value="approve">
                                            <button type="submit" class="pet-btn pet-btn-primary py-2 px-3" style="font-size: 0.85rem;">
                                                ✓ Verifikasi Akun
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.verifyProvider', $user) }}" class="m-0">
                                            @csrf
                                            <input type="hidden" name="action" value="reject">
                                            <button type="submit" class="pet-btn pet-btn-outline py-2 px-3" style="font-size: 0.85rem; border-color: #c06c48; color: #c06c48 !important;">
                                                ✗ Batalkan Verifikasi (Tolak)
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                {{-- Toggle Active Status --}}
                                <form method="POST" action="{{ route('admin.users.toggleStatus', $user) }}" class="m-0">
                                    @csrf
                                    @if($user->is_active ?? true)
                                        <button type="submit" class="pet-btn pet-btn-outline py-2 px-3" style="font-size: 0.85rem; border-color: #dc3545; color: #dc3545 !important;">
                                            🚫 Nonaktifkan Akun
                                        </button>
                                    @else
                                        <button type="submit" class="pet-btn pet-btn-primary py-2 px-3" style="font-size: 0.85rem; background-color: var(--accent);">
                                            🔌 Aktifkan Akun
                                        </button>
                                    @endif
                                </form>

                                {{-- Delete --}}
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="pet-btn py-2 px-3 text-white" style="font-size: 0.85rem; background-color: #dc3545; border: none; border-radius: 999px;">
                                        🗑️ Hapus Akun
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
