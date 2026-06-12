@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 border-bottom pb-3">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">Booking Layanan 🐾</h1>
                <div class="small text-muted">Tentukan kategori layanan, tanggal, dan slot jam kunjungan di klinik.</div>
            </div>
            <a class="pet-btn pet-btn-outline" href="{{ route('booking.search') }}">← Kembali</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger border-0 mb-4" style="background-color: #fcece6; color: #b05634; border-radius: 16px; font-weight: 500;">
                <h5 class="h6 fw-bold mb-2">⚠️ Peringatan:</h5>
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($pets->isEmpty())
            <div class="alert alert-warning border-0 mb-4" style="background-color: #fff9f3; color: #b06948; border-radius: 16px; font-weight: 500;">
                🐾 Anda belum mendaftarkan hewan peliharaan. Silakan <a href="{{ route('pets.create') }}" class="fw-bold" style="color: var(--primary);">tambah hewan peliharaan</a> terlebih dahulu sebelum melakukan booking.
            </div>
        @endif

        <form method="POST" action="{{ route('booking.store') }}">
            @csrf
            <input type="hidden" name="provider_id" value="{{ $provider->id }}">

            <div class="row g-4">
                {{-- Column 1: Service Selection --}}
                <div class="col-12 col-lg-3">
                    <div class="pet-card p-3 bg-white h-100">
                        <label class="fw-bold mb-3 d-block text-dark">📋 Pilih Layanan</label>
                        <div class="d-flex flex-column gap-2">
                            @foreach($services as $s)
                                <div class="p-3 rounded-3 border d-flex flex-column justify-content-between bg-light" style="cursor: pointer;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="service_id" id="service_{{ $s->id }}" value="{{ $s->id }}" required checked>
                                        <label class="form-check-label fw-bold small" for="service_{{ $s->id }}">
                                            {{ $s->name }}
                                        </label>
                                    </div>
                                    <div class="small text-primary fw-bold mt-2">Rp {{ number_format($s->price, 0, ',', '.') }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Column 2: Date Picker (Native Date Input) --}}
                <div class="col-12 col-lg-5">
                    <div class="pet-card p-3 bg-white h-100">
                        <label class="fw-bold mb-3 d-block text-dark">📅 Pilih Tanggal Kunjungan</label>
                        <div class="mb-4">
                            <input type="date" name="booking_date" id="selected_date_input" class="form-control pet-input py-3" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required onchange="updateTimeSlots()">
                        </div>
                        <div class="alert alert-info border-0 p-3" style="border-radius: 16px; background-color: #f0f7f4; color: #355e4e; font-size: 0.85rem;">
                            💡 Silakan tentukan tanggal di atas. Sistem akan menyelaraskan dengan jadwal kerja operasional tenaga klinik.
                        </div>
                    </div>
                </div>

                {{-- Column 3: Waktu, Hewan, Konfirmasi --}}
                <div class="col-12 col-lg-4">
                    <div class="pet-card p-3 bg-white h-100 d-flex flex-column justify-content-between">
                        <div>
                            {{-- Waktu Mulai --}}
                            <div class="mb-3">
                                <label class="fw-bold mb-2 d-block text-dark">⏰ Pilih Slot Jam</label>
                                <div class="row g-2" id="time-slots-container" style="max-height: 250px; overflow-y: auto;">
                                    {{-- Time slots will be generated dynamically by JavaScript --}}
                                </div>
                                <input type="hidden" name="start_time" id="selected_time_input" required>
                            </div>

                            {{-- Pilih Hewan --}}
                            <div class="mb-3">
                                <label class="fw-bold mb-2 d-block text-dark">🐾 Pilih Hewan</label>
                                <select class="form-select pet-input w-100" name="pet_id" required style="height: 50px;">
                                    @foreach($pets as $pet)
                                        <option value="{{ $pet->id }}">{{ $pet->name }} ({{ $pet->type }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" id="btn-submit-booking" class="pet-btn pet-btn-primary w-100 py-3 mt-3">
                            Booking Sekarang ➔
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        const bookedSlots = @json($bookedSlots);
        const providerSchedules = @json($schedules);

        function selectTime(element, timeStr) {
            document.querySelectorAll('.time-slot-btn').forEach(el => {
                el.classList.remove('active');
                el.style.backgroundColor = '';
                el.style.color = '';
                el.style.borderColor = '';
            });
            element.classList.add('active');
            element.style.backgroundColor = 'var(--secondary)';
            element.style.color = '#white';
            element.style.borderColor = 'var(--secondary)';
            document.getElementById('selected_time_input').value = timeStr;
        }

        function updateTimeSlots() {
            const selectedDateStr = document.getElementById('selected_date_input').value;
            const container = document.getElementById('time-slots-container');
            const submitBtn = document.getElementById('btn-submit-booking');
            
            if (!selectedDateStr) {
                container.innerHTML = '<div class="col-12 text-center text-muted small py-3">Pilih tanggal terlebih dahulu</div>';
                return;
            }

            // Get day of week (0 = Sunday, 1 = Monday, etc.)
            // Note: JS Date constructor parses local dates if split correctly
            const dateParts = selectedDateStr.split('-');
            const dateObj = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
            const dayOfWeek = dateObj.getDay();

            // Find schedule for this day
            const schedule = providerSchedules.find(s => s.day_of_week === dayOfWeek);

            if (!schedule) {
                container.innerHTML = '<div class="col-12 text-center text-danger small py-3">⚠️ Tenaga klinik tidak bertugas pada hari tersebut.</div>';
                document.getElementById('selected_time_input').value = '';
                submitBtn.disabled = true;
                return;
            }

            submitBtn.disabled = false;

            const slotPairs = [
                { start: '07:00', end: '08:00', display: '07:00 - 08:00' },
                { start: '08:00', end: '09:00', display: '08:00 - 09:00' },
                { start: '09:00', end: '10:00', display: '09:00 - 10:00' },
                { start: '10:00', end: '11:00', display: '10:00 - 11:00' },
                { start: '13:00', end: '14:00', display: '13:00 - 14:00' },
                { start: '14:00', end: '15:00', display: '14:00 - 15:00' },
                { start: '15:00', end: '16:00', display: '15:00 - 16:00' },
                { start: '16:00', end: '17:00', display: '16:00 - 17:00' }
            ];
            
            let html = '';
            let anyAvailable = false;

            slotPairs.forEach(slot => {
                const key = selectedDateStr + '_' + slot.start;
                const isBooked = bookedSlots.includes(key);
                
                // Check if slot is within provider operational hours
                const schedStart = schedule.start_time.substring(0, 5);
                const schedEnd = schedule.end_time.substring(0, 5);
                
                const isWithinWorkingHours = (slot.start >= schedStart && slot.end <= schedEnd);

                if (!isWithinWorkingHours) {
                    return; // Skip slots outside of specific workday hours
                }

                anyAvailable = true;

                if (isBooked) {
                    html += `
                        <div class="col-12">
                            <button type="button" class="time-slot-btn w-100 text-center py-2" disabled style="background-color: #fcece6; color: #c06c48; border: 1.5px solid #f5d7cb; cursor: not-allowed; opacity: 0.8; font-size: 0.85rem; border-radius: 12px; height: 44px; font-weight: 500;">
                                ${slot.display} &nbsp;<span style="font-size: 0.75rem; font-weight: bold; background: #eba991; color: white; padding: 2px 6px; border-radius: 6px;">booked</span>
                            </button>
                        </div>
                    `;
                } else {
                    html += `
                        <div class="col-12">
                            <button type="button" class="time-slot-btn w-100 text-center py-2 btn btn-outline-light" onclick="selectTime(this, '${slot.start}')" style="font-size: 0.85rem; border-radius: 12px; height: 44px; color: var(--ink); border: 1.5px solid var(--color-warm-border); font-weight: 500;">
                                ${slot.display} &nbsp;<span style="font-size: 0.75rem; font-weight: bold; background: var(--bg-sage); color: #43634f; padding: 2px 6px; border-radius: 6px;">tersedia</span>
                            </button>
                        </div>
                    `;
                }
            });

            if (!anyAvailable) {
                container.innerHTML = '<div class="col-12 text-center text-muted small py-3">Tidak ada slot operasional di jam kerja ini</div>';
            } else {
                container.innerHTML = html;
            }
            
            // Auto-select first available slot if any
            const firstAvailable = container.querySelector('button:not([disabled])');
            if (firstAvailable) {
                firstAvailable.click();
            } else {
                document.getElementById('selected_time_input').value = '';
            }
        }

        // Initialize slots on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateTimeSlots();
        });
    </script>
@endsection
