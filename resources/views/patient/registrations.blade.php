@extends('layouts.app')

@section('content')
<div class="py-6 sm:py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-4 sm:mb-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali
                    </a>
                </div>
                <a href="{{ route('queue.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Daftar Berobat Baru
                </a>
            </div>
        </div>

        <!-- Content Card -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-blue-600 to-cyan-600 text-white">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-lg bg-white/20 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold">Daftar Berobat</h2>
                        <p class="text-blue-100 text-sm">Riwayat pendaftaran antrian Anda</p>
                    </div>
                </div>
            </div>

            <div class="px-4 sm:px-6 py-4 sm:py-6">
                @if($registrations->isEmpty())
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="text-gray-500 mb-4">Anda belum memiliki riwayat pendaftaran berobat.</p>
                        <a href="{{ route('queue.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm">
                            Daftar Berobat Sekarang
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">No. Antrian</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Layanan/Klaster</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($registrations as $reg)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-indigo-100 text-indigo-800">
                                                {{ $reg->queue_number ?: 'Saat scan loket' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">
                                            {{ $reg->created_at->format('d M Y') }}
                                            <div class="text-xs text-gray-500">{{ $reg->created_at->format('H:i') }}</div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $reg->service_type ?? '-' }}</td>
                                        <td class="px-4 py-3">
                                            @php
                                                $statusColors = [
                                                    'approved' => 'bg-blue-100 text-blue-800',
                                                    'pending' => 'bg-amber-100 text-amber-800',
                                                    'waiting' => 'bg-yellow-100 text-yellow-800',
                                                    'called' => 'bg-purple-100 text-purple-800',
                                                    'served' => 'bg-green-100 text-green-800',
                                                    'skipped' => 'bg-red-100 text-red-800',
                                                    'rejected' => 'bg-red-100 text-red-800',
                                                    'cancelled' => 'bg-gray-100 text-gray-800',
                                                ];
                                                $statusLabels = [
                                                    'approved' => 'Menunggu Scan QR',
                                                    'pending' => 'Menunggu Persetujuan',
                                                    'waiting' => 'Dalam Antrian',
                                                    'called' => 'Dipanggil',
                                                    'served' => 'Selesai Dilayani',
                                                    'skipped' => 'Dilewati',
                                                    'rejected' => 'Ditolak',
                                                    'cancelled' => 'Dibatalkan',
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$reg->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $statusLabels[$reg->status] ?? ucfirst($reg->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <a href="{{ route('queue.show', $reg->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                Lihat Tiket
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $registrations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
