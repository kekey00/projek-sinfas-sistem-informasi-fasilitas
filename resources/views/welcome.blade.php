<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SINFAS — Sistem Informasi & Inventaris Fasilitas Sekolah Terpadu. Akses peminjaman sarana prasarana mudah, transparan, dan realtime.">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/sinfas-logo.svg'))) }}">
    <title>SINFAS — Sistem Informasi Fasilitas Sekolah Modern</title>

    <!-- Google Fonts: Outfit (Headings) & Plus Jakarta Sans (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            /* SINFAS Official Signature Palette (Harmonized with User & Login pages) */
            --brand-primary: #3B5998;
            --brand-dark: #2C4A7C;
            --brand-deep: #152238;
            --brand-abyss: #0E1726;
            --brand-violet: #5B8DEF;
            --brand-light: #7BA7D9;
            --brand-cyan: #06B6D4;
            --brand-cyan-light: #67E8F9;
            
            --brand-gradient: linear-gradient(135deg, #7BA7D9 0%, #3B5998 50%, #2C4A7C 100%);
            --brand-gradient-action: linear-gradient(135deg, #5B8DEF 0%, #3B5998 50%, #2C4A7C 100%);
            --brand-gradient-hover: linear-gradient(135deg, #5B8DEF 0%, #2C4A7C 100%);
            --hero-gradient: linear-gradient(165deg, #182848 0%, #2C4A7C 48%, #141F35 100%);
            
            --text-main: #0F172A;
            --text-secondary: #475569;
            --text-muted: #64748B;
            --text-light: #94A3B8;
            
            --bg-canvas: #F8FAFC;
            --surface-glass: rgba(255, 255, 255, 0.92);
            --border-subtle: #E2E8F0;
            --border-glow: rgba(91, 141, 239, 0.4);
            
            --radius-pill: 9999px;
            --radius-card: 22px;
            --radius-sub: 16px;
            
            --shadow-glow: 0 10px 30px -4px rgba(59, 89, 152, 0.45);
            --shadow-card: 0 10px 30px -5px rgba(15, 23, 42, 0.06), 0 4px 10px -2px rgba(15, 23, 42, 0.02);
            --shadow-card-hover: 0 20px 35px -8px rgba(59, 89, 152, 0.18), 0 8px 16px -4px rgba(15, 23, 42, 0.06);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-canvas);
            background-image: radial-gradient(at 0% 0%, rgba(91, 141, 239, 0.06) 0px, transparent 50%),
                              radial-gradient(at 100% 0%, rgba(123, 167, 217, 0.05) 0px, transparent 50%),
                              radial-gradient(at 50% 100%, rgba(6, 182, 212, 0.04) 0px, transparent 50%);
            background-attachment: fixed;
            color: var(--text-main);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.22s ease;
        }

        button {
            font-family: inherit;
            cursor: pointer;
            border: none;
            background: none;
        }

        .container {
            width: min(100% - 48px, 1240px);
            margin: 0 auto;
        }

        /* ----------------------------------------------------
           NAVBAR (Sticky SINFAS Glass)
        ---------------------------------------------------- */
        .glass-navbar-wrap {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(20, 31, 53, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            padding: 14px 0;
            transition: all 0.3s ease;
        }

        .navbar-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-link {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        /* School Logo Badge (Navbar) */
        .school-logo-badge-nav {
            display: inline-flex;
            align-items: center;
            gap: 14px;
        }

        .school-logo-divider {
            width: 1px;
            height: 32px;
            background: rgba(255, 255, 255, 0.2);
            flex-shrink: 0;
        }

        .school-logo-img-nav {
            width: 38px;
            height: 38px;
            object-fit: contain;
            border-radius: 8px;
            filter: drop-shadow(0 2px 8px rgba(0,0,0,0.2));
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .school-logo-badge-nav:hover .school-logo-img-nav {
            transform: scale(1.08);
        }

        .school-name-text-nav {
            display: flex;
            flex-direction: column;
        }

        .school-name-text-nav strong {
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.1;
            letter-spacing: -0.2px;
        }

        .school-name-text-nav span {
            font-size: 9.5px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.6);
            letter-spacing: 0.3px;
        }

        .brand-icon-wrap {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--brand-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 4px 16px rgba(59, 89, 152, 0.45);
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            overflow: hidden;
            flex-shrink: 0;
        }

        .brand-link:hover .brand-icon-wrap {
            transform: scale(1.08) rotate(-4deg);
        }

        .brand-logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-text-block {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-family: 'Outfit', sans-serif;
            font-size: 22px;
            font-weight: 900;
            letter-spacing: -0.5px;
            line-height: 1;
            color: #ffffff;
        }

        .brand-title span {
            color: var(--brand-cyan-light);
        }

        .brand-sub {
            font-size: 10px;
            font-weight: 700;
            color: var(--brand-light);
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin-top: 3px;
        }

        .nav-links-row {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }

        .nav-links-row a {
            font-size: 14px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.82);
            position: relative;
        }

        .nav-links-row a:hover {
            color: #ffffff;
        }

        .nav-links-row a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -6px;
            width: 0;
            height: 2px;
            background: var(--brand-cyan);
            transition: width 0.22s ease;
            border-radius: var(--radius-pill);
        }

        .nav-links-row a:hover::after {
            width: 100%;
        }

        .nav-cta-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-brand-primary {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 10px 24px;
            border-radius: var(--radius-pill);
            background: var(--brand-gradient-action);
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 700;
            box-shadow: var(--shadow-glow);
            transition: all 0.25s ease;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        .btn-brand-primary:hover {
            background: var(--brand-gradient-hover);
            transform: translateY(-2px);
            box-shadow: 0 14px 34px -4px rgba(91, 141, 239, 0.55);
        }

        /* ----------------------------------------------------
           HERO SECTION (Edu-Tech SINFAS Navy-Blue)
        ---------------------------------------------------- */
        .hero-edutech {
            background: var(--hero-gradient);
            color: #ffffff;
            position: relative;
            padding: 80px 0 130px;
            overflow: hidden;
        }

        .hero-edutech::before {
            content: '';
            position: absolute;
            top: -15%;
            left: 10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(91, 141, 239, 0.26) 0%, transparent 68%);
            pointer-events: none;
            filter: blur(55px);
        }

        .hero-edutech::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 5%;
            width: 520px;
            height: 520px;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.22) 0%, transparent 70%);
            pointer-events: none;
            filter: blur(60px);
        }

        .hero-grid-2col {
            display: grid;
            grid-template-columns: 1.15fr 0.95fr;
            align-items: center;
            gap: 52px;
            position: relative;
            z-index: 2;
        }

        .hero-kicker-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: var(--radius-pill);
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(8px);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: var(--brand-cyan-light);
            margin-bottom: 22px;
        }

        /* Hero School Identity Badge */
        .hero-school-identity {
            display: inline-flex;
            align-items: center;
            gap: 16px;
            padding: 14px 22px 14px 16px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 20px;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            margin-bottom: 28px;
            animation: floatBadge 4s ease-in-out infinite;
        }

        @keyframes floatBadge {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        .hero-school-logo-glow {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 20px rgba(91, 141, 239, 0.25), inset 0 0 12px rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
        }

        .hero-school-logo-glow::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, transparent 50%);
            border-radius: inherit;
        }

        .hero-school-logo-glow img {
            width: 42px;
            height: 42px;
            object-fit: contain;
            filter: drop-shadow(0 2px 6px rgba(0,0,0,0.15));
            position: relative;
            z-index: 1;
        }

        .hero-school-info {
            display: flex;
            flex-direction: column;
        }

        .hero-school-info strong {
            font-family: 'Outfit', sans-serif;
            font-size: 16px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.15;
            letter-spacing: -0.3px;
        }

        .hero-school-info span {
            font-size: 11.5px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.65);
            margin-top: 3px;
            letter-spacing: 0.2px;
        }

        .live-pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10B981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.35);
            animation: pulseGlow 2s infinite;
        }

        @keyframes pulseGlow {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
            70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .hero-heading {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(42px, 5.2vw, 64px);
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -1.2px;
            margin-bottom: 22px;
        }

        .gradient-headline {
            background: linear-gradient(135deg, #A5C4F7 0%, #67E8F9 50%, #93C5FD 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-subtext {
            font-size: 16px;
            line-height: 1.75;
            color: rgba(255, 255, 255, 0.82);
            max-width: 530px;
            margin-bottom: 38px;
        }

        .hero-btn-group {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn-glass-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: var(--radius-pill);
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.22);
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            backdrop-filter: blur(10px);
            transition: all 0.2s ease;
        }

        .btn-glass-secondary:hover {
            background: rgba(255, 255, 255, 0.16);
            transform: translateY(-2px);
        }

        /* Hero Right: Modern Glass Dashboard Mockup */
        .glass-showcase-panel {
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 28px;
            padding: 28px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 30px 60px -12px rgba(10, 20, 40, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.1) inset;
            position: relative;
        }

        .showcase-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            margin-bottom: 20px;
        }

        .showcase-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-circle-pulse {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--brand-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 14px;
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(59, 89, 152, 0.35);
        }

        .showcase-user-text strong {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #ffffff;
        }

        .showcase-user-text span {
            font-size: 11px;
            color: var(--brand-cyan-light);
        }

        .status-badge-live {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            background: rgba(16, 185, 129, 0.18);
            border: 1px solid rgba(16, 185, 129, 0.4);
            border-radius: var(--radius-pill);
            color: #34D399;
            font-size: 11px;
            font-weight: 700;
        }

        .showcase-card-stack {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 20px;
        }

        .mini-facility-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(20, 32, 56, 0.65);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 14px 16px;
            transition: all 0.2s ease;
        }

        .mini-facility-row:hover {
            background: rgba(35, 53, 90, 0.85);
            border-color: rgba(91, 141, 239, 0.4);
            transform: translateX(4px);
        }

        .mini-facility-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .facility-icon-square {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            background: rgba(59, 89, 152, 0.3);
            border: 1px solid rgba(91, 141, 239, 0.4);
            color: var(--brand-cyan-light);
        }

        .facility-name-block strong {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
        }

        .facility-name-block span {
            font-size: 11px;
            color: var(--brand-light);
        }

        .badge-ready {
            font-size: 11px;
            font-weight: 700;
            color: #34D399;
            background: rgba(16, 185, 129, 0.15);
            padding: 4px 10px;
            border-radius: var(--radius-pill);
        }

        .badge-queue {
            font-size: 11px;
            font-weight: 700;
            color: #FBBF24;
            background: rgba(251, 191, 36, 0.15);
            padding: 4px 10px;
            border-radius: var(--radius-pill);
        }

        .showcase-footer-action {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 12px 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .showcase-footer-action span {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.75);
        }

        .link-quick-borrow {
            color: var(--brand-cyan-light);
            font-size: 12px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .link-quick-borrow:hover {
            color: #ffffff;
            transform: translateX(3px);
        }

        /* ----------------------------------------------------
           METRICS COUNTER SECTION (Floating Edu-Tech KPI Bar)
        ---------------------------------------------------- */
        .metrics-floating-bar {
            margin-top: -60px;
            position: relative;
            z-index: 10;
        }

        .metrics-glass-box {
            background: #ffffff;
            border-radius: var(--radius-card);
            border: 1px solid var(--border-subtle);
            padding: 34px 44px;
            box-shadow: var(--shadow-card);
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 28px;
        }

        .metric-cell {
            display: flex;
            align-items: center;
            gap: 16px;
            border-right: 1px solid #EDF2F7;
            padding-right: 16px;
        }

        .metric-cell:last-child {
            border-right: none;
            padding-right: 0;
        }

        .metric-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: #EEF4FF;
            color: var(--brand-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .metric-cell:nth-child(2) .metric-icon-box { background: #ECFEFF; color: #0891B2; }
        .metric-cell:nth-child(3) .metric-icon-box { background: #ECFDF5; color: #059669; }
        .metric-cell:nth-child(4) .metric-icon-box { background: #F1F5F9; color: var(--brand-dark); }

        .metric-val {
            font-family: 'Outfit', sans-serif;
            font-size: 32px;
            font-weight: 800;
            color: var(--brand-dark);
            line-height: 1;
            margin-bottom: 4px;
        }

        .metric-desc {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            line-height: 1.35;
        }

        /* ----------------------------------------------------
           SPOILER / KATALOG BARANG USER STYLE (The Requested Section)
        ---------------------------------------------------- */
        .spoiler-section {
            padding: 96px 0 84px;
        }

        .section-header-center {
            text-align: center;
            max-width: 680px;
            margin: 0 auto 44px;
        }

        .section-tag {
            display: inline-block;
            font-size: 11px;
            font-weight: 800;
            color: var(--brand-primary);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .section-title {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(32px, 3.8vw, 44px);
            font-weight: 800;
            letter-spacing: -0.6px;
            color: var(--brand-dark);
            margin-bottom: 14px;
        }

        .section-subtitle {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.65;
        }

        /* User Dashboard Grid Style */
        .user-spoiler-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 40px;
        }

        .card-facility-vibe {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 22px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08);
            position: relative;
            cursor: pointer;
        }

        .card-facility-vibe:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 35px -8px rgba(59, 89, 152, 0.18), 0 8px 16px -4px rgba(15, 23, 42, 0.06);
            border-color: #5B8DEF;
        }

        .card-image-aspect {
            position: relative;
            width: 100%;
            height: 195px;
            background: linear-gradient(135deg, #F8FAFC, #EEF4FF);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 14px;
        }

        .card-image-aspect img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.08));
        }

        .card-facility-vibe:hover .card-image-aspect img {
            transform: scale(1.06);
        }

        /* Floating Status Pill */
        .status-pill-floating {
            position: absolute;
            top: 12px;
            right: 12px;
            padding: 5px 12px;
            border-radius: var(--radius-pill);
            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: 0.2px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            z-index: 2;
        }

        .status-pill-floating.available {
            background: rgba(236, 253, 245, 0.95);
            color: #047857;
            border: 1px solid #A7F3D0;
        }

        .status-dot-pulse {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
            box-shadow: 0 0 6px #10B981;
        }

        .card-detail-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .card-item-title {
            font-size: 17px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .card-item-tag {
            font-size: 12.5px;
            font-weight: 600;
            color: #3B5998;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .btn-loan-request-modern {
            margin-top: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 16px;
            border-radius: var(--radius-pill);
            background: linear-gradient(135deg, #7BA7D9 0%, #3B5998 50%, #2C4A7C 100%);
            color: #FFFFFF !important;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(59, 89, 152, 0.35);
            transition: all 0.22s ease;
        }

        .card-facility-vibe:hover .btn-loan-request-modern {
            background: linear-gradient(135deg, #5B8DEF 0%, #2C4A7C 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 89, 152, 0.45);
        }

        /* ----------------------------------------------------
           FAQ SECTION (Accordion)
        ---------------------------------------------------- */
        .faq-section-wrap {
            padding: 80px 0 96px;
            border-top: 1px solid var(--border-subtle);
        }

        .faq-layout-split {
            display: grid;
            grid-template-columns: 0.85fr 1.15fr;
            gap: 64px;
            align-items: start;
        }

        .faq-sticky-left h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 38px;
            font-weight: 800;
            letter-spacing: -0.6px;
            color: var(--brand-dark);
            margin-bottom: 16px;
            line-height: 1.15;
        }

        .faq-sticky-left p {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 32px;
        }

        .faq-contact-card {
            background: #ffffff;
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            padding: 24px;
            box-shadow: var(--shadow-card);
        }

        .faq-contact-card strong {
            display: block;
            font-size: 14px;
            color: var(--brand-dark);
            margin-bottom: 4px;
        }

        .faq-contact-card span {
            font-size: 12px;
            color: var(--text-muted);
        }

        .faq-accordion-group {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .faq-box-card {
            background: #ffffff;
            border: 1px solid var(--border-subtle);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: var(--shadow-card);
            transition: border-color 0.2s ease;
        }

        .faq-box-card.active {
            border-color: var(--brand-violet);
        }

        .faq-btn-trigger {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 24px;
            text-align: left;
            font-family: 'Outfit', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--brand-dark);
            cursor: pointer;
        }

        .faq-btn-trigger:hover {
            color: var(--brand-primary);
        }

        .faq-icon-arrow {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #F1F5F9;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: var(--text-muted);
            transition: transform 0.25s ease, background 0.2s ease;
            flex-shrink: 0;
        }

        .faq-box-card.active .faq-icon-arrow {
            transform: rotate(90deg);
            background: var(--brand-primary);
            color: #ffffff;
        }

        .faq-body-text {
            display: none;
            padding: 0 24px 22px;
            font-size: 14px;
            line-height: 1.7;
            color: var(--text-muted);
            border-top: 1px solid #F8FAFC;
        }

        .faq-box-card.active .faq-body-text {
            display: block;
        }

        /* ----------------------------------------------------
           CTA CALLOUT BANNER (SINFAS Gradient)
        ---------------------------------------------------- */
        .callout-banner-section {
            padding: 20px 0 84px;
        }

        .callout-card-glow {
            background: var(--brand-gradient);
            border-radius: 32px;
            padding: 56px 48px;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 36px;
            box-shadow: 0 20px 50px -12px rgba(44, 74, 124, 0.45);
            position: relative;
            overflow: hidden;
        }

        .callout-card-glow::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.16) 0%, transparent 70%);
            pointer-events: none;
        }

        .callout-text h2 {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(28px, 3.5vw, 38px);
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 12px;
        }

        .callout-text p {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.9);
            max-width: 560px;
        }

        /* ----------------------------------------------------
           FOOTER (Deep Navy SINFAS)
        ---------------------------------------------------- */
        .site-footer-deep {
            background: var(--brand-deep);
            color: #ffffff;
            padding: 72px 0 32px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .footer-grid-4col {
            display: grid;
            grid-template-columns: 1.6fr 1fr 1fr 1.2fr;
            gap: 48px;
            padding-bottom: 48px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-brand-title {
            font-family: 'Outfit', sans-serif;
            font-size: 24px;
            font-weight: 900;
            letter-spacing: -0.5px;
            color: #ffffff;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-brand-title span {
            color: var(--brand-cyan-light);
        }

        /* Footer School Logo */
        .footer-school-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            padding: 10px 14px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            max-width: 280px;
        }

        .footer-school-badge img {
            width: 36px;
            height: 36px;
            object-fit: contain;
            filter: drop-shadow(0 2px 6px rgba(0,0,0,0.2));
        }

        .footer-school-badge-text {
            display: flex;
            flex-direction: column;
        }

        .footer-school-badge-text strong {
            font-size: 12px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
        }

        .footer-school-badge-text span {
            font-size: 10px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.55);
        }

        .footer-col-title {
            font-family: 'Outfit', sans-serif;
            font-size: 16px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 18px;
            letter-spacing: -0.2px;
        }

        .footer-nav-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .footer-nav-list a {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.75);
        }

        .footer-nav-list a:hover {
            color: #ffffff;
            transform: translateX(4px);
        }

        .footer-contact-block {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.75);
            line-height: 1.7;
        }

        .footer-copyright-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 28px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.65);
        }

        /* ----------------------------------------------------
           SPOILER LOGIN REQUIRED MODAL
        ---------------------------------------------------- */
        .spoiler-modal-shade {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeIn 0.2s ease;
        }

        .spoiler-modal-card {
            background: #FFFFFF;
            border-radius: 28px;
            max-width: 440px;
            width: 100%;
            padding: 34px 30px;
            box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.35);
            text-align: center;
            animation: scaleUp 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes scaleUp {
            from { opacity: 0; transform: scale(0.92); }
            to { opacity: 1; transform: scale(1); }
        }

        .spoiler-modal-icon {
            width: 64px;
            height: 64px;
            border-radius: 20px;
            background: #EEF4FF;
            color: #3B5998;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            box-shadow: 0 8px 20px rgba(59, 89, 152, 0.2);
        }

        .spoiler-modal-title {
            font-family: 'Outfit', sans-serif;
            font-size: 22px;
            font-weight: 800;
            color: #1E293B;
            margin-bottom: 8px;
        }

        .spoiler-modal-desc {
            font-size: 14px;
            color: #64748B;
            line-height: 1.6;
            margin-bottom: 26px;
        }

        .spoiler-modal-actions {
            display: flex;
            gap: 12px;
        }

        .btn-modal-cancel {
            flex: 1;
            padding: 12px 18px;
            border-radius: var(--radius-pill);
            background: #F1F5F9;
            color: #475569;
            font-size: 13.5px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-modal-cancel:hover {
            background: #E2E8F0;
            color: #0F172A;
        }

        .btn-modal-login {
            flex: 1.4;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: var(--radius-pill);
            background: linear-gradient(135deg, #5B8DEF 0%, #3B5998 50%, #2C4A7C 100%);
            color: #FFFFFF !important;
            font-size: 13.5px;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(59, 89, 152, 0.35);
            transition: all 0.2s ease;
        }

        .btn-modal-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 22px rgba(59, 89, 152, 0.45);
        }

        /* ----------------------------------------------------
           RESPONSIVE MEDIA QUERIES
        ---------------------------------------------------- */
        @media (max-width: 1200px) {
            .user-spoiler-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 1024px) {
            .hero-grid-2col,
            .faq-layout-split,
            .callout-card-glow {
                grid-template-columns: 1fr;
                flex-direction: column;
                align-items: stretch;
            }

            .metrics-glass-box {
                grid-template-columns: repeat(2, 1fr);
                padding: 28px;
            }

            .metric-cell:nth-child(2) {
                border-right: none;
            }

            .user-spoiler-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-grid-4col {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .nav-links-row {
                display: none;
            }

            .school-name-text-nav {
                display: none;
            }

            .school-logo-img-nav {
                width: 32px;
                height: 32px;
            }

            .hero-school-identity {
                padding: 10px 16px 10px 12px;
                gap: 12px;
            }

            .hero-school-logo-glow {
                width: 44px;
                height: 44px;
            }

            .hero-school-logo-glow img {
                width: 32px;
                height: 32px;
            }

            .hero-school-info strong {
                font-size: 14px;
            }

            .hero-school-info span {
                font-size: 10px;
            }

            .hero-edutech {
                padding: 56px 0 96px;
            }

            .metrics-floating-bar {
                margin-top: -40px;
            }

            .metrics-glass-box {
                grid-template-columns: 1fr;
                gap: 18px;
                padding: 24px;
            }

            .metric-cell {
                border-right: none;
                border-bottom: 1px solid #F1F5F9;
                padding-bottom: 14px;
            }

            .metric-cell:last-child {
                border-bottom: none;
                padding-bottom: 0;
            }

            .user-spoiler-grid {
                grid-template-columns: 1fr;
            }

            .footer-grid-4col {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .footer-copyright-bar {
                flex-direction: column;
                gap: 8px;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <!-- 1. STICKY SINFAS GLASS NAVBAR -->
    <header class="glass-navbar-wrap">
        <div class="container navbar-flex">
            <div class="school-logo-badge-nav">
                <a href="{{ url('/') }}" class="brand-link">
                    <div class="brand-icon-wrap">
                        @include('components.sinfas-logo', ['class' => 'brand-logo-img', 'variant' => 'user'])
                    </div>
                    <div class="brand-text-block">
                        <span class="brand-title">SINFAS<span></span>
                        <span class="brand-sub">Sistem Informasi Fasilitas</span>
                    </div>
                </a>
                <div class="school-logo-divider"></div>
                <img src="{{ asset('images/logo-smkn11-bandung.png') }}" alt="Logo SMKN 11 Bandung" class="school-logo-img-nav">
                <div class="school-name-text-nav">
                    <strong>SMKN 11</strong>
                    <span>Bandung</span>
                </div>
            </div>

            <nav>
                <ul class="nav-links-row">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#katalog-spoiler">Daftar Fasilitas</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </nav>

            <div class="nav-cta-wrap">
                @auth
                    @if(auth()->user()->role === 'siswa')
                        <a href="{{ route('user.dashboard') }}" class="btn-brand-primary">
                            <span>Portal Siswa</span>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    @elseif(auth()->user()->role === 'admin_sarana')
                        <a href="{{ route('admin.dashboard') }}" class="btn-brand-primary">
                            <span>Panel Sarpras</span>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <a href="{{ route('sistem.dashboard') }}" class="btn-brand-primary">
                            <span>Panel Sistem</span>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-brand-primary">
                        <span>Masuk</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main id="beranda">
        <!-- 2. HERO SECTION (Edu-Tech SINFAS Navy Canvas + Glassmorphism Showcase) -->
        <section class="hero-edutech">
            <div class="container hero-grid-2col">
                <div>
                    {{-- School Identity Badge --}}
                    <div class="hero-school-identity">
                        <div class="hero-school-logo-glow">
                            <img src="{{ asset('images/logo-smkn11-bandung.png') }}" alt="Logo SMKN 11 Bandung">
                        </div>
                        <div class="hero-school-info">
                            <strong>SMK Negeri 11 Bandung</strong>
                            <span>Sistem Informasi Fasilitas & Sarpras Sekolah</span>
                        </div>
                    </div>

                    <div class="hero-kicker-pill">
                        <span class="live-pulse-dot"></span>
                        <span>PLATFORM FASILITAS & SARPRAS SEKOLAH</span>
                    </div>

                    <h1 class="hero-heading">
                        Akses Fasilitas Belajar,<br>
                        <span class="gradient-headline">Mudah & Real-Time.</span>
                    </h1>

                    <p class="hero-subtext">
                        Sistem terintegrasi untuk mengecek ketersediaan laboratorium, proyektor multimedia, ruang aula, hingga perlengkapan ekstrakurikuler sekolah secara tertib dan transparan.
                    </p>

                    <div class="hero-btn-group">
                        <a href="#katalog-spoiler" class="btn-brand-primary" style="padding: 13px 30px; font-size: 14px;">
                            <span>Lihat Barang Siap Pinjam</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <a href="{{ route('login') }}" class="btn-glass-secondary">
                            <span>Masuk ke Akun</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </a>
                    </div>
                </div>

                <!-- Showcase Panel: Simulated Interactive Dashboard Screen -->
                <div class="glass-showcase-panel">
                    <div class="showcase-header">
                        <div class="showcase-user">
                            <div class="avatar-circle-pulse">
                                @include('components.sinfas-logo', ['class' => 'brand-logo-img', 'style' => 'width: 20px; height: 20px;'])
                            </div>
                            <div class="showcase-user-text">
                                <strong>Katalog Fasilitas</strong>
                                <span>Status Ketersediaan Hari Ini</span>
                            </div>
                        </div>
                        <span class="status-badge-live">● Aktif Real-Time</span>
                    </div>

                    <div class="showcase-card-stack">
                        <!-- Facility 1 -->
                        <div class="mini-facility-row">
                            <div class="mini-facility-info">
                                <div class="facility-icon-square">📽️</div>
                                <div class="facility-name-block">
                                    <strong>Projector Epson X300</strong>
                                    <span>Gedung Sarpras • Elektronik</span>
                                </div>
                            </div>
                            <span class="badge-ready">Tersedia</span>
                        </div>

                        <!-- Facility 2 -->
                        <div class="mini-facility-row">
                            <div class="mini-facility-info">
                                <div class="facility-icon-square">🔊</div>
                                <div class="facility-name-block">
                                    <strong>Portable Speaker JBL</strong>
                                    <span>Ruang Audio • Audio Visual</span>
                                </div>
                            </div>
                            <span class="badge-ready">Tersedia</span>
                        </div>

                        <!-- Facility 3 -->
                        <div class="mini-facility-row">
                            <div class="mini-facility-info">
                                <div class="facility-icon-square">📷</div>
                                <div class="facility-name-block">
                                    <strong>Kamera DSLR Canon EOS</strong>
                                    <span>Ruang Dokumentasi OSIS</span>
                                </div>
                            </div>
                            <span class="badge-ready">Tersedia</span>
                        </div>
                    </div>

                    <div class="showcase-footer-action">
                        <span>Peminjaman online bebas antrean form</span>
                        <a href="#katalog-spoiler" class="link-quick-borrow">
                            Jelajahi Semua Barang ↓
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. METRICS FLOATING BAR (KPI Counter Edu-Tech) -->
        <section class="container metrics-floating-bar">
            <div class="metrics-glass-box">
                <div class="metric-cell">
                    <div class="metric-icon-box">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                    </div>
                    <div>
                        <div class="metric-val">150+</div>
                        <div class="metric-desc">Inventaris Terdata Lengkap</div>
                    </div>
                </div>

                <div class="metric-cell">
                    <div class="metric-icon-box">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                    <div>
                        <div class="metric-val">100%</div>
                        <div class="metric-desc">Bebas Biaya Fasilitas Sekolah</div>
                    </div>
                </div>

                <div class="metric-cell">
                    <div class="metric-icon-box">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                    <div>
                        <div class="metric-val">1.2K+</div>
                        <div class="metric-desc">Peminjaman Sukses & Tuntas</div>
                    </div>
                </div>

                <div class="metric-cell">
                    <div class="metric-icon-box">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div>
                        <div class="metric-val">24/7</div>
                        <div class="metric-desc">Pengecekan Jadwal Online</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. SPOILER / KATALOG BARANG SIAP DIPINJAM (Replacing the 4 workflow cards with User Dashboard Card Style) -->
        @php
            try {
                $spoilerBarangs = \App\Models\Barang::with('kategori')
                    ->where('jumlah_baik', '>', 0)
                    ->take(8)
                    ->get();
            } catch (\Throwable $e) {
                $spoilerBarangs = collect();
            }

            if ($spoilerBarangs->isEmpty()) {
                $spoilerBarangs = collect([
                    (object)[
                        'kode_barang' => 'BRG-001',
                        'nama_barang' => 'Projector Epson X300',
                        'merk_model' => 'Epson EB-X300 Full HD',
                        'foto' => null,
                        'jumlah_baik' => 4,
                        'kondisi' => 'Baik',
                        'kategori' => (object)['nama_kategori' => 'Elektronik'],
                        'icon' => '📽️'
                    ],
                    (object)[
                        'kode_barang' => 'BRG-002',
                        'nama_barang' => 'Portable Speaker JBL',
                        'merk_model' => 'JBL PartyBox On-The-Go',
                        'foto' => null,
                        'jumlah_baik' => 2,
                        'kondisi' => 'Baik',
                        'kategori' => (object)['nama_kategori' => 'Audio Visual'],
                        'icon' => '🔊'
                    ],
                    (object)[
                        'kode_barang' => 'BRG-003',
                        'nama_barang' => 'Kamera DSLR Canon EOS',
                        'merk_model' => 'Canon EOS 3000D + Lens 18-55mm',
                        'foto' => null,
                        'jumlah_baik' => 3,
                        'kondisi' => 'Baik',
                        'kategori' => (object)['nama_kategori' => 'Audio Visual'],
                        'icon' => '📷'
                    ],
                    (object)[
                        'kode_barang' => 'BRG-004',
                        'nama_barang' => 'Wireless Presenter Laser',
                        'merk_model' => 'Logitech R400 Wireless',
                        'foto' => null,
                        'jumlah_baik' => 6,
                        'kondisi' => 'Baik',
                        'kategori' => (object)['nama_kategori' => 'Elektronik'],
                        'icon' => '📡'
                    ],
                    (object)[
                        'kode_barang' => 'BRG-005',
                        'nama_barang' => 'Terminal Roll Listrik 15M',
                        'merk_model' => 'Uticon Heavy Duty 4 Lubang',
                        'foto' => null,
                        'jumlah_baik' => 8,
                        'kondisi' => 'Baik',
                        'kategori' => (object)['nama_kategori' => 'Kelistrikan'],
                        'icon' => '🔌'
                    ],
                    (object)[
                        'kode_barang' => 'BRG-006',
                        'nama_barang' => 'Mikroskop Binokuler Digital',
                        'merk_model' => 'Olympus CX23 LED Praktikum',
                        'foto' => null,
                        'jumlah_baik' => 5,
                        'kondisi' => 'Baik',
                        'kategori' => (object)['nama_kategori' => 'Peralatan'],
                        'icon' => '🔬'
                    ],
                    (object)[
                        'kode_barang' => 'BRG-007',
                        'nama_barang' => 'Set Bola Basket & Futsal',
                        'merk_model' => 'Molten GG7X & Vantaggio',
                        'foto' => null,
                        'jumlah_baik' => 10,
                        'kondisi' => 'Baik',
                        'kategori' => (object)['nama_kategori' => 'Olahraga'],
                        'icon' => '⚽'
                    ],
                    (object)[
                        'kode_barang' => 'BRG-008',
                        'nama_barang' => 'Walkie Talkie HT Baofeng',
                        'merk_model' => 'Baofeng Dual Band VHF/UHF',
                        'foto' => null,
                        'jumlah_baik' => 6,
                        'kondisi' => 'Baik',
                        'kategori' => (object)['nama_kategori' => 'Komunikasi'],
                        'icon' => '📻'
                    ],
                ]);
            }
        @endphp

        <section class="container spoiler-section" id="katalog-spoiler">
            <div class="section-header-center">
                <span class="section-tag">Cuplikan Inventaris Sarpras</span>
                <h2 class="section-title">Barang & Fasilitas yang Siap Dipinjam</h2>
                <p class="section-subtitle">
                    Berikut beberapa fasilitas sekolah yang tersedia. Untuk mengajukan peminjaman atau melihat jadwal lengkap, silakan masuk dengan akun Anda.
                </p>
            </div>

            <!-- 4-Column Cards Grid Matching User Dashboard -->
            <div class="user-spoiler-grid">
                @foreach($spoilerBarangs as $b)
                    @php
                        $isAvailable = ($b->jumlah_baik ?? 0) > 0;
                    @endphp
                    <div class="card-facility-vibe" onclick="handleItemClick('{{ addslashes($b->nama_barang) }}', '{{ $b->kode_barang }}')">
                        <div class="card-image-aspect">
                            <span class="status-pill-floating {{ $isAvailable ? 'available' : 'empty' }}">
                                <span class="status-dot-pulse"></span>
                                <span>{{ $isAvailable ? 'Tersedia' : 'Habis' }}</span>
                            </span>

                            @if(!empty($b->foto))
                                <img src="{{ asset('storage/' . $b->foto) }}" alt="{{ $b->nama_barang }}" loading="lazy" onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='flex';">
                                <div style="display:none; font-size: 54px; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.1));">
                                    {{ $b->icon ?? '📦' }}
                                </div>
                            @else
                                <div style="font-size: 58px; filter: drop-shadow(0 4px 12px rgba(59, 89, 152, 0.15)); user-select: none;">
                                    {{ $b->icon ?? '📦' }}
                                </div>
                            @endif
                        </div>

                        <div class="card-detail-body">
                            <h3 class="card-item-title">{{ $b->nama_barang }}</h3>
                            <div class="card-item-tag">
                                <span>#</span>
                                <span>{{ $b->kategori->nama_kategori ?? 'Umum' }}</span>
                                <span>&bull;</span>
                                <span>{{ $b->jumlah_baik ?? 1 }} unit siap</span>
                            </div>

                            <button type="button" class="btn-loan-request-modern" onclick="event.stopPropagation(); handleItemClick('{{ addslashes($b->nama_barang) }}', '{{ $b->kode_barang }}')">
                                <span>Pinjam Fasilitas</span>
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Bottom notice for login -->
            <div style="text-align: center;">
                <p style="font-size: 13.5px; color: var(--text-muted); margin-bottom: 14px;">
                    Ingin melihat seluruh inventaris sekolah lainnya atau mengecek tanggal peminjaman?
                </p>
                <a href="{{ route('login') }}" class="btn-brand-primary" style="padding: 12px 28px; font-size: 13.5px;">
                    <span>Masuk ke Portal Siswa / Guru untuk Pinjam</span>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </section>

        <!-- 5. FAQ SECTION (Accordion) -->
        <section class="container faq-section-wrap" id="faq">
            <div class="faq-layout-split">
                <div class="faq-sticky-left">
                    <span class="section-tag">Pusat Bantuan</span>
                    <h2>Pertanyaan yang Sering Diajukan</h2>
                    <p>
                        Informasi lengkap mengenai kebijakan penggunaan fasilitas, tata tertib, dan prosedur pertanggungjawaban di lingkungan sekolah.
                    </p>

                    <div class="faq-contact-card">
                        <strong>Ruang Sarana & Prasarana</strong>
                        <span>Gedung A, Lantai 1 (Jam Kerja: 07.00 – 16.00 WIB)</span>
                        <div style="margin-top: 14px;">
                            <a href="{{ route('login') }}" class="btn-brand-primary" style="padding: 8px 18px; font-size: 12px;">
                                Hubungi Pengelola Sarpras
                            </a>
                        </div>
                    </div>
                </div>

                <div class="faq-accordion-group">
                    <div class="faq-box-card active">
                        <button class="faq-btn-trigger" onclick="toggleFaqBox(this)">
                            <span>Siapa saja yang berhak meminjam fasilitas di SINFAS?</span>
                            <span class="faq-icon-arrow">›</span>
                        </button>
                        <div class="faq-body-text">
                            Seluruh civitas akademika aktif sekolah yang meliputi Siswa terdaftar, Guru Pengajar, Pembina Ekstrakurikuler, dan Staf Karyawan memiliki akun dan hak akses pengajuan.
                        </div>
                    </div>

                    <div class="faq-box-card">
                        <button class="faq-btn-trigger" onclick="toggleFaqBox(this)">
                            <span>Berapa lama batas maksimal peminjaman fasilitas?</span>
                            <span class="faq-icon-arrow">›</span>
                        </button>
                        <div class="faq-body-text">
                            Peminjaman alat pada umumnya berlaku maksimal 1 hari kegiatan sekolah. Untuk kebutuhan acara multi-hari (misal kemah pramuka atau persiapan lomba), wajib mencantumkan surat rekomendasi pembina.
                        </div>
                    </div>

                    <div class="faq-box-card">
                        <button class="faq-btn-trigger" onclick="toggleFaqBox(this)">
                            <span>Mengapa pengembalian wajib menyertakan foto kondisi fisik?</span>
                            <span class="faq-icon-arrow">›</span>
                        </button>
                        <div class="faq-body-text">
                            Dokumentasi foto memastikan akuntabilitas kondisi barang saat diserahkan kembali, sehingga aset sekolah tetap terpantau dengan baik dan terhindar dari kesalahpahaman.
                        </div>
                    </div>

                    <div class="faq-box-card">
                        <button class="faq-btn-trigger" onclick="toggleFaqBox(this)">
                            <span>Apakah bisa mengajukan peminjaman di luar jam sekolah?</span>
                            <span class="faq-icon-arrow">›</span>
                        </button>
                        <div class="faq-body-text">
                            Bisa, pengajuan dapat dibuat kapan saja secara online melalui sistem 24 jam. Verifikasi persetujuan akan diproses pada jam kerja petugas sarpras.
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. CALL TO ACTION BANNER (SINFAS Gradient) -->
        <section class="container callout-banner-section">
            <div class="callout-card-glow">
                <div class="callout-text">
                    <h2>Siap Memaksimalkan Kegiatan Belajar & Ekskul?</h2>
                    <p>
                        Masuk ke akun SINFAS Anda sekarang untuk melihat jadwal dan mengajukan sarana prasarana sekolah dengan mudah.
                    </p>
                </div>
                <div style="flex-shrink: 0;">
                    <a href="{{ route('login') }}" class="btn-brand-primary" style="background: #ffffff; color: var(--brand-dark) !important; padding: 14px 32px; font-size: 14px; font-weight: 800; box-shadow: 0 10px 25px rgba(0,0,0,0.18);">
                        <span>Masuk ke Akun Sekarang</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- 7. FOOTER (Deep Navy SINFAS) -->
    <footer class="site-footer-deep">
        <div class="container">
            <div class="footer-grid-4col">
                <div>
                    <div class="footer-brand-title">
                        <div class="brand-icon-wrap" style="width: 32px; height: 32px; border-radius: 9px;">
                            @include('components.sinfas-logo', ['class' => 'brand-logo-img', 'style' => 'width: 18px; height: 18px;'])
                        </div>
                        <span>SINFAS<span>.</span></span>
                    </div>
                    <div class="footer-school-badge">
                        <img src="{{ asset('images/logo-smkn11-bandung.png') }}" alt="Logo SMKN 11 Bandung">
                        <div class="footer-school-badge-text">
                            <strong>SMK Negeri 11 Bandung</strong>
                            <span>Jl. Budhi Cilember No. 17</span>
                        </div>
                    </div>
                    <p class="footer-contact-block" style="max-width: 340px;">
                        Sistem Informasi Fasilitas Sekolah yang menghadirkan transparansi, kemudahan, dan akuntabilitas peminjaman sarana prasarana demi kelancaran kegiatan belajar.
                    </p>
                </div>

                <div>
                    <h4 class="footer-col-title">Navigasi Cepat</h4>
                    <ul class="footer-nav-list">
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#katalog-spoiler">Daftar Fasilitas</a></li>
                        <li><a href="#faq">Pusat Bantuan</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="footer-col-title">Portal Akses</h4>
                    <ul class="footer-nav-list">
                        <li><a href="{{ route('login') }}">Masuk Siswa</a></li>
                        <li><a href="{{ route('login') }}">Masuk Guru</a></li>
                        <li><a href="{{ route('login') }}">Panel Staf Sarpras</a></li>
                        <li><a href="{{ route('login') }}">Panel Admin Sistem</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="footer-col-title">Ruang Sarana Prasarana</h4>
                    <div class="footer-contact-block">
                        <p><strong>Gedung A, Lantai 1</strong></p>
                        <p>Senin – Jumat: 07.00 – 16.00 WIB</p>
                        <p style="margin-top: 6px; color: var(--brand-cyan-light);">Email: sarpras@sekolah.sch.id</p>
                    </div>
                </div>
            </div>

            <div class="footer-copyright-bar">
                <p>&copy; {{ date('Y') }} SINFAS — Sistem Informasi Fasilitas Sekolah. All rights reserved.</p>
                <p>Mendukung Digitalisasi & Akuntabilitas Aset Sekolah</p>
            </div>
        </div>
    </footer>

    <!-- LOGIN REQUIRED SPOILER MODAL -->
    <div id="login-prompt-modal" class="spoiler-modal-shade" style="display: none;" onclick="if(event.target === this) closeLoginModal();">
        <div class="spoiler-modal-card">
            <div class="spoiler-modal-icon">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </div>
            <h3 class="spoiler-modal-title">Masuk Terlebih Dahulu</h3>
            <p class="spoiler-modal-desc">
                Untuk mengajukan peminjaman fasilitas <strong id="modal-item-name" style="color: var(--brand-dark);">[Barang]</strong>, Anda harus masuk ke portal SINFAS terlebih dahulu.
            </p>
            <div class="spoiler-modal-actions">
                <button type="button" class="btn-modal-cancel" onclick="closeLoginModal()">Nanti Saja</button>
                <a href="{{ route('login') }}" class="btn-modal-login">
                    <span>Masuk (Login)</span>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Interactive JavaScript -->
    <script>
        // Check if user is authenticated
        const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};

        function handleItemClick(itemName, itemCode) {
            if (isAuthenticated) {
                // If logged in, navigate directly to item detail/booking
                window.location.href = "{{ url('/user/barang') }}/" + itemCode;
            } else {
                // If not logged in, show spoiler modal prompting to login
                const modal = document.getElementById('login-prompt-modal');
                const nameLabel = document.getElementById('modal-item-name');
                if (nameLabel) nameLabel.textContent = itemName;
                if (modal) modal.style.display = 'flex';
            }
        }

        function closeLoginModal() {
            const modal = document.getElementById('login-prompt-modal');
            if (modal) modal.style.display = 'none';
        }

        function toggleFaqBox(button) {
            const currentCard = button.closest('.faq-box-card');
            const isOpen = currentCard.classList.contains('active');

            // Close all items
            document.querySelectorAll('.faq-box-card').forEach(item => {
                item.classList.remove('active');
            });

            // Toggle selected item
            if (!isOpen) {
                currentCard.classList.add('active');
            }
        }
    </script>
</body>
</html>