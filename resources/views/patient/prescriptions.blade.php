@extends('layouts.app')

@section('content')
<div class="py-6 sm:py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-4 sm:mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Content Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-purple-600 to-pink-600 text-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">Resep Obat</h2>
                        <p class="text-purple-100 text-sm">Daftar resep obat dari pemeriksaan Anda</p>
                    </div>
                </div>
            </div>

            <div class="px-4 sm:px-6 py-4 bg-amber-50 border-b border-amber-200">
                <div class="flex items-start sm:items-center gap-2 text-amber-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm">
                        <strong>Catatan:</strong> Resep obat diresepkan oleh dokter. Silakan ambil obat di loket farmasi/apotik dengan menunjukkan nomor antrian Anda.
                    </p>
                </div>
            </div>

            <div class="px-4 sm:px-6 py-4 sm:py-6">
                @if($prescriptions->isEmpty())
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        <p class="text-gray-500">Belum ada data resep obat.</p>
                        <p class="text-sm text-gray-400 mt-1">Data akan muncul setelah dokter memberikan resep obat untuk Anda.</p>
                    </div>
                @else
                    <div class="mb-3 text-sm text-gray-600 font-medium">10 resep terakhir</div>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">No. Resep</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Tanggal</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Obat</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Dokter</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($prescriptions as $prescription)
                                    @php
                                        $colors = [
                                            'menunggu' => 'bg-yellow-100 text-yellow-800',
                                            'disiapkan' => 'bg-blue-100 text-blue-800',
                                            'diambil' => 'bg-green-100 text-green-800',
                                        ];
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                            {{ $prescription->nomor_resep ?: ('RX-' . str_pad((string) $prescription->id, 6, '0', STR_PAD_LEFT)) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ optional($prescription->tanggal_resep)->format('d-m-Y') ?? optional($prescription->created_at)->format('d-m-Y') }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ $prescription->nama_obat }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ $prescription->nama_dokter ?? $prescription->medicalExamination?->dokter_pemeriksa ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$prescription->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $prescription->status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $prescriptions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
