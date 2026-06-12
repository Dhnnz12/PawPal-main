@extends('layouts.dashboard')

@section('dashboard_content')
    <div class="py-2">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
            <div>
                <h1 class="h3 mb-1" style="font-family: 'Fraunces', serif; font-weight: 700; color: var(--ink);">Keranjang Belanja 🛒</h1>
                <div class="small text-muted" style="font-family: 'Outfit', sans-serif;">Ringkasan belanjaan dan proses checkout pesanan Anda.</div>
            </div>
            <div class="d-flex gap-2">
                <a class="pet-btn pet-btn-outline" href="{{ route('marketplace.index') }}">⬅️ Kembali Belanja</a>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger border-0 rounded-4 px-4 py-3 mb-4" style="background-color: #fcece6; color: #b05634; font-weight: 500;">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $items = is_array($cart) ? $cart : [];
            $total = 0;
            foreach($items as $id => $it){ $total += $it['price'] * $it['quantity']; }
        @endphp

        @if(empty($items))
            <div class="pet-card p-5 text-center text-muted">
                <span class="fs-1 d-block mb-3">🐾</span>
                Keranjang belanja Anda masih kosong.
            </div>
        @else
            <div class="row g-4">
                <div class="col-12 col-lg-8">
                    <div class="pet-card p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h2 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700;">🛍️ Item Terpilih</h2>
                            <span class="pet-badge pet-badge-sage">{{ count($items) }} Produk</span>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Jumlah</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                        <th class="text-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $id => $it)
                                        <tr>
                                            <td>
                                                <div class="fw-bold" style="color: var(--ink);">{{ $it['name'] }}</div>
                                            </td>
                                            <td class="text-center fw-semibold">{{ $it['quantity'] }}</td>
                                            <td class="small">Rp {{ number_format((float)$it['price'], 0, ',', '.') }}</td>
                                            <td class="fw-semibold" style="color: var(--primary);">Rp {{ number_format((float)($it['price']*$it['quantity']), 0, ',', '.') }}</td>
                                            <td class="text-end">
                                                <form method="POST" action="{{ route('marketplace.cart.remove', $id) }}" class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="pet-btn pet-btn-outline py-1 px-3" style="font-size: 0.8rem;" type="submit">Hapus 🗑️</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-4 border-top pt-3">
                            <h4 class="h5 mb-0" style="font-family: 'Fraunces', serif; font-weight: 700;">Total Pembelanjaan:</h4>
                            <span class="fs-4 fw-bold" style="color: var(--primary);">Rp {{ number_format((float)$total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="pet-card p-4">
                        <h2 class="h5 mb-3" style="font-family: 'Fraunces', serif; font-weight: 700;">🚚 Alamat Pengiriman</h2>

                        <form id="checkoutForm" method="POST" action="{{ route('marketplace.checkout') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-semibold small text-muted">Alamat Pengiriman Lengkap</label>
                                <textarea class="form-control pet-input w-100" id="shipping_address_input" name="shipping_address" rows="3" required placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, dan kode pos...">{{ old('shipping_address') }}</textarea>
                            </div>

                            <button class="pet-btn pet-btn-primary w-100 py-3" type="button" onclick="openPaymentModal()">Bayar & Buat Order 💳</button>

                            {{-- Payment Modal --}}
                            <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true" style="font-family: 'Outfit', sans-serif;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content text-start" style="border-radius: 24px; border: 1.5px solid var(--color-warm-border); background: #faf6f0;">
                                        <div class="modal-header border-bottom-0 pb-0">
                                            <h5 class="modal-title fw-bold" id="paymentModalLabel" style="font-family: 'Fraunces', serif; color: var(--ink);">💳 Konfirmasi Transfer Pembayaran</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body py-4">
                                            <div class="mb-4 text-center">
                                                <div class="small text-muted fw-bold mb-2">SILAKAN TRANSFER SEBESAR:</div>
                                                <div class="fs-3 fw-extrabold text-dark mb-3">Rp {{ number_format((float)$total, 0, ',', '.') }}</div>
                                                <div class="p-3 rounded-4 bg-white border" style="max-width: 320px; margin: 0 auto; border-color: var(--color-warm-border) !important;">
                                                    <div class="small fw-bold text-muted mb-1">REKENING TUJUAN BCA:</div>
                                                    <div class="fs-4 fw-bold text-primary tracking-wide">689067</div>
                                                    <div class="small fw-semibold text-secondary mt-1">A.n PawPal</div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold small text-muted">Unggah Bukti Transfer <span class="text-danger">*</span></label>
                                                <input type="file" name="payment_proof" id="payment_proof_input" class="form-control pet-input" accept="image/*,application/pdf" required>
                                                <div class="small text-muted mt-1">Format: JPG, PNG, PDF (maks. 5MB)</div>
                                            </div>
                                        </div>

                                        <div class="modal-footer border-top-0 pt-0">
                                            <button type="button" class="pet-btn pet-btn-outline py-2 px-3" data-bs-dismiss="modal">Batal</button>
                                            <button id="checkoutSubmitBtn" type="button" onclick="submitCheckoutForm()" class="pet-btn pet-btn-primary py-2 px-4">Bayar Sekarang ➔</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        function openPaymentModal() {
            const address = document.getElementById('shipping_address_input').value.trim();
            if (!address) {
                alert('Harap isi alamat pengiriman lengkap terlebih dahulu.');
                document.getElementById('shipping_address_input').focus();
                return;
            }

            const modalEl = document.getElementById('paymentModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }

        let checkoutSubmitting = false;

        function submitCheckoutForm() {
            if (checkoutSubmitting) return;
            checkoutSubmitting = true;
            const address = document.getElementById('shipping_address_input').value.trim();
            if (!address) {
                alert('Harap isi alamat pengiriman lengkap terlebih dahulu.');
                checkoutSubmitting = false;
                return;
            }

            const fileInput = document.getElementById('payment_proof_input');
            if (!fileInput.value) {
                alert('Harap unggah bukti transfer terlebih dahulu.');
                checkoutSubmitting = false;
                return;
            }

            // langsung submit form (file input tetap ada di dalam form, jadi tidak perlu appendChild)
            document.getElementById('checkoutForm').submit();
        }
    </script>
@endsection

