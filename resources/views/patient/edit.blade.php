@extends('layouts.app')

@section('content')
<h2>Edit Pasien</h2>

<form action="{{ route('patients.update', $patient->id) }}" method="POST">
    @csrf
    @method('PUT')
    <label>Nama:</label>
    <input type="text" name="name" value="{{ $patient->name }}" required><br><br>

    <label>Telepon:</label>
    <input type="text" name="phone" value="{{ $patient->phone }}" required><br><br>

    <button type="submit">Update</button>
</form>

<a href="{{ route('patients.index') }}">Kembali</a>
@endsection