@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Daftar Alamat Pengguna 📍</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Simpan dan kelola alamat pengantaran atau kunjungan layanan.</div>
            </div>
            <div>
                <a class="pet-btn pet-btn-primary" href="{{ route('addresses.create') }}">➕ Tambah Alamat</a>
            </div>
        </div>

        <div class="pet-card p-4">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>Alamat Lengkap</th>
                            <th>Kota</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($addresses as $addr)
                            <tr>
                                <td>
                                    <span class="pet-badge pet-badge-peach">{{ $addr->label }}</span>
                                    @if($addr->is_primary)
                                        <span class="pet-badge pet-badge-sage ms-1">Utama</span>
                                    @endif
                                </td>
                                <td>{{ $addr->address_line }}</td>
                                <td>{{ $addr->city }}</td>
                                <td class="text-end">
                                    <a href="{{ route('addresses.show', $addr) }}" class="text-decoration-none fw-bold me-3" style="color: var(--secondary);">Detail</a>
                                    <a href="{{ route('addresses.edit', $addr) }}" class="text-decoration-none fw-bold" style="color: var(--primary);">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted small py-4">
                                    Belum ada alamat terdaftar. Silakan tambahkan alamat Anda terlebih dahulu 🧡
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
