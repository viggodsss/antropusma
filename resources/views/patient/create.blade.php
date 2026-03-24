@extends('layouts.app')

@section('content')

<div class="bg-white rounded-2xl shadow-lg p-8 max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-indigo-600 mb-6">
        ➕ Tambah Data Pasien
    </h2>

    <form method="POST" action="{{ route('patients.store') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-gray-700 font-medium mb-2">Nama Lengkap</label>
            <input type="text" name="name"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">NIK</label>
            <input type="text" name="nik"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>

        <div>
            <label class="block text-gray-700 font-medium mb-2">No HP</label>
            <input type="text" name="phone"
                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:outline-none">
        </div>

        <div class="flex justify-end">
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition shadow-md">
                Simpan Data
            </button>
        </div>

    </form>
</div>

@endsection