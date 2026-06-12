# TODO

## Marketplace
- [x] Pastikan route checkout: `marketplace.checkout` menerima input `payment_proof` & `shipping_address` sesuai form.
- [x] Perbaiki issue checkout (jika gagal/redirect error) pada controller/route/view.


## Review - bintang
- [x] Ubah tampilan rating di `resources/views/reviews/create.blade.php`: tampilkan bintang kosong abu-abu (tanpa warna).
- [x] Biar bintang baru menyala (warna kuning) saat user klik.
- [x] Pastikan data rating tersimpan benar: controller validasi `rating` 1-5, dan view mengirim `rating`.
- [x] Cek juga tampilan review bintang di halaman lain (mis. list/ detail) bila ada.


