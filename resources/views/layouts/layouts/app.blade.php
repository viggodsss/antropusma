<!DOCTYPE html>
<html>
<head>
    <title>Sistem Antrian</title>

    <!-- WAJIB TAMBAH INI -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- NAVBAR DI SINI -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">

        <span class="navbar-brand">Sistem Antrian Puskesmas</span>

        <div class="d-flex align-items-center">

            <span class="text-white me-3 fw-bold">
                👤 {{ auth()->user()->name ?? 'Admin' }}
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-light btn-sm">
                    Logout
                </button>
            </form>

        </div>

    </div>
</nav>

    <!-- ISI HALAMAN -->
    <div class="container mt-4">
        @yield('content')
    </div>

</body>
</html>