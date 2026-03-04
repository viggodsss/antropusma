@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-8">Dashboard Admin</h1>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
        @endif

        <div class="mb-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Scan QR Loket (Kamera Laptop)</h2>
                <p class="text-sm text-gray-600 mt-1">Klik mulai, arahkan QR pasien ke kamera, sistem akan otomatis memproses token.</p>
            </div>
            <div class="px-6 py-4">
                <div id="qr-reader" class="w-full max-w-md mx-auto"></div>
                <p id="scan-status" class="text-sm text-gray-600 mt-3 text-center">Kamera belum dijalankan.</p>
                <div class="flex justify-center gap-3 mt-4">
                    <button type="button" id="start-scan" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Mulai Scan</button>
                    <button type="button" id="stop-scan" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Stop</button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Jumlah Akun User</h3>
                    <p class="text-2xl font-semibold text-indigo-600">{{ $userStats['total_users'] }}</p>
                    <p class="text-sm text-gray-600 mt-2">Admin: {{ $userStats['total_admins'] }} • Pasien: {{ $userStats['total_patients'] }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-blue-50 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Antrian Hari Ini</h3>
                    <p class="text-2xl font-semibold text-blue-600">{{ $todayQueueCount }}</p>
                    <p class="text-sm text-gray-600 mt-2">Total pendaftar tanggal {{ now()->format('d-m-Y') }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-green-50 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Status Akun Pasien</h3>
                    <p class="text-sm text-gray-700 mt-1">Disetujui: <span class="font-semibold text-green-600">{{ $userStats['approved_patients'] }}</span></p>
                    <p class="text-sm text-gray-700 mt-1">Pending: <span class="font-semibold text-yellow-600">{{ $userStats['pending_patients'] }}</span></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-purple-50 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Jumlah Klaster Tujuan Hari Ini</h2>
                </div>
                <div class="px-6 py-4">
                    @if($clusterSummary->count() > 0)
                        <table class="w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-900">Klaster</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-900">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clusterSummary as $cluster)
                                    <tr class="border-b">
                                        <td class="px-4 py-3">{{ $cluster->service_type }}</td>
                                        <td class="px-4 py-3 font-semibold">{{ $cluster->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-600">Belum ada data klaster untuk hari ini.</p>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-rose-50 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Keluhan Pasien Hari Ini</h2>
                </div>
                <div class="px-6 py-4">
                    @if($todayComplaints->count() > 0)
                        <div class="space-y-3 max-h-80 overflow-auto">
                            @foreach($todayComplaints as $item)
                                <div class="border rounded p-3">
                                    <p class="text-sm font-semibold text-gray-800">{{ $item->queue_number }} • {{ $item->patient_name }} ({{ $item->service_type }})</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $item->complaint }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $item->created_at->format('H:i') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">Belum ada keluhan yang diisi hari ini.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="mb-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-cyan-50 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">Data Akun Pengguna / Pasien</h2>
                    <p class="text-sm text-gray-600 mt-1">Admin dapat memantau biodata akun pasien yang terdaftar.</p>
                </div>

                @if($patientAccounts->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Nama</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Tanggal Daftar</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Terverifikasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($patientAccounts as $account)
                                    <tr class="border-b">
                                        <td class="px-6 py-4">{{ $account->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $account->email }}</td>
                                        <td class="px-6 py-4">
                                            @if($account->status === 'approved')
                                                <span class="text-xs font-semibold px-2 py-1 bg-green-100 text-green-700 rounded">Disetujui</span>
                                            @else
                                                <span class="text-xs font-semibold px-2 py-1 bg-yellow-100 text-yellow-700 rounded">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ optional($account->created_at)->format('d-m-Y H:i') ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ optional($account->verified_at)->format('d-m-Y H:i') ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-4 text-gray-600">
                        Belum ada akun pasien terdaftar.
                    </div>
                @endif
            </div>
        </div>

        <!-- Pending User Verification Section -->
        <div class="mb-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-yellow-50 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900">⏳ Verifikasi Pendaftaran Pasien</h2>
                    <p class="text-sm text-gray-600 mt-1">Total pending: <span class="font-semibold">{{ $pendingUsers->count() }}</span></p>
                </div>

                @if($pendingUsers->count() > 0)
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Nama</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Terdaftar</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 w-48">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingUsers as $user)
                                <tr class="border-b">
                                    <td class="px-6 py-4">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                                        <form method="POST" action="{{ route('admin.approve-user', $user) }}">
                                            @csrf
                                            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">Setujui</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.reject-user', $user) }}" onsubmit="return confirm('Yakin ingin menolak?');">
                                            @csrf
                                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">Tolak</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="px-6 py-4 text-gray-600">
                        ✅ Tidak ada pendaftaran yang menunggu verifikasi.
                    </div>
                @endif
            </div>
        </div>

        <!-- Queue Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-blue-50 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Antrian Menunggu</h3>
                    <p class="text-2xl font-semibold text-blue-600">{{ $waiting->count() }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 bg-green-50 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Antrian Selesai</h3>
                    <p class="text-2xl font-semibold text-green-600">{{ $served->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-6 py-4">
                <form method="POST" action="{{ route('admin.callNext') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Panggil Antrian Berikutnya</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    const qrReaderId = 'qr-reader';
    const statusEl = document.getElementById('scan-status');
    const startBtn = document.getElementById('start-scan');
    const stopBtn = document.getElementById('stop-scan');

    let html5Qrcode = null;
    let scannerRunning = false;

    const setStatus = (text, isError = false) => {
        statusEl.textContent = text;
        statusEl.className = isError ? 'text-sm text-red-600 mt-3 text-center' : 'text-sm text-gray-600 mt-3 text-center';
    };

    const isValidScanUrl = (text) => {
        try {
            const scanned = new URL(text);
            const expectedPath = /^\/admin\/scan\/\d+$/;
            return scanned.origin === window.location.origin && expectedPath.test(scanned.pathname) && scanned.searchParams.has('token');
        } catch (e) {
            return false;
        }
    };

    const onScanSuccess = (decodedText) => {
        if (!isValidScanUrl(decodedText)) {
            setStatus('QR tidak valid untuk loket admin.', true);
            return;
        }

        setStatus('QR valid terdeteksi. Memproses...');
        window.location.href = decodedText;
    };

    const startScanner = async () => {
        if (scannerRunning) {
            return;
        }

        try {
            html5Qrcode = new Html5Qrcode(qrReaderId);
            await html5Qrcode.start(
                { facingMode: 'environment' },
                { fps: 10, qrbox: { width: 220, height: 220 } },
                onScanSuccess
            );
            scannerRunning = true;
            setStatus('Kamera aktif. Arahkan QR ke kotak scan.');
        } catch (error) {
            setStatus('Gagal mengakses kamera. Izinkan akses kamera di browser.', true);
        }
    };

    const stopScanner = async () => {
        if (!scannerRunning || !html5Qrcode) {
            setStatus('Scanner sudah berhenti.');
            return;
        }

        try {
            await html5Qrcode.stop();
            await html5Qrcode.clear();
            scannerRunning = false;
            html5Qrcode = null;
            setStatus('Scanner dihentikan.');
        } catch (error) {
            setStatus('Tidak bisa menghentikan scanner.', true);
        }
    };

    startBtn.addEventListener('click', startScanner);
    stopBtn.addEventListener('click', stopScanner);
</script>
@endsection
