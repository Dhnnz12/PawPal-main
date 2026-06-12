@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2" style="max-width: 820px; margin: 0 auto;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Tambah Hewan Peliharaan 🐾</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Masukkan data hewan peliharaan Anda untuk mulai mengelola profilnya.</div>
            </div>
            <div class="d-flex gap-2">
                <a class="pet-btn pet-btn-outline" href="{{ route('pets.index') }}">⬅️ Kembali</a>
            </div>
        </div>

        <div class="pet-card p-4">
            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-4 px-4 py-3 mb-4" style="background-color: #fcece6; color: #b05634; font-weight: 500;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('pets.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Nama Hewan</label>
                        <input class="form-control pet-input w-100" type="text" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Jenis (Spesies)</label>
                        <input class="form-control pet-input w-100" type="text" name="type" value="{{ old('type') }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Breed (opsional)</label>
                        <input class="form-control pet-input w-100" type="text" name="breed" value="{{ old('breed') }}">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Usia (tahun)</label>
                        <input class="form-control pet-input w-100" type="number" name="age" min="0" value="{{ old('age') }}" required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Berat (opsional)</label>
                        <input class="form-control pet-input w-100" type="number" name="weight" min="0" step="0.01" value="{{ old('weight') }}">
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Foto Profil (opsional)</label>
                        <input class="form-control pet-input w-100" type="file" name="photo" accept="image/*">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold" style="color: var(--ink);">Catatan Kesehatan (opsional)</label>
                        <textarea class="form-control pet-input w-100" name="health_notes" rows="4" placeholder="Misalnya: alergi, riwayat penyakit, jadwal vaksin...">{{ old('health_notes') }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button class="pet-btn pet-btn-primary w-100 py-3" type="submit">Simpan Hewan ✅</button>
                </div>
            </form>
        </div>
    </div>
@endsection

