@extends('layouts.app')

@section('content')
<div class="py-6 sm:py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <div class="mb-6 rounded-2xl p-5 sm:p-6 text-white" style="background: linear-gradient(135deg, #0f766e, #0284c7);">
        <p class="text-xs sm:text-sm uppercase tracking-[0.2em] text-white/80">Dashboard Petugas</p>
        <h1 class="text-2xl sm:text-3xl font-extrabold mt-1">Klaster {{ $cluster }}</h1>
        <p class="mt-2 text-white/90 text-sm">Pantau antrian, keluhan pasien, dan proses layanan klaster.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700 text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700 text-sm">{{ session('error') }}</div>
    @endif
    @if(session('info'))
        <div class="mb-4 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-blue-700 text-sm">{{ session('info') }}</div>
    @endif

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <p class="text-xs text-slate-500">Jumlah Antrian Klaster</p>
            <p class="text-2xl font-bold text-slate-900 mt-1">{{ $counts['total'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-amber-200 p-4">
            <p class="text-xs text-amber-600">Belum Scan</p>
            <p class="text-2xl font-bold text-amber-700 mt-1">{{ $counts['belum_scan'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-cyan-200 p-4">
            <p class="text-xs text-cyan-600">Menunggu</p>
            <p class="text-2xl font-bold text-cyan-700 mt-1">{{ $counts['menunggu'] }}</p>
        </div>
        <div class="bg-white rounded-xl border border-emerald-200 p-4">
            <p class="text-xs text-emerald-600">Selesai</p>
            <p class="text-2xl font-bold text-emerald-700 mt-1">{{ $counts['selesai'] }}</p>
        </div>
    </div>

    <div class="mb-6 flex flex-wrap gap-2">
        <a href="{{ route('petugas.callNext.get') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-white font-semibold" style="background: linear-gradient(135deg, #0ea5e9, #0284c7);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            Panggil Antrian Berikut
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-slate-100 bg-slate-50">
                <h3 class="font-bold text-slate-900">Antrian Menunggu Klaster {{ $cluster }}</h3>
            </div>
            <div class="p-4 sm:p-6">
                @if($waitingQueues->isEmpty())
                    <p class="text-sm text-slate-500">Belum ada antrian menunggu.</p>
                @else
                    <div class="space-y-3">
                        @foreach($waitingQueues as $queue)
                            <div class="border border-slate-200 rounded-lg p-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="font-bold text-slate-900">{{ $queue->queue_number }} - {{ $queue->patient_name }}</p>
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

        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <details class="group" open>
                <summary class="px-4 sm:px-6 py-4 bg-slate-50 cursor-pointer list-none flex items-center justify-between">
                    <h3 class="font-bold text-slate-900">Keluhan Pasien</h3>
                    <span class="text-xs font-semibold text-slate-500">Buka/Tutup</span>
                </summary>
                <div class="p-4 sm:p-6 border-t border-slate-100">
                    @if($complaints->isEmpty())
                        <p class="text-sm text-slate-500">Belum ada keluhan pasien pada klaster ini.</p>
                    @else
                        <div class="space-y-3 max-h-80 overflow-y-auto pr-1">
                            @foreach($complaints as $item)
                                <div class="border border-slate-200 rounded-lg p-3">
                                    <p class="text-sm font-semibold text-slate-900">{{ $item->queue_number }} - {{ $item->patient_name }}</p>
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

    <div class="mt-6 bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-slate-100 bg-slate-50">
            <h3 class="font-bold text-slate-900">Pasien Sedang Dipanggil (Klaster {{ $cluster }})</h3>
        </div>
        <div class="p-4 sm:p-6">
            @if($calledQueues->isEmpty())
                <p class="text-sm text-slate-500">Belum ada pasien berstatus dipanggil.</p>
            @else
                <div class="space-y-3">
                    @foreach($calledQueues as $queue)
                        <div class="border border-emerald-200 bg-emerald-50/40 rounded-lg p-3">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-bold text-slate-900">{{ $queue->queue_number }} - {{ $queue->patient_name }}</p>
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
    <div class="mt-6 bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-slate-100 bg-slate-50">
            <h3 class="font-bold text-slate-900">Riwayat Pemeriksaan Klaster {{ $cluster }}</h3>
        </div>
        <div class="p-4 sm:p-6">
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
    <div class="mt-6 bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-slate-100 bg-slate-50">
            <h3 class="font-bold text-slate-900">Pesan Resep Masuk (Dari Dokter/Petugas Ruangan)</h3>
        </div>
        <div class="p-4 sm:p-6">
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
@endsection
