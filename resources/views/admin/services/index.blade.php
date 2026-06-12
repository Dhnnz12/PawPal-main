@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-4 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">📅 Manajemen Layanan & Jadwal</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif; max-width: 500px;">Kelola layanan yang tersedia (Grooming, Vet, Pet Sitter) dan atur jadwal ketersediaan provider.</div>
            </div>
            <div class="d-flex gap-2">
                <a class="pet-btn pet-btn-primary" href="{{ route('services.create') }}">+ Tambah Layanan</a>
                <a class="pet-btn pet-btn-outline" href="{{ route('admin.dashboard') }}">← Dashboard</a>
            </div>
        </div>

        <div class="row g-4">
            {{-- Services List --}}
            <div class="col-12">
                <div class="pet-card p-4">
                    <div class="mb-3">
                        <h2 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700;">📋 Daftar Layanan</h2>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Layanan</th>
                                    <th>Deskripsi</th>
                                    <th class="text-end" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $service)
                                    <tr>
                                        <td><strong style="color: var(--ink);">{{ $service->name }}</strong></td>
                                        <td class="small text-muted">{{ Str::limit($service->description, 150) }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('services.edit', $service) }}" class="text-decoration-none fw-bold me-2" style="color: var(--primary); font-size: 0.9rem;">Edit</a>
                                            <form method="POST" action="{{ route('services.destroy', $service) }}" class="d-inline-block m-0" onsubmit="return confirm('Hapus layanan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="border-0 bg-transparent fw-bold p-0" style="color: #c06c48; font-size: 0.9rem; cursor: pointer;">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted small py-4">Belum ada layanan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Provider Schedules --}}
            <div class="col-12" id="schedules">
                <div class="pet-card p-4">
                    <div class="mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h2 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700;">⏰ Jadwal Tenaga Klinik & Slot Booking</h2>
                        <a class="pet-btn pet-btn-primary py-2 px-3" href="{{ route('admin.schedules.create') }}" style="font-size: 0.85rem;">+ Tambah Jadwal</a>
                    </div>

                    @php
                        $days = [
                            0 => 'Minggu',
                            1 => 'Senin',
                            2 => 'Selasa',
                            3 => 'Rabu',
                            4 => 'Kamis',
                            5 => 'Jumat',
                            6 => 'Sabtu'
                        ];
                    @endphp

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Tenaga Klinik</th>
                                    <th>Hari</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $schedule)
                                    <tr>
                                        <td><strong style="color: var(--ink);">{{ $schedule->provider->name ?? '-' }}</strong></td>
                                        <td>{{ $days[$schedule->day_of_week] ?? $schedule->day_of_week }}</td>
                                        <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                        <td>
                                            @if($schedule->is_available)
                                                <span class="pet-badge pet-badge-sage">Tersedia</span>
                                            @else
                                                <span class="pet-badge" style="background-color: #fcece6; color: #c06c48;">booked</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.schedules.edit', $schedule) }}" class="text-decoration-none fw-bold me-2" style="color: var(--primary); font-size: 0.9rem;">Edit</a>
                                            <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" class="d-inline-block m-0" onsubmit="return confirm('Hapus slot jadwal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="border-0 bg-transparent fw-bold p-0" style="color: #c06c48; font-size: 0.9rem; cursor: pointer;">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted small py-4">Belum ada jadwal</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
