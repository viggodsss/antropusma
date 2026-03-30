@extends('layouts.app')

@section('content')
<div style="padding: 32px 0;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">

        <div class="admin-page-header">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div>
                    <h1 class="admin-page-title">Antrian Menunggu</h1>
                    <p class="admin-page-subtitle">Daftar pasien yang sedang menunggu dipanggil</p>
                </div>
                <div style="display: flex; gap: 10px;">
                    <form method="POST" action="{{ route('admin.markServedAll') }}" onsubmit="return confirm('Tandai semua antrian menunggu menjadi selesai?');">
                        @csrf
                        <button type="submit" class="admin-btn btn-danger">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Selesai Semua
                        </button>
                    </form>
                    <a href="{{ route('admin.dashboard') }}" class="admin-btn btn-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.served') }}" class="admin-btn btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Antrian Selesai
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="admin-alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe);">
                    <svg class="w-5 h-5" style="color: #2563eb;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Pasien Menunggu Panggilan</h2>
                    <p style="font-size: 13px; color: #6b7280;">Total: <span style="font-weight: 700; color: #2563eb;">{{ $waiting->count() }}</span> pasien</p>
                </div>
            </div>

            @if($waiting->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="text-align: left;">No. Antrian</th>
                                <th style="text-align: left;">Nama Pasien</th>
                                <th style="text-align: left;">NIK</th>
                                <th style="text-align: left;">BPJS</th>
                                <th style="text-align: left;">Keluhan</th>
                                <th style="text-align: left;">Layanan</th>
                                <th style="text-align: left;">Terdaftar</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($waiting as $queue)
                                <tr>
                                    <td><span style="font-weight: 700; color: #2563eb;">{{ $queue->queue_number }}</span></td>
                                    <td style="font-weight: 500;">{{ $queue->patient_name }}</td>
                                    <td>{{ $queue->nik }}</td>
                                    <td>
                                        @if($queue->has_bpjs)
                                            <span class="admin-badge badge-success">Ya</span>
                                        @else
                                            <span class="admin-badge badge-gray">Tidak</span>
                                        @endif
                                    </td>
                                    <td>{{ $queue->complaint ?? '-' }}</td>
                                    <td><span class="admin-badge badge-purple">{{ $queue->service_type ?? '-' }}</span></td>
                                    <td>{{ $queue->created_at->format('d-m-Y H:i') }}</td>
                                    <td style="text-align: center;">
                                        <form method="POST" action="{{ route('admin.markServed', $queue->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="admin-btn btn-primary" style="font-size: 12px; padding: 6px 14px;">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Selesai
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="admin-empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p style="color: #059669; font-weight: 600; font-size: 13px;">Tidak ada antrian yang menunggu.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
