@extends('layouts.app')

@section('content')
<div style="padding: 32px 0;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">

        <div class="admin-page-header">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div>
                    <h1 class="admin-page-title">Data Pasien</h1>
                    <p class="admin-page-subtitle">Kelola dan lihat profil pasien terdaftar</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="admin-btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="admin-alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="admin-alert alert-error">{{ session('error') }}</div>
        @endif

        <div class="admin-card">
            <div class="admin-card-header" style="justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #cffafe, #a5f3fc);">
                        <svg class="w-5 h-5" style="color: #0891b2;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Daftar Pasien</h2>
                        <p style="font-size: 13px; color: #6b7280;">Total: <span style="font-weight: 700; color: #059669;">{{ $patients->total() }}</span> pasien
                            @if($search) (hasil pencarian: "{{ $search }}") @endif
                        </p>
                    </div>
                </div>
                <form method="GET" action="{{ route('admin.patients') }}" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <div style="position: relative;">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama, email, NIK, atau No. HP..." class="admin-search" style="width: 300px;">
                        <svg style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <button type="submit" class="admin-btn btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Cari
                    </button>
                    @if($search)
                        <a href="{{ route('admin.patients') }}" class="admin-btn btn-secondary">Reset</a>
                    @endif
                </form>
            </div>

            @if($patients->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="text-align: left;">No</th>
                                <th style="text-align: left;">Nama</th>
                                <th style="text-align: left;">Email</th>
                                <th style="text-align: left;">NIK</th>
                                <th style="text-align: left;">No. HP</th>
                                <th style="text-align: left;">Status</th>
                                <th style="text-align: left;">Tgl Daftar</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patients as $index => $patient)
                                <tr>
                                    <td>{{ ($patients->currentPage() - 1) * $patients->perPage() + $index + 1 }}</td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #dcfce7, #bbf7d0); display: flex; align-items: center; justify-content: center; font-weight: 700; color: #059669; font-size: 14px;">
                                                {{ strtoupper(substr($patient->name, 0, 1)) }}
                                            </div>
                                            <span style="font-weight: 600; color: #111827;">{{ $patient->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $patient->email }}</td>
                                    <td>{{ $patient->profile->nik ?? '-' }}</td>
                                    <td>{{ $patient->profile->no_hp ?? '-' }}</td>
                                    <td>
                                        @if($patient->status === 'approved')
                                            <span class="admin-badge badge-success">Disetujui</span>
                                        @else
                                            <span class="admin-badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $patient->created_at->format('d-m-Y') }}</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('admin.patient.profile', $patient) }}" class="admin-btn btn-info" style="font-size: 12px; padding: 6px 12px;">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Profil
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div style="padding: 16px 20px;">
                    {{ $patients->links() }}
                </div>
            @else
                <div class="admin-empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <p style="font-weight: 600; color: #374151;">Tidak ada data pasien</p>
                    <p style="color: #9ca3af; font-size: 13px;">
                        @if($search)
                            Tidak ditemukan pasien dengan kata kunci "{{ $search }}"
                        @else
                            Belum ada pasien yang terdaftar
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
