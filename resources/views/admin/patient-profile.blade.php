@extends('layouts.app')

@section('content')
<div style="padding: 32px 0;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">

        <div class="admin-page-header">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div>
                    <h1 class="admin-page-title">Profil Pasien</h1>
                    <p class="admin-page-subtitle">Detail informasi pasien: {{ $user->name }}</p>
                </div>
                <a href="{{ route('admin.patients') }}" class="admin-btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="admin-card" style="border: 1px solid #86efac; background: #f0fdf4; color: #166534; padding: 12px 14px; margin-bottom: 16px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="admin-card" style="border: 1px solid #fca5a5; background: #fef2f2; color: #991b1b; padding: 12px 14px; margin-bottom: 16px;">
                {{ session('error') }}
            </div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-bottom: 28px;">
            {{-- Profile Card --}}
            <div class="admin-card" style="overflow: hidden;">
                <div style="background: linear-gradient(135deg, #059669, #10b981); padding: 32px 24px; text-align: center;">
                    @if(!empty($profile?->profile_photo_path))
                        <img
                            src="{{ asset('storage/' . $profile->profile_photo_path) }}"
                            alt="Foto profil {{ $user->name }}"
                            style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin: 0 auto 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: 2px solid rgba(255,255,255,0.7);"
                        >
                    @else
                        <div style="width: 80px; height: 80px; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                            <span style="font-size: 32px; font-weight: 800; color: #059669;">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                    @endif
                    <h2 style="font-size: 18px; font-weight: 700; color: white;">{{ $user->name }}</h2>
                    <p style="font-size: 13px; color: rgba(255,255,255,0.8); margin-top: 4px;">{{ $user->email }}</p>
                    <div style="margin-top: 12px;">
                        @if($user->status === 'approved')
                            <span class="admin-badge badge-success" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">&#10003; Terverifikasi</span>
                        @else
                            <span class="admin-badge badge-warning">&#9203; Pending</span>
                        @endif
                    </div>
                </div>
                <div style="padding: 20px 24px; display: flex; flex-direction: column; gap: 14px;">
                    <div style="display: flex; justify-content: space-between; font-size: 13px;">
                        <span style="color: #6b7280;">Terdaftar Sejak</span>
                        <span style="font-weight: 600; color: #111827;">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 13px;">
                        <span style="color: #6b7280;">Terverifikasi</span>
                        <span style="font-weight: 600; color: #111827;">{{ $user->verified_at ? $user->verified_at->format('d M Y') : '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- Profile Details --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #dcfce7, #bbf7d0);">
                        <svg class="w-5 h-5" style="color: #059669;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <h3 style="font-size: 16px; font-weight: 700; color: #111827;">Data Profil</h3>
                        <p style="font-size: 13px; color: #6b7280;">Informasi profil yang telah diisi oleh pasien</p>
                    </div>
                </div>
                <div class="admin-card-body">
                    @if($profile)
                        @php
                            $profileFields = [
                                'NIK' => $profile->nik,
                                'No. BPJS' => $profile->no_bpjs,
                                'No. HP' => $profile->no_hp,
                                'No. Telepon Rumah' => $profile->no_telepon,
                                'Tempat Lahir' => $profile->tempat_lahir,
                                'Tanggal Lahir' => $profile->tanggal_lahir ? \Carbon\Carbon::parse($profile->tanggal_lahir)->format('d M Y') : null,
                                'Jenis Kelamin' => $profile->jenis_kelamin === 'L' ? 'Laki-laki' : ($profile->jenis_kelamin === 'P' ? 'Perempuan' : null),
                                'Golongan Darah' => $profile->golongan_darah,
                                'Pekerjaan' => $profile->pekerjaan,
                                'Pendidikan' => $profile->pendidikan,
                                'Status Pernikahan' => $profile->status_pernikahan,
                                'Alamat' => $profile->alamat,
                                'RT' => $profile->rt,
                                'RW' => $profile->rw,
                                'Kelurahan/Desa' => $profile->kelurahan,
                                'Kecamatan' => $profile->kecamatan,
                                'Kota/Kabupaten' => $profile->kota,
                                'Provinsi' => $profile->provinsi,
                                'Kode Pos' => $profile->kode_pos,
                                'Nama Keluarga' => $profile->nama_keluarga,
                                'Hubungan Keluarga' => $profile->hubungan_keluarga,
                                'No. Telepon Keluarga' => $profile->no_telepon_keluarga,
                                'Riwayat Alergi' => $profile->riwayat_alergi,
                                'Riwayat Penyakit' => $profile->riwayat_penyakit,
                            ];
                        @endphp

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            @foreach($profileFields as $label => $value)
                                <div @if(in_array($label, ['Alamat', 'Riwayat Alergi', 'Riwayat Penyakit'], true)) style="grid-column: span 2;" @endif>
                                    <label style="display: block; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af; margin-bottom: 4px;">{{ $label }}</label>
                                    <p style="font-weight: 500; color: #111827;">{{ filled($value) ? $value : '-' }}</p>
                                </div>
                            @endforeach

                            <div style="grid-column: span 2; padding-top: 16px; border-top: 1px solid #f3f4f6;">
                                <p style="font-size: 12px; color: #9ca3af;">
                                    Terakhir diperbarui: {{ $profile->updated_at ? $profile->updated_at->format('d M Y H:i') : '-' }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="admin-empty-state">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p style="font-weight: 600; color: #374151;">Belum ada data profil</p>
                            <p style="color: #9ca3af; font-size: 13px;">Pasien belum mengisi data profilnya</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="admin-card" style="margin-bottom: 24px;">
            <div class="admin-card-header">
                <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #e0e7ff, #c7d2fe);">
                    <svg class="w-5 h-5" style="color: #4f46e5;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #111827;">Dokumen Pasien</h3>
                    <p style="font-size: 13px; color: #6b7280;">Foto profil dan identitas pendukung pasien</p>
                </div>
            </div>
            <div class="admin-card-body">
                @php
                    $docItems = [
                        'Foto Profil' => $profile?->profile_photo_path,
                        'Foto KTP' => $profile?->ktp_photo_path,
                        'Foto Kartu Keluarga' => $profile?->kk_photo_path,
                        'Foto Kartu BPJS' => $profile?->bpjs_photo_path,
                        'Foto Kartu RME' => $profile?->rme_card_photo_path,
                        'Identitas Pendukung Lainnya' => $profile?->supporting_identity_photo_path,
                    ];
                @endphp

                <div style="border: 1px solid #e5e7eb; border-radius: 12px; padding: 14px; margin-bottom: 16px; background: #f9fafb;">
                    <p style="font-size: 13px; font-weight: 700; color: #111827; margin-bottom: 10px;">Kelola Foto Profil Pasien</p>

                    <form action="{{ route('admin.patient.profile-photo.update', $user) }}" method="POST" enctype="multipart/form-data" style="display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 10px;">
                        @csrf
                        <input type="file" name="profile_photo" accept=".jpg,.jpeg,.png,.webp" required style="font-size: 12px;">
                        <button type="submit" class="admin-btn btn-success" style="font-size: 12px; padding: 6px 10px;">Upload / Ganti Foto</button>
                    </form>

                    @if(!empty($profile?->profile_photo_path))
                        <form action="{{ route('admin.patient.profile-photo.delete', $user) }}" method="POST" onsubmit="return confirm('Hapus foto profil pasien?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-btn btn-danger" style="font-size: 12px; padding: 6px 10px;">Hapus Foto Profil</button>
                        </form>
                    @endif

                    @error('profile_photo')
                        <p style="font-size: 12px; color: #b91c1c; margin-top: 8px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px;">
                    @foreach($docItems as $label => $path)
                        <div style="border: 1px solid #e5e7eb; border-radius: 12px; padding: 12px;">
                            <p style="font-size: 12px; font-weight: 600; color: #6b7280; margin-bottom: 8px;">{{ $label }}</p>
                            @if($path)
                                <a href="{{ asset('storage/' . $path) }}" target="_blank" class="admin-btn btn-info" style="font-size: 12px; padding: 6px 10px;">
                                    Lihat Dokumen
                                </a>
                            @else
                                <span class="admin-badge badge-gray">Belum Upload</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Queue History --}}
        <div class="admin-card" style="margin-bottom: 24px;">
            <div class="admin-card-header">
                <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe);">
                    <svg class="w-5 h-5" style="color: #2563eb;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #111827;">Riwayat Pendaftaran Antrian</h3>
                    <p style="font-size: 13px; color: #6b7280;">10 pendaftaran terakhir</p>
                </div>
            </div>
            @if($queues->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="text-align: left;">No. Antrian</th>
                                <th style="text-align: left;">Tanggal</th>
                                <th style="text-align: left;">Klaster</th>
                                <th style="text-align: left;">BPJS</th>
                                <th style="text-align: left;">Keluhan</th>
                                <th style="text-align: left;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($queues as $queue)
                                <tr>
                                    <td style="font-weight: 600;">{{ $queue->queue_number ?: 'Saat scan loket' }}</td>
                                    <td>{{ $queue->queue_date->format('d-m-Y') }}</td>
                                    <td>{{ $queue->service_type }}</td>
                                    <td>
                                        @if($queue->has_bpjs)
                                            <span class="admin-badge badge-success">Ya</span>
                                        @else
                                            <span class="admin-badge badge-gray">Tidak</span>
                                        @endif
                                    </td>
                                    <td>{{ \Illuminate\Support\Str::limit($queue->complaint, 50) ?? '-' }}</td>
                                    <td>
                                        @switch($queue->status)
                                            @case('pending')
                                                <span class="admin-badge badge-warning">Pending</span>
                                                @break
                                            @case('approved')
                                                <span class="admin-badge badge-info">Disetujui</span>
                                                @break
                                            @case('waiting')
                                                <span class="admin-badge badge-cyan">Menunggu</span>
                                                @break
                                            @case('called')
                                                <span class="admin-badge badge-purple">Dipanggil</span>
                                                @break
                                            @case('served')
                                                <span class="admin-badge badge-success">Selesai</span>
                                                @break
                                            @case('rejected')
                                                <span class="admin-badge badge-danger">Ditolak</span>
                                                @break
                                            @case('cancelled')
                                                <span class="admin-badge badge-gray">Dibatalkan</span>
                                                @break
                                            @default
                                                <span class="admin-badge badge-gray">{{ $queue->status }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="admin-empty-state">
                    <p style="color: #9ca3af; font-size: 13px;">Belum ada riwayat pendaftaran</p>
                </div>
            @endif
        </div>

        {{-- Medical Examinations --}}
        <div class="admin-card" style="margin-bottom: 24px;">
            <div class="admin-card-header">
                <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #dcfce7, #bbf7d0);">
                    <svg class="w-5 h-5" style="color: #059669;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #111827;">Riwayat Pemeriksaan</h3>
                    <p style="font-size: 13px; color: #6b7280;">10 pemeriksaan terakhir</p>
                </div>
            </div>
            @if($examinations->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="text-align: left;">Tanggal</th>
                                <th style="text-align: left;">Poli/Klaster</th>
                                <th style="text-align: left;">Keluhan</th>
                                <th style="text-align: left;">Diagnosa</th>
                                <th style="text-align: left;">Dokter</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($examinations as $exam)
                                <tr>
                                    <td>{{ $exam->tanggal_periksa->format('d-m-Y') }}</td>
                                    <td>{{ $exam->poli ?? '-' }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($exam->keluhan, 40) }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($exam->diagnosa, 40) ?? '-' }}</td>
                                    <td>{{ $exam->nama_dokter ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="admin-empty-state">
                    <p style="color: #9ca3af; font-size: 13px;">Belum ada riwayat pemeriksaan</p>
                </div>
            @endif
        </div>

        {{-- Prescriptions --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #ede9fe, #ddd6fe);">
                    <svg class="w-5 h-5" style="color: #7c3aed;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <div>
                    <h3 style="font-size: 16px; font-weight: 700; color: #111827;">Riwayat Resep Obat</h3>
                    <p style="font-size: 13px; color: #6b7280;">10 resep terakhir</p>
                </div>
            </div>
            @if($prescriptions->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="text-align: left;">No. Resep</th>
                                <th style="text-align: left;">Tanggal</th>
                                <th style="text-align: left;">Obat</th>
                                <th style="text-align: left;">Dokter</th>
                                <th style="text-align: left;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prescriptions as $prescription)
                                @php
                                    $colors = [
                                        'menunggu' => 'badge-warning',
                                        'disiapkan' => 'badge-info',
                                        'diambil' => 'badge-success',
                                    ];
                                @endphp
                                <tr>
                                    <td style="font-weight: 600;">{{ $prescription->nomor_resep ?: ('RX-' . str_pad((string) $prescription->id, 6, '0', STR_PAD_LEFT)) }}</td>
                                    <td>{{ optional($prescription->tanggal_resep)->format('d-m-Y') ?? optional($prescription->created_at)->format('d-m-Y') }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($prescription->nama_obat, 40) }}</td>
                                    <td>{{ $prescription->nama_dokter ?? $prescription->medicalExamination?->dokter_pemeriksa ?? '-' }}</td>
                                    <td>
                                        <span class="admin-badge {{ $colors[$prescription->status] ?? 'badge-gray' }}">
                                            {{ $prescription->status_label }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="admin-empty-state">
                    <p style="color: #9ca3af; font-size: 13px;">Belum ada riwayat resep obat</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
