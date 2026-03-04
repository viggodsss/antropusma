@extends('layouts.guest')

@section('content')
<div class="text-center">
    <h1 class="text-3xl font-bold text-gray-800">Puskesmas Mapurujaya</h1>
    <p class="text-sm text-gray-500 mt-2">Sistem Antrian Online</p>
    <p class="text-sm text-gray-600 mt-4">Daftar antrian dengan mudah, cepat, dan tanpa harus menunggu lama.</p>

    <div class="mt-8 space-y-3">
        <a href="{{ route('login') }}" class="block w-full text-center bg-indigo-600 text-white py-3 rounded-xl hover:bg-indigo-700 font-semibold">
            Login Pasien
        </a>

        <a href="{{ route('register') }}" class="block w-full text-center border border-indigo-600 text-indigo-600 py-3 rounded-xl hover:bg-indigo-50 font-semibold">
            Daftar sebagai Pasien
        </a>
    </div>

    <div class="mt-6 pt-4 border-t border-gray-200">
        <a href="{{ route('admin.login') }}" class="text-sm text-gray-600 hover:text-indigo-600">
            Akses sebagai <span class="font-semibold">Admin</span>
        </a>
    </div>

    <p class="mt-8 text-xs text-gray-400">
        &copy; {{ date('Y') }} Sistem Antrian Puskesmas
    </p>
    </div>
@endsection