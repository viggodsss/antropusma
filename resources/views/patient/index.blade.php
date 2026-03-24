@extends('layouts.app')

@section('content')
<h2>Daftar Pasien</h2>

<a href="{{ route('patients.create') }}">Tambah Pasien</a>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Telepon</th>
        <th>Aksi</th>
    </tr>
    @foreach($patients as $patient)
    <tr>
        <td>{{ $patient->id }}</td>
        <td>{{ $patient->name }}</td>
        <td>{{ $patient->phone }}</td>
        <td>
            <a href="{{ route('patients.edit', $patient->id) }}">Edit</a>
            <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Hapus pasien ini?')">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection