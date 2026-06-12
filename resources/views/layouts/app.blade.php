<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'PawPal Pet Care') }}</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700;800&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Vite CSS/JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    {{-- Top Navbar --}}
    @include('partials.ui.navbar', ['user' => Auth::user()])

    <main class="py-4">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success border-0 rounded-4 px-4 py-3 mb-4" style="background-color: var(--bg-sage); color: #43634f; font-weight: 500;">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger border-0 rounded-4 px-4 py-3 mb-4" style="background-color: #fcece6; color: #b05634; font-weight: 500;">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>
</html>
