@extends('layouts.app')

@section('content')
<div class="dashboard-shell" style="padding: 32px 0;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
    <div class="admin-page-header reveal" style="margin-bottom: 28px;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div>
                <p style="font-size: 11px; font-weight: 800; letter-spacing: 0.28em; text-transform: uppercase; color: #158f77; margin-bottom: 10px;">Dashboard Klaster Layanan</p>
                <h1 class="admin-page-title">Dashboard Petugas Klaster {{ $cluster }}</h1>
                <p class="admin-page-subtitle">Pantau antrian, keluhan pasien, dan proses layanan klaster dengan tampilan kesehatan yang konsisten dan fokus operasional.</p>
            </div>
            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; justify-content: flex-end;">
                <div class="admin-badge badge-info">Klaster {{ $cluster }}</div>
                <div class="admin-badge badge-success">Role: Petugas</div>
                <a href="{{ route('petugas.callNext.get') }}" class="admin-btn btn-info" style="padding: 12px 20px;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    Panggil Antrian Berikut
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="admin-alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="admin-alert alert-error">{{ session('error') }}</div>
    @endif
    @if(session('info'))
        <div class="admin-alert alert-info">{{ session('info') }}</div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 28px;">
        <div class="admin-stat-card stat-blue">
            <p class="text-xs text-slate-500">Jumlah Antrian Klaster</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $counts['total'] }}</p>
        </div>
        <div class="admin-stat-card stat-amber">
            <p class="text-xs text-amber-600">Belum Scan</p>
            <p class="text-2xl font-bold text-amber-700 mt-1">{{ $counts['belum_scan'] }}</p>
        </div>
        <div class="admin-stat-card stat-cyan">
            <p class="text-xs text-cyan-600">Menunggu</p>
            <p class="text-2xl font-bold text-cyan-700 mt-1">{{ $counts['menunggu'] }}</p>
        </div>
        <div class="admin-stat-card stat-teal">
            <p class="text-xs text-emerald-600">Selesai</p>
            <p class="text-2xl font-bold text-emerald-700 mt-1">{{ $counts['selesai'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="admin-card overflow-hidden">
            <div class="admin-card-header" style="background: #f9fafb;">
                <h3 class="font-bold text-slate-900">Antrian Menunggu Klaster {{ $cluster }}</h3>
            </div>
            <div class="admin-card-body">
                @if($waitingQueues->isEmpty())
                    <p class="text-sm text-slate-500">Belum ada antrian menunggu.</p>
                @else
                    <div class="space-y-3">
                        @foreach($waitingQueues as $queue)
                            <div class="border border-slate-200 rounded-lg p-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $queue->queue_number ?: 'Menunggu nomor' }} - {{ $queue->patient_name }}</p>
                                        <p class="text-xs text-slate-500 mt-1">{{ $queue->service_type }}</p>
                                        @if($queue->complaint)
                                            <p class="text-sm text-slate-700 mt-2">Keluhan: {{ \Illuminate\Support\Str::limit($queue->complaint, 120) }}</p>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-2 shrink-0">
                                        @if(in_array($cluster, [2, 3, 4], true))
                                            <a href="{{ route('petugas.examinations.create', $queue->id) }}" class="px-3 py-1.5 rounded-md text-xs font-semibold bg-emerald-100 text-emerald-700">Input Pemeriksaan + Resep</a>
                                        @endif
                                        <form method="POST" action="{{ route('petugas.markServed', $queue->id) }}">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 rounded-md text-xs font-semibold bg-slate-100 text-slate-700">Selesai</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="admin-card overflow-hidden">
            <details class="group" open>
                <summary class="admin-card-header cursor-pointer list-none flex items-center justify-between" style="background: #f9fafb;">
                    <h3 class="font-bold text-slate-900">Keluhan Pasien</h3>
                    <span class="text-xs font-semibold text-slate-500">Buka/Tutup</span>
                </summary>
                <div class="admin-card-body" style="border-top: 1px solid #f3f4f6;">
                    @if($complaints->isEmpty())
                        <p class="text-sm text-slate-500">Belum ada keluhan pasien pada klaster ini.</p>
                    @else
                        <div class="space-y-3 max-h-80 overflow-y-auto pr-1">
                            @foreach($complaints as $item)
                                <div class="border border-slate-200 rounded-lg p-3">
                                    <p class="text-sm font-semibold text-slate-900">{{ $item->queue_number ?: 'Belum scan' }} - {{ $item->patient_name }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $item->service_type }}</p>
                                    <p class="text-sm text-slate-700 mt-2 leading-relaxed">{{ $item->complaint }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </details>
        </div>
    </div>

    <div class="mt-6 admin-card overflow-hidden">
        <div class="admin-card-header" style="background: #f9fafb;">
            <h3 class="font-bold text-slate-900">Pasien Sedang Dipanggil (Klaster {{ $cluster }})</h3>
        </div>
        <div class="admin-card-body">
            @if($calledQueues->isEmpty())
                <p class="text-sm text-slate-500">Belum ada pasien berstatus dipanggil.</p>
            @else
                <div class="space-y-3">
                    @foreach($calledQueues as $queue)
                        <div class="border border-emerald-200 bg-emerald-50/40 rounded-lg p-3">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-bold text-slate-900">{{ $queue->queue_number ?: 'Menunggu nomor' }} - {{ $queue->patient_name }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $queue->service_type }}</p>
                                    @if($queue->called_at)
                                        <p class="text-xs text-emerald-700 mt-1">Dipanggil: {{ $queue->called_at->format('H:i') }}</p>
                                    @endif
                                </div>
                                <div class="flex flex-col gap-2 shrink-0">
                                    @if(in_array($cluster, [2, 3, 4], true))
                                        <a href="{{ route('petugas.examinations.create', $queue->id) }}" class="px-3 py-1.5 rounded-md text-xs font-semibold bg-emerald-100 text-emerald-700">Input Pemeriksaan + Resep</a>
                                    @endif
                                    <form method="POST" action="{{ route('petugas.markServed', $queue->id) }}">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-md text-xs font-semibold bg-slate-100 text-slate-700">Selesai</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @if(in_array($cluster, [2, 3, 4], true))
    <div class="mt-6 admin-card overflow-hidden">
        <div class="admin-card-header" style="background: #f9fafb;">
            <h3 class="font-bold text-slate-900">Riwayat Pemeriksaan Klaster {{ $cluster }}</h3>
        </div>
        <div class="admin-card-body">
            @if($recentExaminations->isEmpty())
                <p class="text-sm text-slate-500">Belum ada riwayat pemeriksaan tersimpan.</p>
            @else
                <div class="space-y-3">
                    @foreach($recentExaminations as $exam)
                        <div class="border border-slate-200 rounded-lg p-3">
                            <p class="text-sm font-semibold text-slate-900">{{ $exam->user?->name ?? 'Pasien' }} - {{ $exam->poli_tujuan ?? '-' }}</p>
                            <p class="text-xs text-slate-500 mt-1">{{ optional($exam->tanggal_periksa)->format('d M Y') ?? '-' }} | Dokter/Petugas: {{ $exam->dokter_pemeriksa ?? '-' }}</p>
                            @if($exam->diagnosa)
                                <p class="text-sm text-slate-700 mt-2">Diagnosa: {{ \Illuminate\Support\Str::limit($exam->diagnosa, 140) }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    @endif

    @if($cluster === 5)
    <div class="mt-6 admin-card overflow-hidden">
        <div class="admin-card-header" style="background: #f9fafb;">
            <h3 class="font-bold text-slate-900">Pesan Resep Masuk (Dari Dokter/Petugas Ruangan)</h3>
        </div>
        <div class="admin-card-body">
            @if($prescriptionInbox->isEmpty())
                <p class="text-sm text-slate-500">Belum ada resep masuk.</p>
            @else
                <div class="space-y-3">
                    @foreach($prescriptionInbox as $prescription)
                        <div class="border border-slate-200 rounded-lg p-3">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <p class="font-semibold text-slate-900">{{ $prescription->nomor_resep ?? 'No. Resep: -' }}</p>
                                        <span class="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded">{{ $prescription->tanggal_resep?->format('d/m/Y') ?? '-' }}</span>
                                    </div>
                                    <p class="text-sm text-slate-700 mt-1">👤 <strong>{{ $prescription->nama_dokter ?? 'Dokter: -' }}</strong></p>
                                    <p class="font-semibold text-slate-900 mt-2">💊 {{ $prescription->user?->name }} - {{ $prescription->nama_obat }}</p>
                                    <p class="text-xs text-slate-600 mt-1">Dosis: {{ $prescription->dosis ?? '-' }} | Aturan: {{ $prescription->aturan_pakai ?? '-' }}</p>
                                    @if($prescription->catatan)
                                        <p class="text-sm text-slate-700 mt-2 border-l-2 border-yellow-400 pl-2 bg-yellow-50">Catatan: {{ $prescription->catatan }}</p>
                                    @endif
                                    <p class="text-xs text-slate-500 mt-2">Status: <span class="font-semibold {{ $prescription->status === 'menunggu' ? 'text-yellow-600' : ($prescription->status === 'disiapkan' ? 'text-blue-600' : 'text-green-600') }}">{{ ucfirst($prescription->status) }}</span></p>
                                </div>
                                <form method="POST" action="{{ route('petugas.prescriptions.update-status', $prescription->id) }}" class="shrink-0">
                                    @csrf
                                    <select name="status" class="text-sm border border-slate-300 rounded px-2 py-1">
                                        <option value="menunggu" {{ $prescription->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="disiapkan" {{ $prescription->status === 'disiapkan' ? 'selected' : '' }}>Disiapkan</option>
                                        <option value="diambil" {{ $prescription->status === 'diambil' ? 'selected' : '' }}>Diambil</option>
                                    </select>
                                    <button type="submit" class="ml-2 px-3 py-1.5 rounded-md text-xs font-semibold bg-cyan-100 text-cyan-700">Update</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    @endif
    </div>
</div>
@endsection
