@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-sm mx-auto bg-white shadow-md rounded-lg p-6 text-center">
        <h2 class="text-2xl font-bold mb-4">Nomor Antrian Anda</h2>
        <p class="text-xl mb-2">{{ $queue->queue_number }}</p>
        <p class="text-sm text-gray-600 mb-4">{{ $queue->service_type }}</p>

        <!-- QR Code menggunakan Google Charts API (encode URL tiket) -->
        <div class="mb-4">
            @if($queue->qr_path)
                <img src="{{ asset('storage/'.$queue->qr_path) }}" alt="QR Code" class="mx-auto" />
            @elseif($queue->token)
                {{-- fallback ke Google jika belum dibuat --}}
                @php
                    $ticketUrl = route('queue.show', ['queue'=>$queue,'token'=>$queue->token]);
                @endphp
                <img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl={{ urlencode($ticketUrl) }}&choe=UTF-8" alt="QR Code" class="mx-auto" />
            @else
                <p class="text-red-500">QR code sudah dipindai dan tidak lagi tersedia.</p>
            @endif
        </div>

        <a href="{{ route('dashboard') }}" class="inline-block mt-4 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Kembali ke Dashboard</a>
    </div>
</div>
@endsection