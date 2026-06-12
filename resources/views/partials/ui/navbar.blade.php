<header class="sticky-top z-3 py-3" style="backdrop-filter: blur(16px); background: rgba(250, 246, 240, 0.9); border-bottom: 1.5px solid var(--color-warm-border);">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                <span class="pet-emoji" style="border-radius: var(--radius-organic-1); background-color: var(--bg-peach); font-size: 26px; width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">🐾</span>
                <div class="lh-sm d-none d-sm-block">
                    <div style="font-family: 'Fraunces', serif; font-weight: 700; font-size: 1.25rem; color: var(--ink); letter-spacing: -0.02em;">PawPal</div>
                    <div class="small" style="font-family: 'Outfit', sans-serif; opacity: 0.65; font-weight: 500; color: var(--muted);">Sahabat Terbaik untuk Hewan Kesayanganmu</div>
                </div>
            </a>

            {{-- Navigation Links (Desktop) --}}
            <nav class="d-none d-lg-flex align-items-center gap-4">
                @auth
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link-custom {{ Route::is('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
                        <a href="{{ route('admin.users.index') }}" class="nav-link-custom {{ Route::is('admin.users.*') ? 'active' : '' }}">👥 Pengguna</a>
                        <a href="{{ route('admin.services.index') }}" class="nav-link-custom {{ Route::is('admin.services.*') ? 'active' : '' }}">🔧 Layanan</a>
                        <a href="{{ route('admin.products.index') }}" class="nav-link-custom {{ Route::is('products.create') || Route::is('products.edit') || Route::is('admin.products.*') ? 'active' : '' }}">🛍️ Produk</a>
                        <a href="{{ route('admin.transactions.index') }}" class="nav-link-custom {{ Route::is('admin.transactions.*') ? 'active' : '' }}">💳 Transaksi</a>
                    @else
                        <a href="{{ route('owner.dashboard') }}" class="nav-link-custom {{ Route::is('owner.dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
                        <a href="{{ route('pets.index') }}" class="nav-link-custom {{ Route::is('pets.*') ? 'active' : '' }}">🐾 Hewan Saya</a>
                        <a href="{{ route('booking.search') }}" class="nav-link-custom {{ Route::is('booking.*') ? 'active' : '' }}">📅 Booking Layanan</a>
                        <a href="{{ route('marketplace.index') }}" class="nav-link-custom {{ Route::is('marketplace.*') ? 'active' : '' }}">🛒 Marketplace</a>
                        <a href="{{ route('medical-records.index') }}" class="nav-link-custom {{ Route::is('medical-records.*') ? 'active' : '' }}">🏥 Rekam Medis</a>
                    @endif
                @else
                    <a href="{{ route('home') }}" class="nav-link-custom {{ Route::is('home') && !request()->hasHeader('referer') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('home') }}#services" class="nav-link-custom">Layanan</a>
                    <a href="{{ route('marketplace.index') }}" class="nav-link-custom {{ Route::is('marketplace.*') ? 'active' : '' }}">Marketplace</a>
                    <a href="{{ route('home') }}#about" class="nav-link-custom">Tentang Kami</a>
                    <a href="{{ route('home') }}#faq" class="nav-link-custom">FAQ</a>
                @endauth
            </nav>

            {{-- Auth/User Menu --}}
            <div class="d-flex align-items-center gap-2">
                @auth
                    <nav class="d-flex align-items-center gap-2 flex-wrap justify-content-end">
                        @if (Auth::user()->isAdmin())
                            {{-- Admin Navigation --}}
                            <div class="dropdown">
                                <button class="nb-badge dropdown-toggle" style="border-radius: var(--radius-organic-2); background-color: #f5ece2; color: #c06c48; border: none; cursor: pointer; font-weight: 700;" type="button" data-bs-toggle="dropdown">
                                    📊 Admin Panel
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" style="border: 1.5px solid var(--color-warm-border); border-radius: 20px; background-color: #ffffff;">
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}" style="color: var(--ink);">📊 Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.users.index') }}" style="color: var(--ink);">👥 User Management</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.services.index') }}" style="color: var(--ink);">🔧 Services</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.products.index') }}" style="color: var(--ink);">🛍️ Products</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.pets.index') }}" style="color: var(--ink);">🐾 Pets</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.medical-records.index') }}" style="color: var(--ink);">🏥 Medical Records</a></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index') }}" style="color: var(--ink);">💳 Transactions</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item" style="color: var(--ink);">🚪 Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @else
                            {{-- Pet Owner Navigation --}}
                            <div class="dropdown">
                                <button class="nb-badge dropdown-toggle" style="border-radius: var(--radius-organic-2); background-color: var(--bg-sage); color: #43634f; border: none; cursor: pointer;" type="button" data-bs-toggle="dropdown">
                                    👤 {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" style="border: 1.5px solid var(--color-warm-border); border-radius: 20px; background-color: #ffffff;">
                                    <li><a class="dropdown-item" href="{{ route('owner.dashboard') }}" style="color: var(--ink);">🏠 Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('pets.index') }}" style="color: var(--ink);">🐾 My Pets</a></li>
                                    <li><a class="dropdown-item" href="{{ route('booking.search') }}" style="color: var(--ink);">📅 Booking Layanan</a></li>
                                    <li><a class="dropdown-item" href="{{ route('bookings.index') }}" style="color: var(--ink);">📋 History Booking</a></li>
                                    <li><a class="dropdown-item" href="{{ route('medical-records.index') }}" style="color: var(--ink);">🏥 Medical Records</a></li>
                                    <li><a class="dropdown-item" href="{{ route('marketplace.index') }}" style="color: var(--ink);">🛒 Marketplace</a></li>
                                    <li><a class="dropdown-item" href="{{ route('orders.index') }}" style="color: var(--ink);">🛍️ Purchases & Orders</a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile.index') }}" style="color: var(--ink);">👤 My Profile</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item" style="color: var(--ink);">🚪 Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </nav>
                @endauth

                @guest
                    <div class="d-flex gap-2 flex-wrap justify-content-end">
                        <a class="pet-btn pet-btn-outline" href="{{ route('login') }}" style="font-size: 0.9rem; padding: 8px 20px;">🔑 Masuk</a>
                        <a class="pet-btn pet-btn-primary" href="{{ route('register') }}" style="font-size: 0.9rem; padding: 8px 20px;">🐶 Daftar</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header>






