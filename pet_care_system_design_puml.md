# Dokumen Desain Sistem & Arsitektur PawPal (PlantUML)

Dokumen ini berisi spesifikasi teknis arsitektur, diagram aliran proses, diagram relasi entitas database (ERD), diagram kelas, diagram use case, serta diagram aktivitas dari aplikasi perayap dan pemesanan layanan perawatan hewan **PawPal** dalam format **PlantUML**.

Seluruh file `.puml` terpisah juga dapat ditemukan di folder `puml/` pada proyek ini.

---

## 1. Diagram Arsitektur (Architecture Diagram)
File Sumber: [architecture.puml](file:///c:/Users/62899/.gemini/antigravity-ide/scratch/pet-care-prototype/puml/architecture.puml)

```plantuml
@startuml Architecture
!theme plain
skinparam componentStyle uml2

actor "Client / Web Browser" as Client

package "Web Server" {
  [Nginx / Apache] as WebServer
}

package "Laravel MVC Framework" {
  [Routing & Middleware] as Router
  [Controllers] as Controller
  [Models] as Model
  [Blade Views] as View
}

database "MySQL Database" as DB
folder "File Storage" as Storage

Client <--> WebServer : HTTP Requests / Responses
WebServer <--> Router
Router <--> Controller
Controller <--> Model
Controller <--> View
Model <--> DB
Storage <--> Controller
@enduml
```

---

## 2. Diagram Use Case (Use Case Diagram)
File Sumber: [usecase.puml](file:///c:/Users/62899/.gemini/antigravity-ide/scratch/pet-care-prototype/puml/usecase.puml)

```plantuml
@startuml UseCase
left to right direction
actor "🐾 Pet Owner" as PO
actor "📊 System Administrator" as ADM

package "PawPal System" {
  usecase "Masuk Akun (Login)" as UC1
  usecase "Daftar Akun Mandiri (Pet Owner)" as UC1a
  usecase "Kelola Profil Hewan Peliharaan" as UC2
  usecase "Cari & Pesan Layanan" as UC3
  usecase "Belanja Produk Marketplace" as UC4
  usecase "Kelola Alamat Pengiriman" as UC5
  usecase "Akses Rekam Medis Hewan" as UC6
  usecase "Beri Ulasan / Rating" as UC7
  usecase "Kelola Jadwal & Layanan" as UC8
  usecase "Kelola Transaksi & Produk" as UC9
  usecase "Akses & Unggah Rekam Medis Hewan" as UC10
  usecase "Kelola Pengguna (User Management)" as UC11
}

PO --> UC1
PO --> UC1a
PO --> UC2
PO --> UC3
PO --> UC4
PO --> UC5
PO --> UC6
PO --> UC7

ADM --> UC1
ADM --> UC8
ADM --> UC9
ADM --> UC10
ADM --> UC11
@enduml
```

---

## 3. Diagram Relasi Entitas (Entity Relationship Diagram - ERD)
File Sumber: [erd.puml](file:///c:/Users/62899/.gemini/antigravity-ide/scratch/pet-care-prototype/puml/erd.puml)

```plantuml
@startuml ERD
!theme plain
hide circle
skinparam linetype ortho

entity "USERS" as users {
  * id : bigint <<PK>>
  --
  * name : string
  * email : string
  * password : string
  * role : string (admin | pet_owner)
  phone : string
  bio : string
  * is_verified : boolean
  * is_active : boolean
  avatar : string
}

entity "PETS" as pets {
  * id : bigint <<PK>>
  --
  * user_id : bigint <<FK>>
  * name : string
  * type : string
  breed : string
  age : int
  weight : decimal
  photo : string
  health_notes : text
}

entity "ADDRESSES" as addresses {
  * id : bigint <<PK>>
  --
  * user_id : bigint <<FK>>
  * label : string
  * address_line : text
  * city : string
  latitude : decimal
  longitude : decimal
  * is_primary : boolean
}

entity "SERVICES" as services {
  * id : bigint <<PK>>
  --
  * provider_id : bigint <<FK>>
  * name : string
  description : text
  * price : decimal
  * duration_minutes : int
}

entity "PRODUCTS" as products {
  * id : bigint <<PK>>
  --
  * seller_id : bigint <<FK>>
  * name : string
  description : text
  * price : decimal
  * stock : int
  image : string
}

entity "BOOKINGS" as bookings {
  * id : bigint <<PK>>
  --
  * pet_owner_id : bigint <<FK>>
  * provider_id : bigint <<FK>>
  * pet_id : bigint <<FK>>
  * service_id : bigint <<FK>>
  * booking_date : date
  * start_time : time
  * status : string (pending | confirmed | completed | cancelled)
  * total_price : decimal
  address_id : bigint <<FK>>
  notes : text
}

entity "MEDICAL_RECORDS" as medical_records {
  * id : bigint <<PK>>
  --
  * pet_id : bigint <<FK>>
  * vet_id : bigint <<FK>>
  booking_id : bigint <<FK>>
  * visit_date : date
  * diagnosis : text
  treatment : text
  notes : text
  pdf_path : string
}

entity "REVIEWS" as reviews {
  * id : bigint <<PK>>
  --
  * booking_id : bigint <<FK>>
  * pet_owner_id : bigint <<FK>>
  * provider_id : bigint <<FK>>
  * rating : int
  comment : text
}

entity "ORDERS" as orders {
  * id : bigint <<PK>>
  --
  * pet_owner_id : bigint <<FK>>
  * total_amount : decimal
  * status : string
  shipping_address : text
  payment_proof : string
}

entity "ORDER_ITEMS" as order_items {
  * id : bigint <<PK>>
  --
  * order_id : bigint <<FK>>
  * product_id : bigint <<FK>>
  * quantity : int
  * price : decimal
}

users ||--o{ pets : "owns"
users ||--o{ addresses : "has"
users ||--o{ services : "manages (as admin)"
users ||--o{ products : "sells (as admin)"
users ||--o{ bookings : "books (as owner) / manages (as admin)"
users ||--o{ orders : "purchases"
users ||--o{ reviews : "writes"

pets ||--o{ bookings : "attends"
pets ||--o{ medical_records : "has history"

services ||--o{ bookings : "associated with"
addresses ||--o{ bookings : "destination"

bookings ||--o| medical_records : "results in"
bookings ||--o| reviews : "evaluated by"

orders ||--|{ order_items : "contains"
products ||--o{ order_items : "ordered"
@enduml
```

---

## 4. Diagram Urutan (Sequence Diagram - Booking & Marketplace)
File Sumber: [sequence.puml](file:///c:/Users/62899/.gemini/antigravity-ide/scratch/pet-care-prototype/puml/sequence.puml)

```plantuml
@startuml Sequence
autonumber
actor "Pet Owner" as PetOwner
boundary "Web View" as View
control "Controller" as Controller
entity "Model" as Model
database "Database (MySQL)" as DB

group Alur Booking Layanan (Grooming / Vet)
    PetOwner -> View : Pilih Layanan, Waktu, & Hewan
    PetOwner -> View : Klik 'Simpan Booking'
    activate View
    View -> Controller : POST /booking/store
    activate Controller
    Controller -> Controller : Validasi data input
    Controller -> Model : Create new Booking
    activate Model
    Model -> DB : INSERT INTO bookings
    activate DB
    DB --> Model : Success
    deactivate DB
    Model --> Controller : Booking instance
    deactivate Model
    Controller --> View : Redirect ke Dashboard (Success Alert)
    deactivate Controller
    View --> PetOwner : Tampilkan riwayat booking (Status: Pending)
    deactivate View
end

group Alur Belanja Marketplace (Checkout)
    PetOwner -> View : Tambah Produk ke Keranjang
    PetOwner -> View : Isi Alamat, Unggah Bukti Bayar & Checkout
    activate View
    View -> Controller : POST /marketplace/checkout
    activate Controller
    Controller -> Controller : Validasi form & cek stok produk
    Controller -> DB : BEGIN TRANSACTION
    Controller -> Model : Create Order & OrderItems
    activate Model
    Model -> DB : INSERT INTO orders & order_items
    activate DB
    DB --> Model : Success
    Model -> DB : UPDATE products SET stock = stock - qty
    DB --> Model : Success
    deactivate DB
    Model --> Controller : Order instance
    deactivate Model
    Controller -> DB : COMMIT
    Controller --> View : Redirect ke Dashboard (Success Alert)
    deactivate Controller
    View --> PetOwner : Tampilkan riwayat pesanan (Status: Pending)
    deactivate View
end
@enduml
```

---

## 5. Diagram Kelas (Class Diagram)
File Sumber: [class.puml](file:///c:/Users/62899/.gemini/antigravity-ide/scratch/pet-care-prototype/puml/class.puml)

```plantuml
@startuml ClassDiagram
skinparam classAttributeIconSize 0

class Controller {
}

class Model {
}

class AuthController {
  +showLogin()
  +login(Request)
  +showRegister()
  +register(Request)
  +logout()
}

class DashboardController {
  +index()
  +ownerDashboard()
  +adminDashboard()
}

class PetController {
  +index()
  +create()
  +store(Request)
  +show(Pet)
  +edit(Pet)
  +update(Request, Pet)
  +destroy(Pet)
}

class BookingController {
  +search(Request)
  +showCreate(User)
  +store(Request)
  +updateStatus(Request, Booking)
}

class MarketplaceController {
  +index()
  +cart()
  +checkout(Request)
}

class ReviewController {
  +create(Booking)
  +store(Request, Booking)
}

class User {
  +id: bigint
  +name: string
  +role: string
  +isAdmin(): boolean
  +isPetOwner(): boolean
  +pets()
  +addresses()
}

class Pet {
  +id: bigint
  +name: string
  +type: string
  +age: int
  +owner()
}

class Booking {
  +id: bigint
  +booking_date: date
  +status: string
  +pet()
  +provider()
}

class Order {
  +id: bigint
  +total_amount: decimal
  +status: string
  +items()
}

class Review {
  +id: bigint
  +rating: int
  +comment: string
}

AuthController --|> Controller
DashboardController --|> Controller
PetController --|> Controller
BookingController --|> Controller
MarketplaceController --|> Controller
ReviewController --|> Controller

User --|> Model
Pet --|> Model
Booking --|> Model
Order --|> Model
Review --|> Model

User "1" *-- "0..*" Pet : owns
User "1" *-- "0..*" Booking : schedules (as owner) / manages (as admin)
User "1" *-- "0..*" Order : purchases
Pet "1" *-- "0..*" Booking : attends
Booking "1" *-- "0..1" Review : has
@enduml
```

---

## 6. Diagram Aktivitas (Activity Diagram)

### A. Alur Pemesanan Layanan (Booking)
File Sumber: [activity_booking.puml](file:///c:/Users/62899/.gemini/antigravity-ide/scratch/pet-care-prototype/puml/activity_booking.puml)

```plantuml
@startuml Activity_Booking
start
:Klik Cari Penyedia Layanan;
:Pilih Kategori (Groomer/Vet/Sitter);
:Pilih Provider & Klik Booking;
:Tentukan Layanan Terkait;
:Tentukan Hari & Jam;
:Pilih Hewan Terdaftar;
:Klik Lanjutkan / Konfirmasi;
:Data Booking Dibuat (Status Pending);
:Notifikasi Ditampilkan ke Admin;

if (Keputusan Admin?) then (Setuju)
  :Konfirmasi Booking;
  :Layanan Dilaksanakan;
  if (Layanan adalah Medis / Vet?) then (Ya)
    :Admin/Vet Mengisi Rekam Medis;
  else (Tidak)
  endif
  :Pemilik Hewan Memberikan Ulasan/Rating;
else (Tolak / Batalkan)
  :Booking Dibatalkan;
endif
stop
@enduml
```

### B. Alur Belanja Marketplace (Checkout)
File Sumber: [activity_marketplace.puml](file:///c:/Users/62899/.gemini/antigravity-ide/scratch/pet-care-prototype/puml/activity_marketplace.puml)

```plantuml
@startuml Activity_Marketplace
start
:Buka Halaman Marketplace;
:Pilih Produk;
:Masukkan Jumlah & Tambah ke Keranjang;
if (Lanjut Belanja?) then (Ya)
  :Pilih Produk Lain;
else (Tidak, ke Keranjang)
  :Buka Halaman Keranjang Belanja;
  :Review Item & Total Harga;
  :Isi Alamat Pengiriman Lengkap;
  :Unggah Bukti Pembayaran (Transfer);
  :Klik 'Bayar & Buat Order';
  :Pesanan Dibuat (Status: Pending);
  :Sistem Mengurangi Stok Produk;
  
  if (Verifikasi Pembayaran oleh Admin?) then (Valid/Approve)
    :Status Pesanan Menjadi 'Paid' / 'Shipped';
    :Produk Dikirim ke Pelanggan;
    :Pesanan Selesai (Completed);
  else (Tidak Valid/Reject)
    :Pesanan Dibatalkan (Cancelled);
    :Stok Produk Dikembalikan;
  endif
endif
stop
@enduml
```

---

## 7. Tabel Pemetaan (Mapping Table)

### A. Pemetaan Database ke Model Eloquent
| Nama Tabel | Nama Model | Deskripsi |
| :--- | :--- | :--- |
| `users` | `User` | Menyimpan kredensial pengguna, peran, status verifikasi, dan biodata |
| `pets` | `Pet` | Profil data hewan peliharaan milik Pet Owner |
| `addresses` | `Address` | Alamat pengiriman/kunjungan lengkap beserta koordinat GPS |
| `services` | `Service` | Kategori layanan perawatan hewan yang ditawarkan oleh Provider |
| `products` | `Product` | Katalog produk pakan/perlengkapan hewan di marketplace |
| `provider_schedules` | `ProviderSchedule` | Jam dan hari operasional ketersediaan milik provider |
| `bookings` | `Booking` | Pemesanan kunjungan layanan (grooming/dokter/sitter) |
| `medical_records` | `MedicalRecord` | Digitalisasi rekam medis hewan pasca kunjungan dokter hewan |
| `reviews` | `Review` | Penilaian bintang (1-5) dan komentar dari Pet Owner untuk Provider |
| `orders` | `Order` | Transaksi invoice pesanan produk marketplace |
| `order_items` | `OrderItem` | Rincian produk dan kuantitas di dalam suatu pesanan/order |

### B. Pemetaan Rute, Kontroler, dan Tampilan (Routes, Controllers & Views)
| HTTP Method | URL Path | Nama Rute | Controller & Method | Blade View / Redirect |
| :--- | :--- | :--- | :--- | :--- |
| **GET** | `/` | `home` | *Closure* | `welcome.blade.php` |
| **GET** | `/login` | `login` | `AuthController@showLogin` | `auth/login.blade.php` |
| **POST** | `/login` | — | `AuthController@login` | *Redirect ke* `/dashboard` |
| **GET** | `/register` | `register` | `AuthController@showRegister` | `auth/register.blade.php` |
| **POST** | `/register` | — | `AuthController@register` | *Redirect ke* `/dashboard` |
| **POST** | `/logout` | `logout` | `AuthController@logout` | *Redirect ke* `/login` |
| **GET** | `/dashboard` | `dashboard` | `DashboardController@index` | *Redirect berdasarkan peran* |
| **GET** | `/owner/dashboard` | `owner.dashboard` | `DashboardController@ownerDashboard` | `owner/dashboard.blade.php` |
| **GET** | `/pets` | `pets.index` | `PetController@index` | `owner/pets/index.blade.php` |
| **GET** | `/pets/create` | `pets.create` | `PetController@create` | `owner/pets/create.blade.php` |
| **POST** | `/pets` | `pets.store` | `PetController@store` | *Redirect ke* `pets.index` |
| **GET** | `/pets/{pet}` | `pets.show` | `PetController@show` | `owner/pets/show.blade.php` |
| **GET** | `/pets/{pet}/edit` | `pets.edit` | `PetController@edit` | `owner/pets/edit.blade.php` |
| **PUT** | `/pets/{pet}` | `pets.update` | `PetController@update` | *Redirect ke* `pets.show` |
| **DELETE** | `/pets/{pet}` | `pets.destroy` | `PetController@destroy` | *Redirect ke* `pets.index` |
| **GET** | `/addresses` | `addresses.index` | `AddressController@index` | `owner/addresses/index.blade.php` |
| **GET** | `/booking/search` | `booking.search` | `BookingController@search` | `owner/search_providers.blade.php` |
| **GET** | `/booking/create/{provider}` | `booking.create` | `BookingController@showCreate` | `owner/create_booking.blade.php` |
| **POST** | `/booking/store` | `booking.store` | `BookingController@store` | *Redirect ke* `bookings.index` |
| **GET** | `/marketplace` | `marketplace.index` | `MarketplaceController@index` | `marketplace/index.blade.php` |
| **GET** | `/marketplace/cart` | `marketplace.cart` | `MarketplaceController@cart` | `marketplace/cart.blade.php` |
| **POST** | `/marketplace/checkout` | `marketplace.checkout` | `MarketplaceController@checkout` | *Redirect ke dashboard* |
| **GET** | `/reviews/create/{booking}` | `reviews.create` | `ReviewController@create` | `reviews/create.blade.php` |
| **POST** | `/reviews/store/{booking}` | `reviews.store` | `ReviewController@store` | *Redirect ke booking detail* |
