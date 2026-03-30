@extends('layouts.app')

@section('content')
<div style="padding: 32px 0;">
    <div style="max-width: 900px; margin: 0 auto; padding: 0 24px;">

        <div class="admin-page-header">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                <div>
                    <h1 class="admin-page-title">Pengaturan Display & WhatsApp API</h1>
                    <p class="admin-page-subtitle">Kelola video display dan konfigurasi notifikasi WhatsApp dari panel admin.</p>
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
                                    <button type="submit" name="remove_slot" value="{{ $slotData['slot'] }}" onclick="return confirm('Hapus video pada slot ini?');" class="admin-btn btn-danger" style="font-size: 12px; padding: 6px 12px;">
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

        <div class="admin-card" style="margin-top: 24px;">
            <div class="admin-card-header">
                <div class="admin-card-header-icon" style="background: linear-gradient(135deg, #dcfce7, #bbf7d0);">
                    <svg class="w-5 h-5" style="color: #047857;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m5 0h3M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/></svg>
                </div>
                <div>
                    <h2 style="font-size: 16px; font-weight: 700; color: #111827;">Pengaturan WhatsApp API</h2>
                    <p style="font-size: 13px; color: #6b7280;">Simpan atau hapus override tiap parameter WA API tanpa edit file .env langsung.</p>
                </div>
            </div>

            <div class="admin-card-body" style="padding: 24px;">
                <form id="wa-bulk-save-form" method="POST" action="{{ route('admin.settings.whatsapp.save') }}">
                    @csrf
                </form>
                <div style="overflow-x: auto;">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th style="text-align: left; min-width: 220px;">Pengaturan</th>
                                <th style="text-align: left; min-width: 220px;">Nilai</th>
                                <th style="text-align: left; min-width: 160px;">Default</th>
                                <th style="text-align: left; min-width: 150px;">Status Override</th>
                                <th style="text-align: left; min-width: 200px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($whatsAppSettings as $waSetting)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: #111827;">{{ $waSetting['label'] }}</div>
                                        <div style="font-size: 12px; color: #6b7280; margin-top: 3px;">{{ $waSetting['description'] }}</div>
                                        <div style="font-size: 11px; color: #9ca3af; margin-top: 4px;">{{ $waSetting['key'] }}</div>
                                    </td>
                                    <td>
                                        @if($waSetting['type'] === 'boolean')
                                            <select name="settings[{{ $waSetting['key'] }}]" form="wa-bulk-save-form" class="admin-search" style="width: 160px; padding-left: 12px;">
                                                <option value="1" {{ (string) $waSetting['effective_value'] === '1' ? 'selected' : '' }}>Aktif (1)</option>
                                                <option value="0" {{ (string) $waSetting['effective_value'] === '0' ? 'selected' : '' }}>Nonaktif (0)</option>
                                            </select>
                                        @elseif($waSetting['type'] === 'integer')
                                            <input type="number" min="0" name="settings[{{ $waSetting['key'] }}]" form="wa-bulk-save-form" value="{{ $waSetting['effective_value'] }}" class="admin-search" style="width: 140px; padding-left: 12px;" />
                                        @elseif($waSetting['type'] === 'password')
                                            <input type="text" name="settings[{{ $waSetting['key'] }}]" form="wa-bulk-save-form" value="{{ $waSetting['effective_value'] }}" class="admin-search" style="width: 320px; padding-left: 12px;" placeholder="Isi token API" />
                                        @else
                                            <input type="text" name="settings[{{ $waSetting['key'] }}]" form="wa-bulk-save-form" value="{{ $waSetting['effective_value'] }}" class="admin-search" style="width: 320px; padding-left: 12px;" />
                                        @endif
                                    </td>
                                    <td>
                                        <span style="font-size: 12px; color: #374151; word-break: break-all;">{{ $waSetting['default_value'] !== '' ? $waSetting['default_value'] : '-' }}</span>
                                    </td>
                                    <td>
                                        @if($waSetting['has_override'])
                                            <span class="admin-badge badge-success">Tersimpan di DB</span>
                                        @else
                                            <span class="admin-badge badge-gray">Pakai default</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($waSetting['has_override'])
                                            <form method="POST" action="{{ route('admin.settings.whatsapp.delete', ['key' => $waSetting['key']]) }}" onsubmit="return confirm('Hapus override pengaturan ini?');">
                                                @csrf
                                                <button type="submit" class="admin-btn btn-danger" style="font-size: 12px; padding: 7px 12px;">Hapus Override</button>
                                            </form>
                                        @else
                                            <span style="font-size: 12px; color: #9ca3af;">Belum ada override</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #9ca3af;">Belum ada definisi pengaturan WhatsApp.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div style="margin-top: 14px; display: flex; justify-content: flex-end;">
                    <button type="submit" form="wa-bulk-save-form" class="admin-btn btn-primary" style="font-size: 13px; padding: 9px 16px;">
                        Simpan Semua Pengaturan
                    </button>
                </div>
            </div>
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
