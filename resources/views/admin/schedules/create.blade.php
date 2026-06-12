@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">➕ Tambah Jadwal Tenaga Klinik</h1>
                <div class="small text-muted">Buat slot jadwal ketersediaan kerja baru untuk tenaga klinik.</div>
            </div>
            <a class="pet-btn pet-btn-outline" href="{{ route('admin.services.index') }}">← Kembali</a>
        </div>

        {{-- Error Feedback --}}
        @if ($errors->any())
            <div class="alert alert-danger border-0 mb-4" style="background-color: #fcece6; color: #b05634; border-radius: 16px; font-weight: 500;">
                <h5 class="h6 fw-bold mb-2">⚠️ Harap perbaiki kesalahan berikut:</h5>
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Create Form --}}
        <div class="pet-card p-4">
            <form method="POST" action="{{ route('admin.schedules.store') }}">
                @csrf
                
                <div class="row g-4">
                    {{-- 1. Pilih Tenaga Klinik --}}
                    <div class="col-12 col-md-6 d-flex flex-column">
                        <label for="user_id" class="small fw-semibold text-muted mb-2">Tenaga Klinik <span class="text-danger">*</span></label>
                        <select name="user_id" id="user_id" class="form-select pet-input w-100" style="height: 50px;" required>
                            <option value="">-- Pilih Tenaga Klinik --</option>
                            @foreach($providers as $p)
                                <option value="{{ $p->id }}" {{ old('user_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }} ({{ ucfirst($p->provider_type) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 2. Pilih Hari --}}
                    <div class="col-12 col-md-6 d-flex flex-column">
                        <label for="day_of_week" class="small fw-semibold text-muted mb-2">Hari Operasional <span class="text-danger">*</span></label>
                        <select name="day_of_week" id="day_of_week" class="form-select pet-input w-100" style="height: 50px;" required>
                            <option value="">-- Pilih Hari --</option>
                            <option value="1" {{ old('day_of_week') == '1' ? 'selected' : '' }}>Senin</option>
                            <option value="2" {{ old('day_of_week') == '2' ? 'selected' : '' }}>Selasa</option>
                            <option value="3" {{ old('day_of_week') == '3' ? 'selected' : '' }}>Rabu</option>
                            <option value="4" {{ old('day_of_week') == '4' ? 'selected' : '' }}>Kamis</option>
                            <option value="5" {{ old('day_of_week') == '5' ? 'selected' : '' }}>Jumat</option>
                            <option value="6" {{ old('day_of_week') == '6' ? 'selected' : '' }}>Sabtu</option>
                            <option value="0" {{ old('day_of_week') == '0' ? 'selected' : '' }}>Minggu</option>
                        </select>
                    </div>

                    {{-- 3. Jam Mulai & Jam Selesai --}}
                    <div class="col-12 col-md-6 d-flex flex-column">
                        <label for="start_time" class="small fw-semibold text-muted mb-2">Jam Mulai <span class="text-danger">*</span></label>
                        <input type="time" name="start_time" id="start_time" class="pet-input" min="07:00" max="17:00" value="{{ old('start_time', '07:00') }}" required>
                        <div class="small text-muted mt-1">Buka jam 7 pagi (07:00)</div>
                    </div>

                    <div class="col-12 col-md-6 d-flex flex-column">
                        <label for="end_time" class="small fw-semibold text-muted mb-2">Jam Selesai <span class="text-danger">*</span></label>
                        <input type="time" name="end_time" id="end_time" class="pet-input" min="07:00" max="17:00" value="{{ old('end_time', '17:00') }}" required>
                        <div class="small text-muted mt-1">Tutup jam 5 sore (17:00)</div>
                    </div>

                    {{-- 4. Status Ketersediaan --}}
                    <div class="col-12 col-md-6 d-flex flex-column">
                        <label for="is_available" class="small fw-semibold text-muted mb-2">Status Ketersediaan <span class="text-danger">*</span></label>
                        <select name="is_available" id="is_available" class="form-select pet-input w-100" style="height: 50px;" required>
                            <option value="1" {{ old('is_available', '1') == '1' ? 'selected' : '' }}>Tersedia</option>
                            <option value="0" {{ old('is_available') == '0' ? 'selected' : '' }}>booked</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top d-flex gap-3 justify-content-end">
                    <a href="{{ route('admin.services.index') }}" class="pet-btn pet-btn-outline">Batal</a>
                    <button type="submit" class="pet-btn pet-btn-primary">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
@endsection
