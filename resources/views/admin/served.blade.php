@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8">Antrian Selesai</h1>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            @if($served->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Nomor Antrian</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Nama Pasien</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">NIK</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Keluhan</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Layanan</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Waktu Terdaftar</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Waktu Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($served as $queue)
                                <tr class="border-b bg-green-50">
                                    <td class="px-6 py-4 font-semibold text-green-600">{{ $queue->queue_number }}</td>
                                    <td class="px-6 py-4">{{ $queue->patient_name }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $queue->nik }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $queue->complaint ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $queue->service_type ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $queue->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $queue->updated_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-4 text-gray-600">
                    ℹ️ Belum ada antrian yang selesai.
                </div>
            @endif
        </div>

        <div class="flex gap-4 mt-8">
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali ke Dashboard</a>
            <a href="{{ route('admin.waiting') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Lihat Antrian Menunggu</a>
        </div>
    </div>
</div>
@endsection
