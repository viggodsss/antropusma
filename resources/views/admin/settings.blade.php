@extends('layouts.app')

@section('content')
<div style="padding: 32px 0;">
    <div style="max-width: 900px; margin: 0 auto; padding: 0 24px;">

        <div class="admin-page-header">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div>
                    <h1 class="admin-page-title">Pengaturan Display</h1>
                    <p class="admin-page-subtitle">Kelola video offline untuk tampilan display antrian (maksimal 5 slot)</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="admin-btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="admin-alert alert-success">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="admin-alert alert-error">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/></svg>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="admin-alert alert-error">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01"/></svg>
                <div>
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="admin-card">
            <div class="admin-card-header">
                <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #fee2e2, #fecaca);">
                    <svg class="w-5 h-5" style="color: #dc2626;" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                </div>
                <div>
                    <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Video Offline Display (5 Slot)</h2>
                    <p style="font-size: 13px; color: #6b7280;">Video akan diputar urut 1,2,3,4,5 lalu kembali ke 1.</p>
                </div>
            </div>

            @php
                $slotOrderValue = $videoOrder ?? [1, 2, 3, 4, 5];
            @endphp

            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="admin-card-body" style="padding: 24px;">
                @csrf
                <input type="hidden" name="slot_order" id="slot-order-input" value='@json($slotOrderValue)'>

                <p style="font-size: 12px; color: #6b7280; margin-bottom: 10px;">Drag & drop kartu slot untuk mengubah urutan putar tanpa reupload.</p>
                <div id="slot-list" style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 24px;">
                    @foreach($orderedSlots as $slotData)
                        <div class="slot-card" draggable="true" data-slot="{{ $slotData['slot'] }}" style="border: 1px solid #e5e7eb; border-radius: 12px; padding: 14px; background: #fff; cursor: move;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; flex-wrap: wrap;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; background: #ecfeff; color: #0e7490; font-weight: 800; border-radius: 8px; font-size: 13px;">{{ $slotData['slot'] }}</div>
                                    <div>
                                        <p style="font-size: 14px; font-weight: 700; color: #111827;">Slot Video {{ $slotData['slot'] }}</p>
                                        <p style="font-size: 12px; color: #6b7280;">Format disarankan: MP4</p>
                                    </div>
                                </div>
                                @if(!empty($slotData['path']))
                                    <button type="submit" name="remove_slot" value="{{ $slotData['slot'] }}" onclick="return confirm('Hapus video pada slot {{ $slotData['slot'] }}?');" class="admin-btn btn-danger" style="font-size: 12px; padding: 6px 12px;">
                                        Hapus
                                    </button>
                                @endif
                            </div>

                            <div style="margin-top: 12px; display: grid; grid-template-columns: 1fr; gap: 10px;">
                                <input type="file" name="video_files[{{ $slotData['index'] }}]" accept="video/mp4,video/webm,video/ogg,video/quicktime,video/x-msvideo,video/x-matroska,video/mpeg" class="admin-input" style="width: 100%;" />

                                @if(!empty($slotData['url']))
                                    <video controls preload="metadata" style="width: 100%; max-height: 220px; border-radius: 10px; background: #000;">
                                        <source src="{{ $slotData['url'] }}" type="video/mp4">
                                    </video>
                                    <p style="font-size: 12px; color: #059669;">Video aktif pada slot {{ $slotData['slot'] }}</p>
                                @else
                                    <p style="font-size: 12px; color: #9ca3af;">Belum ada video pada slot ini.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="border-top: 1px solid #e5e7eb; margin: 24px 0; padding-top: 20px;">
                    <h3 style="font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 6px;">Notifikasi WhatsApp Panggilan Antrian</h3>
                    <p style="font-size: 12px; color: #6b7280; margin-bottom: 16px;">Fleksibel untuk berbagai gateway. Sistem akan kirim POST JSON ke endpoint Anda saat pasien dipanggil.</p>

                    <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                        <input type="checkbox" name="wa_enabled" value="1" {{ old('wa_enabled', !empty($waSettings['enabled'])) ? 'checked' : '' }}>
                        <span style="font-size: 13px; color: #111827; font-weight: 600;">Aktifkan notifikasi WhatsApp</span>
                    </label>

                    <div style="display: grid; grid-template-columns: 1fr; gap: 12px; margin-bottom: 12px;">
                        <div>
                            <label style="display:block; font-size:12px; color:#374151; margin-bottom:6px; font-weight:600;">Endpoint URL Gateway</label>
                            <input type="url" name="wa_endpoint" class="admin-input" value="{{ old('wa_endpoint', $waSettings['endpoint'] ?? '') }}" placeholder="https://gateway.example.com/send" style="width:100%;">
                        </div>

                        <div>
                            <label style="display:block; font-size:12px; color:#374151; margin-bottom:6px; font-weight:600;">Token API (Opsional)</label>
                            <input type="text" name="wa_token" class="admin-input" value="{{ old('wa_token', $waSettings['token'] ?? '') }}" placeholder="Bearer token" style="width:100%;">
                        </div>

                        <div>
                            <label style="display:block; font-size:12px; color:#374151; margin-bottom:6px; font-weight:600;">Nama Pengirim</label>
                            <input type="text" name="wa_sender" class="admin-input" value="{{ old('wa_sender', $waSettings['sender'] ?? 'Puskesmas') }}" placeholder="Puskesmas" style="width:100%;">
                        </div>

                        <div>
                            <label style="display:block; font-size:12px; color:#374151; margin-bottom:6px; font-weight:600;">Template Pesan</label>
                            <textarea name="wa_template" class="admin-input" rows="4" style="width:100%;">{{ old('wa_template', $waSettings['template'] ?? 'Halo {name}, nomor antrian {queue_number} sedang dipanggil ke {service_type}. Silakan segera menuju lokasi layanan.') }}</textarea>
                            <p style="font-size:11px; color:#6b7280; margin-top:6px;">Placeholder: {name}, {queue_number}, {service_type}, {called_by_role}</p>
                        </div>
                    </div>
                </div>

                <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                    <button type="submit" class="admin-btn btn-primary" style="padding: 12px 24px;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Video Offline
                    </button>
                    
                    <a href="{{ route('queue.display') }}" target="_blank" class="admin-btn btn-info" style="padding: 12px 24px;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Lihat Display
                    </a>
                </div>
            </form>
        </div>

        <div class="admin-alert alert-info" style="margin-top: 24px;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div>
                <p style="font-weight: 600; margin-bottom: 6px;">Tips Playlist</p>
                <ul style="font-size: 13px; list-style: disc; padding-left: 18px; display: flex; flex-direction: column; gap: 3px;">
                    <li>Hanya 5 slot video yang diputar bergiliran (1-5).</li>
                    <li>Sumber video murni dari file lokal yang diunggah admin.</li>
                    <li>Format utama yang disarankan: MP4.</li>
                    <li>Kosongkan slot (hapus) jika tidak ingin diputar.</li>
                    <li>Urutan putar mengikuti nomor slot yang aktif.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
(() => {
    const slotList = document.getElementById('slot-list');
    const orderInput = document.getElementById('slot-order-input');
    if (!slotList || !orderInput) return;

    let draggingCard = null;

    const syncOrder = () => {
        const order = Array.from(slotList.querySelectorAll('.slot-card')).map((card) => Number(card.dataset.slot));
        orderInput.value = JSON.stringify(order);
    };

    slotList.querySelectorAll('.slot-card').forEach((card) => {
        card.addEventListener('dragstart', () => {
            draggingCard = card;
            card.style.opacity = '0.6';
        });

        card.addEventListener('dragend', () => {
            card.style.opacity = '1';
            draggingCard = null;
            syncOrder();
        });

        card.addEventListener('dragover', (event) => {
            event.preventDefault();
            if (!draggingCard || draggingCard === card) return;

            const rect = card.getBoundingClientRect();
            const shouldInsertBefore = event.clientY < rect.top + rect.height / 2;
            if (shouldInsertBefore) {
                slotList.insertBefore(draggingCard, card);
            } else {
                slotList.insertBefore(draggingCard, card.nextSibling);
            }
        });
    });

    syncOrder();
})();
</script>
@endsection
