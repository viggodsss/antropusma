@extends('layouts.guest')

@section('content')
<div class="text-center">
    <h1 class="text-2xl font-bold text-gray-800">Pendaftaran Berhasil</h1>
    <p class="text-sm text-gray-600 mt-3">Akun Anda telah terdaftar dan sedang menunggu verifikasi dari admin.</p>
    <p class="text-sm text-gray-500 mt-2">Silakan login kembali setelah akun disetujui.</p>

    <a href="{{ route('login') }}" class="inline-block mt-6 bg-indigo-600 text-white px-5 py-2.5 rounded-xl hover:bg-indigo-700 font-semibold">
        Kembali ke Login
    </a>
</div>
@endsection
