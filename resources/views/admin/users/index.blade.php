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

        {{-- Header --}}
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-4 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 800; color: var(--ink);">👥 Manajemen Pengguna</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif; max-width: 500px;">Kelola data pengguna, Pet Owner, Service Provider, dan status keaktifan akun mereka.</div>
            </div>
            <div class="d-flex gap-2">
                <a class="pet-btn pet-btn-primary" href="{{ route('admin.users.create') }}">+ Tambah Pengguna</a>
                <a class="pet-btn pet-btn-outline" href="{{ route('admin.dashboard') }}">← Dashboard</a>
            </div>
        </div>

        {{-- Filter Pills --}}
        <div class="d-flex flex-wrap gap-2 mb-4">
            <a href="{{ route('admin.users.index') }}" 
               class="pet-btn py-2 px-3 fs-6 {{ !$roleFilter ? 'pet-btn-secondary' : 'pet-btn-outline' }}" style="font-size: 0.85rem;">
                Semua
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'pet_owner']) }}" 
               class="pet-btn py-2 px-3 fs-6 {{ $roleFilter === 'pet_owner' ? 'pet-btn-secondary' : 'pet-btn-outline' }}" style="font-size: 0.85rem;">
                🐾 Pet Owner
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'service_provider', 'type' => 'groomer']) }}" 
               class="pet-btn py-2 px-3 fs-6 {{ $roleFilter === 'service_provider' && $typeFilter === 'groomer' ? 'pet-btn-secondary' : 'pet-btn-outline' }}" style="font-size: 0.85rem;">
                ✨ Groomer
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'service_provider', 'type' => 'veterinarian']) }}" 
               class="pet-btn py-2 px-3 fs-6 {{ $roleFilter === 'service_provider' && $typeFilter === 'veterinarian' ? 'pet-btn-secondary' : 'pet-btn-outline' }}" style="font-size: 0.85rem;">
                🩺 Dokter Hewan
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" 
               class="pet-btn py-2 px-3 fs-6 {{ $roleFilter === 'admin' ? 'pet-btn-secondary' : 'pet-btn-outline' }}" style="font-size: 0.85rem;">
                🛡️ Admin
            </a>
        </div>

        {{-- Users Card --}}
        <div class="pet-card p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700;">Daftar Pengguna</h2>
                <span class="pet-badge pet-badge-sage">{{ $users->count() }} Pengguna</span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr style="border-bottom: 2px solid #eadacb;">
                            <th>Pengguna</th>
                            <th>Email & Telepon</th>
                            <th>Role / Tipe</th>
                            <th>Keaktifan</th>
                            <th>Status Verifikasi</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr style="border-bottom: 1px solid #f2ebdf;">
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                                 alt="{{ $user->name }}" 
                                                 style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; border: 1.5px solid #eadacb;">
                                        @else
                                            <div style="width: 44px; height: 44px; border-radius: 50%; background-color: var(--bg-peach); border: 1.5px solid #eadacb; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                                                👤
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold" style="color: var(--ink);">{{ $user->name }}</div>
                                            @if($user->bio)
                                                <div class="small text-muted" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                    {{ $user->bio }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>{{ $user->email }}</div>
                                    <div class="small text-muted">{{ $user->phone ?? '-' }}</div>
                                </td>
                                <td>
                                    @if($user->isPetOwner())
                                        <span class="pet-badge pet-badge-peach">🐾 Pet Owner</span>
                                    @elseif($user->isVet())
                                        <span class="pet-badge pet-badge-sage">🩺 Dokter Hewan</span>
                                    @elseif($user->isGroomer())
                                        <span class="pet-badge pet-badge-sage">✨ Groomer</span>
                                    @elseif($user->isAdmin())
                                        <span class="pet-badge" style="background-color: #e5e7eb; color: #374151; border-color: #d1d5db;">🛡️ Admin</span>
                                    @else
                                        <span class="pet-badge">👤 Pengguna</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->is_active ?? true)
                                        <span class="pet-badge pet-badge-sage">Aktif</span>
                                    @else
                                        <span class="pet-badge" style="background-color: #fcece6; color: #c06c48;">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->is_verified)
                                        <span class="pet-badge pet-badge-sage">✓ Verified</span>
                                    @else
                                        <span class="pet-badge" style="background-color: #fcece6; color: #c06c48;">Unverified</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-2 justify-content-end align-items-center">
                                        <a href="{{ route('admin.users.show', $user) }}" class="text-decoration-none fw-bold" style="color: var(--accent); font-size: 0.9rem;">Detail</a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="text-decoration-none fw-bold" style="color: var(--secondary); font-size: 0.9rem;">Edit</a>
                                        
                                        @if(!$user->isAdmin())
                                            <form method="POST" action="{{ route('admin.users.toggleStatus', $user) }}" class="d-inline m-0">
                                                @csrf
                                                <button type="submit" class="btn btn-link p-0 text-decoration-none fw-bold shadow-none" 
                                                        style="color: #c06c48; font-size: 0.9rem; border: none; background: none;">
                                                    {{ $user->is_active ?? true ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini? Semua data terkait (hewan, layanan, rekam medis, dll.) akan ikut terhapus!');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link p-0 text-decoration-none fw-bold shadow-none" 
                                                        style="color: #dc3545; font-size: 0.9rem; border: none; background: none;">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted small py-5">
                                    <div class="fs-1 mb-2">👥</div>
                                    Belum ada data pengguna yang sesuai dengan filter ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
