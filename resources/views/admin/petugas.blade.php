@extends('layouts.app')

@section('content')
<div style="padding: 32px 0;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
        <div class="admin-page-header">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div>
                    <h1 class="admin-page-title">Kelola Akun Petugas</h1>
                    <p class="admin-page-subtitle">Buat/edit akun petugas per klaster tanpa update database manual</p>
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

        <div class="admin-card" style="margin-bottom: 20px;">
            <div class="admin-card-header">
                <div>
                    <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Tambah Petugas Baru</h2>
                    <p style="font-size: 13px; color: #6b7280;">Role otomatis diset menjadi petugas</p>
                </div>
            </div>
            <div class="admin-card-body">
                <form method="POST" action="{{ route('admin.petugas.store') }}" style="display: grid; grid-template-columns: repeat(auto-fit,minmax(220px,1fr)); gap: 14px; align-items: end;">
                    @csrf
                    <div>
                        <label style="display:block; font-size:12px; color:#6b7280; margin-bottom:6px;">Nama</label>
                        <input type="text" name="name" required class="admin-search" style="width:100%;" placeholder="Nama petugas">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; color:#6b7280; margin-bottom:6px;">Email</label>
                        <input type="email" name="email" required class="admin-search" style="width:100%;" placeholder="Email login">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; color:#6b7280; margin-bottom:6px;">Password</label>
                        <input type="password" name="password" required class="admin-search" style="width:100%;" placeholder="Minimal 6 karakter">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; color:#6b7280; margin-bottom:6px;">Klaster</label>
                        <select name="cluster_number" required class="admin-search" style="width:100%;">
                            <option value="">Pilih Klaster</option>
                            <option value="1">Klaster 1</option>
                            <option value="2">Klaster 2</option>
                            <option value="3">Klaster 3</option>
                            <option value="4">Klaster 4</option>
                            <option value="5">Klaster 5</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; color:#6b7280; margin-bottom:6px;">Status</label>
                        <select name="status" required class="admin-search" style="width:100%;">
                            <option value="approved">Approved</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="admin-btn btn-primary" style="width:100%;">Simpan Petugas</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card-header" style="justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div>
                    <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Daftar Petugas</h2>
                    <p style="font-size: 13px; color: #6b7280;">Total: <span style="font-weight:700; color:#059669;">{{ $petugas->total() }}</span> petugas</p>
                </div>
                <form method="GET" action="{{ route('admin.petugas') }}" style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama/email petugas" class="admin-search" style="width:280px;">
                    <select name="cluster" class="admin-search" style="width:140px;">
                        <option value="">Semua Klaster</option>
                        @for($i=1; $i<=5; $i++)
                            <option value="{{ $i }}" {{ (string) ($selectedCluster ?? '') === (string) $i ? 'selected' : '' }}>Klaster {{ $i }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="admin-btn btn-primary">Cari</button>
                    @if($search || !empty($selectedCluster))
                        <a href="{{ route('admin.petugas') }}" class="admin-btn btn-secondary">Reset</a>
                    @endif
                </form>
            </div>

            @if($petugas->count() > 0)
                <div style="overflow-x:auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Klaster</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($petugas as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td><span class="admin-badge badge-info">{{ ucfirst($item->role) }}</span></td>
                                    <td><span class="admin-badge badge-purple">Klaster {{ $item->cluster_number ?? '-' }}</span></td>
                                    <td>
                                        @if($item->status === 'approved')
                                            <span class="admin-badge badge-success">Approved</span>
                                        @else
                                            <span class="admin-badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="display: flex; flex-direction: column; gap: 8px;">
                                            <form method="POST" action="{{ route('admin.petugas.update', $item) }}" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="name" value="{{ $item->name }}" class="admin-search" style="width:140px;">
                                                <input type="email" name="email" value="{{ $item->email }}" class="admin-search" style="width:180px;">
                                                <select name="cluster_number" class="admin-search" style="width:120px;">
                                                    @for($i=1; $i<=5; $i++)
                                                        <option value="{{ $i }}" {{ (int) $item->cluster_number === $i ? 'selected' : '' }}>Klaster {{ $i }}</option>
                                                    @endfor
                                                </select>
                                                <select name="status" class="admin-search" style="width:110px;">
                                                    <option value="approved" {{ $item->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="pending" {{ $item->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                </select>
                                                <input type="password" name="password" class="admin-search" style="width:170px;" placeholder="Password baru (opsional)">
                                                <button type="submit" class="admin-btn btn-info" style="font-size:12px; padding: 7px 12px;">Update</button>
                                            </form>

                                            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                                <form method="POST" action="{{ route('admin.petugas.deactivate', $item) }}" onsubmit="return confirm('Nonaktifkan akun petugas ini?')">
                                                    @csrf
                                                    <button type="submit" class="admin-btn btn-warning" style="font-size:12px; padding: 6px 10px;">Nonaktifkan</button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.petugas.destroy', $item) }}" onsubmit="return confirm('Hapus akun petugas ini permanen?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="admin-btn btn-danger" style="font-size:12px; padding: 6px 10px;">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="padding: 16px 20px;">
                    {{ $petugas->links() }}
                </div>
            @else
                <div class="admin-empty-state">
                    <p style="font-weight: 600; color: #374151;">Belum ada akun petugas</p>
                    <p style="color: #9ca3af; font-size: 13px;">Silakan tambah akun petugas untuk klaster 1-5</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
