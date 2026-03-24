@extends('layouts.app')

@section('content')
<div class="py-6 sm:py-10 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
    <div class="mb-5">
        <a href="{{ route('petugas.dashboard') }}" class="inline-flex items-center text-sm text-slate-600 hover:text-slate-900">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Dashboard Petugas
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-7">
        <h1 class="text-2xl font-extrabold text-slate-900">Input Riwayat Pemeriksaan</h1>
        <p class="text-sm text-slate-600 mt-1">Pasien: <span class="font-semibold">{{ $queue->patient_name }}</span> ({{ $queue->queue_number ?? 'Menunggu Nomor' }})</p>
        <p class="text-sm text-slate-600">Klaster/Layanan: {{ $queue->service_type }}</p>

        @if($errors->any())
            <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700 text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('petugas.examinations.store', $queue->id) }}" class="mt-5 space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Tanggal Pemeriksaan</label>
                    <input type="date" name="tanggal_periksa" value="{{ old('tanggal_periksa', now()->toDateString()) }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Dokter Pemeriksa</label>
                    <input type="text" name="dokter_pemeriksa" value="{{ old('dokter_pemeriksa', Auth::user()->name) }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                </div>
            </div>

            <div class="border-t border-slate-100 pt-4">
                <h2 class="font-bold text-slate-900 mb-4">Vital Signs (Tanda Vital)</h2>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Tekanan Darah Sistolik (mmHg)</label>
                        <input type="number" name="tekanan_darah_sistolik" value="{{ old('tekanan_darah_sistolik') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Tekanan Darah Diastolik (mmHg)</label>
                        <input type="number" name="tekanan_darah_diastolik" value="{{ old('tekanan_darah_diastolik') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Nadi (x/menit)</label>
                        <input type="number" name="nadi" value="{{ old('nadi') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Suhu (°C)</label>
                        <input type="number" step="0.1" name="suhu" value="{{ old('suhu') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Respirasi (x/menit)</label>
                        <input type="number" name="respirasi" value="{{ old('respirasi') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Berat Badan (kg)</label>
                        <input type="number" step="0.1" name="berat_badan" value="{{ old('berat_badan') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Tinggi Badan (cm)</label>
                        <input type="number" step="0.1" name="tinggi_badan" value="{{ old('tinggi_badan') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Keluhan Utama</label>
                <textarea name="keluhan_utama" rows="2" class="w-full border border-slate-300 rounded-lg px-3 py-2">{{ old('keluhan_utama', $queue->complaint) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Hasil Pemeriksaan Fisik</label>
                <textarea name="hasil_pemeriksaan_fisik" rows="2" class="w-full border border-slate-300 rounded-lg px-3 py-2">{{ old('hasil_pemeriksaan_fisik') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Diagnosa <span class="text-red-600">*</span></label>
                <textarea name="diagnosa" rows="3" required class="w-full border border-slate-300 rounded-lg px-3 py-2">{{ old('diagnosa') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Kode ICD-10</label>
                <input type="text" name="kode_icd10" value="{{ old('kode_icd10') }}" placeholder="cth: I10" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Tindakan</label>
                <textarea name="tindakan" rows="2" class="w-full border border-slate-300 rounded-lg px-3 py-2">{{ old('tindakan') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Anjuran</label>
                <textarea name="anjuran" rows="2" class="w-full border border-slate-300 rounded-lg px-3 py-2">{{ old('anjuran') }}</textarea>
            </div>

            <div class="pt-2 border-t border-slate-100">
                <h2 class="font-bold text-slate-900">Input Resep (Opsional)</h2>
                <p class="text-sm text-slate-500">Jika diisi, resep otomatis masuk ke inbox petugas klaster 5.</p>
            </div>

            @for($i = 0; $i < 3; $i++)
                <div class="rounded-xl border border-slate-200 p-4">
                    <p class="text-sm font-semibold text-slate-700 mb-3">Obat {{ $i + 1 }}</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-slate-600 mb-1">Nama Obat</label>
                            <input type="text" name="nama_obat[]" value="{{ old('nama_obat.' . $i) }}" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Jumlah</label>
                            <input type="text" name="jumlah[]" value="{{ old('jumlah.' . $i) }}" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Dosis</label>
                            <input type="text" name="dosis[]" value="{{ old('dosis.' . $i) }}" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-slate-600 mb-1">Aturan Pakai</label>
                            <input type="text" name="aturan_pakai[]" value="{{ old('aturan_pakai.' . $i) }}" class="w-full border border-slate-300 rounded-lg px-3 py-2" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-slate-600 mb-1">Catatan</label>
                            <textarea name="catatan[]" rows="2" class="w-full border border-slate-300 rounded-lg px-3 py-2">{{ old('catatan.' . $i) }}</textarea>
                        </div>
                    </div>
                </div>
            @endfor

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2.5 rounded-lg text-white font-semibold" style="background: linear-gradient(135deg, #0f766e, #0284c7);">Simpan Pemeriksaan</button>
            </div>
        </form>
    </div>
</div>
@endsection
