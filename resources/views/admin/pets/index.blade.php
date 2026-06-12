@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-4 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">🐶 Manajemen Data Hewan Peliharaan</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif; max-width: 500px;">Lihat semua data hewan peliharaan yang terdaftar dalam sistem.</div>
            </div>
            <div>
                <a class="pet-btn pet-btn-outline" href="{{ route('admin.dashboard') }}">← Dashboard</a>
            </div>
        </div>

        <div class="pet-card p-4">
            <div class="mb-3">
                <h2 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700;">🐾 Daftar Semua Hewan Peliharaan</h2>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Nama Hewan</th>
                            <th>Jenis</th>
                            <th>Pemilik</th>
                            <th>Umur</th>
                            <th>Berat</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pets as $pet)
                            <tr>
                                <td><strong style="color: var(--ink);">{{ $pet->name }}</strong></td>
                                <td><span class="pet-badge pet-badge-peach">{{ $pet->type }}</span></td>
                                <td>{{ $pet->owner->name ?? '-' }}</td>
                                <td>{{ $pet->age ?? '-' }} tahun</td>
                                <td>{{ $pet->weight ?? '-' }} kg</td>
                                <td class="text-end">
                                    <a href="{{ route('pets.show', $pet) }}" class="text-decoration-none fw-bold me-2" style="color: var(--accent); font-size: 0.9rem;">Detail</a>
                                    <a href="{{ route('pets.edit', $pet) }}" class="text-decoration-none fw-bold me-2" style="color: var(--primary); font-size: 0.9rem;">Edit</a>
                                    <form method="POST" action="{{ route('pets.destroy', $pet) }}" class="d-inline-block m-0" onsubmit="return confirm('Hapus profil hewan ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border-0 bg-transparent fw-bold p-0" style="color: #c06c48; font-size: 0.9rem; cursor: pointer;">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted small py-4">Belum ada data hewan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
