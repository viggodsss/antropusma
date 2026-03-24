@extends('layouts.app')

@section('content')
<div class="dashboard-shell" style="padding: 32px 0;">
    <div style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
        @php
            $activeSection = $activeSection ?? 'dashboard';
            $dashboardBundleSections = ['dashboard', 'persetujuan-antrian', 'menunggu-scan', 'ringkasan-antrian'];
            $showDashboard = in_array($activeSection, $dashboardBundleSections, true);
            $showScanQr = $showDashboard;
            $showLaporan = $activeSection === 'laporan-antrian';
            $showStatistik = $activeSection === 'statistik-ringkas';
            $showKlaster = $activeSection === 'klaster-keluhan';
            $showAkun = $activeSection === 'akun-pasien';
            $showVerifikasi = false;
            $showPersetujuan = in_array($activeSection, $dashboardBundleSections, true);
            $showMenungguScan = in_array($activeSection, $dashboardBundleSections, true);
            $showRingkasan = in_array($activeSection, $dashboardBundleSections, true);
        @endphp

        @if($showDashboard)
        <div class="admin-page-header reveal" style="margin-bottom: 28px;">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div>
                    <p style="font-size: 11px; font-weight: 800; letter-spacing: 0.28em; text-transform: uppercase; color: #158f77; margin-bottom: 10px;">Command Center Puskesmas</p>
                    <h1 class="admin-page-title">Selamat Datang, {{ auth()->user()->name }} 👋</h1>
                    <p class="admin-page-subtitle">Ringkasan aktivitas Puskesmas Mapurujaya — {{ now()->translatedFormat('l, d F Y') }}</p>
                </div>
                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                    <div class="admin-badge badge-info">Operasional Hari Ini</div>
                    <div class="admin-badge badge-success">Role: {{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>
        </div>
        @endif

        {{-- Alerts --}}
        @if(session('success'))
            <div class="admin-alert alert-success">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="admin-alert alert-error">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        @endif
        @if(session('info'))
            <div class="admin-alert alert-info">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('info') }}
            </div>
        @endif

        @if($showDashboard)
        <div class="admin-card reveal" style="margin-bottom: 20px; background: linear-gradient(135deg, rgba(255,255,255,0.96), rgba(233,246,242,0.92));">
            <div class="admin-card-body" style="display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; padding: 20px 24px;">
                <div>
                    <p style="font-size: 12px; font-weight: 700; letter-spacing: 0.4px; text-transform: uppercase; color: #6b7280; margin-bottom: 4px;">Aksi Cepat Dashboard</p>
                    <p style="font-size: 14px; color: #374151; margin: 0;">Gunakan tombol ini untuk langsung memanggil pasien berikutnya dari loket.</p>
                </div>
                <form method="POST" action="{{ route('admin.callNext') }}" style="display: inline; margin: 0;">
                    @csrf
                    <button type="submit" class="admin-btn btn-primary" style="padding: 12px 24px; font-size: 14px;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6 3 3 0 000 6z"/></svg>
                        Panggil Antrian Berikutnya
                    </button>
                </form>
            </div>
        </div>

        <div class="admin-card reveal" style="margin-bottom: 28px;">
            <div class="admin-card-header">
                <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #dcfce7, #bbf7d0);">
                    <svg class="w-5 h-5" style="color: #15803d;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div>
                    <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Pendaftaran Manual di Loket</h2>
                    <p style="font-size: 13px; color: #6b7280; margin-top: 2px;">Gunakan untuk pasien datang langsung, tidak membawa HP, atau perlu dibantu petugas. Nomor langsung diterbitkan dan masuk FIFO menunggu.</p>
                </div>
            </div>
            <div class="admin-card-body">
                @if($errors->any())
                    <div class="admin-alert alert-error" style="margin-bottom: 16px;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.queues.manual.store') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px;">
                    @csrf
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #374151; margin-bottom: 6px;">Nama Pasien</label>
                        <input type="text" name="patient_name" value="{{ old('patient_name') }}" class="admin-search" style="padding-left: 12px; width: 100%;" placeholder="Masukkan nama pasien" required>
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #374151; margin-bottom: 6px;">NIK</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" class="admin-search" style="padding-left: 12px; width: 100%;" inputmode="numeric" maxlength="16" placeholder="16 digit NIK" required>
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #374151; margin-bottom: 6px;">Layanan / Klaster</label>
                        <select name="service_type" class="admin-search" style="padding-left: 12px; width: 100%;" required>
                            <option value="">Pilih layanan</option>
                            @foreach($manualServices as $service)
                                <option value="{{ $service }}" {{ old('service_type') === $service ? 'selected' : '' }}>{{ $service }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #374151; margin-bottom: 6px;">Kepesertaan</label>
                        <label style="display: flex; align-items: center; gap: 8px; min-height: 44px; border: 1px solid #e5e7eb; border-radius: 12px; padding: 10px 12px;">
                            <input type="hidden" name="has_bpjs" value="0">
                            <input type="checkbox" name="has_bpjs" value="1" {{ old('has_bpjs') ? 'checked' : '' }}>
                            <span style="font-size: 13px; color: #374151;">Pasien menggunakan BPJS</span>
                        </label>
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #374151; margin-bottom: 6px;">Keluhan</label>
                        <textarea name="complaint" rows="3" class="admin-search" style="padding: 12px; width: 100%; min-height: 96px;">{{ old('complaint') }}</textarea>
                    </div>
                    <div style="grid-column: 1 / -1; display: flex; justify-content: flex-end;">
                        <button type="submit" class="admin-btn btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Tambahkan ke Antrian Menunggu
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        @if($showLaporan)
        <div class="admin-page-header">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div>
                    <h1 class="admin-page-title">Download Laporan Antrian</h1>
                    <p class="admin-page-subtitle">Unduh laporan admin berisi sheet Data Antrian dan Rekap Kalender.</p>
                </div>
            </div>
        </div>

        <div class="admin-card" style="margin-bottom: 28px;">
            <div class="admin-card-header" style="justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                <div>
                    <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Download Laporan Antrian (Spreadsheet)</h2>
                    <p style="font-size: 13px; color: #6b7280; margin-top: 2px;">Unduh laporan admin berisi sheet Data Antrian dan Rekap Kalender.</p>
                </div>
                <form method="GET" action="{{ route('admin.reports.queues.download') }}" style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap;">
                    <input type="date" name="start_date" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}" class="admin-search" style="padding-left: 12px; width: 170px;" />
                    <input type="date" name="end_date" value="{{ request('end_date', now()->format('Y-m-d')) }}" class="admin-search" style="padding-left: 12px; width: 170px;" />
                    <button type="submit" class="admin-btn btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M5 20h14a2 2 0 002-2v-2a2 2 0 00-2-2h-3M5 20a2 2 0 01-2-2v-2a2 2 0 012-2h3m0 0V4a2 2 0 012-2h4a2 2 0 012 2v10"/></svg>
                        Download XLSX
                    </button>
                </form>
            </div>
        </div>
        @endif

        @if($showScanQr)
        {{-- Scan QR Section --}}
        <div id="scan-qr" class="admin-card" style="margin-bottom: 28px;">
            <div class="admin-card-header">
                <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe);">
                    <svg class="w-5 h-5" style="color: #2563eb;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                </div>
                <div>
                    <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Scan QR Loket</h2>
                    <p style="font-size: 13px; color: #6b7280; margin-top: 2px;">Pilih mode scan: Barcode Scanner HID atau Kamera HP/Laptop.</p>
                </div>
            </div>
            <div class="admin-card-body" style="text-align: center;">
                <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
                    <button type="button" id="mode-hid" class="admin-btn btn-primary">Barcode Scanner HID</button>
                    <button type="button" id="mode-camera" class="admin-btn btn-secondary">Kamera HP/Laptop</button>
                </div>

                <div id="camera-panel" style="display: none; margin-top: 14px;">
                    <div id="qr-reader" style="width: 100%; max-width: 280px; margin: 0 auto; border-radius: 16px; overflow: hidden; border: 2px solid #e5e7eb;"></div>
                </div>

                <p id="scan-status" style="font-size: 13px; color: #6b7280; margin-top: 12px;">⌨️ Mode Barcode Scanner HID aktif. Silakan scan tiket pasien.</p>
                <div id="camera-actions" style="display: none; justify-content: center; gap: 10px; margin-top: 16px; flex-wrap: wrap;">
                    <button type="button" id="start-scan" class="admin-btn btn-primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Mulai Scan
                    </button>
                    <button type="button" id="stop-scan" class="admin-btn btn-secondary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/></svg>
                        Stop
                    </button>
                    <button type="button" id="upload-qr" class="admin-btn btn-info">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Upload Gambar QR
                    </button>
                </div>
                <div id="hid-panel" style="margin-top: 14px; display: grid; gap: 8px; justify-items: center;">
                    <p style="font-size: 12px; color: #4b5563; margin: 0;">Mode Scanner USB HID: klik kolom lalu scan QR/barcode dari perangkat USB.</p>
                    <input type="text" id="hid-scan-input" autocomplete="off" placeholder="Klik di sini lalu scan dengan barcode scanner USB" style="width: 100%; max-width: 380px; border: 1px solid #d1d5db; border-radius: 10px; padding: 10px 12px; font-size: 13px; color: #111827;">
                </div>
                <input type="file" id="qr-image-input" accept="image/*" class="hidden">
            </div>
        </div>
        @endif

        @if($showStatistik)
        {{-- Statistics Cards --}}
        <div id="statistik-ringkas" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 28px;">
            <div class="admin-stat-card stat-teal">
                <div class="admin-stat-icon" style="background: #dcfce7;">
                    <svg class="w-6 h-6" style="color: #059669;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280;">Total Akun</p>
                <p style="font-size: 28px; font-weight: 800; color: #111827; margin: 4px 0;">{{ $userStats['total_users'] }}</p>
                <p style="font-size: 12px; color: #6b7280;">Admin: {{ $userStats['total_admins'] }} &bull; Pasien: {{ $userStats['total_patients'] }}</p>
            </div>

            <div class="admin-stat-card stat-blue">
                <div class="admin-stat-icon" style="background: #dbeafe;">
                    <svg class="w-6 h-6" style="color: #2563eb;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280;">Antrian Hari Ini</p>
                <p style="font-size: 28px; font-weight: 800; color: #111827; margin: 4px 0;">{{ $todayQueueCount }}</p>
                <p style="font-size: 12px; color: #6b7280;">{{ now()->format('d-m-Y') }}</p>
            </div>

            <div class="admin-stat-card stat-amber">
                <div class="admin-stat-icon" style="background: #fef3c7;">
                    <svg class="w-6 h-6" style="color: #d97706;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280;">Status Akun</p>
                <div style="display: flex; gap: 16px; margin-top: 8px;">
                    <div>
                        <p style="font-size: 20px; font-weight: 800; color: #059669;">{{ $userStats['approved_patients'] }}</p>
                        <p style="font-size: 11px; color: #6b7280;">Disetujui</p>
                    </div>
                    <div>
                        <p style="font-size: 20px; font-weight: 800; color: #d97706;">{{ $userStats['pending_patients'] }}</p>
                        <p style="font-size: 11px; color: #6b7280;">Pending</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($showRingkasan)
        {{-- Queue Summary Row --}}
        <div id="ringkasan-antrian" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 28px;">
            <div class="admin-stat-card stat-cyan">
                <div class="admin-stat-icon" style="background: #cffafe;">
                    <svg class="w-6 h-6" style="color: #0891b2;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </div>
                <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280;">Belum Scan</p>
                <p style="font-size: 28px; font-weight: 800; color: #111827; margin: 4px 0;">{{ $approvedQueues->count() }}</p>
                <p style="font-size: 12px; color: #6b7280;">Menunggu scan QR</p>
            </div>
            <div class="admin-stat-card stat-blue">
                <div class="admin-stat-icon" style="background: #dbeafe;">
                    <svg class="w-6 h-6" style="color: #2563eb;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280;">Menunggu</p>
                <p style="font-size: 28px; font-weight: 800; color: #111827; margin: 4px 0;">{{ $waiting->count() }}</p>
                <p style="font-size: 12px; color: #6b7280;">Menunggu dipanggil</p>
            </div>
            <div class="admin-stat-card stat-teal">
                <div class="admin-stat-icon" style="background: #dcfce7;">
                    <svg class="w-6 h-6" style="color: #059669;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280;">Selesai</p>
                <p style="font-size: 28px; font-weight: 800; color: #111827; margin: 4px 0;">{{ $served->count() }}</p>
                <p style="font-size: 12px; color: #6b7280;">Sudah dilayani hari ini</p>
            </div>
            <div class="admin-stat-card stat-green">
                <div class="admin-stat-icon" style="background: #bbf7d0;">
                    <svg class="w-6 h-6" style="color: #15803d;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"/></svg>
                </div>
                <p style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; color: #6b7280;">Total Selesai</p>
                <p style="font-size: 28px; font-weight: 800; color: #111827; margin: 4px 0;">{{ $servedAllCount }}</p>
                <p style="font-size: 12px; color: #6b7280;">Akumulasi semua hari</p>
            </div>
        </div>

        {{-- Daftar Antrian Menunggu --}}
        <div id="daftar-antrian-menunggu" style="margin-bottom: 28px;">
            <div class="admin-card">
                <div class="admin-card-header" style="justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe);">
                            <svg class="w-5 h-5" style="color: #2563eb;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Daftar Antrian Menunggu (Nama + Nomor)</h2>
                            <p style="font-size: 13px; color: #6b7280;">Total: <span style="font-weight: 700; color: #2563eb;">{{ $waiting->count() }}</span> pasien menunggu</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.waiting') }}" class="admin-btn btn-info">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        Lihat Halaman Antrian Menunggu
                    </a>
                </div>

                @if($waiting->count() > 0)
                    <div style="max-height: 360px; overflow: auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th style="text-align: left;">No. Antrian</th>
                                    <th style="text-align: left;">Nama Pasien</th>
                                    <th style="text-align: left;">Layanan</th>
                                    <th style="text-align: left;">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($waiting as $queue)
                                    <tr>
                                        <td><span style="font-weight: 700; color: #2563eb;">{{ $queue->queue_number }}</span></td>
                                        <td style="font-weight: 600; color: #1f2937;">{{ $queue->patient_name }}</td>
                                        <td>{{ $queue->service_type }}</td>
                                        <td>{{ optional($queue->token_scanned_at ?? $queue->created_at)->format('H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="admin-empty-state">
                        <p style="color: #9ca3af; font-size: 13px;">Tidak ada antrian menunggu saat ini.</p>
                    </div>
                @endif
            </div>
        </div>
        @endif

        @if($showKlaster)
        {{-- Klaster & Keluhan --}}
        <div id="klaster-keluhan" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px;">
            <div class="admin-card" style="grid-column: span 1;">
                <div class="admin-card-header">
                    <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #ede9fe, #ddd6fe);">
                        <svg class="w-5 h-5" style="color: #7c3aed;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <div>
                        <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Klaster Tujuan Hari Ini</h2>
                    </div>
                </div>
                <div class="admin-card-body" style="padding: 0;">
                    @if($clusterSummary->count() > 0)
                        <table class="admin-table">
                            <thead><tr><th style="text-align: left;">Klaster</th><th style="text-align: left;">Jumlah</th></tr></thead>
                            <tbody>
                                @foreach($clusterSummary as $cluster)
                                    <tr>
                                        <td style="font-weight: 500;">{{ $cluster->service_type }}</td>
                                        <td><span class="admin-badge badge-info">{{ $cluster->total }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="admin-empty-state" style="padding: 32px;">
                            <p style="color: #9ca3af; font-size: 13px;">Belum ada data klaster hari ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="admin-card" style="grid-column: span 1;">
                <div class="admin-card-header">
                    <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #fee2e2, #fecaca);">
                        <svg class="w-5 h-5" style="color: #dc2626;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    </div>
                    <div>
                        <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Keluhan Pasien Hari Ini</h2>
                    </div>
                </div>
                <div class="admin-card-body">
                    @if($todayComplaints->count() > 0)
                        <div style="max-height: 320px; overflow-y: auto; display: flex; flex-direction: column; gap: 10px;">
                            @foreach($todayComplaints as $item)
                                <div class="complaint-card">
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                                        <span class="admin-badge badge-info">{{ $item->queue_number ?: 'Belum scan' }}</span>
                                        <span style="font-size: 13px; font-weight: 600; color: #374151;">{{ $item->patient_name }}</span>
                                        <span class="admin-badge badge-purple">{{ $item->service_type }}</span>
                                    </div>
                                    <p style="font-size: 13px; color: #6b7280;">{{ $item->complaint }}</p>
                                    <p style="font-size: 11px; color: #9ca3af; margin-top: 4px;">{{ $item->created_at->format('H:i') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="admin-empty-state" style="padding: 32px;">
                            <p style="color: #9ca3af; font-size: 13px;">Belum ada keluhan hari ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        @if($showAkun)
        {{-- Data Akun Pasien --}}
        <div id="akun-pasien" style="margin-bottom: 28px;" x-data="{ search: '' }">
            <div class="admin-card">
                <div class="admin-card-header" style="justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #cffafe, #a5f3fc);">
                            <svg class="w-5 h-5" style="color: #0891b2;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Data Akun Pasien</h2>
                            <p style="font-size: 13px; color: #6b7280;">Pantau biodata akun pasien terdaftar</p>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="position: relative;">
                            <input type="text" x-model="search" placeholder="Cari nama pasien..." class="admin-search" style="width: 240px;">
                            <svg style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #9ca3af;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <a href="{{ route('admin.patients') }}" class="admin-btn btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            Lihat Semua
                        </a>
                    </div>
                </div>

                @if($patientAccounts->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th style="text-align: left;">Nama</th>
                                    <th style="text-align: left;">Email</th>
                                    <th style="text-align: left;">Status</th>
                                    <th style="text-align: left;">Tgl Daftar</th>
                                    <th style="text-align: left;">Terverifikasi</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patientAccounts as $account)
                                    <tr x-show="search === '' || '{{ strtolower($account->name) }}'.includes(search.toLowerCase())">
                                        <td style="font-weight: 600;">{{ $account->name }}</td>
                                        <td>{{ $account->email }}</td>
                                        <td>
                                            @if($account->status === 'approved')
                                                <span class="admin-badge badge-success">Disetujui</span>
                                            @else
                                                <span class="admin-badge badge-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>{{ optional($account->created_at)->format('d-m-Y H:i') ?? '-' }}</td>
                                        <td>{{ optional($account->verified_at)->format('d-m-Y H:i') ?? '-' }}</td>
                                        <td style="text-align: center;">
                                            <a href="{{ route('admin.patient.profile', $account) }}" class="admin-btn btn-info" style="font-size: 12px; padding: 6px 12px;">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                Profil
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="admin-empty-state">
                        <p style="color: #9ca3af; font-size: 13px;">Belum ada akun pasien terdaftar.</p>
                    </div>
                @endif
            </div>
        </div>
        @endif

        @if($showVerifikasi)
        {{-- Verifikasi Pendaftaran Pasien --}}
        <div id="verifikasi-pasien" style="margin-bottom: 28px;">
            <div class="admin-card">
                <div class="admin-card-header">
                    <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #fef3c7, #fde68a);">
                        <svg class="w-5 h-5" style="color: #d97706;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Verifikasi Pendaftaran Pasien</h2>
                        <p style="font-size: 13px; color: #6b7280;">Total pending: <span style="font-weight: 700; color: #d97706;">{{ $pendingUsers->count() }}</span></p>
                    </div>
                </div>

                @if($pendingUsers->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th style="text-align: left;">Nama</th>
                                    <th style="text-align: left;">Email</th>
                                    <th style="text-align: left;">Terdaftar</th>
                                    <th style="text-align: left; width: 180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingUsers as $user)
                                    <tr>
                                        <td style="font-weight: 600;">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->format('d-m-Y H:i') }}</td>
                                        <td style="white-space: nowrap;">
                                            <div style="display: flex; gap: 6px;">
                                                <form method="POST" action="{{ route('admin.approve-user', $user) }}">
                                                    @csrf
                                                    <button type="submit" class="admin-btn btn-primary" style="font-size: 12px; padding: 6px 14px;">Setujui</button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.reject-user', $user) }}" onsubmit="return confirm('Yakin ingin menolak?');">
                                                    @csrf
                                                    <button type="submit" class="admin-btn btn-danger" style="font-size: 12px; padding: 6px 14px;">Tolak</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="admin-empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p style="color: #059669; font-weight: 600; font-size: 13px;">Tidak ada pendaftaran yang menunggu verifikasi.</p>
                    </div>
                @endif
            </div>
        </div>
        @endif

        @if($showPersetujuan)
        {{-- Persetujuan Antrian --}}
        <div id="persetujuan-antrian" style="margin-bottom: 28px;">
            <div class="admin-card">
                <div class="admin-card-header">
                    <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #ffedd5, #fed7aa);">
                        <svg class="w-5 h-5" style="color: #ea580c;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <div>
                        <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Persetujuan Pengajuan Antrian</h2>
                        <p style="font-size: 13px; color: #6b7280;">Tentukan apakah pengajuan antrian pasien diperbolehkan atau ditolak.</p>
                    </div>
                </div>

                @if($pendingQueueApprovals->count() > 0)
                    <div style="overflow-x: auto;">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th style="text-align: left;">Nomor</th>
                                    <th style="text-align: left;">Nama</th>
                                    <th style="text-align: left;">NIK</th>
                                    <th style="text-align: left;">BPJS</th>
                                    <th style="text-align: left;">Klaster</th>
                                    <th style="text-align: left;">Keluhan</th>
                                    <th style="text-align: left;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingQueueApprovals as $queue)
                                    <tr>
                                        <td><span style="font-weight: 700; color: #059669;">{{ $queue->queue_number ?: 'Saat scan loket' }}</span></td>
                                        <td style="font-weight: 500;">{{ $queue->patient_name }}</td>
                                        <td>{{ $queue->nik }}</td>
                                        <td>
                                            @if($queue->has_bpjs)
                                                <span class="admin-badge badge-success">Ya</span>
                                            @else
                                                <span class="admin-badge badge-gray">Tidak</span>
                                            @endif
                                        </td>
                                        <td><span class="admin-badge badge-purple">{{ $queue->service_type }}</span></td>
                                        <td>{{ $queue->complaint ?: '-' }}</td>
                                        <td style="white-space: nowrap;">
                                            <div style="display: flex; gap: 6px;">
                                                <form method="POST" action="{{ route('admin.queues.approve', $queue) }}">
                                                    @csrf
                                                    <button type="submit" class="admin-btn btn-primary" style="font-size: 12px; padding: 6px 14px;">Setujui</button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.queues.reject', $queue) }}" onsubmit="return confirm('Yakin menolak pengajuan antrian ini?');">
                                                    @csrf
                                                    <button type="submit" class="admin-btn btn-danger" style="font-size: 12px; padding: 6px 14px;">Tolak</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="admin-empty-state">
                        <p style="color: #9ca3af; font-size: 13px;">Tidak ada pengajuan antrian yang menunggu persetujuan.</p>
                    </div>
                @endif
            </div>
        </div>
        @endif

        @if($showMenungguScan)
        {{-- Menunggu Scan --}}
        @if($approvedQueues->count() > 0)
        <div id="menunggu-scan" style="margin-bottom: 28px;">
            <div class="admin-card">
                <div class="admin-card-header">
                    <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #cffafe, #a5f3fc);">
                        <svg class="w-5 h-5" style="color: #0891b2;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Pasien Menunggu Scan QR</h2>
                        <p style="font-size: 13px; color: #6b7280;">Sudah daftar online tapi belum scan di loket. Total: <span style="font-weight: 700; color: #0891b2;">{{ $approvedQueues->count() }}</span></p>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="text-align: left;">Nomor</th>
                                <th style="text-align: left;">Nama</th>
                                <th style="text-align: left;">BPJS</th>
                                <th style="text-align: left;">Klaster</th>
                                <th style="text-align: left;">Waktu Daftar</th>
                                <th style="text-align: left;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvedQueues as $queue)
                                <tr>
                                    <td><span style="font-weight: 700; color: #0891b2;">{{ $queue->queue_number ?: 'Saat scan loket' }}</span></td>
                                    <td style="font-weight: 500;">{{ $queue->patient_name }}</td>
                                    <td>
                                        @if($queue->has_bpjs)
                                            <span class="admin-badge badge-success">Ya</span>
                                        @else
                                            <span class="admin-badge badge-gray">Tidak</span>
                                        @endif
                                    </td>
                                    <td>{{ $queue->service_type }}</td>
                                    <td>{{ $queue->created_at->format('H:i') }}</td>
                                    <td><span class="admin-badge badge-cyan">Belum Scan</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        {{-- Antrian Kadaluarsa (Belum Scan) --}}
        @if(!empty($staleApprovedQueues) && $staleApprovedQueues->count() > 0)
        <div id="stuck-loket" style="margin-bottom: 28px;">
            <div class="admin-card" style="border: 1px solid #fecaca;">
                <div class="admin-card-header">
                    <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #fee2e2, #fecaca);">
                        <svg class="w-5 h-5" style="color: #dc2626;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Antrian Kadaluarsa di Loket</h2>
                        <p style="font-size: 13px; color: #6b7280;">Pasien daftar online tetapi tidak scan sampai hari berganti. Data ini bisa dibersihkan manual.</p>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="text-align: left;">Tanggal</th>
                                <th style="text-align: left;">Nomor</th>
                                <th style="text-align: left;">Nama</th>
                                <th style="text-align: left;">Klaster</th>
                                <th style="text-align: left;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staleApprovedQueues as $queue)
                                <tr>
                                    <td>{{ optional($queue->queue_date)->format('d-m-Y') }}</td>
                                    <td><span style="font-weight: 700; color: #dc2626;">{{ $queue->queue_number ?: 'Belum scan' }}</span></td>
                                    <td style="font-weight: 500;">{{ $queue->patient_name }}</td>
                                    <td>{{ $queue->service_type }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.queues.destroy-stuck', $queue) }}" onsubmit="return confirm('Hapus antrian kadaluarsa ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-btn btn-danger" style="font-size: 12px; padding: 6px 14px;">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        @endif

    </div>
</div>

    @if($showScanQr)
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    const qrReaderId = 'qr-reader';
    const statusEl = document.getElementById('scan-status');
    const startBtn = document.getElementById('start-scan');
    const stopBtn = document.getElementById('stop-scan');
    const uploadBtn = document.getElementById('upload-qr');
    const qrImageInput = document.getElementById('qr-image-input');
    const hidScanInput = document.getElementById('hid-scan-input');
    const modeHidBtn = document.getElementById('mode-hid');
    const modeCameraBtn = document.getElementById('mode-camera');
    const cameraPanel = document.getElementById('camera-panel');
    const cameraActions = document.getElementById('camera-actions');
    const hidPanel = document.getElementById('hid-panel');
    const scanModeStorageKey = 'admin_scan_mode';

    let html5Qrcode = null;
    let scannerRunning = false;
    let isProcessing = false;
    let activeScanMode = 'hid';
    let hidBuffer = '';
    let hidBufferTimer = null;
    let lastHidKeyAt = 0;

    const isCameraApiAvailable = () => {
        return !!(navigator.mediaDevices && typeof navigator.mediaDevices.getUserMedia === 'function');
    };

    const isTrustedCameraContext = () => {
        if (window.isSecureContext) return true;
        const host = window.location.hostname;
        return host === 'localhost' || host === '127.0.0.1' || host === '::1';
    };

    const getReadableCameraError = (error) => {
        const raw = (error && error.message) ? error.message : String(error || 'Unknown error');
        const lower = raw.toLowerCase();

        if (lower.includes('not supported')) {
            return 'Browser belum mendukung streaming kamera. Gunakan Chrome/Edge terbaru dan akses via HTTPS atau localhost.';
        }
        if (lower.includes('notallowederror') || lower.includes('permission') || lower.includes('denied')) {
            return 'Izin kamera ditolak. Izinkan akses kamera di browser lalu coba lagi.';
        }
        if (lower.includes('notfounderror') || lower.includes('device not found') || lower.includes('no camera')) {
            return 'Kamera tidak ditemukan pada perangkat ini.';
        }
        if (lower.includes('notreadableerror') || lower.includes('could not start video source')) {
            return 'Kamera sedang dipakai aplikasi lain. Tutup aplikasi lain lalu coba lagi.';
        }

        return raw;
    };

    const pickBestCameraId = (cameras) => {
        if (!Array.isArray(cameras) || cameras.length === 0) return null;

        const backCam = cameras.find((cam) => {
            const label = (cam.label || '').toLowerCase();
            return label.includes('back') || label.includes('rear') || label.includes('environment');
        });

        return (backCam || cameras[0]).id;
    };

    const setStatus = (text, type = 'normal') => {
        statusEl.textContent = text;
        const classes = {
            'normal': 'text-sm text-gray-600 mt-3 text-center',
            'error': 'text-sm text-red-600 mt-3 text-center font-semibold',
            'success': 'text-sm text-green-600 mt-3 text-center font-semibold',
            'warning': 'text-sm text-yellow-600 mt-3 text-center font-semibold'
        };
        statusEl.className = classes[type] || classes['normal'];
    };

    const getReadyStatusText = () => {
        if (activeScanMode === 'hid') {
            return '⌨️ Mode Barcode Scanner HID aktif. Silakan scan tiket pasien.';
        }

        return '🔍 Mode kamera siap. Arahkan QR ke kamera atau upload gambar QR.';
    };

    const updateModeButtonState = () => {
        if (!modeHidBtn || !modeCameraBtn) return;

        if (activeScanMode === 'hid') {
            modeHidBtn.classList.remove('btn-secondary');
            modeHidBtn.classList.add('btn-primary');
            modeCameraBtn.classList.remove('btn-primary');
            modeCameraBtn.classList.add('btn-secondary');
            return;
        }

        modeCameraBtn.classList.remove('btn-secondary');
        modeCameraBtn.classList.add('btn-primary');
        modeHidBtn.classList.remove('btn-primary');
        modeHidBtn.classList.add('btn-secondary');
    };

    const extractScanPath = (text) => {
        // Extract /admin/scan/{id}?token={token} from any URL
        const match = text.match(/\/admin\/scan\/(\d+)\?token=([a-f0-9-]+)/i);
        if (match) {
            return '/admin/scan/' + match[1] + '?token=' + match[2];
        }
        return null;
    };

    const onScanSuccess = async (decodedText) => {
        if (isProcessing) return;
        
        console.log('=== QR DETECTED ===');
        console.log('Raw text:', decodedText);
        
        // Extract the path from QR URL
        const scanPath = extractScanPath(decodedText);
        
        if (!scanPath) {
            setStatus('❌ QR tidak valid. Pastikan QR dari tiket antrian.', 'error');
            console.log('Could not extract scan path from:', decodedText);
            setTimeout(() => {
                if (!isProcessing) {
                    setStatus(getReadyStatusText(), 'normal');
                }
            }, 2000);
            return;
        }

        isProcessing = true;
        
        // Build URL using current browser's origin (fixes localhost vs IP issue)
        const targetUrl = window.location.origin + scanPath;
        console.log('Target URL:', targetUrl);
        
        setStatus('✅ QR Valid! Memproses tiket...', 'success');
        
        // Stop scanner
        try {
            if (html5Qrcode && scannerRunning) {
                await html5Qrcode.stop();
                scannerRunning = false;
            }
        } catch (e) {
            console.log('Scanner stop error:', e);
        }

        // Redirect to correct host
        window.location.href = targetUrl;
    };

    const clearHidBuffer = () => {
        hidBuffer = '';
        lastHidKeyAt = 0;
        if (hidBufferTimer) {
            clearTimeout(hidBufferTimer);
            hidBufferTimer = null;
        }
        if (hidScanInput) {
            hidScanInput.value = '';
        }
    };

    const flushHidBuffer = () => {
        const payload = hidBuffer.trim();
        clearHidBuffer();

        if (!payload || payload.length < 8 || isProcessing) {
            return;
        }

        setStatus('⌨️ Data scanner USB diterima. Memproses tiket...', 'warning');
        onScanSuccess(payload);
    };

    const setupHidKeyboardScanner = () => {
        document.addEventListener('keydown', (event) => {
            if (isProcessing) return;
            if (activeScanMode !== 'hid') return;

            const activeEl = document.activeElement;
            const isTypingField = activeEl && (
                activeEl.tagName === 'INPUT' ||
                activeEl.tagName === 'TEXTAREA' ||
                activeEl.isContentEditable
            );

            // Avoid hijacking normal typing in other form fields.
            if (isTypingField && activeEl !== hidScanInput) {
                return;
            }

            if (event.key === 'Enter') {
                if (hidBuffer.length > 0) {
                    event.preventDefault();
                    flushHidBuffer();
                }
                return;
            }

            if (event.key.length !== 1) {
                return;
            }

            const now = Date.now();
            if (now - lastHidKeyAt > 250) {
                hidBuffer = '';
            }

            lastHidKeyAt = now;
            hidBuffer += event.key;

            if (hidScanInput) {
                hidScanInput.value = hidBuffer;
            }

            if (hidBufferTimer) {
                clearTimeout(hidBufferTimer);
            }

            hidBufferTimer = setTimeout(() => {
                // Many scanners send Enter as suffix; timeout fallback supports scanners without suffix.
                flushHidBuffer();
            }, 140);
        });

        if (hidScanInput) {
            hidScanInput.addEventListener('focus', () => {
                setStatus('⌨️ Scanner USB HID siap. Silakan scan tiket pasien.', 'success');
            });

            hidScanInput.addEventListener('blur', () => {
                clearHidBuffer();
            });
        }
    };

    const onScanError = (errorMessage) => {
        // Ignore errors during scanning
    };

    const scanFromImageFile = async (file) => {
        if (!file) return;

        if (typeof Html5Qrcode === 'undefined') {
            setStatus('❌ Library scanner gagal dimuat. Periksa koneksi internet lalu refresh halaman.', 'error');
            return;
        }

        setStatus('⏳ Memindai QR dari gambar...', 'warning');

        try {
            const imageScanner = new Html5Qrcode(qrReaderId);
            const decodedText = await imageScanner.scanFile(file, true);
            await onScanSuccess(decodedText);
        } catch (error) {
            console.error('Image scan error:', error);
            setStatus('❌ QR pada gambar tidak terbaca. Coba gambar lain yang lebih jelas.', 'error');
            setTimeout(() => {
                if (!isProcessing) {
                    setStatus(getReadyStatusText(), 'normal');
                }
            }, 2000);
        } finally {
            qrImageInput.value = '';
        }
    };

    const startScanner = async () => {
        if (activeScanMode !== 'camera') {
            setStatus('ℹ️ Mode aktif adalah Barcode Scanner HID. Pilih mode Kamera jika ingin scan via kamera.', 'warning');
            return;
        }

        if (scannerRunning) {
            setStatus('🔍 Scanner sudah aktif. Arahkan QR ke kamera...', 'success');
            return;
        }

        if (!isTrustedCameraContext()) {
            setStatus('❌ Kamera butuh koneksi aman. Akses lewat HTTPS atau localhost (URL sekarang: ' + window.location.protocol + '//' + window.location.hostname + ').', 'error');
            return;
        }

        if (!isCameraApiAvailable()) {
            setStatus('❌ Browser ini tidak mendukung API kamera. Gunakan Chrome/Edge/Safari versi terbaru.', 'error');
            return;
        }

        if (typeof Html5Qrcode === 'undefined') {
            setStatus('❌ Library scanner gagal dimuat. Periksa koneksi internet lalu refresh halaman.', 'error');
            return;
        }

        setStatus('⏳ Mengaktifkan kamera...', 'warning');
        isProcessing = false;

        try {
            html5Qrcode = new Html5Qrcode(qrReaderId);
            
            const config = { 
                fps: 10,
                qrbox: { width: 180, height: 180 },
                aspectRatio: 1.0,
                formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE ]
            };

            let cameraSource = { facingMode: 'environment' };
            try {
                const cameras = await Html5Qrcode.getCameras();
                const bestCameraId = pickBestCameraId(cameras);
                if (bestCameraId) {
                    cameraSource = { deviceId: { exact: bestCameraId } };
                }
            } catch (cameraListError) {
                console.log('Could not list cameras, fallback to facingMode:', cameraListError);
            }
            
            await html5Qrcode.start(
                cameraSource,
                config,
                onScanSuccess,
                onScanError
            );
            
            scannerRunning = true;
            setStatus('🔍 Kamera aktif. Arahkan QR tiket ke kotak hijau...', 'success');
            startBtn.textContent = 'Scanner Aktif';
            startBtn.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
            startBtn.classList.add('bg-green-600', 'hover:bg-green-700');
            console.log('Scanner started successfully');
        } catch (error) {
            console.error('Camera error:', error);
            setStatus('❌ Gagal akses kamera: ' + getReadableCameraError(error), 'error');
        }
    };

    const stopScanner = async (showIdleMessage = true) => {
        if (!scannerRunning || !html5Qrcode) {
            if (showIdleMessage) {
                setStatus('Scanner sudah berhenti.', 'normal');
            }
            return;
        }

        try {
            await html5Qrcode.stop();
            scannerRunning = false;
            html5Qrcode = null;
            isProcessing = false;
            if (showIdleMessage) {
                setStatus('⏹️ Scanner dihentikan.', 'normal');
            }
            startBtn.textContent = 'Mulai Scan';
            startBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
            startBtn.classList.add('bg-indigo-600', 'hover:bg-indigo-700');
        } catch (error) {
            console.error('Stop error:', error);
        }
    };

    const applyScanMode = async (mode, autoStartCamera = false) => {
        if (mode !== 'hid' && mode !== 'camera') {
            return;
        }

        activeScanMode = mode;
        try {
            localStorage.setItem(scanModeStorageKey, mode);
        } catch (storageError) {
            console.log('Unable to persist scan mode:', storageError);
        }

        updateModeButtonState();

        if (mode === 'hid') {
            await stopScanner(false);

            if (cameraPanel) {
                cameraPanel.style.display = 'none';
            }
            if (cameraActions) {
                cameraActions.style.display = 'none';
            }
            if (hidPanel) {
                hidPanel.style.display = 'grid';
            }

            clearHidBuffer();
            setStatus(getReadyStatusText(), 'success');

            if (hidScanInput) {
                hidScanInput.focus();
            }

            return;
        }

        if (cameraPanel) {
            cameraPanel.style.display = 'block';
        }
        if (cameraActions) {
            cameraActions.style.display = 'flex';
        }
        if (hidPanel) {
            hidPanel.style.display = 'none';
        }

        clearHidBuffer();

        if (autoStartCamera) {
            if (isTrustedCameraContext()) {
                await startScanner();
            } else {
                setStatus('ℹ️ Kamera browser butuh HTTPS/localhost. Gunakan Barcode Scanner HID atau Upload Gambar QR.', 'warning');
            }
        } else {
            setStatus(getReadyStatusText(), 'normal');
        }
    };

    startBtn.addEventListener('click', startScanner);
    stopBtn.addEventListener('click', () => stopScanner(true));
    uploadBtn.addEventListener('click', () => qrImageInput.click());
    modeHidBtn.addEventListener('click', async () => applyScanMode('hid', false));
    modeCameraBtn.addEventListener('click', async () => applyScanMode('camera', true));
    qrImageInput.addEventListener('change', (event) => {
        const file = event.target.files && event.target.files[0];
        scanFromImageFile(file);
    });

    // Auto-start when page loads
    document.addEventListener('DOMContentLoaded', async () => {
        setupHidKeyboardScanner();

        let savedMode = 'hid';
        try {
            const stored = localStorage.getItem(scanModeStorageKey);
            if (stored === 'camera' || stored === 'hid') {
                savedMode = stored;
            }
        } catch (storageError) {
            console.log('Unable to read saved scan mode:', storageError);
        }

        await applyScanMode(savedMode, savedMode === 'camera');
    });
</script>
@endif
@endsection
