<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ANTROPUSMA — Sistem Antrian Online Puskesmas Mapurujaya</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ============================
           RESET & BASE
        ============================ */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Figtree', sans-serif;
            color: #1a2e1a;
            overflow-x: hidden;
            background: #f0faf0;
        }

        /* ============================
           ANIMATED BACKGROUND
        ============================ */
        .hero-bg {
            position: relative;
            min-height: 100vh;
            background: linear-gradient(135deg,
                #005c2f 0%,
                #007a40 18%,
                #00a854 35%,
                #00875a 50%,
                #006644 65%,
                #004d33 80%,
                #003322 100%);
            overflow: hidden;
        }

        /* Floating blob shapes */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.25;
            pointer-events: none;
        }
        .blob-1 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, #00ff88, #00cc66);
            top: -150px; left: -150px;
            animation: blobDrift1 12s ease-in-out infinite;
        }
        .blob-2 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #00ddff, #0099cc);
            top: 30%; right: -120px;
            animation: blobDrift2 10s ease-in-out infinite;
        }
        .blob-3 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, #aaff44, #66cc00);
            bottom: -100px; left: 40%;
            animation: blobDrift3 14s ease-in-out infinite;
        }
        .blob-4 {
            width: 300px; height: 300px;
            background: radial-gradient(circle, #ffffff, #e0ffe8);
            top: 60%; left: 10%;
            animation: blobDrift1 9s ease-in-out infinite reverse;
            opacity: 0.1;
        }

        @keyframes blobDrift1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(80px, 60px) scale(1.1); }
            66% { transform: translate(-40px, 100px) scale(0.95); }
        }
        @keyframes blobDrift2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(-70px, 80px) scale(1.05); }
            66% { transform: translate(50px, -60px) scale(1.1); }
        }
        @keyframes blobDrift3 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-80px, -60px) scale(1.15); }
        }

        /* DNA helix decorative lines */
        .grid-lines {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        /* Floating medical cross icons */
        .float-icon {
            position: absolute;
            opacity: 0.08;
            animation: floatUp linear infinite;
            pointer-events: none;
        }
        @keyframes floatUp {
            0% { transform: translateY(110vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.08; }
            90% { opacity: 0.08; }
            100% { transform: translateY(-10vh) rotate(180deg); opacity: 0; }
        }

        /* ============================
           NAVBAR
        ============================ */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 40px;
            background: rgba(0, 50, 25, 0.5);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            transition: all 0.3s ease;
        }
        .navbar.scrolled {
            background: rgba(0, 50, 25, 0.85);
            padding: 10px 40px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.3);
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .nav-logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #00ff88, #00cc66);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 15px rgba(0,255,136,0.4);
        }
        .nav-logo-text {
            font-weight: 800;
            font-size: 20px;
            color: #fff;
            letter-spacing: 1px;
        }
        .nav-logo-text span { color: #00ff88; }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .nav-btn {
            padding: 9px 22px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            letter-spacing: 0.3px;
        }
        .nav-btn-ghost {
            color: rgba(255,255,255,0.85);
            border: 1px solid rgba(255,255,255,0.25);
        }
        .nav-btn-ghost:hover {
            background: rgba(255,255,255,0.12);
            color: #fff;
            border-color: rgba(255,255,255,0.5);
        }
        .nav-btn-primary {
            background: linear-gradient(135deg, #00ff88, #00cc66);
            color: #003322;
            border: none;
        }
        .nav-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0,255,136,0.45);
        }

        /* ============================
           HERO SECTION
        ============================ */
        .hero-content {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 120px 24px 60px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(0,255,136,0.12);
            border: 1px solid rgba(0,255,136,0.3);
            color: #00ff88;
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 28px;
            animation: fadeInDown 0.8s ease both;
        }
        .hero-badge::before {
            content: '';
            width: 8px; height: 8px;
            border-radius: 50%;
            background: #00ff88;
            box-shadow: 0 0 8px #00ff88;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.4); opacity: 0.6; }
        }

        .hero-title {
            font-size: clamp(2.4rem, 6vw, 5rem);
            font-weight: 900;
            line-height: 1.1;
            color: #fff;
            margin-bottom: 12px;
            animation: fadeInDown 0.9s ease 0.1s both;
            text-shadow: 0 4px 30px rgba(0,0,0,0.3);
        }
        .hero-title .accent {
            background: linear-gradient(90deg, #00ff88, #00ddff, #aaff44);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: clamp(1rem, 2vw, 1.35rem);
            color: rgba(255,255,255,0.75);
            max-width: 580px;
            line-height: 1.7;
            margin-bottom: 48px;
            animation: fadeInDown 1s ease 0.2s both;
        }

        .hero-cta {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeInUp 1s ease 0.35s both;
            margin-bottom: 72px;
        }
        .cta-main {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #00ff88, #00cc66);
            color: #002a18;
            padding: 16px 36px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 8px 32px rgba(0,255,136,0.4);
            transition: all 0.25s ease;
        }
        .cta-main:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 40px rgba(0,255,136,0.55);
        }
        .cta-outline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.08);
            color: #fff;
            padding: 16px 36px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            text-decoration: none;
            border: 1.5px solid rgba(255,255,255,0.3);
            backdrop-filter: blur(10px);
            transition: all 0.25s ease;
        }
        .cta-outline:hover {
            background: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.6);
            transform: translateY(-2px);
        }

        /* Hero stat chips */
        .hero-stats {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            animation: fadeInUp 1s ease 0.5s both;
        }
        .stat-chip {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 16px 28px;
            text-align: center;
            min-width: 120px;
        }
        .stat-chip .num {
            font-size: 28px;
            font-weight: 800;
            color: #00ff88;
            line-height: 1;
            display: block;
        }
        .stat-chip .lbl {
            font-size: 12px;
            color: rgba(255,255,255,0.6);
            margin-top: 4px;
            letter-spacing: 0.5px;
        }

        /* Scroll chevron */
        .scroll-cue {
            position: absolute;
            bottom: 32px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            animation: scrollBounce 2s ease-in-out infinite;
            color: rgba(255,255,255,0.5);
            font-size: 24px;
            cursor: pointer;
            text-decoration: none;
        }
        @keyframes scrollBounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(10px); }
        }

        /* ============================
           WAVY DIVIDER
        ============================ */
        .wave-divider {
            line-height: 0;
            overflow: hidden;
            margin-top: -2px;
        }
        .wave-divider svg { display: block; width: 100%; }

        /* ============================
           LAYANAN SECTION
        ============================ */
        .section {
            padding: 90px 24px;
        }
        .section-center {
            max-width: 1100px;
            margin: 0 auto;
        }
        .section-tag {
            display: inline-block;
            background: linear-gradient(135deg, #e6fff2, #ccffdd);
            color: #006633;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 6px 18px;
            border-radius: 50px;
            margin-bottom: 14px;
        }
        .section-title {
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            font-weight: 800;
            color: #003322;
            line-height: 1.2;
            margin-bottom: 14px;
        }
        .section-desc {
            font-size: 16px;
            color: #4d7a5e;
            max-width: 560px;
            line-height: 1.7;
        }

        /* Layanan cards */
        .layanan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
            margin-top: 52px;
        }
        .layanan-card {
            position: relative;
            background: #fff;
            border-radius: 24px;
            padding: 36px 28px;
            box-shadow: 0 4px 30px rgba(0, 80, 40, 0.08);
            border: 1px solid rgba(0, 150, 80, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .layanan-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: var(--card-accent, linear-gradient(90deg, #00cc66, #00ff88));
        }
        .layanan-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 48px rgba(0, 80, 40, 0.15);
        }
        .layanan-icon {
            width: 62px; height: 62px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 20px;
            background: var(--icon-bg, linear-gradient(135deg, #e6fff2, #ccffdd));
        }
        .layanan-card h3 {
            font-size: 18px;
            font-weight: 700;
            color: #003322;
            margin-bottom: 10px;
        }
        .layanan-card p {
            font-size: 14px;
            color: #5a7a6a;
            line-height: 1.7;
        }

        /* ============================
           HOW IT WORKS
        ============================ */
        .steps-bg {
            background: linear-gradient(135deg, #003322 0%, #005533 50%, #003322 100%);
            position: relative;
            overflow: hidden;
        }
        .steps-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0;
            margin-top: 52px;
            position: relative;
        }
        .steps-grid::before {
            content: '';
            position: absolute;
            top: 38px;
            left: 10%;
            right: 10%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(0,255,136,0.4), transparent);
            z-index: 0;
        }
        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 20px 24px;
            position: relative;
            z-index: 1;
        }
        .step-num {
            width: 76px; height: 76px;
            border-radius: 50%;
            background: linear-gradient(135deg, #00ff88, #00cc66);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 900;
            color: #002a18;
            margin-bottom: 20px;
            box-shadow: 0 8px 30px rgba(0,255,136,0.35);
            position: relative;
        }
        .step-num::after {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 50%;
            border: 2px solid rgba(0,255,136,0.3);
        }
        .step-item h3 {
            font-size: 17px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
        }
        .step-item p {
            font-size: 13px;
            color: rgba(255,255,255,0.55);
            line-height: 1.6;
            max-width: 180px;
        }

        /* ============================
           INFO / FEATURES SECTION
        ============================ */
        .features-bg { background: #f0faf4; }
        .feature-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        @media (max-width: 768px) {
            .feature-split { grid-template-columns: 1fr; gap: 40px; }
            .navbar { padding: 12px 20px; }
            .nav-logo { gap: 8px; }
            .nav-logo img { height: 32px !important; }
            .nav-logo-text { font-size: 15px; letter-spacing: 0.5px; }
            .nav-links { gap: 6px; }
            .nav-btn { padding: 8px 14px; font-size: 12px; }
            .hero-content { padding: 108px 16px 48px; }
            .hero-cta {
                width: 100%;
                max-width: 340px;
                flex-direction: column;
                align-items: stretch;
            }
            .cta-main, .cta-outline { width: 100%; justify-content: center; }
            .hero-stats { gap: 10px; }
            .stat-chip { min-width: 140px; padding: 12px 16px; }
            .feature-card-stack { height: auto; }
            .f-card, .f-card-main {
                position: relative;
                top: auto;
                left: auto;
                width: 100%;
            }
            .f-card-behind1, .f-card-behind2 { display: none; }
            .galeri-grid { grid-template-columns: 1fr; gap: 16px; }
            .galeri-img { height: 210px; }
            .steps-grid::before { display: none; }
        }

        @media (max-width: 480px) {
            .navbar { padding: 10px 12px; }
            .nav-logo-text { display: none; }
            .nav-btn { padding: 7px 10px; font-size: 11px; }
            .section { padding: 72px 16px; }
            .hero-title { font-size: clamp(2rem, 11vw, 2.4rem); }
            .hero-subtitle { font-size: 0.94rem; }
            .stat-chip { min-width: calc(50% - 8px); }
        }

        .feature-visual {
            position: relative;
        }
        .feature-card-stack {
            position: relative;
            height: 360px;
        }
        .f-card {
            position: absolute;
            background: #fff;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 8px 40px rgba(0,80,40,0.12);
            border: 1px solid rgba(0,150,80,0.1);
        }
        .f-card-main {
            width: 100%;
            top: 0; left: 0;
            z-index: 3;
        }
        .f-card-behind1 {
            width: 90%;
            top: 12px;
            left: 5%;
            z-index: 2;
            opacity: 0.6;
            transform: scale(0.97);
        }
        .f-card-behind2 {
            width: 80%;
            top: 22px;
            left: 10%;
            z-index: 1;
            opacity: 0.3;
            transform: scale(0.94);
        }
        .f-card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        .f-avatar {
            width: 46px; height: 46px;
            border-radius: 14px;
            background: linear-gradient(135deg, #00cc66, #00ff88);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }
        .f-card-title { font-size: 16px; font-weight: 700; color: #003322; }
        .f-card-sub { font-size: 12px; color: #6a9a7a; }
        .f-token-display {
            background: linear-gradient(135deg, #003322, #005533);
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            color: #fff;
            margin-bottom: 16px;
        }
        .f-token-num {
            font-size: 52px;
            font-weight: 900;
            background: linear-gradient(90deg, #00ff88, #00ddff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
        }
        .f-token-label {
            font-size: 11px;
            color: rgba(255,255,255,0.5);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 4px;
        }
        .f-progress-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #4d7a5e;
            margin-bottom: 6px;
        }
        .f-progress-bar {
            height: 6px;
            background: #e0f0e8;
            border-radius: 4px;
            overflow: hidden;
        }
        .f-progress-fill {
            height: 100%;
            width: 65%;
            background: linear-gradient(90deg, #00cc66, #00ff88);
            border-radius: 4px;
        }

        .feature-list { list-style: none; margin-top: 32px; }
        .feature-list li {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 22px;
        }
        .feat-icon {
            width: 42px; height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 1px;
        }
        .feat-icon.green { background: #e6fff2; }
        .feat-icon.blue  { background: #e6f4ff; }
        .feat-icon.amber { background: #fff8e6; }
        .feat-icon.rose  { background: #fff0f0; }
        .feature-list .feat-title { font-size: 15px; font-weight: 700; color: #00331a; margin-bottom: 3px; }
        .feature-list .feat-desc  { font-size: 13px; color: #5a7a6a; line-height: 1.6; }

        /* ============================
           HEALTH TIPS TICKER
        ============================ */
        .ticker-bar {
            background: linear-gradient(90deg, #00cc66, #00aa55);
            padding: 12px 0;
            overflow: hidden;
            white-space: nowrap;
        }
        .ticker-track {
            display: inline-flex;
            animation: ticker 40s linear infinite;
            gap: 0;
        }
        .ticker-track:hover { animation-play-state: paused; }
        @keyframes ticker {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .ticker-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            padding: 0 40px;
        }
        .ticker-dot {
            width: 6px; height: 6px;
            border-radius: 50%;
            background: rgba(255,255,255,0.5);
        }

        /* ============================
           CTA SECTION
        ============================ */
        .cta-section {
            background: linear-gradient(135deg, #004d2a 0%, #006633 50%, #003a1f 100%);
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 30% 50%, rgba(0,255,136,0.1) 0%, transparent 70%),
                        radial-gradient(ellipse at 70% 50%, rgba(0,200,255,0.08) 0%, transparent 70%);
        }
        .cta-inner {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
        }
        .cta-title {
            font-size: clamp(1.8rem, 4vw, 3rem);
            font-weight: 900;
            color: #fff;
            margin-bottom: 16px;
            line-height: 1.2;
        }
        .cta-desc {
            font-size: 17px;
            color: rgba(255,255,255,0.7);
            margin-bottom: 40px;
            line-height: 1.7;
        }
        .cta-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 32px;
        }
        .cta-btn-big {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 18px 44px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            letter-spacing: 0.3px;
        }
        .cta-btn-big.primary {
            background: linear-gradient(135deg, #00ff88, #00cc66);
            color: #002a18;
            box-shadow: 0 8px 32px rgba(0,255,136,0.4);
        }
        .cta-btn-big.primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 48px rgba(0,255,136,0.55);
        }
        .cta-btn-big.secondary {
            background: rgba(255,255,255,0.1);
            color: #fff;
            border: 1.5px solid rgba(255,255,255,0.3);
            backdrop-filter: blur(10px);
        }
        .cta-btn-big.secondary:hover {
            background: rgba(255,255,255,0.18);
        }
        .cta-staff-link {
            color: rgba(255,255,255,0.5);
            font-size: 14px;
            text-decoration: none;
            transition: color 0.2s;
        }
        .cta-staff-link:hover { color: rgba(255,255,255,0.85); }
        .cta-staff-link span { color: #00ff88; font-weight: 600; }

        /* ============================
           GALERI SECTION
        ============================ */
        .galeri-bg { background: #f0faf4; }
        .galeri-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 28px;
            margin-top: 52px;
        }
        .galeri-item {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 4px 30px rgba(0, 80, 40, 0.08);
            border: 1px solid rgba(0, 150, 80, 0.1);
            transition: all 0.3s ease;
        }
        .galeri-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 48px rgba(0, 80, 40, 0.15);
        }
        .galeri-img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            display: block;
        }
        .galeri-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 204, 102, 0.15), rgba(0, 255, 136, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .galeri-item:hover .galeri-overlay {
            opacity: 1;
        }
        .galeri-icon {
            width: 56px; height: 56px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            box-shadow: 0 8px 24px rgba(0, 255, 136, 0.3);
        }
        .galeri-info {
            padding: 20px;
        }
        .galeri-title {
            font-size: 16px;
            font-weight: 700;
            color: #003322;
            margin-bottom: 6px;
        }
        .galeri-desc {
            font-size: 13px;
            color: #5a7a6a;
            line-height: 1.6;
        }

        /* ============================
           FOOTER
        ============================ */
        .footer {
            background: #001a0d;
            padding: 48px 24px 24px;
        }
        .footer-inner {
            max-width: 1100px;
            margin: 0 auto;
        }
        .footer-top {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 48px;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        @media (max-width: 768px) {
            .footer-top { grid-template-columns: 1fr; gap: 32px; }
            .feature-split { grid-template-columns: 1fr; }
        }
        .footer-brand p {
            font-size: 13px;
            color: rgba(255,255,255,0.4);
            line-height: 1.7;
            margin-top: 12px;
            max-width: 280px;
        }
        .footer-col h4 {
            font-size: 13px;
            font-weight: 700;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
        }
        .footer-col a {
            display: block;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 10px;
            transition: color 0.2s;
        }
        .footer-col a:hover { color: #00ff88; }
        .footer-bottom {
            padding-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: gap;
            gap: 10px;
        }
        .footer-bottom p {
            font-size: 12px;
            color: rgba(255,255,255,0.3);
        }
        .footer-bottom p span { color: rgba(255,255,255,0.5); }

        /* ============================
           ANIMATIONS
        ============================ */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .delay-1 { transition-delay: 0.1s !important; }
        .delay-2 { transition-delay: 0.2s !important; }
        .delay-3 { transition-delay: 0.3s !important; }
        .delay-4 { transition-delay: 0.4s !important; }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar" id="navbar">
        <a href="/" class="nav-logo">
            <img src="{{ asset('images/kampusnavlogo.png') }}" alt="AntroPusma Logo" style="height: 40px; object-fit: contain;">
            <img src="{{ asset('images/navlogo.png') }}" alt="AntroPusma Logo" style="height: 40px; object-fit: contain;">
            <span class="nav-logo-text">ANTRO<span>PUSMA</span></span>
        </a>
        <div class="nav-links">
            <a href="{{ route('login') }}" class="nav-btn nav-btn-ghost">Masuk</a>
            <a href="{{ route('register') }}" class="nav-btn nav-btn-primary">Daftar Sekarang</a>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="hero-bg" id="hero">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
        <div class="blob blob-4"></div>
        <div class="grid-lines"></div>

        {{-- Floating icons --}}
        <div id="floatIcons"></div>

        <div class="hero-content">
            <div class="hero-badge">Sistem Informasi Kesehatan Digital</div>

            <h1 class="hero-title">
                Pelayanan Kesehatan<br>
                <span class="accent">Lebih Mudah &amp; Cepat</span>
            </h1>

            <p class="hero-subtitle">
                Amolongo nimaowitimi saipa, hallo pace mace.
                Puskesmas Mapurujaya hadir dengan sistem antrian online cerdas.
                Daftar dari rumah, pantau antrianmu, dan dapatkan pelayanan tanpa menunggu lama.
            </p>

            <div class="hero-cta">
                <a href="{{ route('register') }}" class="cta-main">
                    <span>🩺</span> Daftar Antrian Sekarang
                </a>
                <a href="#layanan" class="cta-outline">
                    <span>📋</span> Lihat Layanan
                </a>
            </div>

            <div class="hero-stats">
                <div class="stat-chip">
                    <span class="num">10+</span>
                    <span class="lbl">Layanan Medis</span>
                </div>
                <div class="stat-chip">
                    <span class="num">24/7</span>
                    <span class="lbl">Info Real-time</span>
                </div>
                <div class="stat-chip">
                    <span class="num">QR</span>
                    <span class="lbl">Tiket Digital</span>
                </div>
                <div class="stat-chip">
                    <span class="num">100%</span>
                    <span class="lbl">Gratis</span>
                </div>
            </div>
        </div>

        <a href="#layanan" class="scroll-cue" aria-label="Scroll ke bawah">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none">
                <path d="M6 10l8 8 8-8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </section>

    {{-- WAVE DIVIDER --}}
    <div class="wave-divider" style="background:#005533;">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,80L120,68C240,56,480,32,720,26.7C960,21,1200,43,1320,53.3L1440,64L1440,0L1320,0C1200,0,960,0,720,0C480,0,240,0,120,0L0,0Z" fill="#005533"/>
            <path d="M0,80L80,72C160,64,320,48,480,42.7C640,37,800,43,960,48C1120,53,1280,56,1360,57.3L1440,58L1440,80L1360,80C1280,80,1120,80,960,80C800,80,640,80,480,80C320,80,160,80,80,80L0,80Z" fill="#f0faf4"/>
        </svg>
    </div>

    {{-- LAYANAN --}}
    <section class="section" id="layanan" style="background:#f0faf4;">
        <div class="section-center">
            <div style="text-align:center; margin-bottom:0;">
                <span class="section-tag reveal">🏥 Layanan Kami</span>
                <h2 class="section-title reveal delay-1">Layanan Kesehatan<br>Lengkap & Terpercaya</h2>
                <p class="section-desc reveal delay-2" style="margin: 0 auto;">
                    Kami menyediakan berbagai layanan kesehatan primer yang mudah diakses melalui sistem antrian digital terintegrasi.
                </p>
            </div>
            <div class="layanan-grid">
                <div class="layanan-card reveal" style="--card-accent: linear-gradient(90deg,#00cc66,#00ff88); --icon-bg: linear-gradient(135deg,#e6fff2,#ccffdd);">
                    <div class="layanan-icon">🩺</div>
                    <h3>Poli Umum</h3>
                    <p>Konsultasi dokter umum untuk pemeriksaan kesehatan dasar, diagnosis, dan rujukan sesuai kebutuhan pasien.</p>
                </div>
                <div class="layanan-card reveal delay-1" style="--card-accent: linear-gradient(90deg,#0099ff,#00ddff); --icon-bg: linear-gradient(135deg,#e6f4ff,#ccecff);">
                    <div class="layanan-icon" style="background: linear-gradient(135deg,#e6f4ff,#ccecff);">🤰</div>
                    <h3>KIA / Kebidanan</h3>
                    <p>Pelayanan kesehatan ibu dan anak termasuk pemeriksaan kehamilan, imunisasi, dan tumbuh kembang anak.</p>
                </div>
                <div class="layanan-card reveal delay-2" style="--card-accent: linear-gradient(90deg,#ff9900,#ffcc00); --icon-bg: linear-gradient(135deg,#fff8e6,#ffeecc);">
                    <div class="layanan-icon" style="background: linear-gradient(135deg,#fff8e6,#ffeecc);">💊</div>
                    <h3>Apotek / Farmasi</h3>
                    <p>Layanan pengambilan obat resep dokter dengan sistem antrian terpisah dan notifikasi saat obat siap diambil.</p>
                </div>
                <div class="layanan-card reveal delay-3" style="--card-accent: linear-gradient(90deg,#ff4466,#ff88aa); --icon-bg: linear-gradient(135deg,#fff0f3,#ffdddd);">
                    <div class="layanan-icon" style="background: linear-gradient(135deg,#fff0f3,#ffdddd);">🩸</div>
                    <h3>Laboratorium</h3>
                    <p>Pemeriksaan laboratorium klinik dasar dengan hasil yang akurat dan cepat sebagai penunjang diagnosis medis.</p>
                </div>
                <div class="layanan-card reveal" style="--card-accent: linear-gradient(90deg,#aa44ff,#cc88ff); --icon-bg: linear-gradient(135deg,#f5eeff,#eedrff);">
                    <div class="layanan-icon" style="background: linear-gradient(135deg,#f5eeff,#e8d8ff);">🦷</div>
                    <h3>Poli Gigi</h3>
                    <p>Perawatan gigi dan mulut oleh dokter gigi berpengalaman, mulai dari konsultasi hingga tindakan cabut dan tambal gigi.</p>
                </div>
                <div class="layanan-card reveal delay-1" style="--card-accent: linear-gradient(90deg,#00aa88,#00ddaa); --icon-bg: linear-gradient(135deg,#e6fff8,#ccffee);">
                    <div class="layanan-icon" style="background: linear-gradient(135deg,#e6fff8,#ccffee);">📋</div>
                    <h3>Rekam Medis</h3>
                    <p>Pengelolaan data rekam medis pasien yang aman, terintegrasi, dan dapat diakses secara digital oleh tenaga medis.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- HEALTH TIPS TICKER --}}
    <div class="ticker-bar">
        <div class="ticker-track" id="tickerTrack">
            <span class="ticker-item"><span class="ticker-dot"></span>💧 Minum 8 gelas air per hari untuk menjaga hidrasi tubuh</span>
            <span class="ticker-item"><span class="ticker-dot"></span>🏃 Olahraga 30 menit setiap hari untuk jantung yang sehat</span>
            <span class="ticker-item"><span class="ticker-dot"></span>🥦 Konsumsi sayur dan buah minimal 5 porsi sehari</span>
            <span class="ticker-item"><span class="ticker-dot"></span>😴 Tidur cukup 7–8 jam semalam untuk pemulihan tubuh optimal</span>
            <span class="ticker-item"><span class="ticker-dot"></span>🚭 Hindari rokok dan asap rokok untuk kesehatan paru-paru</span>
            <span class="ticker-item"><span class="ticker-dot"></span>🧘 Kelola stres dengan meditasi dan aktivitas positif</span>
            <span class="ticker-item"><span class="ticker-dot"></span>🩺 Periksakan kesehatan secara rutin minimal setahun sekali</span>
            <span class="ticker-item"><span class="ticker-dot"></span>🧼 Cuci tangan pakai sabun selama 20 detik sebelum makan</span>
            {{-- Duplikat untuk efek loop --}}
            <span class="ticker-item"><span class="ticker-dot"></span>💧 Minum 8 gelas air per hari untuk menjaga hidrasi tubuh</span>
            <span class="ticker-item"><span class="ticker-dot"></span>🏃 Olahraga 30 menit setiap hari untuk jantung yang sehat</span>
            <span class="ticker-item"><span class="ticker-dot"></span>🥦 Konsumsi sayur dan buah minimal 5 porsi sehari</span>
            <span class="ticker-item"><span class="ticker-dot"></span>😴 Tidur cukup 7–8 jam semalam untuk pemulihan tubuh optimal</span>
            <span class="ticker-item"><span class="ticker-dot"></span>🚭 Hindari rokok dan asap rokok untuk kesehatan paru-paru</span>
            <span class="ticker-item"><span class="ticker-dot"></span>🧘 Kelola stres dengan meditasi dan aktivitas positif</span>
            <span class="ticker-item"><span class="ticker-dot"></span>🩺 Periksakan kesehatan secara rutin minimal setahun sekali</span>
            <span class="ticker-item"><span class="ticker-dot"></span>🧼 Cuci tangan pakai sabun selama 20 detik sebelum makan</span>
        </div>
    </div>

    {{-- HOW IT WORKS --}}
    <section class="section steps-bg" id="cara">
        <div class="section-center" style="text-align:center;">
            <span class="section-tag reveal" style="background:rgba(0,255,136,0.15); color:#00ff88;">✨ Cara Kerja</span>
            <h2 class="section-title reveal delay-1" style="color:#fff;">Mudah dalam 4 Langkah</h2>
            <p class="section-desc reveal delay-2" style="color:rgba(255,255,255,0.55); margin:0 auto;">
                Tidak perlu ke puskesmas lebih awal. Cukup ikuti langkah berikut dari rumahmu.
            </p>
            <div class="steps-grid reveal">
                <div class="step-item">
                    <div class="step-num">1</div>
                    <h3>Buat Akun</h3>
                    <p>Daftar akun pasien gratis dengan data diri yang valid</p>
                </div>
                <div class="step-item">
                    <div class="step-num">2</div>
                    <h3>Ambil Antrian</h3>
                    <p>Pilih poli layanan yang dibutuhkan dan ambil nomor antrian digital</p>
                </div>
                <div class="step-item">
                    <div class="step-num">3</div>
                    <h3>Pantau Status</h3>
                    <p>Monitor posisi antrian secara real-time dari ponselmu</p>
                </div>
                <div class="step-item">
                    <div class="step-num">4</div>
                    <h3>Datang Tepat Waktu</h3>
                    <p>Tiba di puskesmas saat giliranmu dipanggil dan tunjukkan QR tiket</p>
                </div>
            </div>
        </div>
    </section>

    {{-- WAVE --}}
    <div class="wave-divider" style="background:#003322;">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,0L120,10.7C240,21,480,43,720,48C960,53,1200,43,1320,37.3L1440,32L1440,80L1320,80C1200,80,960,80,720,80C480,80,240,80,120,80L0,80Z" fill="#f0faf4"/>
        </svg>
    </div>

    {{-- FEATURE DETAIL --}}
    <section class="section features-bg" id="fitur">
        <div class="section-center">
            <div class="feature-split">
                {{-- Visual Mock Card --}}
                <div class="feature-visual reveal">
                    <div class="feature-card-stack">
                        <div class="f-card f-card-behind2"></div>
                        <div class="f-card f-card-behind1"></div>
                        <div class="f-card f-card-main">
                            <div class="f-card-header">
                                <div class="f-avatar">👤</div>
                                <div>
                                    <div class="f-card-title">Tiket Antrian Digital</div>
                                    <div class="f-card-sub">Poli Umum · Puskesmas Mapurujaya</div>
                                </div>
                                <div style="margin-left:auto; background:#e6fff2; color:#006633; font-size:11px; font-weight:700; padding:4px 10px; border-radius:50px;">AKTIF</div>
                            </div>
                            <div class="f-token-display">
                                <div class="f-token-num">A-042</div>
                                <div class="f-token-label">Nomor Antrian Anda</div>
                            </div>
                            <div class="f-progress-row">
                                <span>Posisi dalam antrian</span>
                                <span style="font-weight:700; color:#006633;">Menunggu giliran</span>
                            </div>
                            <div class="f-progress-bar">
                                <div class="f-progress-fill"></div>
                            </div>
                            <div style="margin-top:16px; display:flex; gap:10px;">
                                <div style="flex:1; background:#f0faf4; border-radius:12px; padding:12px; text-align:center;">
                                    <div style="font-size:20px; margin-bottom:4px;">📍</div>
                                    <div style="font-size:11px; color:#5a7a6a;">Lokasi</div>
                                    <div style="font-size:13px; font-weight:700; color:#003322;">Lt. 1</div>
                                </div>
                                <div style="flex:1; background:#f0faf4; border-radius:12px; padding:12px; text-align:center;">
                                    <div style="font-size:20px; margin-bottom:4px;">🕐</div>
                                    <div style="font-size:11px; color:#5a7a6a;">Est. Tunggu</div>
                                    <div style="font-size:13px; font-weight:700; color:#003322;">~15 mnt</div>
                                </div>
                                <div style="flex:1; background:#f0faf4; border-radius:12px; padding:12px; text-align:center;">
                                    <div style="font-size:20px; margin-bottom:4px;">📲</div>
                                    <div style="font-size:11px; color:#5a7a6a;">Scan QR</div>
                                    <div style="font-size:13px; font-weight:700; color:#003322;">Aktif</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Feature list --}}
                <div class="reveal delay-2">
                    <span class="section-tag">⚡ Fitur Unggulan</span>
                    <h2 class="section-title" style="margin-bottom:8px;">Kenapa Pilih<br>Sistem Kami?</h2>
                    <p class="section-desc" style="margin-bottom:8px;">
                        Dirancang khusus untuk kemudahan pasien dan efisiensi pelayanan tenaga medis.
                    </p>
                    <ul class="feature-list">
                        <li>
                            <div class="feat-icon green">⚡</div>
                            <div>
                                <div class="feat-title">Antrian Real-time</div>
                                <div class="feat-desc">Pantau posisi antrian secara langsung tanpa perlu refresh. Notifikasi otomatis saat giliran hampir tiba.</div>
                            </div>
                        </li>
                        <li>
                            <div class="feat-icon blue">📲</div>
                            <div>
                                <div class="feat-title">Tiket QR Digital</div>
                                <div class="feat-desc">Setiap antrian mendapat QR code unik. Petugas scan QR saat Anda tiba — tidak perlu cetak tiket fisik.</div>
                            </div>
                        </li>
                        <li>
                            <div class="feat-icon amber">📁</div>
                            <div>
                                <div class="feat-title">Rekam Medis Terintegrasi</div>
                                <div class="feat-desc">Riwayat pemeriksaan, resep, dan diagnosa tersimpan digital dan dapat diakses kapan saja.</div>
                            </div>
                        </li>
                        <li>
                            <div class="feat-icon rose">🔔</div>
                            <div>
                                <div class="feat-title">Layar Antrian TV</div>
                                <div class="feat-desc">Display antrian otomatis di ruang tunggu puskesmas disertai suara notifikasi panggilan.</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- GALERI --}}
    <section class="section galeri-bg" id="galeri">
        <div class="section-center">
            <div style="text-align:center; margin-bottom:0;">
                <span class="section-tag reveal">🖼️ Galeri</span>
                <h2 class="section-title reveal delay-1">Puskesmas<br>Mapurujaya</h2>
                <p class="section-desc reveal delay-2" style="margin: 0 auto;">
                    Lihat fasilitas, tim medis profesional, dan momen pelayanan kesehatan kami yang berkualitas.
                </p>
            </div>
            <div class="galeri-grid">
                {{-- Galeri Item 1 --}}
                <div class="galeri-item reveal">
                    <img src="{{ asset('images/galeri1.png') }}" alt="Ruang Pemeriksaan" class="galeri-img" onerror="this.style.backgroundColor='#e6fff2'; this.style.display='none';">
                    
                    <div class="galeri-info">
                        <div class="galeri-title">Ruang Pemeriksaan</div>
                        <div class="galeri-desc">Fasilitas pemeriksaan pasien yang nyaman dan modern dengan peralatan medis terkini.</div>
                    </div>
                </div>

                {{-- Galeri Item 2 --}}
                <div class="galeri-item reveal delay-1">
                    <img src="{{ asset('images/galeri2.png') }}" alt="Ruang Tunggu" class="galeri-img" onerror="this.style.backgroundColor='#e6f4ff'; this.style.display='none';">
                    
                   
                    <div class="galeri-info">
                        <div class="galeri-title">Ruang Tunggu Pasien</div>
                        <div class="galeri-desc">Area tunggu yang nyaman dengan kursi ergonomis dan fasilitas penunjang kesehatan.</div>
                    </div>
                </div>

                {{-- Galeri Item 3 --}}
                <div class="galeri-item reveal delay-2">
                    <img src="{{ asset('images/galeri3.png') }}" alt="Tim Medis" class="galeri-img" onerror="this.style.backgroundColor='#fff8e6'; this.style.display='none';">

                    <div class="galeri-info">
                        <div class="galeri-title">Tim Dokter Profesional</div>
                        <div class="galeri-desc">Dokter dan perawat bersertifikat siap memberikan pelayanan kesehatan terbaik.</div>
                    </div>
                </div>

                {{-- Galeri Item 4 --}}
                <div class="galeri-item reveal delay-3">
                    <img src="{{ asset('images/galeri4.png') }}" alt="Laboratorium" class="galeri-img" onerror="this.style.backgroundColor='#fff0f0'; this.style.display='none';">
    
                    <div class="galeri-info">
                        <div class="galeri-title">Laboratorium Klinik</div>
                        <div class="galeri-desc">Peralatan laboratorium modern untuk hasil pemeriksaan yang akurat dan cepat.</div>
                    </div>
                </div>

                {{-- Galeri Item 5 --}}
                <div class="galeri-item reveal">
                    <img src="{{ asset('images/galeri5.png') }}" alt="Apotek" class="galeri-img" onerror="this.style.backgroundColor='#f5eeff'; this.style.display='none';">
                    
                    <div class="galeri-info">
                        <div class="galeri-title">Apotek Modern</div>
                        <div class="galeri-desc">Layanan farmasi lengkap dengan obat-obatan berkualitas dan staf profesional.</div>
                    </div>
                </div>

                {{-- Galeri Item 6 --}}
                <div class="galeri-item reveal delay-1">
                    <img src="{{ asset('images/galeri6.png') }}" alt="Antrian Digital" class="galeri-img" onerror="this.style.backgroundColor='#e6fff8'; this.style.display='none';">
                    
                    <div class="galeri-info">
                        <div class="galeri-title">Sistem Antrian Digital</div>
                        <div class="galeri-desc">Layar antrian otomatis yang menampilkan nomor dan status pasien secara real-time.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- WAVE ke CTA --}}
    <div class="wave-divider" style="background:#f0faf4;">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,80L120,68C240,56,480,32,720,26.7C960,21,1200,43,1320,53.3L1440,64L1440,0L1320,0C1200,0,960,0,720,0C480,0,240,0,120,0L0,0Z" fill="#004d2a"/>
        </svg>
    </div>

    {{-- CTA --}}
    <section class="section cta-section">
        <div class="cta-inner reveal">
            <h2 class="cta-title">Siap Nikmati Layanan<br>Kesehatan yang Lebih Baik?</h2>
            <p class="cta-desc">
                Bergabunglah bersama ribuan pasien yang telah menikmati kemudahan antrian online Puskesmas Mapurujaya. Daftar gratis sekarang!
            </p>
            <div class="cta-buttons">
                <a href="{{ route('register') }}" class="cta-btn-big primary">
                    <span>🩺</span> Daftar Sebagai Pasien
                </a>
                <a href="{{ route('login') }}" class="cta-btn-big secondary">
                    <span>🔑</span> Masuk ke Akun
                </a>
            </div>
            <div>
                <a href="{{ route('admin.login') }}" class="cta-staff-link">
                    Akses sebagai <span>Petugas Medis / Admin</span> →
                </a>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-top">
                <div class="footer-brand">
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:0;">
                        <img src="{{ asset('images/navlogo.png') }}" alt="AntroPusma Logo" style="height: 36px; object-fit: contain;">
                        <span style="font-size:18px;font-weight:800;color:#fff;">Antro<span style="color:#00ff88;">Pusma</span></span>
                    </div>
                    <p>Sistem Antrian Online Puskesmas Mapurujaya. Memudahkan akses pelayanan kesehatan primer berbasis digital.</p>
                </div>
                <div class="footer-col">
                    <h4>Layanan</h4>
                    <a href="#layanan">Poli Umum</a>
                    <a href="#layanan">KIA / Kebidanan</a>
                    <a href="#layanan">Poli Gigi</a>
                    <a href="#layanan">Laboratorium</a>
                    <a href="#layanan">Apotek</a>
                </div>
                <div class="footer-col">
                    <h4>Akses Sistem</h4>
                    <a href="{{ route('login') }}">Login Pasien</a>
                    <a href="{{ route('register') }}">Daftar Baru</a>
                    <a href="{{ route('admin.login') }}">Portal Petugas</a>
                    <a href="{{ route('queue.display') }}">Display Antrian TV</a>
                </div>
            </div>
            <div class="footer-bottom">
                <p>Copyright &copy; {{ date('Y') }} <span>Politeknik Amamapare Timika</span></p>
                <p><span>Vinsensius Danang Viggo Sudianto — 22512047</span></p>
            </div>
        </div>
    </footer>

    <script>
    (function () {
        // Navbar scroll effect
        var navbar = document.getElementById('navbar');
        window.addEventListener('scroll', function () {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        // Floating medical icons in hero
        var iconContainer = document.getElementById('floatIcons');
        var icons = ['➕', '🩺', '💊', '🧬', '❤️', '🫀', '🩻', '⚕️', '🔬', '🩹'];
        for (var i = 0; i < 18; i++) {
            (function (i) {
                var el = document.createElement('div');
                el.className = 'float-icon';
                el.textContent = icons[Math.floor(Math.random() * icons.length)];
                var size = Math.random() * 28 + 16;
                var left  = Math.random() * 100;
                var dur   = Math.random() * 18 + 14;
                var delay = Math.random() * 20;
                el.style.cssText =
                    'font-size:' + size + 'px;' +
                    'left:' + left + '%;' +
                    'animation-duration:' + dur + 's;' +
                    'animation-delay:' + delay + 's;';
                iconContainer.appendChild(el);
            })(i);
        }

        // Scroll reveal
        var reveals = document.querySelectorAll('.reveal');
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.12 });
        reveals.forEach(function (el) { observer.observe(el); });
    })();
    </script>
</body>
</html>