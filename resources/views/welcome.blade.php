@extends('layouts.app')

@section('content')
    <div class="py-2">
        {{-- Hero Banner Section --}}
        <div class="row align-items-center mb-5 g-4 py-4" style="background-color: #fbf8f5; border: 1.5px solid #eadacb; border-radius: 32px; overflow: hidden; padding: 40px;">
            <div class="col-12 col-lg-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="fs-4">🐾</span>
                    <span class="fw-bold text-muted small" style="text-transform: uppercase; letter-spacing: 1.5px;">PawPal Solution</span>
                </div>
                <h1 class="mb-3" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629; font-size: 3.2rem; line-height: 1.15; letter-spacing: -0.03em;">
                    Your Pet,<br>Our Priority
                </h1>
                <p class="mb-4" style="font-size: 1.15rem; color: #8c7b72; line-height: 1.6;">
                    Layanan perawatan hewan terpercaya dalam satu platform untuk mereka yang paling berarti.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('booking.search') }}" class="pet-btn pet-btn-primary px-4 py-3">Booking Layanan</a>
                    <a href="{{ route('marketplace.index') }}" class="pet-btn pet-btn-outline px-4 py-3">Belanja Produk</a>
                </div>
            </div>
            
            <div class="col-12 col-lg-6 position-relative text-center">
                {{-- Curved mock container --}}
                <div class="nb-photo-mask bg-white" style="border: 2px solid #eadacb; border-radius: 30px; overflow: hidden; max-height: 380px;">
                    <img src="{{ asset('images/pawpal_hero_pets.png') }}" alt="PawPal Hero Pets" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                
                {{-- Overlay Badge --}}
                <div class="position-absolute bottom-0 start-0 p-3 bg-white border border-warning shadow-sm rounded-4 text-start m-3 d-none d-sm-block" style="max-width: 240px; border-color: #eadacb !important;">
                    <p class="small mb-0" style="color: #4e3629; font-weight: 600; line-height: 1.4;">
                        Untuk Anjing, Kucing, Kelinci, Hamster, dan Sugar Glider ❤️
                    </p>
                </div>
            </div>
        </div>

        {{-- Layanan Kami --}}
        <div id="services" class="mb-5 py-4">
            <h2 class="text-center mb-5" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">🐾 Layanan Kami</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-12 col-md-4">
                    <div class="pet-card p-4 h-100 d-flex flex-column justify-content-between" style="background-color: #ffffff;">
                        <div>
                            <div class="fs-1 mb-3">🧼</div>
                            <h3 class="h5 mb-2" style="font-family: 'Fraunces', serif; font-weight: 700;">Grooming</h3>
                            <p class="small text-muted">Perawatan mandi, potong bulu dan kuku panggilan ke rumah Anda.</p>
                        </div>
                        <a href="{{ route('booking.search') }}?type=groomer" class="pet-btn pet-btn-outline py-2 px-3 mt-3 w-100" style="font-size: 0.85rem;">Lihat Layanan ➔</a>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="pet-card p-4 h-100 d-flex flex-column justify-content-between" style="background-color: #ffffff;">
                        <div>
                            <div class="fs-1 mb-3">🩺</div>
                            <h3 class="h5 mb-2" style="font-family: 'Fraunces', serif; font-weight: 700;">Dokter Hewan</h3>
                            <p class="small text-muted">Konsultasi medis rutin, vaksinasi, dan rekam medis digital terpadu.</p>
                        </div>
                        <a href="{{ route('booking.search') }}?type=veterinarian" class="pet-btn pet-btn-outline py-2 px-3 mt-3 w-100" style="font-size: 0.85rem;">Lihat Layanan ➔</a>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="pet-card p-4 h-100 d-flex flex-column justify-content-between" style="background-color: #ffffff;">
                        <div>
                            <div class="fs-1 mb-3">🛒</div>
                            <h3 class="h5 mb-2" style="font-family: 'Fraunces', serif; font-weight: 700;">Marketplace</h3>
                            <p class="small text-muted">Belanja pakan bernutrisi tinggi, vitamin, mainan, dan aksesori premium.</p>
                        </div>
                        <a href="{{ route('marketplace.index') }}" class="pet-btn pet-btn-outline py-2 px-3 mt-3 w-100" style="font-size: 0.85rem;">Belanja Sekarang ➔</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alur Pemesanan & Aliran Sistem --}}
        <div class="mb-5 p-4 rounded-4" style="background-color: #fbf8f5; border: 1.5px solid #eadacb;">
            <h2 class="text-center mb-4" style="font-family: 'Fraunces', serif; font-weight: 800;">🧭 Alur Fitur Utama PawPal</h2>
            <div class="row text-center g-3">
                <div class="col-6 col-md-3">
                    <div class="p-3 bg-white rounded-3 border">
                        <span class="fs-3 d-block mb-2">1️⃣</span>
                        <div class="fw-bold">Pilih Layanan</div>
                        <p class="small text-muted mb-0">Pilih grooming atau dokter hewan.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-3 bg-white rounded-3 border">
                        <span class="fs-3 d-block mb-2">2️⃣</span>
                        <div class="fw-bold">Pilih Waktu & Jam</div>
                        <p class="small text-muted mb-0">Atur jadwal dan detail peliharaan.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-3 bg-white rounded-3 border">
                        <span class="fs-3 d-block mb-2">3️⃣</span>
                        <div class="fw-bold">Pembayaran & Verifikasi</div>
                        <p class="small text-muted mb-0">Selesaikan transaksi online.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-3 bg-white rounded-3 border">
                        <span class="fs-3 d-block mb-2">4️⃣</span>
                        <div class="fw-bold">Selesai & Review</div>
                        <p class="small text-muted mb-0">Beri rating bintang kepuasan.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tentang Kami (About Us) --}}
        <div id="about" class="row align-items-center mb-5 g-4 py-5">
            <div class="col-12 col-lg-6">
                <div class="p-4 rounded-4" style="background: linear-gradient(135deg, #fbf8f5 0%, #f5ece2 100%); border: 1.5px solid #eadacb; border-radius: 32px;">
                    <span class="fs-2 mb-3 d-block">❤️</span>
                    <h2 class="mb-3" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">Mengapa Memilih PawPal?</h2>
                    <p style="color: #8c7b72; font-size: 1.05rem; line-height: 1.6;">
                        PawPal hadir sebagai solusi terintegrasi untuk seluruh kebutuhan hewan peliharaan Anda. Kami percaya bahwa setiap hewan layak mendapatkan kasih sayang dan perawatan terbaik seperti layaknya keluarga sendiri.
                    </p>
                    <div class="mt-4 d-flex flex-column gap-3">
                        <div class="d-flex gap-3 align-items-start">
                            <span class="fs-4 p-2 rounded-3" style="background-color: var(--bg-sage); color: #43634f;">🛡️</span>
                            <div>
                                <h4 class="h6 mb-1" style="font-weight: 700;">Keamanan Terjamin</h4>
                                <p class="small text-muted mb-0">Semua mitra dokter dan pet sitter kami telah melalui proses verifikasi dan seleksi ketat.</p>
                            </div>
                        </div>
                        <div class="d-flex gap-3 align-items-start">
                            <span class="fs-4 p-2 rounded-3" style="background-color: #fcece6; color: #b05634;">⚡</span>
                            <div>
                                <h4 class="h6 mb-1" style="font-weight: 700;">Booking Instan</h4>
                                <p class="small text-muted mb-0">Cari, pilih, dan booking jadwal kunjungan atau perawatan ke rumah dalam hitungan detik.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="pet-card p-4 text-center d-flex flex-column align-items-center justify-content-center" style="background-color: #ffffff; border-radius: var(--radius-organic-1); min-height: 350px;">
                    <div class="pet-emoji mb-3" style="border-radius: 50%; background-color: var(--bg-peach); font-size: 48px; width: 90px; height: 90px; display: flex; align-items: center; justify-content: center;">🏡</div>
                    <h3 style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629; font-size: 1.75rem;">Rumah Kedua untuk Peliharaan Anda</h3>
                    <p class="text-muted px-3 mt-2" style="font-size: 0.95rem;">
                        Dengan PawPal, Anda tidak perlu lagi khawatir saat harus meninggalkan hewan kesayangan Anda bepergian.
                    </p>
                    <div class="d-flex gap-2 justify-content-center mt-3 flex-wrap">
                        <span class="badge rounded-pill px-3 py-2 text-dark" style="background-color: var(--bg-sage); border: 1px solid #c8dfd2;">🐱 Kucing</span>
                        <span class="badge rounded-pill px-3 py-2 text-dark" style="background-color: #fcece6; border: 1px solid #f7dcd1;">🐶 Anjing</span>
                        <span class="badge rounded-pill px-3 py-2 text-dark" style="background-color: #fff9f3; border: 1px solid #eadacb;">🐰 Kelinci</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hewan Yang Dilayani --}}
        <div class="text-center py-4 mb-3">
            <h2 class="mb-4" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">🐰 Hewan yang Dilayani PawPal</h2>
            <div class="d-flex justify-content-center align-items-center gap-4 flex-wrap">
                <div class="d-flex flex-column align-items-center">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background-color: #ffffff; border: 1.5px solid #eadacb; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">🐶</div>
                    <div class="fw-semibold mt-2 small">Anjing</div>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background-color: #ffffff; border: 1.5px solid #eadacb; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">🐱</div>
                    <div class="fw-semibold mt-2 small">Kucing</div>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background-color: #ffffff; border: 1.5px solid #eadacb; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">🐰</div>
                    <div class="fw-semibold mt-2 small">Kelinci</div>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background-color: #ffffff; border: 1.5px solid #eadacb; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">🐹</div>
                    <div class="fw-semibold mt-2 small">Hamster</div>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background-color: #ffffff; border: 1.5px solid #eadacb; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">🐿️</div>
                    <div class="fw-semibold mt-2 small">Sugar Glider</div>
                </div>
            </div>
        </div>

        {{-- FAQ Section --}}
        <div id="faq" class="mb-5 py-5">
            <h2 class="text-center mb-5" style="font-family: 'Fraunces', serif; font-weight: 800; color: #4e3629;">❓ Pertanyaan yang Sering Diajukan</h2>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="accordion accordion-flush shadow-sm" id="faqAccordion" style="border-radius: 20px; overflow: hidden; border: 1.5px solid #eadacb; background: #ffffff;">
                        
                        <div class="accordion-item" style="background: transparent;">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold px-4 py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="false" style="color: var(--ink); background-color: transparent; font-family: 'Outfit', sans-serif;">
                                    Bagaimana cara memesan layanan grooming di PawPal?
                                </button>
                            </h3>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted px-4 pb-4 pt-1" style="line-height: 1.6;">
                                    Anda cukup login ke akun PawPal Anda, masuk ke menu "Booking Layanan", pilih jenis layanan grooming, tentukan waktu dan peliharaan Anda, lalu selesaikan pembayaran. Groomer kami akan datang langsung ke alamat Anda.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" style="background: transparent; border-top: 1.5px solid #eadacb;">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold px-4 py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" style="color: var(--ink); background-color: transparent; font-family: 'Outfit', sans-serif;">
                                    Apakah semua dokter hewan di PawPal memiliki sertifikasi resmi?
                                </button>
                            </h3>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted px-4 pb-4 pt-1" style="line-height: 1.6;">
                                    Ya, semua dokter hewan (veterinarian) yang bergabung dengan PawPal wajib memiliki Surat Izin Praktik (SIP) yang aktif dan telah lolos tahap verifikasi berkas oleh tim kami.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" style="background: transparent; border-top: 1.5px solid #eadacb;">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold px-4 py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" style="color: var(--ink); background-color: transparent; font-family: 'Outfit', sans-serif;">
                                    Bagaimana proses pengiriman produk dari Marketplace?
                                </button>
                            </h3>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted px-4 pb-4 pt-1" style="line-height: 1.6;">
                                    Produk yang dibeli akan langsung dikemas dan dikirimkan oleh kurir terpercaya sesuai pilihan metode pengiriman yang Anda gunakan pada saat pembayaran. Status pengiriman dapat dipantau di halaman "Purchases & Orders".
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item" style="background: transparent; border-top: 1.5px solid #eadacb;">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold px-4 py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" style="color: var(--ink); background-color: transparent; font-family: 'Outfit', sans-serif;">
                                    Apakah ada rekam medis untuk setiap peliharaan?
                                </button>
                            </h3>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-muted px-4 pb-4 pt-1" style="line-height: 1.6;">
                                    Ya, setelah berkonsultasi atau melakukan perawatan dengan dokter hewan di PawPal, dokter akan memperbarui rekam medis digital peliharaan Anda yang bisa diakses langsung melalui menu "Medical Records".
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
