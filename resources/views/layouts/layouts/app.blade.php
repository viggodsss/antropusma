<!DOCTYPE html>
<html>
<head>
    <title>Sistem Antrian</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- WAJIB TAMBAH INI -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media (max-width: 768px) {
            .navbar .container-fluid {
                gap: 8px;
                flex-wrap: wrap;
            }
            .nav-right-controls {
                width: 100%;
                justify-content: flex-end;
            }
            .nav-right-controls img {
                height: 30px !important;
            }
            .nav-right-controls .btn {
                padding: 4px 10px;
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
            .navbar-brand img {
                height: 32px !important;
            }
            .container.mt-4 {
                margin-top: 1rem !important;
                padding-left: 12px;
                padding-right: 12px;
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR DI SINI -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">

        <a class="navbar-brand" href="/">
            <img src="{{ asset('images/navlogo.png') }}" alt="AntroPusma Logo" style="height: 40px; object-fit: contain;">
        </a>

        <div class="d-flex align-items-center gap-2 nav-right-controls">

            <img src="{{ asset('images/kampusnavlogo.png') }}" alt="Campus Logo" style="height: 36px; object-fit: contain;">

            <span class="text-white me-2 fw-bold d-none d-md-inline">
                👤 {{ auth()->user()->name ?? 'Admin' }}
            </span>

            <a href="{{ route('logout.get') }}" class="btn btn-light btn-sm">
                Logout
            </a>

        </div>

    </div>
</nav>

    <!-- ISI HALAMAN -->
    <div class="container mt-4">
        @yield('content')
    </div>

</body>
</html>