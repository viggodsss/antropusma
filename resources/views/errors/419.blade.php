<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 - Page Expired</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center px-4">
    <div class="w-full max-w-lg bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8 text-center">
        <div class="w-14 h-14 mx-auto rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center mb-4">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0" />
            </svg>
        </div>

        <h1 class="text-2xl font-extrabold text-slate-900">419 - Page Expired</h1>
        <p class="text-slate-600 mt-2">Sesi halaman sudah kedaluwarsa. Silakan kembali ke dashboard untuk lanjut mengisi riwayat pemeriksaan atau resep obat.</p>

        <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
            @auth
                @if(auth()->user()->role === 'petugas')
                    <a href="{{ route('petugas.dashboard') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg text-white font-semibold" style="background: linear-gradient(135deg, #0f766e, #0284c7);">
                        Kembali ke Dashboard Petugas
                    </a>
                @elseif(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg text-white font-semibold" style="background: linear-gradient(135deg, #0f766e, #0284c7);">
                        Kembali ke Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg text-white font-semibold" style="background: linear-gradient(135deg, #0f766e, #0284c7);">
                        Kembali ke Dashboard
                    </a>
                @endif
            @endauth

            <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg border border-slate-300 text-slate-700 font-semibold hover:bg-slate-50">
                Kembali ke Halaman Sebelumnya
            </a>
        </div>
    </div>
</body>
</html>
