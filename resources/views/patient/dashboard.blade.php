@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="mb-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-blue-600 text-white">
                    <h3 class="text-2xl font-bold">
                        Selamat datang, {{ $user->name }}! 👋
                    </h3>
                    <p class="text-indigo-100 mt-1">Role: <span class="font-semibold">{{ ucfirst($user->role) }}</span></p>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Card 1: Antrian Anda -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                <div class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Antrian Anda</p>
                            <p class="text-2xl font-semibold text-gray-900">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Layanan Aktif -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                <div class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-green-500 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Layanan Aktif</p>
                            <p class="text-2xl font-semibold text-green-600">Tersedia</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                <div class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-purple-500 text-white">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Status</p>
                            <p class="text-2xl font-semibold text-purple-600">Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Menu Sections -->
        <div class="mb-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">📋 Pilih Layanan Kesehatan</h3>
                    <p class="text-sm text-gray-600 mt-1">Pilih klaster layanan kesehatan sesuai kebutuhan Anda</p>
                </div>
                
                <!-- Klaster Grid -->
                <div class="px-6 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- 1. Klaster Manajemen -->
                        <a href="#manajemen" class="p-5 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition cursor-pointer group">
                            <div class="flex items-start">
                                <div class="text-2xl mr-3">⚙️</div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-blue-600">Klaster Manajemen</h4>
                                    <p class="text-sm text-gray-600 mt-1">Pengelolaan dan manajemen kesehatan umum</p>
                                </div>
                            </div>
                        </a>

                        <!-- 2. Klaster Ibu & Anak -->
                        <a href="#ibu-anak" class="p-5 border-2 border-gray-200 rounded-lg hover:border-pink-500 hover:bg-pink-50 transition cursor-pointer group">
                            <div class="flex items-start">
                                <div class="text-2xl mr-3">👶</div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-pink-600">Ibu & Anak</h4>
                                    <p class="text-sm text-gray-600 mt-1">Layanan kesehatan ibu hamil & anak</p>
                                </div>
                            </div>
                        </a>

                        <!-- 3. Usia Dewasa & Lansia -->
                        <a href="#dewasa-lansia" class="p-5 border-2 border-gray-200 rounded-lg hover:border-emerald-500 hover:bg-emerald-50 transition cursor-pointer group">
                            <div class="flex items-start">
                                <div class="text-2xl mr-3">🧓</div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-emerald-600">Dewasa & Lansia</h4>
                                    <p class="text-sm text-gray-600 mt-1">Kesehatan dewasa dan lansia</p>
                                </div>
                            </div>
                        </a>

                        <!-- 4. Lintas Klaster Apotek & Farmasi -->
                        <a href="#apotek-farmasi" class="p-5 border-2 border-gray-200 rounded-lg hover:border-amber-500 hover:bg-amber-50 transition cursor-pointer group">
                            <div class="flex items-start">
                                <div class="text-2xl mr-3">💊</div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-amber-600">Apotek & Farmasi</h4>
                                    <p class="text-sm text-gray-600 mt-1">Layanan apotek dan farmasi</p>
                                </div>
                            </div>
                        </a>

                        <!-- 5. Laboratorium -->
                        <a href="#laboratorium" class="p-5 border-2 border-gray-200 rounded-lg hover:border-violet-500 hover:bg-violet-50 transition cursor-pointer group">
                            <div class="flex items-start">
                                <div class="text-2xl mr-3">🔬</div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-violet-600">Laboratorium</h4>
                                    <p class="text-sm text-gray-600 mt-1">Pemeriksaan laboratorium</p>
                                </div>
                            </div>
                        </a>

                        <!-- 6. Daftar Antrian -->
                        <a href="{{ route('queue.create') }}" class="p-5 border-2 border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition cursor-pointer group">
                            <div class="flex items-start">
                                <div class="text-2xl mr-3">📝</div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-green-600">Daftar Antrian</h4>
                                    <p class="text-sm text-gray-600 mt-1">Daftarkan diri untuk antrian</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Actions -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">⚡ Aksi Cepat</h3>
            </div>
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button class="p-4 text-left border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <h4 class="font-semibold text-gray-900">🔍 Lihat Antrian Saat Ini</h4>
                        <p class="text-sm text-gray-600 mt-1">Cek posisi Anda dalam antrian</p>
                    </button>
                    <button class="p-4 text-left border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <h4 class="font-semibold text-gray-900">📋 Riwayat Kunjungan</h4>
                        <p class="text-sm text-gray-600 mt-1">Lihat data riwayat kunjungan</p>
                    </button>
                    <button class="p-4 text-left border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <h4 class="font-semibold text-gray-900">👤 Profil Saya</h4>
                        <p class="text-sm text-gray-600 mt-1">Kelola data profil dan kontak</p>
                    </button>
                    <button class="p-4 text-left border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <h4 class="font-semibold text-gray-900">❓ Bantuan</h4>
                        <p class="text-sm text-gray-600 mt-1">Hubungi customer support</p>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection