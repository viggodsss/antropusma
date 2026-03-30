@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-md mx-auto bg-white shadow-lg rounded-2xl overflow-hidden">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-4 text-center">
            <h2 class="text-xl font-bold">Tiket Antrian Puskesmas</h2>
            <p class="text-green-100 text-sm mt-1">{{ now()->format('d F Y') }}</p>
        </div>

        <div class="p-6">
            {{-- Nomor Antrian --}}
            <div class="text-center mb-6">
                <p class="text-gray-500 text-sm uppercase tracking-wider">Nomor Antrian</p>
                @if(!empty($queue->queue_number))
                    <p class="text-5xl font-black text-green-700 mt-1">{{ $queue->queue_number }}</p>
                @else
                    <p class="text-lg font-bold text-amber-700 mt-2">Belum mendapatkan nomor</p>
                    <p class="text-xs text-gray-500 mt-1">Nomor akan muncul setelah QR discan petugas loket.</p>
                @endif
                <p class="text-gray-600 mt-2">{{ $queue->service_type }}</p>
            </div>

            {{-- Info Pasien --}}
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-gray-500">Nama Pasien</p>
                        <p class="font-semibold text-gray-900">{{ $queue->patient_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">NIK</p>
                        <p class="font-semibold text-gray-900">{{ substr($queue->nik, 0, 6) }}******</p>
                    </div>
                </div>
                @if($queue->complaint)
                    <div class="mt-3 pt-3 border-t text-sm">
                        <p class="text-gray-500">Keluhan</p>
                        <p class="font-medium text-gray-900">{{ $queue->complaint }}</p>
                    </div>
                @endif
            </div>

            @if(!empty($isExpiredTicket))
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
                    <h4 class="font-semibold text-red-800 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tiket Kedaluwarsa
                    </h4>
                    <p class="mt-2 text-sm text-red-700">
                        Tiket ini hanya berlaku pada tanggal {{ $queue->queue_date ? $queue->queue_date->translatedFormat('d F Y') : '-' }}.
                        Silakan daftar ulang untuk mendapatkan antrian hari ini.
                    </p>
                </div>
            @endif

            {{-- Status --}}
            <div class="text-center mb-6">
                @if($queue->status === 'approved')
                    <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Menunggu Scan di Loket
                    </span>
                @elseif($queue->status === 'waiting')
                    <span class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Dalam Antrian Menunggu
                    </span>
                @elseif($queue->status === 'called')
                    <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-semibold animate-pulse">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                        SEDANG DIPANGGIL!
                    </span>
                @elseif($queue->status === 'served')
                    <span class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-800 rounded-full text-sm font-semibold">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Selesai Dilayani
                    </span>
                @endif
            </div>

            {{-- QR Code --}}
            @if($queue->status === 'approved' && ($queue->qr_path || $queue->token) && empty($isExpiredTicket))
                <div class="text-center mb-6">
                    <p class="text-gray-500 text-sm mb-3">Tunjukkan QR Code ini di loket pendaftaran</p>
                    <div class="bg-white border-2 border-dashed border-gray-300 rounded-xl p-4 inline-block">
                        @if(!empty($qrImageDataUri))
                            <img src="{{ $qrImageDataUri }}" alt="QR Code" class="mx-auto w-48 h-48" />
                        @elseif($queue->qr_path)
                            <img src="{{ asset('storage/'.$queue->qr_path) }}" alt="QR Code" class="mx-auto w-48 h-48" />
                        @elseif($queue->token)
                            @php
                                $ticketUrl = route('admin.queue.scan', ['queue'=>$queue,'token'=>$queue->token]);
                            @endphp
                            <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{ urlencode($ticketUrl) }}&choe=UTF-8" alt="QR Code" class="mx-auto" />
                        @endif
                    </div>
                </div>

                {{-- Instruksi --}}
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                    <h4 class="font-semibold text-amber-800 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Langkah Selanjutnya
                    </h4>
                    <ol class="mt-2 text-sm text-amber-700 list-decimal list-inside space-y-1">
                        <li>Datang ke Puskesmas sesuai tanggal pendaftaran</li>
                        <li>Tunjukkan QR Code ini ke petugas loket</li>
                        <li>Tunggu nomor antrian Anda dipanggil</li>
                    </ol>
                </div>
            @elseif($queue->status === 'waiting')
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
                    <h4 class="font-semibold text-blue-800 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi
                    </h4>
                    <p class="mt-2 text-sm text-blue-700">
                        Anda sudah tercatat dalam antrian. Silakan tunggu di ruang tunggu hingga nomor Anda dipanggil.
                    </p>
                </div>
            @elseif($queue->status === 'called')
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                    <h4 class="font-semibold text-green-800 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                        Giliran Anda!
                    </h4>
                    <p class="mt-2 text-sm text-green-700">
                        Silakan menuju ke <strong>{{ $queue->service_type }}</strong> sekarang.
                    </p>
                </div>
            @elseif($queue->status === 'served' && !empty($needsPharmacyStep) && !empty($nextPharmacyQueue))
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                    <h4 class="font-semibold text-amber-800 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Lanjut ke Klaster 5 (Farmasi/Apotek)
                    </h4>
                    <p class="mt-2 text-sm text-amber-700">
                        Pemeriksaan di layanan ini sudah selesai. Silakan lanjut ke <strong>Farmasi/Apotek</strong> untuk mengambil obat.
                    </p>
                    <a href="{{ route('queue.show', $nextPharmacyQueue->id) }}" class="mt-3 inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold text-white" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        Lihat Tiket Farmasi ({{ $nextPharmacyQueue->queue_number }})
                    </a>
                </div>
            @elseif($queue->status === 'served' && !empty($isFinalAtPharmacy))
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 mb-6">
                    <h4 class="font-semibold text-emerald-800 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Alur Layanan Selesai
                    </h4>
                    <p class="mt-2 text-sm text-emerald-700">
                        Obat Anda telah diproses di Farmasi/Apotek. Seluruh alur layanan kunjungan ini sudah selesai.
                    </p>
                </div>
            @endif

            {{-- Tombol Kembali --}}
            <div class="text-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-gray-700 text-white font-medium rounded-xl hover:bg-gray-800 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <div class="bg-gray-50 px-6 py-3 text-center text-xs text-gray-500">
            Tiket berlaku untuk tanggal {{ $queue->queue_date ? $queue->queue_date->format('d F Y') : now()->format('d F Y') }}
        </div>
    </div>
</div>
@endsection