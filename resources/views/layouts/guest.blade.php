<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ANTROPUSMA.COM') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .loading-overlay {
                position: fixed;
                inset: 0;
                z-index: 9999;
                display: flex;
                justify-content: center;
                align-items: center;
                overflow: hidden;
                background: linear-gradient(135deg, #0a0a2e 0%, #0d1b3e 30%, #0a2a1a 70%, #0a0a2e 100%);
                background-size: 400% 400%;
                animation: gradientShift 8s ease infinite;
                transition: opacity 0.6s ease, visibility 0.6s ease;
            }
            .loading-overlay.fade-out {
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
            }

            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            .particles {
                position: fixed;
                inset: 0;
                pointer-events: none;
                z-index: 0;
            }

            .particle {
                position: absolute;
                border-radius: 50%;
                animation: floatParticle linear infinite;
                opacity: 0;
            }

            @keyframes floatParticle {
                0% { transform: translateY(100vh) scale(0); opacity: 0; }
                10% { opacity: 1; }
                90% { opacity: 1; }
                100% { transform: translateY(-10vh) scale(1); opacity: 0; }
            }

            .loading-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 40px;
                z-index: 10;
                position: relative;
            }

            .flipcard-wrapper {
                perspective: 1200px;
                width: 280px;
                height: 280px;
            }

            .flipcard {
                width: 100%;
                height: 100%;
                position: relative;
                transform-style: preserve-3d;
                animation: flipSpin 3s ease-in-out infinite;
            }

            @keyframes flipSpin {
                0% { transform: rotateY(0deg) rotateX(0deg); }
                25% { transform: rotateY(180deg) rotateX(10deg); }
                50% { transform: rotateY(360deg) rotateX(0deg); }
                75% { transform: rotateY(540deg) rotateX(-10deg); }
                100% { transform: rotateY(720deg) rotateX(0deg); }
            }

            .flipcard-face {
                position: absolute;
                width: 100%;
                height: 100%;
                backface-visibility: hidden;
                border-radius: 24px;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 30px;
                box-shadow:
                    0 0 40px rgba(0, 100, 255, 0.3),
                    0 0 80px rgba(0, 200, 100, 0.15),
                    inset 0 0 30px rgba(255, 255, 255, 0.05);
            }

            .flipcard-front {
                background: linear-gradient(145deg, rgba(10, 30, 80, 0.9), rgba(10, 60, 40, 0.9));
                border: 2px solid rgba(0, 150, 255, 0.3);
            }

            .flipcard-back {
                background: linear-gradient(145deg, rgba(10, 60, 40, 0.9), rgba(10, 30, 80, 0.9));
                border: 2px solid rgba(0, 200, 100, 0.3);
                transform: rotateY(180deg);
            }

            .flipcard-front img {
                width: 200px;
                height: auto;
                filter: drop-shadow(0 0 20px rgba(0, 100, 255, 0.5));
                animation: logoPulse 2s ease-in-out infinite;
            }

            .flipcard-back .back-content {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }

            .flipcard-back .logo-initials {
                font-size: 72px;
                font-weight: 900;
                background: linear-gradient(135deg, #0066ff, #00cc66);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                filter: drop-shadow(0 0 15px rgba(0, 100, 255, 0.4));
                letter-spacing: 5px;
            }

            .flipcard-back .tagline {
                color: rgba(255, 255, 255, 0.6);
                font-size: 12px;
                letter-spacing: 4px;
                text-transform: uppercase;
            }

            @keyframes logoPulse {
                0%, 100% { filter: drop-shadow(0 0 20px rgba(0, 100, 255, 0.5)); transform: scale(1); }
                50% { filter: drop-shadow(0 0 35px rgba(0, 200, 100, 0.6)); transform: scale(1.05); }
            }

            .glow-ring {
                position: absolute;
                width: 320px;
                height: 320px;
                border-radius: 50%;
                border: 2px solid transparent;
                animation: ringRotate 4s linear infinite;
                pointer-events: none;
            }

            .glow-ring::before {
                content: '';
                position: absolute;
                top: -2px;
                left: -2px;
                right: -2px;
                bottom: -2px;
                border-radius: 50%;
                background: conic-gradient(
                    from 0deg,
                    transparent 0%,
                    #0066ff 25%,
                    transparent 50%,
                    #00cc66 75%,
                    transparent 100%
                );
                mask: radial-gradient(farthest-side, transparent calc(100% - 3px), #fff calc(100% - 2px));
                -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 3px), #fff calc(100% - 2px));
            }

            @keyframes ringRotate {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }

            .brand-name {
                font-size: 32px;
                font-weight: 300;
                letter-spacing: 15px;
                text-transform: uppercase;
                background: linear-gradient(90deg, #0066ff, #00aaff, #00cc66, #00ff88, #0066ff);
                background-size: 200% auto;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                animation: shimmerText 3s linear infinite;
            }

            @keyframes shimmerText {
                0% { background-position: 0% center; }
                100% { background-position: 200% center; }
            }

            .loading-bar-container {
                width: 300px;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 12px;
            }

            .loading-bar-track {
                width: 100%;
                height: 4px;
                background: rgba(255, 255, 255, 0.08);
                border-radius: 4px;
                overflow: hidden;
                position: relative;
            }

            .loading-bar-fill {
                height: 100%;
                width: 0%;
                border-radius: 4px;
                background: linear-gradient(90deg, #0066ff, #00cc66);
                box-shadow: 0 0 15px rgba(0, 150, 255, 0.5);
                animation: loadProgress 4s ease-in-out infinite;
                position: relative;
            }

            .loading-bar-fill::after {
                content: '';
                position: absolute;
                right: 0;
                top: -3px;
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background: #00ff88;
                box-shadow: 0 0 15px #00ff88, 0 0 30px #00ff88;
            }

            @keyframes loadProgress {
                0% { width: 0%; }
                50% { width: 100%; }
                51% { width: 100%; opacity: 1; }
                52% { opacity: 0; width: 0%; }
                53% { opacity: 1; }
                100% { width: 100%; }
            }

            .loading-text {
                color: rgba(255, 255, 255, 0.5);
                font-size: 13px;
                letter-spacing: 6px;
                text-transform: uppercase;
                animation: textBlink 1.5s ease-in-out infinite;
            }

            @keyframes textBlink {
                0%, 100% { opacity: 0.5; }
                50% { opacity: 1; }
            }

            .loading-percentage {
                color: rgba(255, 255, 255, 0.7);
                font-size: 14px;
                font-weight: 600;
                letter-spacing: 2px;
                font-variant-numeric: tabular-nums;
            }

            .orb {
                position: fixed;
                border-radius: 50%;
                filter: blur(80px);
                opacity: 0.15;
                z-index: 1;
            }

            .orb-1 {
                width: 400px;
                height: 400px;
                background: #0066ff;
                top: -100px;
                left: -100px;
                animation: orbFloat1 6s ease-in-out infinite;
            }

            .orb-2 {
                width: 350px;
                height: 350px;
                background: #00cc66;
                bottom: -80px;
                right: -80px;
                animation: orbFloat2 7s ease-in-out infinite;
            }

            .orb-3 {
                width: 250px;
                height: 250px;
                background: #00aaff;
                top: 50%;
                right: 10%;
                animation: orbFloat3 5s ease-in-out infinite;
            }

            @keyframes orbFloat1 {
                0%, 100% { transform: translate(0, 0); }
                50% { transform: translate(80px, 60px); }
            }

            @keyframes orbFloat2 {
                0%, 100% { transform: translate(0, 0); }
                50% { transform: translate(-60px, -80px); }
            }

            @keyframes orbFloat3 {
                0%, 100% { transform: translate(0, 0); }
                50% { transform: translate(-40px, 50px); }
            }

            @media (max-width: 480px) {
                .flipcard-wrapper {
                    width: 160px;
                    height: 160px;
                }

                .glow-ring {
                    width: 200px;
                    height: 200px;
                }

                .flipcard-front img {
                    width: 110px;
                }

                .flipcard-back .logo-initials {
                    font-size: 40px;
                }

                .brand-name {
                    font-size: 18px;
                    letter-spacing: 8px;
                }

                .loading-bar-container {
                    width: 200px;
                }

                .loading-container {
                    gap: 24px;
                }
            }
        </style>

        {{-- Dark mode anti-FOUC --}}
        <script>
            (function () {
                var theme = localStorage.getItem('theme');
                if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
    </head>
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased transition-colors duration-300">
        {{-- Loading Page --}}
        <div id="loading-overlay" class="loading-overlay">
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <div class="orb orb-3"></div>

            <div class="particles" id="particles"></div>

            <div class="loading-container">
                <div style="position: relative; display: flex; justify-content: center; align-items: center;">
                    <div class="glow-ring"></div>
                    <div class="flipcard-wrapper">
                        <div class="flipcard">
                            <div class="flipcard-face flipcard-front">
                                <img src="{{ asset('images/loadingpage.png') }}" alt="ANTROPUSMA Logo">
                            </div>

                            <div class="flipcard-face flipcard-back">
                                <div class="back-content">
                                    <div class="logo-initials">AP</div>
                                    <div class="tagline">Innovation &bull; Excellence</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="brand-name">Antropusma</div>

                <div class="loading-bar-container">
                    <div class="loading-bar-track">
                        <div class="loading-bar-fill" id="loadingFill"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; width: 100%;">
                        <span class="loading-text">Memuat</span>
                        <span class="loading-percentage" id="loadingPercent">0%</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content with Background Image --}}
           <div class="min-h-screen flex flex-col justify-start sm:justify-center items-center px-3 sm:px-4 pt-4 pb-6 sm:py-0 relative"
               style="background-image: url('/images/bglogin.png'); background-position: center; background-size: cover; background-repeat: no-repeat; background-attachment: fixed;">
            {{-- Overlay gradient --}}
            <div class="absolute inset-0 bg-gradient-to-br from-green-900/70 via-green-700/50 to-yellow-600/40"></div>
            
            {{-- Animated particles --}}
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full blur-xl animate-pulse"></div>
                <div class="absolute top-1/4 right-20 w-32 h-32 bg-green-300/10 rounded-full blur-2xl animate-pulse" style="animation-delay: 1s;"></div>
                <div class="absolute bottom-20 left-1/4 w-24 h-24 bg-yellow-300/10 rounded-full blur-xl animate-pulse" style="animation-delay: 2s;"></div>
            </div>

            <div class="relative z-10 flex flex-col items-center w-full max-w-md">
                {{-- Logo --}}
                <div class="mb-2 sm:mb-6 animate-bounce" style="animation-duration: 3s;">
                    <img src="{{ asset('images/loadingpage.png') }}" alt="Logo Puskesmas" 
                         class="w-12 sm:w-24 h-auto max-h-12 sm:max-h-24 object-contain">
                </div>
                
                <a href="/" class="text-white text-lg sm:text-2xl font-extrabold tracking-tight drop-shadow-lg mb-3 sm:mb-6 hover:scale-105 transition-transform duration-300">
                    AntroPusma.com
                </a>

                <div class="w-full bg-white/95 dark:bg-gray-900/95 backdrop-blur-md shadow-2xl rounded-2xl p-4 sm:p-6 border border-white/30 dark:border-gray-700/50">
                    @isset($slot)
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endisset
                </div>
            </div>
        </div>

        <script>
            (function () {
                const particlesContainer = document.getElementById('particles');
                const percentEl = document.getElementById('loadingPercent');

                if (particlesContainer) {
                    const colors = ['#0066ff', '#00cc66', '#00aaff', '#00ff88', '#ffffff'];
                    for (let i = 0; i < 40; i++) {
                        const particle = document.createElement('div');
                        particle.classList.add('particle');

                        const size = Math.random() * 5 + 2;
                        const left = Math.random() * 100;
                        const duration = Math.random() * 8 + 6;
                        const delay = Math.random() * 10;
                        const color = colors[Math.floor(Math.random() * colors.length)];

                        particle.style.cssText =
                            'width:' + size + 'px;' +
                            'height:' + size + 'px;' +
                            'left:' + left + '%;' +
                            'background:' + color + ';' +
                            'box-shadow:0 0 ' + (size * 2) + 'px ' + color + ';' +
                            'animation-duration:' + duration + 's;' +
                            'animation-delay:' + delay + 's;';

                        particlesContainer.appendChild(particle);
                    }
                }

                if (percentEl) {
                    let progress = 0;
                    const updateProgress = function () {
                        progress += Math.random() * 3 + 0.5;

                        if (progress >= 100) {
                            progress = 100;
                            percentEl.textContent = '100%';
                            return;
                        }

                        percentEl.textContent = Math.floor(progress) + '%';
                        const delay = Math.random() * 80 + 30;
                        setTimeout(updateProgress, delay);
                    };

                    updateProgress();
                }

                window.addEventListener('load', function () {
                    setTimeout(function () {
                        const overlay = document.getElementById('loading-overlay');
                        if (overlay) {
                            overlay.classList.add('fade-out');
                        }
                    }, 1200);
                });
            })();
        </script>

        {{-- Dark mode floating toggle --}}
        <button onclick="toggleDarkMode()" aria-label="Toggle dark mode"
                class="theme-btn fixed top-4 right-4 z-[99999] p-2.5 rounded-xl bg-white/20 dark:bg-gray-800/60 backdrop-blur-sm border border-white/30 dark:border-gray-600 text-white dark:text-gray-200 hover:bg-white/30 dark:hover:bg-gray-700/80 transition-all duration-300 shadow-lg">
            {{-- sun (tampil saat dark) --}}
            <svg id="guest-icon-sun" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25M12 18.75V21M4.22 4.22l1.59 1.59M16.19 16.19l1.59 1.59M3 12h2.25M18.75 12H21M4.22 19.78l1.59-1.59M16.19 7.81l1.59-1.59M12 8a4 4 0 100 8 4 4 0 000-8z"/>
            </svg>
            {{-- moon (tampil saat light) --}}
            <svg id="guest-icon-moon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z"/>
            </svg>
        </button>

        {{-- Dark mode toggle script --}}
        <script>
            function toggleDarkMode() {
                var html = document.documentElement;
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
                updateGuestThemeIcons();
            }

            function updateGuestThemeIcons() {
                var isDark = document.documentElement.classList.contains('dark');
                var sun = document.getElementById('guest-icon-sun');
                var moon = document.getElementById('guest-icon-moon');
                if (sun && moon) {
                    sun.classList.toggle('hidden', !isDark);
                    moon.classList.toggle('hidden', isDark);
                }
            }

            document.addEventListener('DOMContentLoaded', updateGuestThemeIcons);
        </script>
    </body>
</html>
