@extends('layouts.app')

@section('content')
<div class="dashboard-shell" style="padding: 32px 0;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">

    @if(!empty($dailyResetCount))
    <div class="reveal mb-6">
        <div class="admin-alert alert-error" style="padding: 16px 20px; border-radius: 16px;">
            <p class="text-sm font-bold text-red-800">Antrian hari sebelumnya telah ditutup otomatis</p>
            <p class="text-sm text-red-700 mt-1">Silakan daftar ulang untuk mendapatkan nomor antrian pada tanggal hari ini.</p>
        </div>
    </div>
    @endif

    @if(!empty($flowCompleted))
    <div class="reveal mb-6">
        <div class="admin-alert alert-success" style="padding: 16px 20px; border-radius: 16px;">
            <p class="text-sm font-bold text-emerald-800">Alur layanan selesai di Klaster 5 (Farmasi/Apotek)</p>
            <p class="text-sm text-emerald-700 mt-1">Tidak ada antrian aktif saat ini. Dashboard telah kembali ke kondisi awal.</p>
        </div>
    </div>
    @endif

    @if(!empty($activeQueue) && $activeQueue->status === 'called')
    <div class="reveal mb-6">
        <div class="admin-alert alert-success" style="padding: 16px 20px; border-radius: 16px; display: block;">
            <div class="flex items-start sm:items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-bold text-emerald-800">Anda sedang dipanggil</p>
                    <p class="text-sm text-emerald-700 mt-1">Silakan menuju <span class="font-semibold">{{ $activeQueue->service_type }}</span>. Anda akan diarahkan ke detail tiket.</p>
                </div>
                <a href="{{ route('queue.show', $activeQueue->id) }}" class="inline-flex items-center px-3 py-2 rounded-lg text-xs font-semibold text-white shrink-0" style="background: linear-gradient(135deg, #059669, #047857);">Lihat Tiket</a>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function () {
            window.location.href = "{{ route('queue.show', $activeQueue->id) }}";
        }, 1500);
    </script>
    @endif

    <div class="admin-page-header reveal" style="margin-bottom: 28px;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div>
                <p style="font-size: 11px; font-weight: 800; letter-spacing: 0.28em; text-transform: uppercase; color: #158f77; margin-bottom: 10px;">Portal Layanan Kesehatan</p>
                <h1 class="admin-page-title">Halo, {{ $user->name }} 👋</h1>
                <p class="admin-page-subtitle">Dashboard pasien untuk memantau antrian, layanan aktif, dan akses cepat menu kesehatan pada {{ now()->translatedFormat('l, d F Y') }}.</p>
            </div>
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <div class="admin-badge badge-info">{{ now()->translatedFormat('d M Y') }}</div>
                <div class="admin-badge badge-success">Role: {{ ucfirst($user->role) }}</div>
            </div>
        </div>
    </div>

    @if(!empty($pharmacyQueue))
    <div class="reveal mb-6">
        <div class="admin-card" style="border-color: #fde68a; background: linear-gradient(90deg, #fffbeb, #fef3c7);">
            <div class="admin-card-body" style="padding: 20px 24px;">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-amber-800">Rujukan Otomatis ke Klaster 5 (Farmasi/Apotek)</p>
                        <p class="text-sm text-amber-700 mt-1">Resep Anda sudah dibuat oleh petugas/dokter. Nomor antrian farmasi Anda: <span class="font-extrabold">{{ $pharmacyQueue->queue_number ?: 'Menunggu diterbitkan' }}</span>.</p>
                    </div>
                </div>
                <a href="{{ route('queue.show', $pharmacyQueue->id) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white shrink-0" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Lihat Tiket Farmasi
                </a>
            </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Info Cards -->
    <div class="reveal" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 28px;">
        <!-- Card 1: Antrian Anda -->
        <div class="admin-stat-card stat-blue">
            <div class="flex items-center gap-4">
                <div class="admin-stat-icon" style="background: #dbeafe; margin-bottom: 0;">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Antrian Anda</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $activeQueue?->queue_number ?: ($activeQueue?->status === 'approved' ? 'Scan di Loket' : '-') }}</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Layanan Aktif -->
        <div class="admin-stat-card stat-teal">
            <div class="flex items-center gap-4">
                <div class="admin-stat-icon" style="background: #dcfce7; margin-bottom: 0;">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Layanan Aktif</p>
                    <p class="text-2xl font-bold" style="color: #059669;">{{ $activeServiceLabel }}</p>
                </div>
            </div>
        </div>

        <!-- Card 3: Status -->
        <div class="admin-stat-card stat-amber">
            <div class="flex items-center gap-4">
                <div class="admin-stat-icon" style="background: #fef3c7; margin-bottom: 0;">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    <p class="text-base sm:text-xl font-bold" style="color: #10b981;">{{ $activeQueue->service_type ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($activeQueue)
    <div class="reveal mb-6 sm:mb-10">
        <a href="{{ route('queue.show', $activeQueue->id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white hover:opacity-90 transition-all" style="background: linear-gradient(135deg, #0ea5e9, #0284c7);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            Lihat Detail Antrian
        </a>
    </div>
    @endif

    <!-- Pilih Layanan Kesehatan -->
    <div class="reveal mb-10">
        <div class="admin-card overflow-hidden">
            <div class="admin-card-header" style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); border-bottom-color: #dcfce7;">
                <h3 class="text-base sm:text-lg font-bold text-gray-900">📋 Pilih Layanan Kesehatan</h3>
                <p class="text-sm text-gray-600 mt-1">Pilih klaster layanan kesehatan sesuai kebutuhan Anda</p>
            </div>

            <!-- Klaster Grid -->
            <div class="px-4 sm:px-6 py-4 sm:py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- 1. Klaster Manajemen -->
                    <div class="card-lift p-5 border border-green-100 rounded-2xl hover:border-green-300 transition group" style="background: #fdfdfd;">
                        <div class="flex items-start">
                            <div class="flex items-center justify-center h-10 w-10 rounded-xl mr-3 text-lg" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0);">⚙️</div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 group-hover:text-green-700">Klaster 1 Manajemen (Lantai 2)</h4>
                                <p class="text-sm text-gray-500 mt-1">Layanan administrasi dan pengelolaan manajemen.</p>
                                <p class="text-xs font-semibold text-gray-600 mt-3 mb-2">Pilihan ruangan:</p>
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('queue.create', ['service_type' => 'Manajemen - Ruang TU']) }}" class="inline-block px-3.5 py-1.5 text-xs font-semibold rounded-full text-white transition-all hover:shadow-md" style="background: linear-gradient(135deg, #10b981, #059669);">Ruang TU</a>
                                    <a href="{{ route('queue.create', ['service_type' => 'Manajemen - Ruang Keuangan']) }}" class="inline-block px-3.5 py-1.5 text-xs font-semibold rounded-full text-white transition-all hover:shadow-md" style="background: linear-gradient(135deg, #10b981, #059669);">Ruang Keuangan</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Klaster Ibu & Anak -->
                    <div class="card-lift p-5 border border-green-100 rounded-2xl hover:border-green-300 transition group" style="background: #fdfdfd;">
                        <div class="flex items-start">
                            <div class="flex items-center justify-center h-10 w-10 rounded-xl mr-3 text-lg" style="background: linear-gradient(135deg, #fce7f3, #fbcfe8);">👶</div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 group-hover:text-green-700">Klaster 2 Ibu dan Anak (Lantai 1)</h4>
                                <p class="text-sm text-gray-500 mt-1">Melayani ibu hamil, bersalin/nifas, anak, remaja, dan imunisasi.</p>
                                <p class="text-xs font-semibold text-gray-600 mt-3 mb-2">Pilihan ruangan:</p>
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('queue.create', ['service_type' => 'Ibu & Anak - Ruang KIA']) }}" class="inline-block px-3.5 py-1.5 text-xs font-semibold rounded-full text-white transition-all hover:shadow-md" style="background: linear-gradient(135deg, #10b981, #059669);">Ruang KIA</a>
                                    <a href="{{ route('queue.create', ['service_type' => 'Ibu & Anak - Ruang VK/Bersalin']) }}" class="inline-block px-3.5 py-1.5 text-xs font-semibold rounded-full text-white transition-all hover:shadow-md" style="background: linear-gradient(135deg, #10b981, #059669);">Ruang VK/bersalin</a>
                                    <a href="{{ route('queue.create', ['service_type' => 'Ibu & Anak - Ruang Imunisasi']) }}" class="inline-block px-3.5 py-1.5 text-xs font-semibold rounded-full text-white transition-all hover:shadow-md" style="background: linear-gradient(135deg, #10b981, #059669);">Ruang imunisasi</a>
                                    <a href="{{ route('queue.create', ['service_type' => 'Ibu & Anak - Ruangan Klaster 2 (Bayi/Balita/Remaja)']) }}" class="inline-block px-3.5 py-1.5 text-xs font-semibold rounded-full text-white transition-all hover:shadow-md" style="background: linear-gradient(135deg, #10b981, #059669);">pelayanan bayi, balita anak prasekolah dan remaja</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Usia Dewasa & Lansia -->
                    <div class="card-lift p-5 border border-green-100 rounded-2xl hover:border-green-300 transition group" style="background: #fdfdfd;">
                        <div class="flex items-start">
                            <div class="flex items-center justify-center h-10 w-10 rounded-xl mr-3 text-lg" style="background: linear-gradient(135deg, #d1fae5, #a7f3d0);">🧓</div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 group-hover:text-green-700">Klaster 3 Usia Dewasa dan Lansia (Lantai 1)</h4>
                                <p class="text-sm text-gray-500 mt-1">Skrining PTM, pemeriksaan berkala, dan penanganan usia 18+.</p>
                                <p class="text-xs font-semibold text-gray-600 mt-3 mb-2">Pilihan ruangan:</p>
                                <a href="{{ route('queue.create', ['service_type' => 'Usia Dewasa & Lansia - Ruangan Klaster 3 (Skrining PTM)']) }}" class="inline-block px-3.5 py-1.5 text-xs font-semibold rounded-full text-white transition-all hover:shadow-md" style="background: linear-gradient(135deg, #10b981, #059669);">Ruangan Klaster 3</a>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Penanggulangan Penyakit Menular -->
                    <div class="card-lift p-5 border border-green-100 rounded-2xl hover:border-green-300 transition group" style="background: #fdfdfd;">
                        <div class="flex items-start">
                            <div class="flex items-center justify-center h-10 w-10 rounded-xl mr-3 text-lg" style="background: linear-gradient(135deg, #fef3c7, #fde68a);">🦠</div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 group-hover:text-green-700">Klaster 4 Penyakit Menular & Kesling</h4>
                                <p class="text-sm text-gray-500 mt-1">Penanggulangan penyakit menular dan pengendalian risiko lingkungan.</p>
                                <p class="text-xs font-semibold text-gray-600 mt-3 mb-2">Pilihan ruangan:</p>
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('queue.create', ['service_type' => 'Klaster 4 - Poli Anggrek (Penyakit Menular)']) }}" class="inline-block px-3.5 py-1.5 text-xs font-semibold rounded-full text-white transition-all hover:shadow-md" style="background: linear-gradient(135deg, #10b981, #059669);">Poli Anggrek</a>
                                    <a href="{{ route('queue.create', ['service_type' => 'Klaster 4 - Ruang TB']) }}" class="inline-block px-3.5 py-1.5 text-xs font-semibold rounded-full text-white transition-all hover:shadow-md" style="background: linear-gradient(135deg, #10b981, #059669);">Ruang TB</a>
                                    <a href="{{ route('queue.create', ['service_type' => 'Klaster 4 - Ruang Kesling']) }}" class="inline-block px-3.5 py-1.5 text-xs font-semibold rounded-full text-white transition-all hover:shadow-md" style="background: linear-gradient(135deg, #10b981, #059669);">Ruang Kesling</a>
                                    <a href="{{ route('queue.create', ['service_type' => 'Klaster 4 - Ruang Malaria']) }}" class="inline-block px-3.5 py-1.5 text-xs font-semibold rounded-full text-white transition-all hover:shadow-md" style="background: linear-gradient(135deg, #10b981, #059669);">Ruang Malaria</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Lintas Klaster -->
                    <div class="card-lift p-5 border border-green-100 rounded-2xl hover:border-green-300 transition group" style="background: #fdfdfd;">
                        <div class="flex items-start">
                            <div class="flex items-center justify-center h-10 w-10 rounded-xl mr-3 text-lg" style="background: linear-gradient(135deg, #ede9fe, #ddd6fe);">🏥</div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-900 group-hover:text-green-700">Klaster 5 Lintas Klaster</h4>
                                <p class="text-sm text-gray-500 mt-1">Pelayanan penunjang lintas klaster untuk kondisi gawat, farmasi, dan lab.</p>
                                <p class="text-xs font-semibold text-gray-600 mt-3 mb-2">Pilihan ruangan:</p>
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('queue.create', ['service_type' => 'Lintas Klaster - Ruang UGD & Observasi']) }}" class="inline-block px-3.5 py-1.5 text-xs font-semibold rounded-full text-white transition-all hover:shadow-md" style="background: linear-gradient(135deg, #ef4444, #dc2626);">UGD & Observasi</a>
                                    <a href="{{ route('queue.create', ['service_type' => 'Lintas Klaster - Farmasi/Apotek']) }}" class="inline-block px-3.5 py-1.5 text-xs font-semibold rounded-full text-white transition-all hover:shadow-md" style="background: linear-gradient(135deg, #10b981, #059669);">Farmasi/apotik</a>
                                    <a href="{{ route('queue.create', ['service_type' => 'Lintas Klaster - Laboratorium']) }}" class="inline-block px-3.5 py-1.5 text-xs font-semibold rounded-full text-white transition-all hover:shadow-md" style="background: linear-gradient(135deg, #10b981, #059669);">laboratorium</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Menu Pasien -->
    <div class="reveal">
        <div class="admin-card overflow-hidden">
            <div class="admin-card-header" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); border-bottom-color: #d1fae5;">
                <h3 class="text-base sm:text-lg font-bold text-gray-900">⚡ Menu Pasien</h3>
            </div>
            <div class="px-4 sm:px-6 py-4 sm:py-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('patient.profile') }}" class="card-lift p-5 text-left border border-green-100 rounded-2xl hover:border-green-300 transition group" style="background: #fdfdfd;">
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white" style="background: linear-gradient(135deg, #10b981, #059669);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 group-hover:text-green-700">Profil Saya</h4>
                                <p class="text-sm text-gray-500 mt-1">Kelola data diri, identitas, dan informasi kontak</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('patient.registrations') }}" class="card-lift p-5 text-left border border-green-100 rounded-2xl hover:border-green-300 transition group" style="background: #fdfdfd;">
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white" style="background: linear-gradient(135deg, #34d399, #10b981);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 group-hover:text-green-700">Daftar Berobat</h4>
                                <p class="text-sm text-gray-500 mt-1">Lihat riwayat pendaftaran antrian Anda</p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('patient.examinations') }}" class="card-lift p-5 text-left border border-green-100 rounded-2xl hover:border-green-300 transition group" style="background: #fdfdfd;">
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white" style="background: linear-gradient(135deg, #6ee7b7, #34d399);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 group-hover:text-green-700">Riwayat Pemeriksaan</h4>
                                <p class="text-sm text-gray-500 mt-1">Lihat data rekam medis pemeriksaan <span class="text-xs text-gray-400">(hanya baca)</span></p>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('patient.prescriptions') }}" class="card-lift p-5 text-left border border-green-100 rounded-2xl hover:border-green-300 transition group" style="background: #fdfdfd;">
                        <div class="flex items-start gap-4">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white" style="background: linear-gradient(135deg, #a7f3d0, #6ee7b7);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 group-hover:text-green-700">Resep Obat</h4>
                                <p class="text-sm text-gray-500 mt-1">Lihat daftar resep obat Anda <span class="text-xs text-gray-400">(hanya baca)</span></p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    </div>
</div>
@endsection