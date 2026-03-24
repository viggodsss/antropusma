<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Display Antrian</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* === Loading Page Futuristic Styles === */
        .loading-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0a0e17;
            overflow: hidden;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }
        .loading-overlay.fade-out {
            opacity: 0;
            visibility: hidden;
        }
        
        /* Animated Background Particles */
        .bg-particles { position: fixed; inset: 0; z-index: 0; }
        .particle {
            position: absolute;
            border-radius: 50%;
            opacity: 0;
            animation: particleFloat linear infinite;
        }
        @keyframes particleFloat {
            0% { opacity: 0; transform: translateY(100vh) scale(0); }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; transform: translateY(-10vh) scale(1); }
        }
        
        /* Ambient Glow */
        .ambient-glow {
            position: fixed;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.15;
            z-index: 0;
        }
        .glow-1 { background: #356d35; top: -200px; left: -200px; animation: glowDrift1 8s ease-in-out infinite; }
        .glow-2 { background: #0d3a58; bottom: -200px; right: -200px; animation: glowDrift2 10s ease-in-out infinite; }
        .glow-3 { background: #ffde17; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 250px; height: 250px; opacity: 0.05; animation: glowPulseCenter 4s ease-in-out infinite; }
        @keyframes glowDrift1 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(80px, 100px); } }
        @keyframes glowDrift2 { 0%, 100% { transform: translate(0, 0); } 50% { transform: translate(-100px, -80px); } }
        @keyframes glowPulseCenter { 0%, 100% { opacity: 0.03; transform: translate(-50%, -50%) scale(1); } 50% { opacity: 0.08; transform: translate(-50%, -50%) scale(1.5); } }
        
        /* Main Container */
        .loading-container { position: relative; z-index: 10; display: flex; flex-direction: column; align-items: center; gap: 40px; }
        
        /* Logo Wrapper */
        .logo-wrapper { position: relative; width: 200px; height: 200px; display: flex; align-items: center; justify-content: center; }
        
        /* Orbital Rings */
        .orbit-ring { position: absolute; border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 50%; }
        .orbit-ring-1 { width: 220px; height: 220px; border-color: rgba(53, 109, 53, 0.3); animation: orbitSpin1 12s linear infinite; }
        .orbit-ring-2 { width: 260px; height: 260px; border-color: rgba(13, 58, 88, 0.3); animation: orbitSpin2 18s linear infinite reverse; }
        .orbit-ring-3 { width: 300px; height: 300px; border-color: rgba(255, 222, 23, 0.2); animation: orbitSpin3 25s linear infinite; }
        .orbit-dot { position: absolute; width: 8px; height: 8px; border-radius: 50%; top: -4px; left: 50%; transform: translateX(-50%); }
        .orbit-ring-1 .orbit-dot { background: #356d35; box-shadow: 0 0 15px #356d35, 0 0 25px #356d35; }
        .orbit-ring-2 .orbit-dot { background: #0d3a58; box-shadow: 0 0 15px #0d3a58, 0 0 25px #0d3a58; width: 6px; height: 6px; }
        .orbit-ring-3 .orbit-dot { background: #ffde17; box-shadow: 0 0 15px #ffde17, 0 0 25px rgba(255, 222, 23, 0.5); width: 5px; height: 5px; }
        @keyframes orbitSpin1 { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes orbitSpin2 { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes orbitSpin3 { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        
        /* Loading PNG */
        .logo-svg-container {
            position: relative;
            z-index: 5;
            animation: logoFloat 6s ease-in-out infinite;
            filter: drop-shadow(0 0 30px rgba(53, 109, 53, 0.4)) drop-shadow(0 0 50px rgba(13, 58, 88, 0.3));
        }
        .logo-svg-container img { width: 180px; max-width: 48vw; height: auto; object-fit: contain; }
        @keyframes logoFloat { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        
        /* Progress Section */
        .progress-section { display: flex; flex-direction: column; align-items: center; gap: 16px; width: 280px; }
        .progress-track { width: 100%; height: 4px; background: rgba(255, 255, 255, 0.05); border-radius: 2px; position: relative; overflow: hidden; }
        .progress-fill { position: absolute; height: 100%; border-radius: 2px; background: linear-gradient(90deg, #356d35, #0d3a58, #ffde17); background-size: 200% 100%; animation: progressGrow 3s ease-in-out infinite, progressShimmer 2s linear infinite; box-shadow: 0 0 15px rgba(53, 109, 53, 0.5); }
        @keyframes progressGrow { 0% { width: 0%; } 50% { width: 80%; } 100% { width: 100%; } }
        @keyframes progressShimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
        .progress-scanner { position: absolute; top: 0; width: 80px; height: 100%; background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent); animation: scanMove 2s ease-in-out infinite; }
        @keyframes scanMove { 0% { left: -80px; } 100% { left: 100%; } }
        
        /* Loading Text */
        .loading-text-animated { display: flex; align-items: center; gap: 6px; color: rgba(255, 255, 255, 0.5); font-size: 14px; font-weight: 300; letter-spacing: 4px; text-transform: uppercase; }
        .loading-text-animated span { display: inline-block; animation: letterWave 2s ease-in-out infinite; }
        @keyframes letterWave { 0%, 100% { transform: translateY(0); opacity: 0.5; } 50% { transform: translateY(-5px); opacity: 1; } }
        
        /* Dot Spinner */
        .dot-spinner { display: flex; gap: 6px; }
        .dot-spinner .dot { width: 6px; height: 6px; border-radius: 50%; animation: dotBounce 1.4s ease-in-out infinite; }
        .dot:nth-child(1) { background: #356d35; animation-delay: 0s; }
        .dot:nth-child(2) { background: #0d3a58; animation-delay: 0.2s; }
        .dot:nth-child(3) { background: #ffde17; animation-delay: 0.4s; }
        @keyframes dotBounce { 0%, 80%, 100% { transform: scale(0.6); opacity: 0.3; } 40% { transform: scale(1.2); opacity: 1; } }
        
        /* Percentage */
        .percentage { font-size: 16px; font-weight: 600; background: linear-gradient(135deg, #356d35, #0d3a58, #ffde17); background-size: 300% 300%; -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; animation: gradientShift 3s ease-in-out infinite; }
        @keyframes gradientShift { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }

        /* Low GPU mode (enabled after page is ready) */
        body.low-gpu .ambient-glow,
        body.low-gpu .bg-particles,
        body.low-gpu .progress-scanner,
        body.low-gpu .dot-spinner,
        body.low-gpu .loading-text-animated {
            display: none !important;
        }

        body.low-gpu .backdrop-blur-sm {
            -webkit-backdrop-filter: none !important;
            backdrop-filter: none !important;
        }

        body.low-gpu .shadow-2xl,
        body.low-gpu .shadow-lg,
        body.low-gpu .drop-shadow-lg,
        body.low-gpu .logo-svg-container,
        body.low-gpu .orbit-ring-1 .orbit-dot,
        body.low-gpu .orbit-ring-2 .orbit-dot,
        body.low-gpu .orbit-ring-3 .orbit-dot,
        body.low-gpu .progress-fill {
            filter: none !important;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.22) !important;
            text-shadow: none !important;
        }

        body.low-gpu .orbit-ring,
        body.low-gpu .logo-wrapper,
        body.low-gpu .logo-svg-container,
        body.low-gpu .progress-fill,
        body.low-gpu .percentage,
        body.low-gpu .particle {
            animation: none !important;
            transition: none !important;
        }
    </style>
</head>
<body class="min-h-screen text-white"
    style="background: linear-gradient(135deg, #237227 0%, #519A66 50%, #FFD786 100%);">

    {{-- Loading Page Futuristic --}}
    <div id="loading-overlay" class="loading-overlay">
        <div class="ambient-glow glow-1"></div>
        <div class="ambient-glow glow-2"></div>
        <div class="ambient-glow glow-3"></div>
        <div class="bg-particles" id="particles"></div>
        
        <div class="loading-container">
            <div class="logo-wrapper">
                <div class="orbit-ring orbit-ring-1"><div class="orbit-dot"></div></div>
                <div class="orbit-ring orbit-ring-2"><div class="orbit-dot"></div></div>
                <div class="orbit-ring orbit-ring-3"><div class="orbit-dot"></div></div>
                
                <div class="logo-svg-container">
                    <img src="{{ asset('images/loadingpage.svg') }}" alt="Loading">
                </div>
            </div>
            
            <div class="progress-section">
                <div class="progress-track">
                    <div class="progress-fill"></div>
                    <div class="progress-scanner"></div>
                </div>
                <div class="loading-text-animated" id="loadingText"></div>
                <div class="dot-spinner">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
                <div class="percentage" id="percentage">0%</div>
            </div>
        </div>
    </div>

    {{-- Header dengan Logo --}}
    <div class="bg-white/10 backdrop-blur-sm border-b border-white/20 mb-6">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-center gap-4">
            <img src="{{ asset('images/nav.svg') }}" alt="Logo" class="h-12 w-auto object-contain">
            <img src="{{ asset('images/navlogo.png') }}" alt="Logo" class="h-12 w-auto object-contain">
            <h1 class="text-3xl font-extrabold text-center drop-shadow-lg">DISPLAY ANTRIAN PUSKESMAS MAPURUJAYA</h1>
            <img src="{{ asset('images/kampusnavlogo.png') }}" alt="Logo" class="h-12 w-auto object-contain">
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 pb-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Antrian Dipanggil --}}
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-8 text-center shadow-2xl">
                <p class="text-lg text-yellow-200 uppercase tracking-widest">Nomor Antrian Dipanggil</p>
                <div id="current-queue" class="text-7xl font-black mt-4 drop-shadow-lg">{{ $current?->queue_number ?? '---' }}</div>
                <p class="mt-4 text-xl text-white/90">
                    Nama Lengkap: <span id="current-name" class="font-bold">{{ $current?->patient_name ?? '-' }}</span>
                </p>
                <p class="mt-1 text-sm text-yellow-200">
                    Klaster Tujuan: <span id="current-service" class="font-semibold">{{ $current?->service_type ?? '-' }}</span>
                </p>
            </div>

            {{-- YouTube Video Player --}}
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 shadow-2xl">
                <div class="mb-3 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-yellow-200 uppercase tracking-wider">
                        <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                        Informasi & Hiburan
                    </h2>
                    <span id="video-counter" class="text-sm text-white/70 bg-white/10 px-3 py-1 rounded-full {{ count($localVideoUrls) > 1 ? '' : 'hidden' }}">
                        {{ count($localVideoUrls) > 0 ? '1 / ' . count($localVideoUrls) : '0 / 0' }}
                    </span>
                </div>

                {{-- Video Container --}}
                <div class="relative w-full rounded-xl overflow-hidden bg-black/50" style="padding-bottom: 56.25%;">
                    <video id="local-video-player" class="absolute inset-0 w-full h-full {{ count($localVideoUrls) > 0 ? '' : 'hidden' }}" autoplay muted playsinline preload="auto" controls>
                        <source src="{{ $localVideoUrls[0] ?? '' }}" type="video/mp4">
                    </video>

                    {{-- Placeholder when no video --}}
                    <div id="video-placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-white/70 {{ count($localVideoUrls) > 0 ? 'hidden' : '' }}">
                        <svg class="w-16 h-16 mb-3 text-white/40" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                        </svg>
                        <p class="text-sm">Video offline belum diatur admin</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 shadow-2xl">
            <h2 class="text-2xl font-bold mb-4">Antrian Menunggu</h2>
            <div id="waiting-list" class="flex flex-wrap gap-3">
                @if($waiting->count())
                    @foreach($waiting as $item)
                        <span class="inline-flex items-center px-4 py-2 rounded-xl bg-white/90 text-green-700 font-bold">
                            {{ $item->queue_number ?: '---' }}
                        </span>
                    @endforeach
                @else
                    <p class="text-white/80" id="waiting-empty">Tidak ada antrian menunggu.</p>
                @endif
            </div>
        </div>
    </div>

    <div id="audio-unlock" class="fixed bottom-4 right-4 bg-white text-gray-900 rounded-xl shadow-lg p-4 z-50">
        <p class="text-sm mb-2 font-medium">🔇 Suara diblokir browser</p>
        <p class="text-xs text-gray-500 mb-3">Klik untuk mengaktifkan suara panggilan & video</p>
        <button id="unlock-audio-btn" type="button" class="w-full px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 text-sm font-medium flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
            </svg>
            Aktifkan Suara
        </button>
    </div>

    <div id="audio-status" class="fixed bottom-4 left-4 bg-green-600 text-white rounded-xl shadow-lg px-4 py-2 z-50 hidden">
        <span class="text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
            </svg>
            🔊 Suara Aktif
        </span>
    </div>

    <audio id="queue-bell" src="{{ asset('sound/bell.mp3') }}" preload="auto"></audio>

    <script>
        window.__stopLoadingAnimations = false;

        const currentQueueEl = document.getElementById('current-queue');
        const currentNameEl = document.getElementById('current-name');
        const currentServiceEl = document.getElementById('current-service');
        const waitingListEl = document.getElementById('waiting-list');
        const bellEl = document.getElementById('queue-bell');
        const audioUnlockEl = document.getElementById('audio-unlock');
        const unlockAudioBtn = document.getElementById('unlock-audio-btn');
        const audioStatusEl = document.getElementById('audio-status');
        const videoCounterEl = document.getElementById('video-counter');
        const videoPlaceholderEl = document.getElementById('video-placeholder');
        const localVideoPlayerEl = document.getElementById('local-video-player');

        const ULTRA_KIOSK_REFRESH_MINUTES = 30;
        const ULTRA_KIOSK_VIDEO_VOLUME = 0.6;

        let lastAnnouncedQueueId = localStorage.getItem('last_announced_queue_id');
        let announcementInProgress = false;
        let pendingAnnouncement = null;
        let announcementToken = 0;
        let audioUnlocked = false;
        let fullscreenRequested = false;
        let currentVideoIndex = 0;
        let lastAudioPolicyAt = 0;
        let localVideoUrls = @json($localVideoUrls);
        let localVideoSignature = JSON.stringify(localVideoUrls);

        // Auto-unlock audio on page load (no user interaction required for kiosk mode)
        window.addEventListener('load', async function() {
            await sleep(500);
            if (!audioUnlocked) {
                await unlockAudio();
            }
        });

        function sleep(ms) {
            return new Promise((resolve) => setTimeout(resolve, ms));
        }

        function showAudioUnlock() {
            audioUnlockEl.classList.remove('hidden');
            audioStatusEl.classList.add('hidden');
        }

        function hideAudioUnlock() {
            audioUnlockEl.classList.add('hidden');
            audioStatusEl.classList.remove('hidden');
            // Auto-hide status after 3 seconds
            setTimeout(() => {
                audioStatusEl.classList.add('hidden');
            }, 3000);
        }

        async function requestFullscreenOnce() {
            if (fullscreenRequested || document.fullscreenElement) {
                return;
            }

            const target = document.documentElement;
            if (!target) {
                return;
            }

            try {
                if (target.requestFullscreen) {
                    await target.requestFullscreen();
                    fullscreenRequested = true;
                    return;
                }

                if (target.webkitRequestFullscreen) {
                    target.webkitRequestFullscreen();
                    fullscreenRequested = true;
                }
            } catch (error) {
                console.log('Fullscreen request blocked:', error);
            }
        }

        function applyYoutubeAudioPolicy() {
            const now = Date.now();
            if (now - lastAudioPolicyAt < 800) {
                return;
            }
            lastAudioPolicyAt = now;

            try {
                if (!localVideoPlayerEl) {
                    return;
                }

                if (!audioUnlocked || announcementInProgress) {
                    localVideoPlayerEl.muted = true;
                    return;
                }

                localVideoPlayerEl.muted = false;
                localVideoPlayerEl.volume = ULTRA_KIOSK_VIDEO_VOLUME;
            } catch (error) {
                console.log('Local video audio policy apply failed:', error);
            }
        }

        async function unlockAudio() {
            if (!bellEl) {
                return;
            }

            await requestFullscreenOnce();

            try {
                bellEl.muted = true;
                bellEl.currentTime = 0;
                await bellEl.play();
                bellEl.pause();
                bellEl.currentTime = 0;
                bellEl.muted = false;
                audioUnlocked = true;

                applyYoutubeAudioPolicy();
                
                hideAudioUnlock();
            } catch (error) {
                audioUnlocked = false;
                showAudioUnlock();
            }
        }

        function isAnnouncementInterrupted(token) {
            return token !== announcementToken;
        }

        function interruptCurrentAnnouncement() {
            announcementToken += 1;

            if ('speechSynthesis' in window) {
                speechSynthesis.cancel();
            }

            if (bellEl) {
                try {
                    bellEl.pause();
                    bellEl.currentTime = 0;
                } catch (e) {
                    console.log('Bell interrupt error:', e);
                }
            }

            applyYoutubeAudioPolicy();
        }

        function playAirportChime(token) {
            return new Promise(async (resolve) => {
                if (!bellEl || isAnnouncementInterrupted(token)) {
                    resolve();
                    return;
                }

                let settled = false;
                let interruptWatcher = null;
                let fallbackTimer = null;

                const cleanup = () => {
                    if (settled) return;
                    settled = true;
                    bellEl.onended = null;
                    bellEl.onerror = null;
                    if (interruptWatcher) clearInterval(interruptWatcher);
                    if (fallbackTimer) clearTimeout(fallbackTimer);
                    resolve();
                };

                interruptWatcher = setInterval(() => {
                    if (!isAnnouncementInterrupted(token)) return;
                    try {
                        bellEl.pause();
                        bellEl.currentTime = 0;
                    } catch (e) {
                        console.log('Bell interrupt error:', e);
                    }
                    cleanup();
                }, 100);

                fallbackTimer = setTimeout(cleanup, 3500);

                bellEl.onended = cleanup;
                bellEl.onerror = cleanup;

                try {
                    bellEl.currentTime = 0;
                    await bellEl.play();
                } catch (error) {
                    showAudioUnlock();
                    cleanup();
                }
            });
        }

        function speakText(text, token) {
            return new Promise((resolve) => {
                if (!('speechSynthesis' in window) || isAnnouncementInterrupted(token)) {
                    resolve();
                    return;
                }

                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = 'id-ID';
                utterance.rate = 0.9;
                utterance.pitch = 1;
                let settled = false;
                let interruptWatcher = null;

                const cleanup = () => {
                    if (settled) return;
                    settled = true;
                    utterance.onend = null;
                    utterance.onerror = null;
                    if (interruptWatcher) clearInterval(interruptWatcher);
                    resolve();
                };

                utterance.onend = cleanup;
                utterance.onerror = cleanup;

                interruptWatcher = setInterval(() => {
                    if (!isAnnouncementInterrupted(token)) return;
                    speechSynthesis.cancel();
                    cleanup();
                }, 100);

                speechSynthesis.cancel();
                speechSynthesis.speak(utterance);
            });
        }

        async function announceQueueNow(payload, token) {
            if (isAnnouncementInterrupted(token)) {
                return;
            }

            const queueNumber = payload.queueNumber;
            const patientName = payload.patientName;
            const serviceType = payload.serviceType;

            // Mute YouTube during announcement
            applyYoutubeAudioPolicy();

            const text = `Perhatian. Nomor antrian ${queueNumber}. Atas nama lengkap ${patientName}. Silakan menuju klaster tujuan ${serviceType}.`;

            for (let repeat = 1; repeat <= 3; repeat += 1) {
                if (isAnnouncementInterrupted(token)) {
                    return;
                }

                if (!audioUnlocked) {
                    await unlockAudio();
                }

                if (isAnnouncementInterrupted(token)) {
                    return;
                }

                await playAirportChime(token);

                if (isAnnouncementInterrupted(token)) {
                    return;
                }

                await speakText(text, token);

                if (isAnnouncementInterrupted(token)) {
                    return;
                }

                if (repeat < 3) {
                    await sleep(1100);
                }
            }

            if (isAnnouncementInterrupted(token)) {
                return;
            }

            // Restore YouTube audio after announcement
            applyYoutubeAudioPolicy();
        }

        async function processAnnouncementQueue() {
            if (announcementInProgress || !pendingAnnouncement) {
                return;
            }

            announcementInProgress = true;

            while (pendingAnnouncement) {
                const nextAnnouncement = pendingAnnouncement;
                pendingAnnouncement = null;
                const token = ++announcementToken;
                await announceQueueNow(nextAnnouncement, token);
            }

            announcementInProgress = false;
            applyYoutubeAudioPolicy();
        }

        function announceQueue(queueNumber, patientName, serviceType) {
            pendingAnnouncement = {
                queueNumber,
                patientName,
                serviceType
            };

            if (announcementInProgress) {
                interruptCurrentAnnouncement();
                return;
            }

            processAnnouncementQueue();
        }

        function renderWaiting(waitingItems) {
            waitingListEl.innerHTML = '';

            if (!waitingItems || waitingItems.length === 0) {
                waitingListEl.innerHTML = '<p class="text-white/80" id="waiting-empty">Tidak ada antrian menunggu.</p>';
                return;
            }

            waitingItems.forEach((item) => {
                const span = document.createElement('span');
                span.className = 'inline-flex items-center px-4 py-2 rounded-xl bg-white/90 text-green-700 font-bold';
                span.textContent = item.queue_number || '---';
                waitingListEl.appendChild(span);
            });
        }

        function updateLocalVideoCounter() {
            if (!videoCounterEl) {
                return;
            }

            if (localVideoUrls.length > 1) {
                videoCounterEl.classList.remove('hidden');
                videoCounterEl.textContent = (currentVideoIndex + 1) + ' / ' + localVideoUrls.length;
                return;
            }

            videoCounterEl.classList.add('hidden');
            videoCounterEl.textContent = localVideoUrls.length > 0 ? '1 / 1' : '0 / 0';
        }

        function showLocalVideoPlaceholder(show) {
            if (videoPlaceholderEl) {
                videoPlaceholderEl.classList.toggle('hidden', !show);
            }
            if (localVideoPlayerEl) {
                localVideoPlayerEl.classList.toggle('hidden', show);
            }
        }

        function loadLocalVideoByIndex(index) {
            if (!localVideoPlayerEl || localVideoUrls.length === 0) {
                return;
            }

            currentVideoIndex = ((index % localVideoUrls.length) + localVideoUrls.length) % localVideoUrls.length;
            localVideoPlayerEl.src = localVideoUrls[currentVideoIndex];
            localVideoPlayerEl.load();
            applyYoutubeAudioPolicy();
            updateLocalVideoCounter();

            const playPromise = localVideoPlayerEl.play();
            if (playPromise && typeof playPromise.catch === 'function') {
                playPromise.catch(() => {
                    showAudioUnlock();
                });
            }
        }

        function playNextLocalVideo() {
            if (localVideoUrls.length === 0) {
                return;
            }
            const nextIndex = (currentVideoIndex + 1) % localVideoUrls.length;
            loadLocalVideoByIndex(nextIndex);
        }

        function initLocalVideoPlayer() {
            if (!localVideoPlayerEl || localVideoUrls.length === 0) {
                showLocalVideoPlaceholder(true);
                updateLocalVideoCounter();
                return;
            }

            showLocalVideoPlaceholder(false);
            updateLocalVideoCounter();

            localVideoPlayerEl.onended = playNextLocalVideo;
            localVideoPlayerEl.onerror = playNextLocalVideo;

            if (!localVideoPlayerEl.src) {
                loadLocalVideoByIndex(0);
            }
        }

        function applyLocalPlaylistUpdate(urls, signature) {
            const normalizedUrls = Array.isArray(urls)
                ? urls.filter((url) => typeof url === 'string' && url.trim().length > 0)
                : [];

            const incomingSignature = signature || JSON.stringify(normalizedUrls);
            if (incomingSignature === localVideoSignature) {
                return;
            }

            localVideoUrls = normalizedUrls;
            localVideoSignature = incomingSignature;
            currentVideoIndex = 0;

            if (localVideoUrls.length === 0) {
                if (localVideoPlayerEl) {
                    localVideoPlayerEl.pause();
                    localVideoPlayerEl.removeAttribute('src');
                    localVideoPlayerEl.load();
                }
                showLocalVideoPlaceholder(true);
                updateLocalVideoCounter();
                return;
            }

            showLocalVideoPlaceholder(false);
            loadLocalVideoByIndex(0);
        }

        function updateVideoCounter() {
            if (!videoCounterEl) {
                return;
            }

            if (playlistVideoIds.length > 1) {
                videoCounterEl.classList.remove('hidden');
                videoCounterEl.textContent = (currentVideoIndex + 1) + ' / ' + playlistVideoIds.length;
                return;
            }

            videoCounterEl.classList.add('hidden');
            videoCounterEl.textContent = playlistVideoIds.length > 0 ? '1 / 1' : '0 / 0';
        }

        function showVideoPlaceholder(show) {
            if (videoPlaceholderEl) {
                videoPlaceholderEl.classList.toggle('hidden', !show);
            }
            if (youtubePlayerEl) {
                youtubePlayerEl.classList.toggle('hidden', show);
            }
            if (youtubeFallbackEl && show) {
                youtubeFallbackEl.classList.add('hidden');
            }
        }

        function buildFallbackEmbedUrl(videoId) {
            const muteParam = (!audioUnlocked || announcementInProgress) ? '1' : '0';
            const fallbackPlaylist = playlistVideoIds.join(',');
            const playlistParam = fallbackPlaylist ? `&playlist=${encodeURIComponent(fallbackPlaylist)}` : '';
            return `https://www.youtube.com/embed/${videoId}?autoplay=1&mute=${muteParam}&playsinline=1&rel=0&modestbranding=1&controls=0&loop=0${playlistParam}`;
        }

        function stopFallbackRotation() {
            if (fallbackRotateTimer) {
                clearInterval(fallbackRotateTimer);
                fallbackRotateTimer = null;
            }
        }

        function stopPlaylistRotation() {
            if (playlistRotateTimer) {
                clearTimeout(playlistRotateTimer);
                playlistRotateTimer = null;
            }
        }

        function startPlaylistRotation() {
            stopPlaylistRotation();

            if (usingIframeFallback || playlistVideoIds.length <= 1 || ULTRA_KIOSK_PLAYLIST_ROTATE_MS <= 0) {
                return;
            }

            // Force sequential rotation if YouTube "ended" event is not emitted.
            playlistRotateTimer = setTimeout(() => {
                playNextVideo();
            }, ULTRA_KIOSK_PLAYLIST_ROTATE_MS);
        }

        function loadFallbackIframeByIndex(index) {
            if (!youtubeFallbackFrameEl || playlistVideoIds.length === 0) {
                return;
            }

            currentVideoIndex = index;
            updateVideoCounter();
            youtubeFallbackFrameEl.src = buildFallbackEmbedUrl(playlistVideoIds[currentVideoIndex]);
        }

        function startFallbackRotation() {
            stopFallbackRotation();
        }

        function activateIframeFallback(reason) {
            if (playlistVideoIds.length === 0) {
                return;
            }

            console.log('Activate iframe fallback:', reason);
            usingIframeFallback = true;

            if (youtubePlayerEl) {
                youtubePlayerEl.classList.add('hidden');
            }
            if (youtubeFallbackEl) {
                youtubeFallbackEl.classList.remove('hidden');
            }

            if (youtubePlayer && youtubePlayer.destroy) {
                try {
                    youtubePlayer.destroy();
                } catch (e) {
                    console.log('Destroy player before fallback failed:', e);
                }
            }
            youtubePlayer = null;

            loadFallbackIframeByIndex(currentVideoIndex || 0);
            startFallbackRotation();
        }

        function disableIframeFallback() {
            if (!usingIframeFallback) {
                return;
            }

            usingIframeFallback = false;
            stopFallbackRotation();

            if (youtubeFallbackEl) {
                youtubeFallbackEl.classList.add('hidden');
            }
            if (youtubeFallbackFrameEl) {
                youtubeFallbackFrameEl.src = 'about:blank';
            }
            if (youtubePlayerEl && playlistVideoIds.length > 0) {
                youtubePlayerEl.classList.remove('hidden');
            }

            youtubePlayerErrorCount = 0;
        }

        function loadVideoByIndex(index) {
            if (usingIframeFallback) {
                loadFallbackIframeByIndex(index);
                return;
            }

            if (!youtubePlayer || !youtubePlayer.loadVideoById || playlistVideoIds.length === 0) {
                return;
            }

            currentVideoIndex = index;
            updateVideoCounter();
            youtubePlayer.loadVideoById(playlistVideoIds[currentVideoIndex]);
            stopPlaylistRotation();
            setTimeout(ensureVideoAutoplay, 900);
        }

        function ensureVideoAutoplay() {
            if (usingIframeFallback) {
                return;
            }

            if (!youtubePlayer || !youtubePlayer.playVideo || playlistVideoIds.length === 0) {
                return;
            }

            const now = Date.now();
            if (now - lastEnsureAutoplayAt < 1800) {
                return;
            }
            lastEnsureAutoplayAt = now;

            // If already healthy, don't force play repeatedly.
            if (youtubePlayer.getPlayerState) {
                try {
                    const currentState = youtubePlayer.getPlayerState();
                    if (currentState === 1 || currentState === 3) {
                        return;
                    }
                } catch (e) {
                    // Ignore and continue with safe recovery call.
                }
            }

            try {
                // Start safely in muted mode, then restore desired audio policy.
                if (youtubePlayer.mute) youtubePlayer.mute();
                youtubePlayer.playVideo();
                setTimeout(applyYoutubeAudioPolicy, 120);

                // Verify a bit later; if still paused/cued/unstarted, count as failure.
                setTimeout(() => {
                    if (!youtubePlayer || !youtubePlayer.getPlayerState) {
                        return;
                    }

                    let state;
                    try {
                        state = youtubePlayer.getPlayerState();
                    } catch (e) {
                        return;
                    }

                    // 1=playing, 3=buffering are considered healthy.
                    if (state === 1 || state === 3) {
                        autoplayFailCount = 0;
                        return;
                    }

                    autoplayFailCount += 1;
                    if (autoplayFailCount >= 6) {
                        reloadYoutubePlayer('autoplay-check-failed');
                    }
                }, 1000);
            } catch (error) {
                console.log('Autoplay guard retry:', error);
                autoplayFailCount += 1;
                if (autoplayFailCount >= 6) {
                    reloadYoutubePlayer('autoplay-throw');
                }
            }
        }

        function startAutoplayGuard() {
            if (autoplayGuardTimer) {
                return;
            }

            autoplayGuardTimer = setInterval(() => {
                ensureVideoAutoplay();
            }, 3500);
        }

        function startKioskWatchdog() {
            if (kioskWatchdogTimer) {
                return;
            }

            kioskWatchdogTimer = setInterval(() => {
                if (usingIframeFallback) {
                    return;
                }

                if (!youtubePlayer || playlistVideoIds.length === 0) {
                    return;
                }

                // Grace period so player has time to initialize on slower devices/networks.
                if (Date.now() - playerBootAt < 20000) {
                    return;
                }

                const idleMs = Date.now() - lastPlayerStateAt;
                if (idleMs > 25000) {
                    reloadYoutubePlayer('state-timeout');
                    return;
                }

                // If player remains paused/cued too long, force recreate.
                if (lastPlayerState === 2 || lastPlayerState === 5 || lastPlayerState === -1) {
                    autoplayFailCount += 1;
                    if (autoplayFailCount >= 7) {
                        reloadYoutubePlayer('stuck-state');
                    }
                }

                // Do not repeatedly force audio policy here to avoid stutter.
            }, 5000);
        }

        function reloadYoutubePlayer(reason) {
            if (usingIframeFallback) {
                return;
            }

            if (!youtubeApiReady || !youtubePlayerEl || playlistVideoIds.length === 0) {
                return;
            }

            // Prevent rapid reload loops.
            if (Date.now() - lastReloadAt < 30000) {
                console.log('Skip reload (cooldown):', reason);
                return;
            }

            console.log('Reloading YouTube player:', reason);
            autoplayFailCount = 0;
            lastReloadAt = Date.now();

            if (youtubePlayer && youtubePlayer.destroy) {
                try {
                    youtubePlayer.destroy();
                } catch (e) {
                    console.log('Player destroy error:', e);
                }
            }

            youtubePlayer = null;
            lastPlayerStateAt = Date.now();
            lastPlayerState = null;
            playerBootAt = Date.now();

            setTimeout(() => {
                initYoutubePlayerIfNeeded();
                setTimeout(ensureVideoAutoplay, 900);
                setTimeout(applyYoutubeAudioPolicy, 1300);
            }, 300);
        }

        function playNextVideo() {
            if (playlistVideoIds.length === 0) {
                return;
            }

            stopPlaylistRotation();
            const nextIndex = (currentVideoIndex + 1) % playlistVideoIds.length;
            loadVideoByIndex(nextIndex);
        }

        function onPlayerReady(event) {
            disableIframeFallback();
            event.target.mute();
            if (playlistVideoIds.length > 1 && event.target.loadPlaylist) {
                event.target.loadPlaylist({
                    playlist: playlistVideoIds,
                    index: currentVideoIndex,
                    startSeconds: 0,
                });
            } else {
                event.target.playVideo();
            }
            updateVideoCounter();
            startPlaylistRotation();
            if (audioUnlocked) {
                hideAudioUnlock();
            } else {
                showAudioUnlock();
            }
            autoplayFailCount = 0;
            youtubePlayerErrorCount = 0;
            lastPlayerStateAt = Date.now();
            lastPlayerState = 1;
            playerBootAt = Date.now();
            applyYoutubeAudioPolicy();
            startAutoplayGuard();
            startKioskWatchdog();
        }

        function onPlayerStateChange(event) {
            lastPlayerStateAt = Date.now();
            lastPlayerState = event.data;

            if (event.data === 0) {
                autoplayFailCount = 0;
                playNextVideo();
                return;
            }

            if (event.data === 1 || event.data === 3) {
                autoplayFailCount = 0;
                applyYoutubeAudioPolicy();
                if (event.data === 1) {
                    startPlaylistRotation();
                }
            }

            // -1: unstarted, 2: paused, 5: video cued
            if (event.data === -1 || event.data === 2 || event.data === 5) {
                stopPlaylistRotation();
                setTimeout(ensureVideoAutoplay, 700);
            }
        }

        function onPlayerError(event) {
            console.error('YouTube Player Error:', event.data);
            youtubePlayerErrorCount += 1;
            autoplayFailCount += 1;

            // First few errors: try skip to next video first.
            if (playlistVideoIds.length > 1 && youtubePlayerErrorCount <= 3) {
                setTimeout(playNextVideo, 800);
                return;
            }

            if (autoplayFailCount >= 3 || youtubePlayerErrorCount >= 4) {
                activateIframeFallback('youtube-error-' + event.data);
                return;
            }
            setTimeout(playNextVideo, 1500);
        }

        function initYoutubePlayerIfNeeded() {
            if (usingIframeFallback) {
                return;
            }

            if (!youtubeApiReady || !youtubePlayerEl || playlistVideoIds.length === 0) {
                return;
            }

            showVideoPlaceholder(false);

            if (youtubePlayer && youtubePlayer.loadVideoById) {
                return;
            }

            playerBootAt = Date.now();

            youtubePlayer = new YT.Player('youtube-player', {
                videoId: playlistVideoIds[currentVideoIndex],
                playerVars: {
                    'autoplay': 1,
                    'mute': 1,
                    'controls': 0,
                    'disablekb': 1,
                    'fs': 0,
                    'iv_load_policy': 3,
                    'modestbranding': 1,
                    'rel': 0,
                    'showinfo': 0,
                    'playsinline': 1
                },
                events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange,
                    'onError': onPlayerError
                }
            });
        }

        function requestYoutubeApi() {
            if (youtubeApiRequested) {
                return;
            }

            youtubeApiRequested = true;
            const tag = document.createElement('script');
            tag.src = 'https://www.youtube.com/iframe_api';
            const firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            youtubeApiStartupTimer = setTimeout(() => {
                if (!youtubeApiReady || !youtubePlayer) {
                    activateIframeFallback('api-startup-timeout');
                }
            }, 12000);

            window.onYouTubeIframeAPIReady = function() {
                youtubeApiReady = true;
                if (youtubeApiStartupTimer) {
                    clearTimeout(youtubeApiStartupTimer);
                    youtubeApiStartupTimer = null;
                }
                initYoutubePlayerIfNeeded();
            };
        }

        function applyPlaylistUpdate(videoIds, signature) {
            const normalizedIds = Array.isArray(videoIds)
                ? videoIds.filter((id) => typeof id === 'string' && id.trim().length === 11)
                : [];

            const incomingSignature = signature || normalizedIds.join('|');

            if (incomingSignature === playlistSignature) {
                return;
            }

            playlistVideoIds = normalizedIds;
            playlistSignature = incomingSignature;
            currentVideoIndex = 0;
            updateVideoCounter();

            if (playlistVideoIds.length === 0) {
                showVideoPlaceholder(true);
                disableIframeFallback();
                stopPlaylistRotation();
                if (youtubePlayer && youtubePlayer.stopVideo) {
                    youtubePlayer.stopVideo();
                }
                autoplayFailCount = 0;
                return;
            }

            showVideoPlaceholder(false);

            if (usingIframeFallback) {
                loadFallbackIframeByIndex(0);
                return;
            }

            requestYoutubeApi();

            if (youtubePlayer && youtubePlayer.loadVideoById) {
                loadVideoByIndex(0);
                return;
            }

            initYoutubePlayerIfNeeded();
        }

        async function refreshDisplay() {
            try {
                const response = await fetch('{{ route('queue.display.data') }}', { cache: 'no-store' });
                const data = await response.json();

                if (data.current) {
                    currentQueueEl.textContent = data.current.queue_number || '---';
                    currentNameEl.textContent = data.current.patient_name || '-';
                    currentServiceEl.textContent = data.current.service_type || '-';

                    const currentId = String(data.current.id);
                    if (lastAnnouncedQueueId !== currentId) {
                        lastAnnouncedQueueId = currentId;
                        localStorage.setItem('last_announced_queue_id', currentId);
                        announceQueue(
                            data.current.queue_number || '---',
                            data.current.patient_name || 'Pasien',
                            data.current.service_type || 'layanan terkait'
                        );
                    }
                } else {
                    currentQueueEl.textContent = '---';
                    currentNameEl.textContent = '-';
                    currentServiceEl.textContent = '-';
                }

                renderWaiting(data.waiting || []);
                applyLocalPlaylistUpdate(data.local_video_urls || [], data.local_video_signature || '');
            } catch (error) {
                console.error('Gagal memperbarui display antrian:', error);
            }
        }

        // Generate Background Particles for Loading
        (function() {
            const particlesContainer = document.getElementById('particles');
            if (!particlesContainer) return;
            const colors = ['#356d35', '#0d3a58', '#ffde17', 'rgba(255,255,255,0.3)'];
            for (let i = 0; i < 40; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                const size = Math.random() * 5 + 1;
                particle.style.cssText = `width:${size}px;height:${size}px;left:${Math.random()*100}%;background:${colors[Math.floor(Math.random()*colors.length)]};animation-duration:${Math.random()*10+8}s;animation-delay:${Math.random()*10}s;`;
                particlesContainer.appendChild(particle);
            }
            
            // Animated Loading Text
            const loadingTextEl = document.getElementById('loadingText');
            if (loadingTextEl) {
                'LOADING'.split('').forEach((char, i) => {
                    const span = document.createElement('span');
                    span.textContent = char;
                    span.style.animationDelay = `${i * 0.15}s`;
                    loadingTextEl.appendChild(span);
                });
            }
            
            // Percentage Counter
            const percentageEl = document.getElementById('percentage');
            if (percentageEl) {
                let progress = 0;
                const targetSpeeds = [{target:30,speed:50},{target:55,speed:100},{target:70,speed:35},{target:85,speed:120},{target:95,speed:70},{target:100,speed:150}];
                let currentPhase = 0;
                function animatePercentage() {
                    if (window.__stopLoadingAnimations) {
                        return;
                    }
                    if (currentPhase >= targetSpeeds.length) { progress = 0; currentPhase = 0; setTimeout(animatePercentage, 600); return; }
                    const { target, speed } = targetSpeeds[currentPhase];
                    if (progress < target) { progress++; percentageEl.textContent = `${progress}%`; setTimeout(animatePercentage, speed); }
                    else { currentPhase++; setTimeout(animatePercentage, Math.random() * 300 + 80); }
                }
                animatePercentage();
            }
        })();

        // Loading page fade out
        window.addEventListener('load', function() {
            setTimeout(function() {
                const loadingOverlay = document.getElementById('loading-overlay');
                if (loadingOverlay) {
                    loadingOverlay.classList.add('fade-out');
                }

                window.__stopLoadingAnimations = true;

                // Switch to low-GPU rendering once page is fully ready.
                document.body.classList.add('low-gpu');

                // Remove heavy loading DOM after transition to free memory/GPU resources.
                setTimeout(() => {
                    if (loadingOverlay && loadingOverlay.parentNode) {
                        loadingOverlay.parentNode.removeChild(loadingOverlay);
                    }
                }, 900);
            }, 2000);
        });

        refreshDisplay();
        setInterval(refreshDisplay, 3500);

        unlockAudioBtn?.addEventListener('click', unlockAudio);

        const handleFirstOperatorInteraction = () => {
            requestFullscreenOnce();
            if (!audioUnlocked) {
                unlockAudio();
            }
        };

        document.addEventListener('click', handleFirstOperatorInteraction, { once: true });
        document.addEventListener('touchstart', handleFirstOperatorInteraction, { once: true });

        if (ULTRA_KIOSK_REFRESH_MINUTES > 0) {
            setInterval(() => {
                window.location.reload();
            }, ULTRA_KIOSK_REFRESH_MINUTES * 60 * 1000);
        }

        // ======== YOUTUBE PLAYLIST PLAYER ========
        (function() {
            initLocalVideoPlayer();
            if (localVideoUrls.length > 0) {
                loadLocalVideoByIndex(0);
            }
        })();
    </script>

</body>
</html>