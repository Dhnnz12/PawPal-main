@extends('layouts.app')

@section('content')
<div class="row g-4">
    {{-- Sidebar Navigation --}}
    <div class="col-12 col-lg-3 d-none d-lg-block">
        <div class="pet-card p-3" style="border-radius: 24px; background-color: #ffffff;">
            <div class="px-3 py-2 border-bottom mb-3 d-flex align-items-center gap-3">
                <span class="pet-emoji" style="border-radius: 12px; background-color: var(--bg-peach); font-size: 22px; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">🐾</span>
                <div>
                    <div class="fw-bold text-dark" style="font-family: 'Fraunces', serif; font-size: 1.15rem; letter-spacing: -0.02em;">PawPal</div>
                    <div class="small text-muted" style="font-family: 'Outfit', sans-serif; font-size: 0.8rem; font-weight: 500; opacity: 0.85;">
                        @if(Auth::user()->isAdmin())
                            Dashboard Admin
                        @elseif(Auth::user()->isServiceProvider())
                            Panel Provider
                        @else
                            Panel Pemilik
                        @endif
                    </div>
                </div>
            </div>
            
            <nav class="d-flex flex-column gap-1">
                @if(Auth::user()->isAdmin())
                    {{-- Admin Sidebar Menu --}}
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
                    <a href="{{ route('admin.bookings.index') }}" class="sidebar-link {{ Route::is('admin.bookings.*') ? 'active' : '' }}">📋 Riwayat Booking</a>
                    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ Route::is('admin.users.*') ? 'active' : '' }}">👥 Pengguna</a>
                    <a href="{{ route('admin.services.index') }}" class="sidebar-link {{ Route::is('admin.services.*') ? 'active' : '' }}">🔧 Layanan</a>
                    <a href="{{ route('admin.transactions.index') }}" class="sidebar-link {{ Route::is('admin.transactions.*') ? 'active' : '' }}">💳 Transaksi</a>
                    <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ Route::is('products.create') || Route::is('products.edit') || Route::is('admin.products.*') ? 'active' : '' }}">🛍️ Produk</a>
                    <a href="{{ route('admin.medical-records.index') }}" class="sidebar-link {{ Route::is('admin.medical-records.*') ? 'active' : '' }}">🏥 Rekam Medis</a>
                    <a href="{{ route('admin.pets.index') }}" class="sidebar-link {{ Route::is('admin.pets.*') ? 'active' : '' }}">🐱 Data Hewan</a>
                @else
                    {{-- Pet Owner Sidebar Menu --}}
                    <a href="{{ route('owner.dashboard') }}" class="sidebar-link {{ Route::is('owner.dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
                    <a href="{{ route('pets.index') }}" class="sidebar-link {{ Route::is('pets.*') ? 'active' : '' }}">🐾 Hewan Saya</a>
                    <a href="{{ route('booking.search') }}" class="sidebar-link {{ Route::is('booking.search') || Route::is('booking.create') ? 'active' : '' }}">📅 Booking Layanan</a>
                    <a href="{{ route('bookings.index') }}" class="sidebar-link {{ Route::is('bookings.index') || Route::is('bookings.show') ? 'active' : '' }}">📋 History Booking</a>
                    <a href="{{ route('orders.index') }}" class="sidebar-link {{ Route::is('orders.*') ? 'active' : '' }}">🛍️ Pembelian & Transaksi</a>
                    <a href="{{ route('marketplace.index') }}" class="sidebar-link {{ Route::is('marketplace.*') ? 'active' : '' }}">🛒 Marketplace</a>
                    <a href="{{ route('addresses.index') }}" class="sidebar-link {{ Route::is('addresses.*') ? 'active' : '' }}">📍 Alamat Saya</a>
                    <a href="{{ route('medical-records.index') }}" class="sidebar-link {{ Route::is('medical-records.*') ? 'active' : '' }}">🏥 Rekam Medis</a>
                    <a href="{{ route('profile.index') }}" class="sidebar-link {{ Route::is('profile.*') ? 'active' : '' }}">👤 Pengaturan Profil</a>
                @endif
                
                <hr class="my-2" style="border-top: 1px dashed #eadacb;">
                
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="sidebar-link w-100 border-0 bg-transparent text-start text-danger" style="cursor: pointer;">
                        🚪 Keluar
                    </button>
                </form>
            </nav>
        </div>
    </div>

    {{-- Dashboard Main Content --}}
    <div class="col-12 col-lg-9">
        @if(Request::is('marketplace*'))
            <div class="py-1">
                @yield('dashboard_content')
            </div>
        @else
            <div class="pet-card p-4 bg-white" style="border-radius: 28px;">
                @yield('dashboard_content')
            </div>
        @endif
    </div>
</div>
@endsection
