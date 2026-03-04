@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Daftar Antrian</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('queue.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700">Nama Lengkap</label>
                <input type="text" name="patient_name" class="w-full border rounded px-3 py-2" value="{{ old('patient_name') }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">NIK</label>
                <input type="text" name="nik" maxlength="16" class="w-full border rounded px-3 py-2" value="{{ old('nik') }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Keluhan</label>
                <textarea name="complaint" class="w-full border rounded px-3 py-2" rows="3">{{ old('complaint') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Klaster</label>
                <select name="service_type" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- pilih klaster --</option>
                    @foreach($klasters as $k)
                        <option value="{{ $k }}" {{ old('service_type') == $k ? 'selected' : '' }}>{{ $k }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Daftar</button>
            </div>
        </form>
    </div>
</div>
@endsection