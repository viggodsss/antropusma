@extends('layouts.app')

@section('content')
<div class="py-6 sm:py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto grid grid-cols-1 xl:grid-cols-5 gap-5 lg:gap-8 items-start">
        <div class="xl:col-span-2 relative overflow-hidden bg-gradient-to-br from-emerald-500 to-cyan-600 text-blue rounded-2xl p-5 sm:p-7 shadow-xl">
            <div class="absolute -top-16 -right-16 w-40 h-40 rounded-full bg-white/10 blur-2xl"></div>
            <div class="absolute -bottom-16 -left-16 w-44 h-44 rounded-full bg-cyan-200/20 blur-2xl"></div>
            <div class="relative">
                <p class="text-xs sm:text-sm font-semibold tracking-[0.2em] uppercase text-blue/80">Puskesmas Mapurujaya</p>
                <h2 class="mt-2 text-2xl sm:text-3xl font-extrabold tracking-tight">Daftarkan diri anda ke Antrian</h2>
                <p class="mt-3 text-sm sm:text-base text-blue/90 leading-relaxed">
                    Isi data pasien dan pilih klaster layanan. Setelah submit, sistem akan membuat nomor antrian otomatis.
                </p>
            </div>
        </div>

        <div class="xl:col-span-3 relative overflow-hidden z-10 bg-white p-5 sm:p-8 rounded-2xl shadow-xl border border-emerald-100 before:w-28 before:h-28 before:absolute before:bg-green-400/30 before:rounded-full before:-z-10 before:blur-2xl before:-top-10 before:-left-10 after:w-36 after:h-36 after:absolute after:bg-sky-400/20 after:rounded-full after:-z-10 after:blur-2xl after:top-28 after:-right-16">
            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('queue.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1" for="patient_name">Nama Lengkap</label>
                        <input id="patient_name" name="patient_name" type="text" value="{{ old('patient_name') }}" required class="mt-1 p-2.5 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1" for="nik">NIK</label>
                        <input id="nik" name="nik" type="text" maxlength="16" value="{{ old('nik') }}" required class="mt-1 p-2.5 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1" for="complaint">Keluhan</label>
                    <textarea id="complaint" name="complaint" rows="3" class="mt-1 p-2.5 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('complaint') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1" for="service_type">Klaster</label>
                    <select id="service_type" name="service_type" required class="mt-1 p-2.5 w-full border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">-- pilih klaster --</option>
                        @foreach($clusterGroups as $groupName => $services)
                            <optgroup label="{{ $groupName }}">
                                @foreach($services as $service)
                                    <option value="{{ $service }}" {{ (old('service_type', $selectedService) == $service) ? 'selected' : '' }}>
                                        {{ $service }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center space-x-3 pt-2">
                    <input id="has_bpjs" name="has_bpjs" type="checkbox" value="1" {{ old('has_bpjs') ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-2 focus:ring-emerald-500 cursor-pointer" />
                    <label for="has_bpjs" class="text-sm font-medium text-gray-700 cursor-pointer">Saya memiliki BPJS Kesehatan</label>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="w-full sm:w-auto text-white px-5 py-2.5 font-bold rounded-lg hover:opacity-90 transition-all" style="background: linear-gradient(144deg,#14b8a6,#0284c7 50%,#0ea5e9);">
                        DAFTAR
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
