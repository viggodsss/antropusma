@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('patient.examinations') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Riwayat
                </a>
            </div>
        </div>

        <!-- Content Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-6 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">Detail Pemeriksaan</h2>
                            <p class="text-emerald-100 text-sm">{{ $examination->tanggal_periksa->format('d F Y') }}</p>
                        </div>
                    </div>
                    @if($examination->status === 'selesai')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20">
                            ✓ Selesai
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-400/20 text-yellow-100">
                            ⏳ Dalam Proses
                        </span>
                    @endif
                </div>
            </div>

            <div class="divide-y divide-gray-200">
                <!-- Informasi Umum -->
                <div class="px-6 py-5">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">📋 Informasi Umum</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Pemeriksaan</p>
                            <p class="font-medium text-gray-900">{{ $examination->tanggal_periksa->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Poli/Klaster Tujuan</p>
                            <p class="font-medium text-gray-900">{{ $examination->poli_tujuan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Dokter Pemeriksa</p>
                            <p class="font-medium text-gray-900">{{ $examination->dokter_pemeriksa ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Keluhan -->
                @if($examination->keluhan_utama || $examination->riwayat_penyakit_sekarang)
                <div class="px-6 py-5">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">🩺 Keluhan</h3>
                    <div class="space-y-4">
                        @if($examination->keluhan_utama)
                        <div>
                            <p class="text-sm text-gray-500">Keluhan Utama</p>
                            <p class="text-gray-900 mt-1">{{ $examination->keluhan_utama }}</p>
                        </div>
                        @endif
                        @if($examination->riwayat_penyakit_sekarang)
                        <div>
                            <p class="text-sm text-gray-500">Riwayat Penyakit Sekarang</p>
                            <p class="text-gray-900 mt-1">{{ $examination->riwayat_penyakit_sekarang }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Tanda Vital -->
                @if($examination->tekanan_darah || $examination->nadi || $examination->suhu || $examination->respirasi || $examination->berat_badan || $examination->tinggi_badan)
                <div class="px-6 py-5">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">💓 Tanda Vital</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @if($examination->tekanan_darah)
                        <div class="p-3 bg-red-50 rounded-lg">
                            <p class="text-xs text-red-600 font-medium">Tekanan Darah</p>
                            <p class="text-lg font-bold text-red-700">{{ $examination->tekanan_darah }}</p>
                        </div>
                        @endif
                        @if($examination->nadi)
                        <div class="p-3 bg-pink-50 rounded-lg">
                            <p class="text-xs text-pink-600 font-medium">Nadi</p>
                            <p class="text-lg font-bold text-pink-700">{{ $examination->nadi }} x/menit</p>
                        </div>
                        @endif
                        @if($examination->suhu)
                        <div class="p-3 bg-orange-50 rounded-lg">
                            <p class="text-xs text-orange-600 font-medium">Suhu</p>
                            <p class="text-lg font-bold text-orange-700">{{ $examination->suhu }}°C</p>
                        </div>
                        @endif
                        @if($examination->respirasi)
                        <div class="p-3 bg-blue-50 rounded-lg">
                            <p class="text-xs text-blue-600 font-medium">Respirasi</p>
                            <p class="text-lg font-bold text-blue-700">{{ $examination->respirasi }} x/menit</p>
                        </div>
                        @endif
                        @if($examination->berat_badan)
                        <div class="p-3 bg-green-50 rounded-lg">
                            <p class="text-xs text-green-600 font-medium">Berat Badan</p>
                            <p class="text-lg font-bold text-green-700">{{ $examination->berat_badan }} kg</p>
                        </div>
                        @endif
                        @if($examination->tinggi_badan)
                        <div class="p-3 bg-indigo-50 rounded-lg">
                            <p class="text-xs text-indigo-600 font-medium">Tinggi Badan</p>
                            <p class="text-lg font-bold text-indigo-700">{{ $examination->tinggi_badan }} cm</p>
                        </div>
                        @endif
                        @if($examination->imt)
                        <div class="p-3 bg-purple-50 rounded-lg">
                            <p class="text-xs text-purple-600 font-medium">IMT</p>
                            <p class="text-lg font-bold text-purple-700">{{ $examination->imt }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Hasil Pemeriksaan -->
                @if($examination->hasil_pemeriksaan_fisik)
                <div class="px-6 py-5">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">🔬 Hasil Pemeriksaan Fisik</h3>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-gray-900 whitespace-pre-line">{{ $examination->hasil_pemeriksaan_fisik }}</p>
                    </div>
                </div>
                @endif

                <!-- Diagnosa -->
                @if($examination->diagnosa)
                <div class="px-6 py-5">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">🏥 Diagnosa</h3>
                    <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                        <p class="font-medium text-emerald-800">{{ $examination->diagnosa }}</p>
                        @if($examination->kode_icd10)
                            <p class="text-sm text-emerald-600 mt-1">Kode ICD-10: {{ $examination->kode_icd10 }}</p>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Tindakan & Anjuran -->
                @if($examination->tindakan || $examination->anjuran)
                <div class="px-6 py-5">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">📝 Tindakan & Anjuran</h3>
                    <div class="space-y-4">
                        @if($examination->tindakan)
                        <div>
                            <p class="text-sm font-medium text-gray-700">Tindakan yang Dilakukan:</p>
                            <p class="text-gray-900 mt-1">{{ $examination->tindakan }}</p>
                        </div>
                        @endif
                        @if($examination->anjuran)
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <p class="text-sm font-medium text-blue-700 mb-1">💡 Anjuran Dokter:</p>
                            <p class="text-blue-800">{{ $examination->anjuran }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Resep Obat -->
                @if($examination->prescriptions->count() > 0)
                <div class="px-6 py-5">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">💊 Resep Obat</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">No</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Nama Obat</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Jumlah</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Dosis</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Aturan Pakai</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($examination->prescriptions as $index => $prescription)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $prescription->nama_obat }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $prescription->jumlah ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $prescription->dosis ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-900">{{ $prescription->aturan_pakai ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        @php
                                            $colors = [
                                                'menunggu' => 'bg-yellow-100 text-yellow-800',
                                                'disiapkan' => 'bg-blue-100 text-blue-800',
                                                'diambil' => 'bg-green-100 text-green-800',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $colors[$prescription->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $prescription->status_label }}
                                        </span>
                                    </td>
                                </tr>
                                @if($prescription->catatan)
                                <tr class="bg-gray-50">
                                    <td></td>
                                    <td colspan="5" class="px-4 py-2 text-xs text-gray-600">
                                        <span class="font-medium">Catatan:</span> {{ $prescription->catatan }}
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
