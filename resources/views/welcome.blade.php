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
            --radius-card: 24px;
            --radius-sub: 16px;
            
            --shadow-glow: 0 10px 30px -4px rgba(59, 89, 152, 0.45);
            --shadow-card: 0 12px 32px -8px rgba(15, 23, 42, 0.06);
            --shadow-card-hover: 0 20px 40px -10px rgba(59, 89, 152, 0.2);
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
            width: 24px;
            height: 24px;
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

        /* Ambient light glows */
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

        /* Facility Cards Inside Showcase */
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
           KATALOG FASILITAS POPULER
        ---------------------------------------------------- */
        .catalog-section {
            padding: 96px 0 84px;
        }

        .section-header-center {
            text-align: center;
            max-width: 680px;
            margin: 0 auto 48px;
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

        .catalog-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }

        .facility-card-item {
            background: #ffffff;
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            padding: 24px;
            box-shadow: var(--shadow-card);
            transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .facility-card-item:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-card-hover);
            border-color: var(--border-glow);
        }

        .card-top-category {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .category-chip {
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: var(--radius-pill);
            background: #EEF4FF;
            color: var(--brand-primary);
        }

        .availability-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            color: #10B981;
        }

        .card-title {
            font-family: 'Outfit', sans-serif;
            font-size: 20px;
            font-weight: 800;
            color: var(--brand-dark);
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .card-spec-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 22px;
            padding-bottom: 16px;
            border-bottom: 1px solid #F1F5F9;
        }

        .card-spec-list li {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 11px;
            border-radius: var(--radius-pill);
            background: #F8FAFC;
            border: 1px solid var(--border-subtle);
            color: var(--brand-dark);
            font-size: 13px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .facility-card-item:hover .card-btn-action {
            background: var(--brand-primary);
            color: #ffffff;
            border-color: var(--brand-primary);
            box-shadow: 0 4px 14px rgba(59, 89, 152, 0.3);
        }

        /* ----------------------------------------------------
           ALUR PEMINJAMAN (Step-by-Step Visual)
        ---------------------------------------------------- */
        .workflow-section {
            background: #ffffff;
            border-top: 1px solid var(--border-subtle);
            border-bottom: 1px solid var(--border-subtle);
            padding: 96px 0;
        }

        .steps-flow-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            position: relative;
        }

        .step-flow-card {
            background: #F8FAFC;
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            padding: 28px 22px;
            position: relative;
            transition: all 0.25s ease;
        }

        .step-flow-card:hover {
            transform: translateY(-6px);
            background: #ffffff;
            border-color: var(--brand-violet);
            box-shadow: var(--shadow-card);
        }

        .step-index-badge {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--brand-gradient-action);
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            box-shadow: 0 6px 16px rgba(59, 89, 152, 0.25);
        }

        .step-title {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 800;
            color: var(--brand-dark);
            margin-bottom: 10px;
        }

        .step-desc {
            font-size: 13px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ----------------------------------------------------
           FAQ SECTION (Accordion)
        ---------------------------------------------------- */
        .faq-section-wrap {
            padding: 96px 0;
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
           RESPONSIVE MEDIA QUERIES
        ---------------------------------------------------- */
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

            .steps-flow-grid {
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

            .steps-flow-grid {
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
            <a href="{{ url('/') }}" class="brand-link">
                <div class="brand-icon-wrap">
                    @include('components.sinfas-logo', ['class' => 'brand-logo-img', 'variant' => 'user'])
                </div>
                <div class="brand-text-block">
                    <span class="brand-title">SINFAS<span>.</span></span>
                    <span class="brand-sub">Sistem Informasi Fasilitas</span>
                </div>
            </a>

            <nav>
                <ul class="nav-links-row">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#katalog">Fasilitas</a></li>
                    <li><a href="#alur">Alur Pinjam</a></li>
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
                        <span>Masuk ke Sistem</span>
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
                        <a href="{{ route('login') }}" class="btn-brand-primary" style="padding: 13px 30px; font-size: 14px;">
                            <span>Cari & Ajukan Fasilitas</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <a href="#alur" class="btn-glass-secondary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                            <span>Panduan Peminjaman</span>
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
                                    <strong>Proyektor EPSON EB-X500</strong>
                                    <span>Gedung Sarpras • Multimedia</span>
                                </div>
                            </div>
                            <span class="badge-ready">Tersedia</span>
                        </div>

                        <!-- Facility 2 -->
                        <div class="mini-facility-row">
                            <div class="mini-facility-info">
                                <div class="facility-icon-square">💻</div>
                                <div class="facility-name-block">
                                    <strong>Laboratorium Komputer 1</strong>
                                    <span>Lantai 2 • 36 Unit PC Siap</span>
                                </div>
                            </div>
                            <span class="badge-ready">Tersedia</span>
                        </div>

                        <!-- Facility 3 -->
                        <div class="mini-facility-row">
                            <div class="mini-facility-info">
                                <div class="facility-icon-square">🔊</div>
                                <div class="facility-name-block">
                                    <strong>Sound System Portable Wireless</strong>
                                    <span>Aula Utama • Acara & Rapat</span>
                                </div>
                            </div>
                            <span class="badge-queue">Dipinjam (Kembali 14:00)</span>
                        </div>
                    </div>

                    <div class="showcase-footer-action">
                        <span>Peminjaman online bebas antrean form</span>
                        <a href="{{ route('login') }}" class="link-quick-borrow">
                            Ajukan Pinjam Sekarang →
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

        <!-- 4. KATALOG FASILITAS UNGGULAN -->
        <section class="container catalog-section" id="katalog">
            <div class="section-header-center">
                <span class="section-tag">Katalog Sarana Prasarana</span>
                <h2 class="section-title">Fasilitas Siap Pakai Untuk Mendukung Prestasi</h2>
                <p class="section-subtitle">
                    Temukan fasilitas yang Anda butuhkan untuk kegiatan belajar mengajar, praktikum, organisasi kesiswaan, hingga ekstrakurikuler.
                </p>
            </div>

            <div class="catalog-cards-grid">
                <!-- Card 1 -->
                <div class="facility-card-item">
                    <div>
                        <div class="card-top-category">
                            <span class="category-chip">Laboratorium</span>
                            <span class="availability-pill">● Siap Digunakan</span>
                        </div>
                        <h3 class="card-title">Lab Komputer Jaringan</h3>
                        <ul class="card-spec-list">
                            <li>📍 Gedung Timur Lantai 2</li>
                            <li>🖥️ Kapasitas 36 Unit PC Core i5</li>
                            <li>⚡ Koneksi Fiber Optik Cepat</li>
                        </ul>
                    </div>
                    <a href="{{ route('login') }}" class="card-btn-action">
                        <span>Cek Ketersediaan & Pinjam</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <!-- Card 2 -->
                <div class="facility-card-item">
                    <div>
                        <div class="card-top-category">
                            <span class="category-chip">Multimedia</span>
                            <span class="availability-pill">● Siap Digunakan</span>
                        </div>
                        <h3 class="card-title">Proyektor EPSON Full HD</h3>
                        <ul class="card-spec-list">
                            <li>📍 Ruang Penyimpanan Sarpras</li>
                            <li>🔌 Dilengkapi Kabel HDMI & Adaptor</li>
                            <li>✨ Kualitas Gambar 3600 Lumens</li>
                        </ul>
                    </div>
                    <a href="{{ route('login') }}" class="card-btn-action">
                        <span>Cek Ketersediaan & Pinjam</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <!-- Card 3 -->
                <div class="facility-card-item">
                    <div>
                        <div class="card-top-category">
                            <span class="category-chip">Audio & Sound</span>
                            <span class="availability-pill">● Siap Digunakan</span>
                        </div>
                        <h3 class="card-title">Portable Wireless Sound</h3>
                        <ul class="card-spec-list">
                            <li>📍 Ruang Perlengkapan OSIS</li>
                            <li>🎤 Termasuk 2 Mic Wireless</li>
                            <li>🔋 Baterai Tahan Hingga 8 Jam</li>
                        </ul>
                    </div>
                    <a href="{{ route('login') }}" class="card-btn-action">
                        <span>Cek Ketersediaan & Pinjam</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <!-- Card 4 -->
                <div class="facility-card-item">
                    <div>
                        <div class="card-top-category">
                            <span class="category-chip">Ruang & Aula</span>
                            <span class="availability-pill">● Siap Digunakan</span>
                        </div>
                        <h3 class="card-title">Aula Serbaguna Sekolah</h3>
                        <ul class="card-spec-list">
                            <li>📍 Gedung Utama Lantai 3</li>
                            <li>👥 Daya Tampung Hingga 300 Siswa</li>
                            <li>❄️ Pendingin Ruangan (AC Central)</li>
                        </ul>
                    </div>
                    <a href="{{ route('login') }}" class="card-btn-action">
                        <span>Cek Ketersediaan & Pinjam</span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- 5. ALUR PEMINJAMAN VISUAL (Step-by-Step Interactive Workflow) -->
        <section class="workflow-section" id="alur">
            <div class="container">
                <div class="section-header-center">
                    <span class="section-tag">Alur Penggunaan</span>
                    <h2 class="section-title">4 Langkah Mudah Meminjam Fasilitas</h2>
                    <p class="section-subtitle">
                        Proses digital yang dirancang efisien dan teratur, memastikan setiap aset sekolah terdokumentasi dengan baik.
                    </p>
                </div>

                <div class="steps-flow-grid">
                    <div class="step-flow-card">
                        <div class="step-index-badge">01</div>
                        <h3 class="step-title">Eksplorasi Barang</h3>
                        <p class="step-desc">
                            Lihat ketersediaan barang dan jadwal pemakaian secara transparan melalui portal siswa/guru.
                        </p>
                    </div>

                    <div class="step-flow-card">
                        <div class="step-index-badge">02</div>
                        <h3 class="step-title">Ajukan Jadwal</h3>
                        <p class="step-desc">
                            Pilih tanggal peminjaman, jam mulai, jam pengembalian, serta tuliskan tujuan penggunaan.
                        </p>
                    </div>

                    <div class="step-flow-card">
                        <div class="step-index-badge">03</div>
                        <h3 class="step-title">Verifikasi Cepat</h3>
                        <p class="step-desc">
                            Staf sarana prasarana memeriksa pengajuan dan memberikan persetujuan tanpa perlu form kertas.
                        </p>
                    </div>

                    <div class="step-flow-card">
                        <div class="step-index-badge">04</div>
                        <h3 class="step-title">Ambil & Kembalikan</h3>
                        <p class="step-desc">
                            Ambil barang di ruang sarpras dan kembalikan tepat waktu dengan bukti foto kondisi fisik.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. FAQ SECTION (Accordion) -->
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

        <!-- 7. CALL TO ACTION BANNER (SINFAS Gradient) -->
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

    <!-- 8. FOOTER (Deep Navy SINFAS) -->
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
                    <p class="footer-contact-block" style="max-width: 340px;">
                        Sistem Informasi Fasilitas Sekolah yang menghadirkan transparansi, kemudahan, dan akuntabilitas peminjaman sarana prasarana demi kelancaran kegiatan belajar.
                    </p>
                </div>

                <div>
                    <h4 class="footer-col-title">Navigasi Cepat</h4>
                    <ul class="footer-nav-list">
                        <li><a href="#beranda">Beranda</a></li>
                        <li><a href="#katalog">Katalog Fasilitas</a></li>
                        <li><a href="#alur">Alur Peminjaman</a></li>
                        <li><a href="#faq">Pusat Bantuan</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="footer-col-title">Portal Akses</h4>
                    <ul class="footer-nav-list">
                        <li><a href="{{ route('login') }}">Masuk Siswa</a></li>
                        <li><a href="{{ route('login') }}">Masuk Guru & Pembina</a></li>
                        <li><a href="{{ route('login') }}">Panel Staf Sarpras</a></li>
                        <li><a href="{{ route('login') }}">Panel Admin Sistem</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="footer-col-title">Ruang Sarana Prasarana</h4>
                    <div class="footer-contact-block">
                        <p><strong>Gedung A, Lantai 1</strong></p>
                        <p>Senin – Jumat: 07.00 – 16.00 WIB</p>
                        <p style="margin-top: 6px;">Sabtu: 08.00 – 12.00 WIB</p>
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

    <!-- Interactive JavaScript -->
    <script>
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