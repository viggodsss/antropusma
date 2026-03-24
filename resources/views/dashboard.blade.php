@extends('layouts.app')

@section('content')

<h2 class="mb-4">Dashboard Admin</h2>

<div class="row">

    <div class="col-md-3">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6 class="text-muted">Total Pasien Hari Ini</h6>
                <h3>{{ $totalPatients ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6 class="text-muted">Total Antrian Hari Ini</h6>
                <h3>{{ $totalQueues ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6 class="text-muted">Menunggu</h6>
                <h3>{{ $waiting ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow border-0">
            <div class="card-body">
                <h6 class="text-muted">Selesai</h6>
                <h3>{{ $done ?? 0 }}</h3>
            </div>
        </div>
    </div>

</div>

@endsection