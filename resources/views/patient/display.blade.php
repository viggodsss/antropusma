@extends('layouts.app')

@section('content')
{{-- ════════════════════════════════════════════════════
     Patient Display — tema sama seperti TV Display
     Real-time fetch setiap 10 detik tanpa reload penuh
     ════════════════════════════════════════════════════ --}}

<style>
    /* Full-bleed gradient background sama seperti TV display */
    #patient-display-wrap {
        background: linear-gradient(135deg, #237227 0%, #2e6b3a 35%, #1a4a5e 70%, #0f2d42 100%);
        background-size: 400% 400%;
        animation: bgShift 20s ease infinite;
    }
    @keyframes bgShift {
        0%   { background-position: 0%   50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0%   50%; }
    }
    .glass {
        background: rgba(255,255,255,.10);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255,255,255,.18);
    }
    .glass-dark {
        background: rgba(0,0,0,.18);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,.10);
    }
    /* Pulse on called number */
    @keyframes calledPulse {
        0%,100% { transform: scale(1);    opacity: 1;   }
        50%      { transform: scale(1.05); opacity: .85; }
    }
    .called-pulse { animation: calledPulse 2.2s ease-in-out infinite; }

    /* Bounce-in when value changes */
    @keyframes bounceIn {
        0%   { opacity:0; transform: scale(.7) translateY(8px); }
        60%  { opacity:1; transform: scale(1.08) translateY(-3px); }
        100% { opacity:1; transform: scale(1) translateY(0); }
    }
    .bounce-in { animation: bounceIn .35s cubic-bezier(.34,1.56,.64,1) forwards; }

    /* Live dot blink */
    @keyframes liveDot {
        0%,100% { opacity:1; }
        50%      { opacity:.2; }
    }
    .live-dot { animation: liveDot 1.4s ease-in-out infinite; }

    /* Shimmer badge */
    @keyframes shimmer {
        0%   { background-position: -200% center; }
        100% { background-position:  200% center; }
    }
    .shimmer-called {
        background: linear-gradient(90deg, #fbbf24 0%, #fde68a 40%, #f59e0b 60%, #fbbf24 100%);
        background-size: 200% auto;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        animation: shimmer 3s linear infinite;
    }
    /* waiting badge hover */
    .wait-badge:hover { background: rgba(255,255,255,.22); transform: scale(1.08); }
    .wait-badge { transition: all .18s ease; }

    /* Fade-in for initial load */
    @keyframes fadeIn { from {opacity:0;} to {opacity:1;} }
    .fade-in { animation: fadeIn .5s ease forwards; }
</style>

<div id="patient-display-wrap" class="min-h-screen text-white px-4 sm:px-6 py-6 pb-12 fade-in">
    <div class="max-w-7xl mx-auto">

        {{-- ── Header ── --}}
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="live-dot w-2.5 h-2.5 rounded-full bg-emerald-400 inline-block"></span>
                    <span class="text-xs font-bold uppercase tracking-[.2em] text-emerald-300">
                        LIVE · Pembaruan Otomatis 10 Detik
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black drop-shadow-lg tracking-tight">
                    Display Antrian <span class="text-yellow-300">Pasien</span>
                </h1>
                <p class="mt-1 text-sm text-white/60">Puskesmas Mapurujaya &mdash; Hari Ini</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                {{-- Jam digital --}}
                <div class="glass rounded-2xl px-4 py-2 text-center min-w-[90px]">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-white/50 mb-1">Jam</p>
                    <p id="live-clock" class="text-2xl font-black text-yellow-300 tabular-nums leading-none">--:--:--</p>
                </div>
                <a href="{{ route('dashboard') }}"
                   class="glass rounded-2xl px-4 py-2 text-sm font-semibold text-white hover:bg-white/20 transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Dashboard
                </a>
            </div>
        </div>

        {{-- ── Summary cards ── --}}
        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
            {{-- Nomor dipanggil --}}
            <div class="glass rounded-3xl p-5 text-center shadow-2xl">
                <p class="text-xs font-bold uppercase tracking-[.18em] text-yellow-300 mb-3">Nomor Dipanggil</p>
                <p id="summary-called" class="text-6xl font-black drop-shadow-lg called-pulse shimmer-called">
                    {{ $currentCalledQueue ?? '—' }}
                </p>
                <p id="summary-called-cluster" class="mt-2 text-sm text-white/60">
                    {{ $currentCalledCluster ? 'Klaster '.$currentCalledCluster : '—' }}
                </p>
            </div>

            {{-- Total menunggu --}}
            <div class="glass rounded-3xl p-5 text-center shadow-2xl">
                <p class="text-xs font-bold uppercase tracking-[.18em] text-emerald-300 mb-3">Total Menunggu</p>
                <p id="summary-waiting" class="text-6xl font-black text-emerald-300 drop-shadow-lg">
                    {{ $totalWaitingQueues }}
                </p>
                <p class="mt-2 text-sm text-white/60">Antrian aktif hari ini</p>
            </div>

            {{-- Klaster aktif + jam update --}}
            <div class="glass rounded-3xl p-5 text-center shadow-2xl">
                <p class="text-xs font-bold uppercase tracking-[.18em] text-sky-300 mb-3">Klaster Aktif</p>
                <p id="summary-clusters" class="text-6xl font-black text-sky-300 drop-shadow-lg">
                    {{ $totalActiveClusters }}
                </p>
                <p id="summary-updated" class="mt-2 text-sm text-white/60">
                    Pkl {{ $lastUpdatedAt->format('H:i:s') }}
                </p>
            </div>
        </div>

        {{-- ── Per-cluster grid ── --}}
        <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">
            @foreach($clusters as $cluster)
            <div id="cluster-card-{{ $cluster['number'] }}"
                 class="glass rounded-3xl overflow-hidden shadow-2xl">

                {{-- Card header --}}
                <div class="glass-dark px-5 py-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between border-b border-white/10">
                    <div>
                        <h2 class="text-base font-black tracking-tight">{{ $cluster['name'] }}</h2>
                        <p class="text-xs text-white/40 mt-0.5">Klaster {{ $cluster['number'] }}</p>
                    </div>
                    <div class="flex gap-2 flex-wrap">
                        <span id="badge-active-{{ $cluster['number'] }}"
                              class="inline-flex items-center rounded-full border border-emerald-400/30 bg-emerald-400/15 px-3 py-1 text-xs font-bold text-emerald-300">
                            Aktif: {{ $cluster['active_count'] }}
                        </span>
                        <span id="badge-wait-{{ $cluster['number'] }}"
                              class="inline-flex items-center rounded-full border border-sky-400/30 bg-sky-400/15 px-3 py-1 text-xs font-bold text-sky-300">
                            Tunggu: {{ $cluster['waiting_count'] }}
                        </span>
                    </div>
                </div>

                {{-- Card body --}}
                <div class="px-5 py-5">
                    {{-- Called number box --}}
                    <div class="rounded-2xl border border-yellow-400/25 bg-yellow-400/10 px-4 py-4 text-center mb-4">
                        <p class="text-[10px] font-bold uppercase tracking-[.2em] text-yellow-300 mb-2">Sedang Dipanggil</p>
                        <p id="called-{{ $cluster['number'] }}"
                           class="text-5xl font-black drop-shadow-lg called-pulse shimmer-called">
                            {{ $cluster['called_queue'] ?? '—' }}
                        </p>
                    </div>

                    {{-- Waiting list --}}
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-bold text-white/80">Menunggu</p>
                            <span id="wait-count-{{ $cluster['number'] }}"
                                  class="text-xs text-white/40">{{ $cluster['waiting_count'] }} nomor</span>
                        </div>
                        <div id="waiting-badges-{{ $cluster['number'] }}" class="flex flex-wrap gap-2">
                            @if($cluster['waiting_numbers']->isEmpty())
                                <p class="text-sm text-white/40 italic w-full text-center py-3">
                                    Tidak ada antrian menunggu
                                </p>
                            @else
                                @foreach($cluster['waiting_numbers'] as $queueNumber)
                                    <span class="wait-badge inline-flex items-center rounded-xl border border-white/20 bg-white/10 px-3 py-2 text-sm font-bold text-white">
                                        {{ $queueNumber }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        {{-- ── Status footer ── --}}
        <div class="mt-6 glass rounded-2xl px-5 py-3 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 text-xs text-white/40">
            <span id="status-bar">Menunggu pembaruan pertama...</span>
            <span>Auto-fetch setiap 10 detik &bull; Tidak perlu refresh halaman</span>
        </div>

    </div>
</div>

<script>
(function () {
    'use strict';

    const DATA_URL  = "{{ route('patient.display.data') }}";
    const INTERVAL  = 10_000; // ms

    // ── Clock ──────────────────────────────────────────────────────────────
    const clockEl = document.getElementById('live-clock');
    function tickClock() {
        const n = new window.Date();
        clockEl.textContent =
            String(n.getHours()).padStart(2,'0') + ':' +
            String(n.getMinutes()).padStart(2,'0') + ':' +
            String(n.getSeconds()).padStart(2,'0');
    }
    setInterval(tickClock, 1000);
    tickClock();

    // ── Helpers ────────────────────────────────────────────────────────────
    function setText(id, value) {
        const el = document.getElementById(id);
        if (el) el.textContent = (value !== null && value !== undefined) ? value : '—';
    }

    function bounceIn(el) {
        if (!el) return;
        el.classList.remove('bounce-in');
        void el.offsetWidth; // force reflow
        el.classList.add('bounce-in');
    }

    // ── Render waiting badges (only if changed) ────────────────────────────
    function renderWaitingBadges(container, numbers) {
        // Compare current vs incoming
        const existing = [...container.querySelectorAll('span')].map(s => s.textContent.trim());
        const incoming  = (numbers || []).map(String);

        if (JSON.stringify(existing) === JSON.stringify(incoming)) return; // no change

        if (incoming.length === 0) {
            container.innerHTML = '<p class="text-sm text-white/40 italic w-full text-center py-3">Tidak ada antrian menunggu</p>';
            return;
        }

        container.innerHTML = incoming
            .map(n => `<span class="wait-badge bounce-in inline-flex items-center rounded-xl border border-white/20 bg-white/10 px-3 py-2 text-sm font-bold text-white">${n}</span>`)
            .join('');
    }

    // ── Update summary cards ───────────────────────────────────────────────
    function updateSummary(data) {
        const calledEl = document.getElementById('summary-called');
        const newCalled = data.current_called_queue ?? '—';
        if (calledEl && calledEl.textContent.trim() !== newCalled) {
            calledEl.textContent = newCalled;
            bounceIn(calledEl);
        }

        const clusterLabel = data.current_called_cluster ? 'Klaster ' + data.current_called_cluster : '—';
        setText('summary-called-cluster', clusterLabel);
        setText('summary-waiting', data.total_waiting_queues ?? 0);
        setText('summary-clusters', data.total_active_clusters ?? 0);
        setText('summary-updated', 'Pkl ' + (data.updated_at ?? '--:--:--'));
    }

    // ── Update per-cluster cards ───────────────────────────────────────────
    function updateClusters(clusters) {
        (clusters || []).forEach(cluster => {
            const n = cluster.number;

            // Called number
            const calledEl = document.getElementById('called-' + n);
            if (calledEl) {
                const next = cluster.called_queue ?? '—';
                if (calledEl.textContent.trim() !== next) {
                    calledEl.textContent = next;
                    bounceIn(calledEl);
                }
            }

            // Badges
            setText('badge-active-' + n, 'Aktif: ' + (cluster.active_count ?? 0));
            setText('badge-wait-'   + n, 'Tunggu: ' + (cluster.waiting_count ?? 0));
            setText('wait-count-'   + n, (cluster.waiting_count ?? 0) + ' nomor');

            // Waiting number badges
            const badgesEl = document.getElementById('waiting-badges-' + n);
            if (badgesEl) renderWaitingBadges(badgesEl, cluster.waiting_numbers);
        });
    }

    // ── Fetch loop ─────────────────────────────────────────────────────────
    let errCount = 0;

    async function fetchAndUpdate() {
        try {
            const resp = await fetch(DATA_URL, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                cache: 'no-store',
            });
            if (!resp.ok) throw new Error('HTTP ' + resp.status);
            const data = await resp.json();

            updateSummary(data);
            updateClusters(data.clusters);

            errCount = 0;
            setText('status-bar', 'Terakhir diperbarui: ' + (data.updated_at ?? '--'));
        } catch (err) {
            errCount++;
            setText('status-bar', 'Gagal memuat data (' + errCount + 'x). Mencoba lagi...');
            console.warn('[PatientDisplay] fetch error:', err);
        }
    }

    // First fetch setelah 1.5 detik (beri waktu halaman fully rendered)
    setTimeout(fetchAndUpdate, 1500);
    setInterval(fetchAndUpdate, INTERVAL);
})();
</script>
@endsection
