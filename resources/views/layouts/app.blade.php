<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

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

            /* ── Navbar blur ── */
            .nav-blur {
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
            }

            .nav-logo-container { transition: all 0.3s ease; }
            .nav-logo-container:hover { transform: scale(1.02); }

            /* ── Blob shape ── */
            .blob {
                border-radius: 62% 38% 68% 32% / 54% 46% 54% 46%;
            }

            /* ── Float animation ── */
            @keyframes floatAnim {
                0%, 100% { transform: translateY(0px); }
                50%      { transform: translateY(-12px); }
            }
            .animate-float-custom {
                animation: floatAnim 4s ease-in-out infinite;
            }

            /* ── Scroll-reveal (IntersectionObserver) ── */
            .reveal {
                opacity: 0;
                transform: translateY(28px);
                transition: opacity .65s ease, transform .65s ease;
            }
            .reveal.visible {
                opacity: 1;
                transform: none;
            }

            /* ── Custom scrollbar ── */
            ::-webkit-scrollbar { width: 6px; }
            ::-webkit-scrollbar-track { background: #f0fdf9; }
            ::-webkit-scrollbar-thumb { background: #2dd4b0; border-radius: 99px; }

            /* ── MindCare-style pill navigation ── */
            .top-pill-nav {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 6px 12px;
                border-radius: 9999px;
                background: transparent;
                color: #374151;
                text-decoration: none;
                transition: all 0.25s ease;
                font-size: 13px;
                font-weight: 500;
                white-space: nowrap;
            }

            .top-pill-nav:hover {
                background: #f0fdf4;
                color: #0d9478;
                transform: translateY(-1px);
            }

            .top-pill-center {
                width: 32px;
                height: 32px;
                border-radius: 9999px;
                background: #f0fdf4;
                color: #0d9478;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.25s ease;
                flex-shrink: 0;
            }

            .top-pill-nav:hover .top-pill-center {
                background: #ccfbef;
                color: #0a7560;
            }

            .top-pill-right {
                display: none;
            }

            .top-pill-active {
                background: linear-gradient(135deg, #2dd4b0, #14b896);
                color: #ffffff;
                box-shadow: 0 2px 10px rgba(20, 184, 150, 0.35);
            }

            .top-pill-active:hover {
                background: linear-gradient(135deg, #14b896, #0d9478);
                color: #ffffff;
                transform: translateY(-1px);
            }

            .top-pill-active .top-pill-center {
                background: rgba(255, 255, 255, 0.25);
                color: #ffffff;
            }

            .top-pill-active:hover .top-pill-center {
                background: rgba(255, 255, 255, 0.35);
                color: #ffffff;
            }

            /* ── Smaller anchor pills ── */
            .top-pill-sm {
                padding: 5px 14px;
                font-size: 12px;
                gap: 0;
                background: #f0fdf4;
                color: #374151;
                border: 1px solid #bbf7d0;
            }
            .top-pill-sm:hover {
                background: linear-gradient(135deg, #10b981, #059669);
                color: #fff;
                border-color: transparent;
            }

            /* ── Mobile navigation list ── */
            .mobile-nav-link {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px 12px;
                border-radius: 12px;
                text-decoration: none;
                transition: all 0.2s ease;
                color: #374151;
            }
            .mobile-nav-link:hover {
                background: #f0fdf4;
            }
            .mobile-nav-active {
                background: linear-gradient(135deg, #ecfdf5, #d1fae5) !important;
                border: 1px solid #a7f3d0;
            }
            .mobile-nav-active .mobile-nav-icon {
                background: linear-gradient(135deg, #2dd4b0, #14b896);
                color: #fff;
            }
            .mobile-nav-icon {
                width: 40px;
                height: 40px;
                border-radius: 12px;
                background: #f0fdf4;
                color: #0d9478;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                transition: all 0.2s ease;
            }
            .mobile-nav-link:hover .mobile-nav-icon {
                background: #ccfbef;
                color: #0a7560;
            }
            .mobile-nav-title {
                display: block;
                font-size: 14px;
                font-weight: 600;
                color: #111827;
                line-height: 1.3;
            }
            .mobile-nav-desc {
                display: block;
                font-size: 11px;
                color: #9ca3af;
                line-height: 1.3;
            }
            .mobile-nav-active .mobile-nav-title {
                color: #065f46;
            }
            .mobile-nav-active .mobile-nav-desc {
                color: #047857;
            }

            /* Pill nav responsive - larger screens get bigger pills */
            @media (min-width: 1024px) {
                .top-pill-nav {
                    gap: 8px;
                    padding: 8px 16px;
                    font-size: 14px;
                }
            }
            @media (min-width: 1280px) {
                .top-pill-nav {
                    padding: 8px 18px;
                }
            }

            /* ── Floating logout button ── */
            .logout-float-btn {
                position: fixed;
                bottom: 30px;
                left: 30px;
                z-index: 50;
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 10px 20px;
                border-radius: 9999px;
                background: linear-gradient(135deg, #ef4444, #dc2626);
                color: #fff;
                font-size: 13px;
                font-weight: 600;
                text-decoration: none;
                box-shadow: 0 4px 15px rgba(239, 68, 68, 0.35);
                opacity: 0;
                visibility: hidden;
                transform: translateY(20px);
                transition: all 0.3s ease;
            }
            .logout-float-btn.show {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
            .logout-float-btn:hover {
                background: linear-gradient(135deg, #dc2626, #b91c1c);
                box-shadow: 0 6px 20px rgba(239, 68, 68, 0.45);
                transform: translateY(-3px);
            }

            /* ── Hide scrollbar on nav ── */
            .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
            .scrollbar-hide::-webkit-scrollbar { display: none; }

            /* ── Admin Sidebar ── */
            .admin-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                width: 260px;
                z-index: 45;
                background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);
                border-right: 1px solid #dcfce7;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(.4,0,.2,1);
                overflow-y: auto;
                box-shadow: 4px 0 25px rgba(0,0,0,0.08);
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .sidebar-overlay {
                position: fixed;
                inset: 0;
                z-index: 44;
                background: rgba(0,0,0,0.3);
                backdrop-filter: blur(2px);
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }
            .sidebar-overlay.show {
                opacity: 1;
                visibility: visible;
            }
            .sidebar-link {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px 20px;
                color: #374151;
                text-decoration: none;
                font-size: 13px;
                font-weight: 500;
                transition: all 0.2s ease;
                border-left: 3px solid transparent;
            }
            .sidebar-link:hover {
                background: #ecfdf5;
                color: #059669;
                border-left-color: #10b981;
            }
            .sidebar-link-active {
                background: linear-gradient(90deg, #ecfdf5, #d1fae5);
                color: #059669;
                font-weight: 600;
                border-left-color: #10b981;
            }
            .sidebar-link .sidebar-icon {
                width: 32px;
                height: 32px;
                border-radius: 10px;
                background: #f0fdf4;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                transition: all 0.2s ease;
            }
            .sidebar-link:hover .sidebar-icon {
                background: #d1fae5;
                color: #059669;
            }
            .sidebar-link-active .sidebar-icon {
                background: linear-gradient(135deg, #10b981, #059669);
                color: #fff;
            }
            .sidebar-divider {
                height: 1px;
                background: linear-gradient(90deg, transparent, #d1fae5, transparent);
                margin: 8px 20px;
            }
            .sidebar-label {
                padding: 8px 20px 4px;
                font-size: 10px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 1px;
                color: #9ca3af;
            }
            .sidebar-toggle-btn {
                width: 40px;
                height: 40px;
                border-radius: 12px;
                border: 1px solid #dcfce7;
                background: #f0fdf4;
                color: #059669;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.2s ease;
            }
            .sidebar-toggle-btn:hover {
                background: #d1fae5;
                transform: scale(1.05);
            }

            /* ── Admin Page Styles ── */
            .admin-card {
                background: #fff;
                border-radius: 16px;
                border: 1px solid #e5e7eb;
                overflow: hidden;
                transition: all 0.3s cubic-bezier(.4,0,.2,1);
            }
            .admin-card:hover {
                box-shadow: 0 10px 40px rgba(5, 150, 105, 0.10);
                border-color: #d1fae5;
            }
            .admin-card-header {
                padding: 20px 24px;
                border-bottom: 1px solid #f0fdf4;
                display: flex;
                align-items: center;
                gap: 14px;
            }
            .admin-card-header-icon {
                width: 44px;
                height: 44px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .admin-card-body {
                padding: 20px 24px;
            }
            .admin-stat-card {
                background: #fff;
                border-radius: 16px;
                border: 1px solid #e5e7eb;
                padding: 24px;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }
            .admin-stat-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 4px;
                border-radius: 16px 16px 0 0;
            }
            .admin-stat-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 40px rgba(0,0,0,0.08);
            }
            .admin-stat-card.stat-teal::before { background: linear-gradient(90deg, #10b981, #059669); }
            .admin-stat-card.stat-blue::before { background: linear-gradient(90deg, #3b82f6, #2563eb); }
            .admin-stat-card.stat-amber::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
            .admin-stat-card.stat-rose::before { background: linear-gradient(90deg, #f43f5e, #e11d48); }
            .admin-stat-card.stat-purple::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }
            .admin-stat-card.stat-cyan::before { background: linear-gradient(90deg, #06b6d4, #0891b2); }
            .admin-stat-icon {
                width: 48px;
                height: 48px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 16px;
            }
            .admin-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
            }
            .admin-table thead th {
                padding: 12px 20px;
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                color: #6b7280;
                background: #f9fafb;
                border-bottom: 1px solid #e5e7eb;
            }
            .admin-table tbody td {
                padding: 14px 20px;
                font-size: 13px;
                color: #374151;
                border-bottom: 1px solid #f3f4f6;
                vertical-align: middle;
            }
            .admin-table tbody tr:hover {
                background: #f0fdf4;
            }
            .admin-table tbody tr:last-child td {
                border-bottom: none;
            }
            .admin-badge {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                padding: 4px 10px;
                border-radius: 8px;
                font-size: 11px;
                font-weight: 600;
                letter-spacing: 0.3px;
            }
            .badge-success { background: #dcfce7; color: #166534; }
            .badge-warning { background: #fef3c7; color: #92400e; }
            .badge-info { background: #dbeafe; color: #1e40af; }
            .badge-danger { background: #fee2e2; color: #991b1b; }
            .badge-purple { background: #ede9fe; color: #5b21b6; }
            .badge-gray { background: #f3f4f6; color: #4b5563; }
            .badge-cyan { background: #cffafe; color: #155e75; }
            .admin-btn {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 16px;
                border-radius: 10px;
                font-size: 13px;
                font-weight: 600;
                transition: all 0.2s ease;
                cursor: pointer;
                border: none;
            }
            .admin-btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            }
            .btn-primary { background: linear-gradient(135deg, #10b981, #059669); color: #fff; }
            .btn-secondary { background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }
            .btn-secondary:hover { background: #e5e7eb; }
            .btn-danger { background: linear-gradient(135deg, #ef4444, #dc2626); color: #fff; }
            .btn-info { background: linear-gradient(135deg, #3b82f6, #2563eb); color: #fff; }
            .btn-warning { background: linear-gradient(135deg, #f59e0b, #d97706); color: #fff; }
            .admin-search {
                padding: 10px 16px 10px 40px;
                border-radius: 12px;
                border: 1px solid #e5e7eb;
                font-size: 13px;
                background: #fff;
                transition: all 0.2s ease;
                width: 100%;
            }
            .admin-search:focus {
                outline: none;
                border-color: #10b981;
                box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            }
            .admin-input {
                padding: 10px 16px;
                border-radius: 12px;
                border: 1px solid #e5e7eb;
                font-size: 13px;
                background: #fff;
                transition: all 0.2s ease;
                width: 100%;
            }
            .admin-input:focus {
                outline: none;
                border-color: #10b981;
                box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            }
            .admin-alert {
                padding: 14px 20px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 13px;
                font-weight: 500;
                margin-bottom: 20px;
            }
            .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
            .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
            .alert-info { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
            .admin-page-header {
                margin-bottom: 32px;
            }
            .admin-page-title {
                font-size: 24px;
                font-weight: 800;
                color: #111827;
                letter-spacing: -0.025em;
            }
            .admin-page-subtitle {
                font-size: 14px;
                color: #6b7280;
                margin-top: 4px;
            }
            .admin-empty-state {
                text-align: center;
                padding: 48px 24px;
            }
            .admin-empty-state svg {
                width: 56px;
                height: 56px;
                color: #d1d5db;
                margin: 0 auto 16px;
            }
            .complaint-card {
                padding: 14px;
                border-radius: 12px;
                border: 1px solid #f3f4f6;
                transition: all 0.2s ease;
            }
            .complaint-card:hover {
                border-color: #d1fae5;
                background: #f0fdf4;
            }

            /* ── Admin Responsive ── */
            @media (max-width: 768px) {
                #klaster-keluhan { grid-template-columns: 1fr !important; }
                #klaster-keluhan .admin-card { grid-column: span 1 !important; }
                .admin-card-header { flex-wrap: wrap; }
                .admin-page-title { font-size: 22px !important; }
                .admin-sidebar { width: min(88vw, 320px); }
                .admin-card-body { overflow-x: auto; }
                .admin-table { min-width: 640px; }
                .scroll-top-btn {
                    right: 14px;
                    bottom: 14px;
                    width: 40px;
                    height: 40px;
                }
                .logout-float-btn {
                    left: 14px;
                    bottom: 14px;
                    padding: 10px 14px;
                }
            }

            @media (max-width: 640px) {
                .nav-logo-container img { height: 34px !important; }
                .sidebar-toggle-btn {
                    width: 36px;
                    height: 36px;
                }
                .loading-container { gap: 24px; }
                .main-content { padding-left: 12px; padding-right: 12px; }
            }

            /* ── Card hover lift ── */
            .card-lift {
                transition: transform .25s ease, box-shadow .25s ease;
            }
            .card-lift:hover {
                transform: translateY(-6px);
                box-shadow: 0 20px 50px rgba(14, 165, 133, 0.16);
            }

            /* ── Scroll to top button ── */
            .scroll-top-btn {
                position: fixed;
                bottom: 30px;
                right: 30px;
                z-index: 50;
                width: 44px;
                height: 44px;
                border-radius: 50%;
                background: linear-gradient(135deg, #2dd4b0, #14b896);
                color: #fff;
                border: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 15px rgba(20, 184, 150, 0.35);
                opacity: 0;
                visibility: hidden;
                transform: translateY(20px);
                transition: all 0.3s ease;
            }
            .scroll-top-btn.show {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
            .scroll-top-btn:hover {
                background: linear-gradient(135deg, #14b896, #0d9478);
                box-shadow: 0 6px 20px rgba(20, 184, 150, 0.45);
                transform: translateY(-3px);
            }

            /* Force full-width content area */
            .page-content-full [class*="max-w-"][class*="mx-auto"] {
                max-width: 100% !important;
                width: 100% !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            /* ================================================================
               DARK MODE OVERRIDES — berlaku saat kelas `dark` ada di <html>
               Harus di sini (setelah definisi kelas) agar cascade menang
               ================================================================ */

            /* ── Scrollbar ── */
            .dark ::-webkit-scrollbar-track { background: #1f2937; }
            .dark ::-webkit-scrollbar-thumb { background: #374151; border-radius: 4px; }
            .dark ::-webkit-scrollbar-thumb:hover { background: #4b5563; }

            /* ── Top Pill Nav ── */
            .dark .top-pill-nav { color: #d1d5db; }
            .dark .top-pill-nav:hover { background: rgba(16,185,129,0.12); color: #34d399; }
            .dark .top-pill-center { background: rgba(16,185,129,0.12); color: #34d399; }
            .dark .top-pill-nav:hover .top-pill-center { background: rgba(16,185,129,0.22); color: #6ee7b7; }
            .dark .top-pill-sm { background: rgba(16,185,129,0.1); color: #d1d5db; border-color: rgba(16,185,129,0.2); }
            .dark .top-pill-active:hover .top-pill-center { background: rgba(255,255,255,0.3); }

            /* ── Admin Sidebar ── */
            .dark .admin-sidebar {
                background: linear-gradient(180deg, #0f172a 0%, #0c1a0f 100%);
                border-right-color: #1e293b;
            }
            .dark .sidebar-link { color: #cbd5e1; }
            .dark .sidebar-link:hover { background: rgba(16,185,129,0.1); color: #34d399; border-left-color: #10b981; }
            .dark .sidebar-link-active { background: linear-gradient(90deg, rgba(16,185,129,0.16), rgba(5,150,105,0.08)); color: #34d399; border-left-color: #10b981; }
            .dark .sidebar-link .sidebar-icon { background: rgba(16,185,129,0.1); color: #34d399; }
            .dark .sidebar-link:hover .sidebar-icon { background: rgba(16,185,129,0.2); }
            .dark .sidebar-link-active .sidebar-icon { background: linear-gradient(135deg, #10b981, #059669); color: #fff; }
            .dark .sidebar-label { color: #64748b; }
            .dark .sidebar-divider { background: linear-gradient(90deg, transparent, rgba(16,185,129,0.2), transparent); }
            .dark .sidebar-toggle-btn { background: #1e293b; border-color: #334155; color: #34d399; }
            .dark .sidebar-toggle-btn:hover { background: #334155; }

            /* ── Mobile Nav ── */
            .dark .mobile-nav-link { color: #cbd5e1; }
            .dark .mobile-nav-link:hover { background: rgba(16,185,129,0.08); }
            .dark .mobile-nav-title { color: #f1f5f9; }
            .dark .mobile-nav-desc { color: #64748b; }
            .dark .mobile-nav-icon { background: rgba(16,185,129,0.1); color: #34d399; }
            .dark .mobile-nav-link:hover .mobile-nav-icon { background: rgba(16,185,129,0.2); }
            .dark .mobile-nav-active { background: linear-gradient(135deg, rgba(16,185,129,0.15), rgba(5,150,105,0.08)) !important; border-color: rgba(16,185,129,0.3); }
            .dark .mobile-nav-active .mobile-nav-title { color: #34d399; }
            .dark .mobile-nav-active .mobile-nav-desc { color: #10b981; }

            /* ── Admin Cards ── */
            .dark .admin-card { background: #1e293b; border-color: #334155; }
            .dark .admin-card:hover { box-shadow: 0 10px 40px rgba(16,185,129,0.07); border-color: rgba(16,185,129,0.25); }
            .dark .admin-card-header { border-bottom-color: #334155; }
            .dark .admin-stat-card { background: #1e293b; border-color: #334155; }
            .dark .admin-stat-card:hover { box-shadow: 0 12px 40px rgba(0,0,0,0.3); }

            /* ── Complaint Card ── */
            .dark .complaint-card { border-color: #334155; }
            .dark .complaint-card:hover { border-color: rgba(16,185,129,0.3); background: rgba(16,185,129,0.05); }

            /* ── Admin Tables ── */
            .dark .admin-table thead th { background: #0f172a; color: #94a3b8; border-bottom-color: #334155; }
            .dark .admin-table tbody td { color: #cbd5e1; border-bottom-color: #334155; }
            .dark .admin-table tbody tr:hover { background: rgba(16,185,129,0.06); }

            /* ── Admin Badges ── */
            .dark .badge-success { background: rgba(6,78,59,0.5); color: #86efac; }
            .dark .badge-warning { background: rgba(120,53,15,0.5); color: #fcd34d; }
            .dark .badge-info    { background: rgba(30,58,138,0.5); color: #93c5fd; }
            .dark .badge-danger  { background: rgba(127,29,29,0.5); color: #fca5a5; }
            .dark .badge-purple  { background: rgba(76,29,149,0.5); color: #c4b5fd; }
            .dark .badge-gray    { background: rgba(55,65,81,0.6);  color: #cbd5e1; }
            .dark .badge-cyan    { background: rgba(21,94,117,0.5); color: #67e8f9; }

            /* ── Admin Buttons ── */
            .dark .btn-secondary { background: #334155; color: #cbd5e1; border-color: #475569; }
            .dark .btn-secondary:hover { background: #475569; color: #f1f5f9; }

            /* ── Admin Inputs / Search ── */
            .dark .admin-search,
            .dark .admin-input {
                background: #334155;
                color: #f1f5f9;
                border-color: #475569;
            }
            .dark .admin-search:focus,
            .dark .admin-input:focus {
                border-color: #10b981;
                box-shadow: 0 0 0 3px rgba(16,185,129,0.15);
            }
            .dark .admin-search::placeholder,
            .dark .admin-input::placeholder { color: #64748b; }

            /* ── Admin Alerts ── */
            .dark .alert-success { background: rgba(6,78,59,0.25); color: #86efac; border-color: rgba(6,78,59,0.5); }
            .dark .alert-error   { background: rgba(127,29,29,0.25); color: #fca5a5; border-color: rgba(127,29,29,0.5); }
            .dark .alert-info    { background: rgba(30,58,138,0.25); color: #93c5fd; border-color: rgba(30,58,138,0.5); }

            /* ── Admin Page Typography ── */
            .dark .admin-page-title   { color: #f1f5f9; }
            .dark .admin-page-subtitle { color: #94a3b8; }
            .dark .admin-empty-state svg { color: #475569; }

            /* ── Tailwind bg overrides ── */
            .dark .bg-white     { background-color: #1e293b !important; }
            .dark .bg-gray-50   { background-color: #1e293b !important; }
            .dark .bg-gray-100  { background-color: #334155 !important; }
            .dark .bg-gray-200  { background-color: #334155 !important; }

            /* ── Tailwind text overrides ── */
            .dark .text-gray-900, .dark .text-gray-950 { color: #f1f5f9; }
            .dark .text-gray-800 { color: #e2e8f0; }
            .dark .text-gray-700 { color: #cbd5e1; }
            .dark .text-gray-600 { color: #94a3b8; }
            .dark .text-gray-500 { color: #64748b; }
            .dark .text-slate-900 { color: #f1f5f9; }
            .dark .text-slate-700 { color: #cbd5e1; }
            .dark .text-slate-600 { color: #94a3b8; }

            /* ── Alert bg (Tailwind) ── */
            .dark .bg-red-50     { background-color: rgba(127,29,29,0.2) !important; }
            .dark .bg-green-50   { background-color: rgba(6,78,59,0.2)   !important; }
            .dark .bg-emerald-50 { background-color: rgba(6,78,59,0.2)   !important; }
            .dark .bg-blue-50    { background-color: rgba(30,58,138,0.2) !important; }
            .dark .bg-yellow-50,
            .dark .bg-amber-50   { background-color: rgba(120,53,15,0.2) !important; }
            .dark .bg-amber-100  { background-color: rgba(120,53,15,0.3) !important; }
            .dark .bg-amber-100.text-amber-700 { color: #fcd34d; }

            /* ── Alert text (Tailwind) ── */
            .dark .text-red-800, .dark .text-red-700   { color: #fca5a5; }
            .dark .text-green-800, .dark .text-green-700   { color: #86efac; }
            .dark .text-emerald-800, .dark .text-emerald-700 { color: #6ee7b7; }
            .dark .text-blue-800, .dark .text-blue-700   { color: #93c5fd; }
            .dark .text-yellow-800, .dark .text-yellow-700 { color: #fcd34d; }
            .dark .text-amber-800, .dark .text-amber-700   { color: #fcd34d; }
            .dark .text-indigo-600, .dark .text-indigo-700, .dark .text-indigo-800 { color: #a5b4fc; }

            /* ── Border overrides (Tailwind) ── */
            .dark .border-gray-100,
            .dark .border-gray-200,
            .dark .border-gray-300  { border-color: #334155; }
            .dark .border-green-100,
            .dark .border-emerald-100,
            .dark .border-emerald-200 { border-color: rgba(6,78,59,0.35); }
            .dark .border-red-200 { border-color: rgba(127,29,29,0.4); }
            .dark .border-amber-200 { border-color: rgba(120,53,15,0.4); }
            .dark .border-blue-200 { border-color: rgba(30,58,138,0.4); }

            /* ── Inline hardcoded color overrides ── */
            .dark [style*="color: #111827"] { color: #f1f5f9 !important; }
            .dark [style*="color: #1f2937"] { color: #e2e8f0 !important; }
            .dark [style*="color: #374151"] { color: #cbd5e1 !important; }
            .dark [style*="color: #4b5563"] { color: #94a3b8 !important; }
            .dark [style*="color: #6b7280"] { color: #94a3b8 !important; }
            .dark [style*="color: #9ca3af"] { color: #64748b !important; }
            .dark [style*="background-color: #fff"],
            .dark [style*="background: #fff"],
            .dark [style*="background-color: #ffffff"],
            .dark [style*="background: #ffffff"],
            .dark [style*="background: #f9fafb"],
            .dark [style*="background-color: #f9fafb"] { background: #1e293b !important; }

            /* ── Inputs (global) ── */
            .dark input:not([type=checkbox]):not([type=radio]),
            .dark textarea,
            .dark select {
                background-color: #334155 !important;
                color: #f1f5f9 !important;
                border-color: #475569 !important;
            }
            .dark input::placeholder, .dark textarea::placeholder { color: #64748b !important; }
            .dark input:focus, .dark textarea:focus, .dark select:focus {
                border-color: #10b981 !important;
                box-shadow: 0 0 0 3px rgba(16,185,129,0.15) !important;
            }
        </style>

        {{-- Dark mode anti-FOUC: apply class sebelum render --}}
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
    <body class="font-sans bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 antialiased min-h-screen transition-colors duration-300">

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

    {{-- Single Combined Top Navbar (MindCare v2 Style) --}}
    <nav x-data="{ scrolled: false, mobileOpen: false }"
         @scroll.window="scrolled = window.scrollY > 20"
         :class="scrolled ? 'shadow-md bg-white/95' : 'bg-white/80'"
         class="fixed top-0 inset-x-0 z-40 nav-blur border-b border-green-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            {{-- Top Row: Logo + Nav Pills + User Info --}}
            <div class="h-16 flex items-center justify-between gap-6">

                <div class="flex items-center gap-3">
                    {{-- Sidebar toggle (admin only) --}}
                    @auth
                    @if(auth()->user()->role === 'admin')
                    <button onclick="toggleSidebar()" class="sidebar-toggle-btn" title="Menu">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    @endif
                    @endauth

                    {{-- Logo --}}
                    <a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'petugas' ? route('petugas.dashboard') : route('dashboard'))) : url('/') }}" class="flex items-center gap-3 nav-logo-container shrink-0">
                        <img src="{{ asset('images/navlogo.png') }}" alt="AntroPusma Logo" class="h-10 object-contain">
                        <div class="hidden md:block">
                            <span class="font-extrabold text-lg tracking-tight text-gray-900">Sistem <span class="text-green-500">Antrian</span></span>
                            <p class="text-xs text-gray-400 -mt-0.5">Puskesmas Mapurujaya</p>
                        </div>
                    </a>
                </div>

                {{-- Desktop nav pills (patient only, admin uses sidebar) --}}
                @auth
                @php
                    $petugasPrescriptionBadge = 0;
                    if (auth()->user()->role === 'petugas' && (int) auth()->user()->cluster_number === 5) {
                        $petugasPrescriptionBadge = \App\Models\Prescription::whereIn('status', ['menunggu', 'disiapkan'])->count();
                    }
                @endphp
                @if(auth()->user()->role === 'patient')
                <div class="hidden md:flex items-center gap-1 overflow-x-auto scrollbar-hide flex-1 min-w-0">
                    <a href="{{ route('dashboard') }}" class="top-pill-nav {{ request()->routeIs('dashboard') ? 'top-pill-active' : '' }}">
                        <span class="top-pill-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-8 9 8M4 10v10h16V10" />
                            </svg>
                        </span>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('patient.profile') }}" class="top-pill-nav {{ request()->routeIs('patient.profile') ? 'top-pill-active' : '' }}">
                        <span class="top-pill-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </span>
                        <span>Profil Saya</span>
                    </a>
                    <a href="{{ route('queue.create') }}" class="top-pill-nav {{ request()->routeIs('queue.create') ? 'top-pill-active' : '' }}">
                        <span class="top-pill-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                            </svg>
                        </span>
                        <span>Daftar Antrian</span>
                    </a>
                    <a href="{{ route('patient.registrations') }}" class="top-pill-nav {{ request()->routeIs('patient.registrations') ? 'top-pill-active' : '' }}">
                        <span class="top-pill-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3M4 12a8 8 0 1116 0 8 8 0 01-16 0z" />
                            </svg>
                        </span>
                        <span>Riwayat</span>
                    </a>
                    <a href="{{ route('patient.display') }}" class="top-pill-nav {{ request()->routeIs('patient.display') ? 'top-pill-active' : '' }}">
                        <span class="top-pill-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h18M3 12h18M3 19h18" />
                            </svg>
                        </span>
                        <span>Display Antrian</span>
                    </a>
                    <a href="{{ route('patient.examinations') }}" class="top-pill-nav {{ request()->routeIs('patient.examinations*') ? 'top-pill-active' : '' }}">
                        <span class="top-pill-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </span>
                        <span>Pemeriksaan</span>
                    </a>
                    <a href="{{ route('patient.prescriptions') }}" class="top-pill-nav {{ request()->routeIs('patient.prescriptions') ? 'top-pill-active' : '' }}">
                        <span class="top-pill-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 0 0-1.022-.547l-2.387-.477a6 6 0 0 0-3.86.517l-.318.158a6 6 0 0 1-3.86.517L6.05 15.21a2 2 0 0 0-1.806.547M8 4h8l-1 1v5.172a2 2 0 0 0 .586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 0 0 9 10.172V5L8 4z" />
                            </svg>
                        </span>
                        <span>Resep Obat</span>
                    </a>
                </div>
                @elseif(auth()->user()->role === 'petugas')
                <div class="hidden md:flex items-center gap-1 overflow-x-auto scrollbar-hide flex-1 min-w-0">
                    <a href="{{ route('petugas.dashboard') }}" class="top-pill-nav {{ request()->routeIs('petugas.dashboard') ? 'top-pill-active' : '' }}">
                        <span class="top-pill-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-8 9 8M4 10v10h16V10" />
                            </svg>
                        </span>
                        <span>Dashboard Petugas</span>
                        @if($petugasPrescriptionBadge > 0)
                            <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-[11px] font-bold bg-rose-500 text-white">{{ $petugasPrescriptionBadge }}</span>
                        @endif
                    </a>
                </div>
                @endif
                @endauth

                {{-- Right: user badge + mobile burger --}}
                <div class="flex items-center gap-3 shrink-0">
                    <img src="{{ asset('images/kampusnavlogo.png') }}" alt="Campus Logo" class="h-9 object-contain hidden sm:block">
                    @auth
                    <div class="hidden sm:flex items-center gap-2 text-sm text-gray-600">
                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-700">{{ auth()->user()->name }}</span>
                    </div>
                    @endauth

                    {{-- Dark mode toggle --}}
                    <button onclick="toggleDarkMode()" id="theme-toggle-btn" aria-label="Toggle dark mode"
                            class="theme-btn p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 transition-all duration-300">
                        {{-- sun icon (tampil saat dark) --}}
                        <svg id="icon-sun" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25M12 18.75V21M4.22 4.22l1.59 1.59M16.19 16.19l1.59 1.59M3 12h2.25M18.75 12H21M4.22 19.78l1.59-1.59M16.19 7.81l1.59-1.59M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                        </svg>
                        {{-- moon icon (tampil saat light) --}}
                        <svg id="icon-moon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z"/>
                        </svg>
                    </button>

                    {{-- Mobile burger (patient only) --}}
                    @auth
                        @if(in_array(auth()->user()->role, ['patient', 'petugas'], true))
                    <button @click="mobileOpen=!mobileOpen" aria-label="Menu"
                            class="md:hidden p-2 rounded-xl hover:bg-green-50 transition">
                        <svg class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileOpen"  stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                    @endif
                    @endauth
                </div>
            </div>
        </div>

        {{-- Mobile dropdown menu (patient only) --}}
        @auth
        @if(in_array(auth()->user()->role, ['patient', 'petugas'], true))
        <div x-show="mobileOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden bg-white border-t border-green-100 px-4 py-3 shadow-lg">
            <div class="flex flex-col gap-1">
                @if(auth()->user()->role === 'patient')
                <a href="{{ route('dashboard') }}" @click="mobileOpen=false" class="mobile-nav-link {{ request()->routeIs('dashboard') ? 'mobile-nav-active' : '' }}">
                    <span class="mobile-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-8 9 8M4 10v10h16V10" />
                        </svg>
                    </span>
                    <div class="flex-1">
                        <span class="mobile-nav-title">Dashboard</span>
                        <span class="mobile-nav-desc">Halaman utama</span>
                    </div>
                </a>
                <a href="{{ route('patient.profile') }}" @click="mobileOpen=false" class="mobile-nav-link {{ request()->routeIs('patient.profile') ? 'mobile-nav-active' : '' }}">
                    <span class="mobile-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </span>
                    <div class="flex-1">
                        <span class="mobile-nav-title">Profil Saya</span>
                        <span class="mobile-nav-desc">Kelola data diri & identitas</span>
                    </div>
                </a>
                <a href="{{ route('queue.create') }}" @click="mobileOpen=false" class="mobile-nav-link {{ request()->routeIs('queue.create') ? 'mobile-nav-active' : '' }}">
                    <span class="mobile-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                        </svg>
                    </span>
                    <div class="flex-1">
                        <span class="mobile-nav-title">Daftar Antrian</span>
                        <span class="mobile-nav-desc">Daftar berobat baru</span>
                    </div>
                </a>
                <a href="{{ route('patient.registrations') }}" @click="mobileOpen=false" class="mobile-nav-link {{ request()->routeIs('patient.registrations') ? 'mobile-nav-active' : '' }}">
                    <span class="mobile-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3M4 12a8 8 0 1116 0 8 8 0 01-16 0z" />
                        </svg>
                    </span>
                    <div class="flex-1">
                        <span class="mobile-nav-title">Riwayat</span>
                        <span class="mobile-nav-desc">Riwayat pendaftaran antrian</span>
                    </div>
                </a>
                <a href="{{ route('patient.display') }}" @click="mobileOpen=false" class="mobile-nav-link {{ request()->routeIs('patient.display') ? 'mobile-nav-active' : '' }}">
                    <span class="mobile-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h18M3 12h18M3 19h18" />
                        </svg>
                    </span>
                    <div class="flex-1">
                        <span class="mobile-nav-title">Display Antrian</span>
                        <span class="mobile-nav-desc">Nomor antrian dan jumlah per klaster</span>
                    </div>
                </a>
                <a href="{{ route('patient.examinations') }}" @click="mobileOpen=false" class="mobile-nav-link {{ request()->routeIs('patient.examinations*') ? 'mobile-nav-active' : '' }}">
                    <span class="mobile-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </span>
                    <div class="flex-1">
                        <span class="mobile-nav-title">Riwayat Pemeriksaan</span>
                        <span class="mobile-nav-desc">Data rekam medis (hanya baca)</span>
                    </div>
                </a>
                <a href="{{ route('patient.prescriptions') }}" @click="mobileOpen=false" class="mobile-nav-link {{ request()->routeIs('patient.prescriptions') ? 'mobile-nav-active' : '' }}">
                    <span class="mobile-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 0 0-1.022-.547l-2.387-.477a6 6 0 0 0-3.86.517l-.318.158a6 6 0 0 1-3.86.517L6.05 15.21a2 2 0 0 0-1.806.547M8 4h8l-1 1v5.172a2 2 0 0 0 .586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 0 0 9 10.172V5L8 4z" />
                        </svg>
                    </span>
                    <div class="flex-1">
                        <span class="mobile-nav-title">Resep Obat</span>
                        <span class="mobile-nav-desc">Daftar resep obat (hanya baca)</span>
                    </div>
                </a>
                @elseif(auth()->user()->role === 'petugas')
                <a href="{{ route('petugas.dashboard') }}" @click="mobileOpen=false" class="mobile-nav-link {{ request()->routeIs('petugas.dashboard') ? 'mobile-nav-active' : '' }}">
                    <span class="mobile-nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-8 9 8M4 10v10h16V10" />
                        </svg>
                    </span>
                    <div class="flex-1">
                        <span class="mobile-nav-title">Dashboard Petugas</span>
                        <span class="mobile-nav-desc">Kelola antrian klaster layanan
                            @if($petugasPrescriptionBadge > 0)
                                • {{ $petugasPrescriptionBadge }} resep masuk
                            @endif
                        </span>
                    </div>
                    @if($petugasPrescriptionBadge > 0)
                        <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-[11px] font-bold bg-rose-500 text-white">{{ $petugasPrescriptionBadge }}</span>
                    @endif
                </a>
                @endif

                {{-- Divider --}}
                <div style="height: 1px; background: #e5e7eb; margin: 4px 0;"></div>

                {{-- User info + Logout --}}
                <div class="flex items-center gap-3 px-3 py-2">
                    <div class="w-9 h-9 rounded-full bg-green-100 flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('logout.get') }}" class="p-2 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition" title="Logout">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endif
        @endauth
    </nav>

    {{-- Admin Sidebar --}}
    @auth
    @if(auth()->user()->role === 'admin')
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>
    <aside id="adminSidebar" class="admin-sidebar">
        {{-- Sidebar header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-green-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-7 3a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H8a1 1 0 110-2h3V7a1 1 0 011-1z"/>
                    </svg>
                </div>
                <div>
                    <span class="font-extrabold text-sm text-gray-900">Sistem <span class="text-green-500">Antrian</span></span>
                    <p class="text-xs text-gray-400 -mt-0.5">Puskesmas Mapurujaya</p>
                </div>
            </div>
            <button onclick="toggleSidebar()" class="p-1.5 rounded-lg hover:bg-green-50 transition text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Navigation --}}
        <div class="py-3">
            <div class="sidebar-label">Navigasi</div>

            <a href="{{ route('admin.dashboard', ['section' => 'dashboard']) }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') && request('section', 'dashboard') === 'dashboard' ? 'sidebar-link-active' : '' }}">
                <span class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-8 9 8M4 10v10h16V10"/></svg>
                </span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.patients') }}" class="sidebar-link {{ request()->routeIs('admin.patients*') ? 'sidebar-link-active' : '' }}">
                <span class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 12a4 4 0 100-8 4 4 0 000 8zm0 2c-4.418 0-8 1.79-8 4v2h16v-2c0-2.21-3.582-4-8-4z"/></svg>
                </span>
                <span>Pasien</span>
            </a>
            <a href="{{ route('admin.petugas') }}" class="sidebar-link {{ request()->routeIs('admin.petugas*') ? 'sidebar-link-active' : '' }}">
                <span class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 20H4v-2a3 3 0 015.356-1.857M9 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <span>Petugas</span>
            </a>
            <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings*') ? 'sidebar-link-active' : '' }}">
                <span class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <span>Pengaturan Display & WA API</span>
            </a>
            <a href="{{ route('queue.display') }}" target="_blank" class="sidebar-link">
                <span class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </span>
                <span>Display</span>
            </a>

            @if(request()->routeIs('admin.dashboard'))
            <div class="sidebar-divider"></div>
            <div class="sidebar-label">Dashboard</div>

            <a href="{{ route('admin.dashboard', ['section' => 'dashboard']) }}" onclick="toggleSidebar()" class="sidebar-link {{ in_array(request('section', 'dashboard'), ['dashboard', 'scan-qr', 'verifikasi-pasien', 'persetujuan-antrian', 'menunggu-scan', 'ringkasan-antrian'], true) ? 'sidebar-link-active' : '' }}">
                <span class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                </span>
                <span>Scan QR di Dashboard</span>
            </a>
            <a href="{{ route('admin.dashboard', ['section' => 'wa-audit']) }}" onclick="toggleSidebar()" class="sidebar-link {{ request('section', 'dashboard') === 'wa-audit' ? 'sidebar-link-active' : '' }}">
                <span class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </span>
                <span>Audit Notifikasi WA</span>
            </a>
            <a href="{{ route('admin.dashboard', ['section' => 'statistik-ringkas']) }}" onclick="toggleSidebar()" class="sidebar-link {{ request('section', 'dashboard') === 'statistik-ringkas' ? 'sidebar-link-active' : '' }}">
                <span class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </span>
                <span>Statistik Ringkas</span>
            </a>
            <a href="{{ route('admin.dashboard', ['section' => 'klaster-keluhan']) }}" onclick="toggleSidebar()" class="sidebar-link {{ request('section', 'dashboard') === 'klaster-keluhan' ? 'sidebar-link-active' : '' }}">
                <span class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </span>
                <span>Klaster & Keluhan</span>
            </a>
            <a href="{{ route('admin.dashboard', ['section' => 'akun-pasien']) }}" onclick="toggleSidebar()" class="sidebar-link {{ request('section', 'dashboard') === 'akun-pasien' ? 'sidebar-link-active' : '' }}">
                <span class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <span>Data Akun Pasien</span>
            </a>
            <a href="{{ route('admin.dashboard', ['section' => 'dashboard']) }}" onclick="toggleSidebar()" class="sidebar-link {{ in_array(request('section', 'dashboard'), ['dashboard', 'verifikasi-pasien', 'persetujuan-antrian', 'menunggu-scan', 'ringkasan-antrian'], true) ? 'sidebar-link-active' : '' }}">
                <span class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </span>
                <span>Verifikasi Pasien</span>
            </a>
            <a href="{{ route('admin.dashboard', ['section' => 'dashboard']) }}" onclick="toggleSidebar()" class="sidebar-link {{ in_array(request('section', 'dashboard'), ['dashboard', 'verifikasi-pasien', 'persetujuan-antrian', 'menunggu-scan', 'ringkasan-antrian'], true) ? 'sidebar-link-active' : '' }}">
                <span class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </span>
                <span>Persetujuan Antrian</span>
            </a>
            <a href="{{ route('admin.dashboard', ['section' => 'dashboard']) }}" onclick="toggleSidebar()" class="sidebar-link {{ in_array(request('section', 'dashboard'), ['dashboard', 'verifikasi-pasien', 'persetujuan-antrian', 'menunggu-scan', 'ringkasan-antrian'], true) ? 'sidebar-link-active' : '' }}">
                <span class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <span>Menunggu Scan</span>
            </a>
            <a href="{{ route('admin.dashboard', ['section' => 'dashboard']) }}" onclick="toggleSidebar()" class="sidebar-link {{ in_array(request('section', 'dashboard'), ['dashboard', 'verifikasi-pasien', 'persetujuan-antrian', 'menunggu-scan', 'ringkasan-antrian'], true) ? 'sidebar-link-active' : '' }}">
                <span class="sidebar-icon">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </span>
                <span>Ringkasan Antrian</span>
            </a>
            @endif

            <div class="sidebar-divider"></div>

            {{-- Logout --}}
            <a href="{{ route('logout.get') }}" class="sidebar-link" style="color: #ef4444;">
                <span class="sidebar-icon" style="background: #fef2f2;">
                    <svg class="w-4 h-4" style="color: #ef4444;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </span>
                <span>Logout</span>
            </a>
        </div>
    </aside>
    @endif
    @endauth

    <main class="page-content-full w-full pb-10 px-0 pt-20">
        @yield('content')
    </main>

    {{-- Footer (MindCare v2 Style) --}}
    <footer class="bg-gray-950 text-gray-400 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-10 mb-12">

                {{-- Brand --}}
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-7 3a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H8a1 1 0 110-2h3V7a1 1 0 011-1z"/>
                            </svg>
                        </div>
                        <span class="font-extrabold text-lg text-white">Sistem <span class="text-green-400">Antrian</span></span>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-500 max-w-xs">
                        Sistem Antrian digital Puskesmas Mapurujaya untuk pelayanan kesehatan yang lebih efisien dan terorganisir.
                    </p>
                    <div class="flex gap-3 mt-5">
                        <span class="w-9 h-9 rounded-full bg-gray-800 flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.373 0 0 5.373 0 12c0 2.119.553 4.107 1.524 5.833L0 24l6.392-1.502A11.955 11.955 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0z"/>
                            </svg>
                        </span>
                        <span class="w-9 h-9 rounded-full bg-gray-800 flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919C21.988 8.416 22 8.796 22 12c0 3.204-.012 3.584-.07 4.85-.148 3.225-1.664 4.771-4.919 4.919C15.584 21.988 15.204 22 12 22c-3.204 0-3.584-.012-4.85-.07-3.26-.149-4.771-1.699-4.919-4.92C2.012 15.584 2 15.204 2 12c0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919C8.416 2.012 8.796 2 12 2z"/>
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="text-white font-bold text-sm mb-4">Menu</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ auth()->check() ? (auth()->user()->role === 'admin' ? route('admin.dashboard') : route('dashboard')) : url('/') }}" class="hover:text-green-400 transition">Dashboard</a></li>
                        @auth
                        @if(auth()->user()->role === 'admin')
                        <li><a href="{{ route('admin.patients') }}" class="hover:text-green-400 transition">Data Pasien</a></li>
                        <li><a href="{{ route('admin.petugas') }}" class="hover:text-green-400 transition">Akun Petugas</a></li>
                        <li><a href="{{ route('admin.settings') }}" class="hover:text-green-400 transition">Pengaturan Display & WA API</a></li>
                        <li><a href="{{ route('queue.display') }}" target="_blank" class="hover:text-green-400 transition">Display Antrian</a></li>
                        @else
                        <li><a href="{{ route('queue.create') }}" class="hover:text-green-400 transition">Daftar Antrian</a></li>
                        <li><a href="{{ route('patient.registrations') }}" class="hover:text-green-400 transition">Riwayat</a></li>
                        @endif
                        @endauth
                    </ul>
                </div>

                {{-- Info --}}
                <div>
                    <h4 class="text-white font-bold text-sm mb-4">Informasi</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-green-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                            </svg>
                            <span>Puskesmas Mapurujaya</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Senin - Sabtu, 08:00 - 17:00</span>
                            <span>PELAYANAN UGD (MALAM) </span>
                        </li>
                        <li class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Sistem Antrian v1.0</span>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-white-600">
                <p>&copy; {{ date('Y') }}   <var>Vinsensius Danang Viggo Sudianto   225 120 47</var>.</p>
                <nav class="flex gap-6">
                    <span class="text-gray-500">Powered by Antropusma</span>
                </nav>
            </div>
        </div>
    </footer>

    {{-- Scroll to Top Button --}}
    <button id="scrollTopBtn" class="scroll-top-btn" onclick="window.scrollTo({top:0,behavior:'smooth'})" title="Scroll ke atas">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    {{-- Floating Logout Button --}}
    @auth
    <a href="{{ route('logout.get') }}" id="logoutFloatBtn" class="logout-float-btn" title="Logout">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        <span>Logout</span>
    </a>
    @endauth

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

        // Scroll to top button + floating logout visibility
        (function() {
            var btn = document.getElementById('scrollTopBtn');
            var logoutBtn = document.getElementById('logoutFloatBtn');
            if (btn || logoutBtn) {
                window.addEventListener('scroll', function() {
                    var show = window.scrollY > 300;
                    if (btn) { btn.classList.toggle('show', show); }
                    if (logoutBtn) { logoutBtn.classList.toggle('show', show); }
                });
            }
        })();

        // Admin Sidebar toggle
        function toggleSidebar() {
            var sidebar = document.getElementById('adminSidebar');
            var overlay = document.getElementById('sidebarOverlay');
            if (sidebar) {
                sidebar.classList.toggle('open');
            }
            if (overlay) {
                overlay.classList.toggle('show');
            }
        }

        // Scroll-reveal: IntersectionObserver
        (function() {
            var revealEls = document.querySelectorAll('.reveal');
            if (revealEls.length > 0) {
                var observerCtor = window.IntersectionObserver;
                if (!observerCtor) {
                    return;
                }
                var observer = new observerCtor(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.12 });
                revealEls.forEach(function(el) { observer.observe(el); });
            }
        })();
    </script>

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
            updateThemeIcons();
        }

        function updateThemeIcons() {
            var isDark = document.documentElement.classList.contains('dark');
            var sun = document.getElementById('icon-sun');
            var moon = document.getElementById('icon-moon');
            if (sun && moon) {
                sun.classList.toggle('hidden', !isDark);
                moon.classList.toggle('hidden', isDark);
            }
        }

        // Sync icon state on page load
        document.addEventListener('DOMContentLoaded', updateThemeIcons);
    </script>

</body>
</html>
