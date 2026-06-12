<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProviderScheduleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\AdminController;

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Dashboard router - smart redirect based on role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pets/{pet}', [PetController::class, 'show'])->name('pets.show')->whereNumber('pet');

    // Orders details & invoices (both admin and the actual order owner can access)
    Route::get('/orders/{order}', function(\App\Models\Order $order) {
        if (auth()->user()->role !== 'admin' && auth()->id() !== $order->pet_owner_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('orders.show', ['order' => $order]);
    })->name('orders.show');

    Route::get('/orders/{order}/invoice', function(\App\Models\Order $order) {
        if (auth()->user()->role !== 'admin' && auth()->id() !== $order->pet_owner_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('orders.invoice', ['order' => $order]);
    })->name('orders.invoice');

    Route::get('/bookings/{booking}', function(\App\Models\Booking $booking) {
        if (auth()->user()->role !== 'admin' && auth()->id() !== $booking->pet_owner_id && auth()->id() !== $booking->provider_id) {
            abort(403, 'Unauthorized action.');
        }
        return view('bookings.show', ['booking' => $booking]);
    })->name('bookings.show');

    // Booking status updates (both admin and the actual booking owner can access)
    Route::post('/booking/{booking}/status', [BookingController::class, 'updateStatus'])->name('booking.updateStatus');
});

// Pet Owner Routes - Protected for Pet Owner only
Route::middleware(['auth', 'pet_owner'])->group(function () {
    Route::get('/owner/dashboard', [DashboardController::class, 'ownerDashboard'])->name('owner.dashboard');

    // Pets
    Route::get('/pets', [PetController::class, 'index'])->name('pets.index');
    Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
    Route::post('/pets', [PetController::class, 'store'])->name('pets.store');
    Route::get('/pets/{pet}/edit', [PetController::class, 'edit'])->name('pets.edit');
    Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.update');
    Route::delete('/pets/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');

    // Addresses
    Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
    Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{address}', [AddressController::class, 'show'])->name('addresses.show');
    Route::get('/addresses/{address}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    // Service Bookings
    Route::get('/booking/search', [BookingController::class, 'search'])->name('booking.search');
    Route::get('/booking/create/{provider}', [BookingController::class, 'showCreate'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');

    // Backward-compatible aliases
    Route::get('/owner/search-providers', [BookingController::class, 'search'])->name('owner.search_providers');



    // Reviews
    Route::get('/reviews/create/{booking}', function(\App\Models\Booking $booking) {
        return view('reviews.create', ['booking' => $booking]);
    })->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Marketplace
    Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace.index');
    Route::get('/marketplace/cart', [MarketplaceController::class, 'cart'])->name('marketplace.cart');
    Route::post('/marketplace/cart/add/{product}', [MarketplaceController::class, 'addToCart'])->name('marketplace.cart.add');
    Route::delete('/marketplace/cart/remove/{id}', [MarketplaceController::class, 'removeFromCart'])->name('marketplace.cart.remove');
    Route::post('/marketplace/checkout', [MarketplaceController::class, 'checkout'])->name('marketplace.checkout');

    // Medical Records (Pet Owner view)
    Route::get('/medical-records', [MedicalRecordController::class, 'index'])->name('medical-records.index');

    // Profile Management
    Route::get('/profile', function() {
        return view('profile.index');
    })->name('profile.index');
    Route::get('/profile/edit', function() {
        return view('profile.edit');
    })->name('profile.edit');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Bookings History
    Route::get('/bookings', function() {
        $bookings = \App\Models\Booking::where('pet_owner_id', Auth()->id())->with('service', 'provider', 'pet')->get();
        return view('bookings.index', ['bookings' => $bookings]);
    })->name('bookings.index');

    // Orders/Transactions
    Route::get('/orders', function() {
        $orders = \App\Models\Order::where('pet_owner_id', Auth()->id())->with('items', 'items.product', 'items.product.seller')->get();
        return view('orders.index', ['orders' => $orders]);
    })->name('orders.index');


});

// Service Provider Routes - Protected for Service Providers only (dashboard)
Route::middleware(['auth', 'service_provider'])->group(function () {
    Route::get('/provider/dashboard', [DashboardController::class, 'providerDashboard'])->name('provider.dashboard');
});

// Authenticated routes - non-role-specific
Route::middleware(['auth'])->group(function () {
    // Provider Schedule (secara prinsip dikelola admin, tapi route ini tetap ada)
    Route::post('/provider/schedule', [ProviderScheduleController::class, 'update'])->name('provider.schedule.update');

    // Medical Records (Admin/Vet post)
    Route::post('/medical-records', [MedicalRecordController::class, 'store'])->name('medical-records.store');
});

// Admin-only: Kelola layanan & jadwal provider
Route::middleware(['auth', 'admin'])->group(function () {
    // Services management
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    // Products management CRUD
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Booking completion forms
    Route::get('/bookings/{booking}/complete', [BookingController::class, 'showCompleteForm'])->name('admin.bookings.completeForm');
    Route::post('/bookings/{booking}/complete', [BookingController::class, 'submitComplete'])->name('admin.bookings.submitComplete');

    // Admin pages (prefix)
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/bookings', [AdminController::class, 'bookingsIndex'])->name('admin.bookings.index');

        Route::get('/users', [AdminController::class, 'usersIndex'])->name('admin.users.index');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
        Route::post('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggleStatus');

        Route::get('/services', function() {
            $services = \App\Models\Service::with('provider')->get();
            $schedules = \App\Models\ProviderSchedule::with('provider')->get();
            return view('admin.services.index', ['services' => $services, 'schedules' => $schedules]);
        })->name('admin.services.index');

        Route::get('/products', function() {
            $products = \App\Models\Product::with('seller')->get();
            return view('admin.products.index', ['products' => $products]);
        })->name('admin.products.index');

        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

        Route::get('/pets', function() {
            $pets = \App\Models\Pet::with('owner')->get();
            return view('admin.pets.index', ['pets' => $pets]);
        })->name('admin.pets.index');

        Route::get('/medical-records', function() {
            $medicalRecords = \App\Models\MedicalRecord::with('pet', 'vet', 'pet.owner')->get();
            return view('admin.medical-records.index', ['medicalRecords' => $medicalRecords]);
        })->name('admin.medical-records.index');

        Route::get('/medical-records/create', function() {
            $pets = \App\Models\Pet::all();
            $bookings = \App\Models\Booking::all();
            return view('admin.medical-records.create', compact('pets', 'bookings'));
        })->name('medical-records.create');

        Route::get('/transactions', function() {
            $orders = \App\Models\Order::with('user')->orderBy('created_at', 'desc')->get();
            $pendingCount = $orders->where('status', 'pending')->count();
            $paidCount = $orders->where('status', 'paid')->count();
            $completedCount = $orders->where('status', 'completed')->count();
            $totalAmount = $orders->sum('total_amount');
            return view('admin.transactions.index', [
                'orders' => $orders,
                'pendingCount' => $pendingCount,
                'paidCount' => $paidCount,
                'completedCount' => $completedCount,
                'totalAmount' => $totalAmount,
            ]);
        })->name('admin.transactions.index');

        Route::post('/transactions/{order}/approve', [AdminController::class, 'approveTransaction'])->name('admin.transactions.approve');
        Route::post('/transactions/{order}/reject', [AdminController::class, 'rejectTransaction'])->name('admin.transactions.reject');

        // Admin Schedule Management
        Route::get('/schedules/create', [AdminController::class, 'createSchedule'])->name('admin.schedules.create');
        Route::post('/schedules', [AdminController::class, 'storeSchedule'])->name('admin.schedules.store');
        Route::get('/schedules/{schedule}/edit', [AdminController::class, 'editSchedule'])->name('admin.schedules.edit');
        Route::put('/schedules/{schedule}', [AdminController::class, 'updateSchedule'])->name('admin.schedules.update');
        Route::delete('/schedules/{schedule}', [AdminController::class, 'destroySchedule'])->name('admin.schedules.destroy');
    });

    // Medical Records detail view
    Route::get('/medical-records/{record}', function(\App\Models\MedicalRecord $record) {
        return view('medical-records.show', ['record' => $record]);
    })->name('medical-records.show');



    // Admin verify provider
    Route::post('/admin/verify/{provider}', [AdminController::class, 'verifyProvider'])->name('admin.verifyProvider');
});


