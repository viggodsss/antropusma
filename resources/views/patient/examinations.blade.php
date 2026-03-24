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
            <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">Riwayat Pemeriksaan</h2>
                        <p class="text-emerald-100 text-sm">Data rekam medis pemeriksaan Anda</p>
                    </div>
                </div>
            </div>

            <div class="px-4 sm:px-6 py-4 bg-amber-50 border-b border-amber-200">
                <div class="flex items-start sm:items-center gap-2 text-amber-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm">
                        <strong>Catatan:</strong> Data rekam medis hanya dapat diisi oleh tenaga medis yang berwenang. Anda hanya dapat melihat data ini.
                    </p>
                </div>
            </div>

            <div class="px-4 sm:px-6 py-4 sm:py-6">
                @if($examinations->isEmpty())
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-gray-500">Belum ada data riwayat pemeriksaan.</p>
                        <p class="text-sm text-gray-400 mt-1">Data akan muncul setelah Anda menjalani pemeriksaan di Puskesmas.</p>
                    </div>
                @else
                    <div class="mb-3 text-sm text-gray-600 font-medium">10 pemeriksaan terakhir</div>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Tanggal</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Poli/Klaster</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Keluhan</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Diagnosa</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Dokter</th>
                                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($examinations as $exam)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ optional($exam->tanggal_periksa)->format('d-m-Y') ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ $exam->poli_tujuan ?? $exam->queue?->service_type ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ \Illuminate\Support\Str::limit($exam->keluhan_utama ?? $exam->queue?->complaint ?? '-', 80) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ \Illuminate\Support\Str::limit($exam->diagnosa ?? '-', 80) }}
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ $exam->dokter_pemeriksa ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('patient.examinations.show', $exam->id) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700 transition">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $examinations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
