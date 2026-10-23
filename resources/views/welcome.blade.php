<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SINFAS - Sistem Informasi Fasilitas Sekolah. Peminjaman sarana prasarana mudah, cepat, dan transparan.">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/sinfas-logo.svg'))) }}">
    <title>SINFAS — Sistem Informasi Fasilitas Sekolah</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-canvas: #f8fafc;
            --surface-white: #ffffff;
            --ink-900: #0f172a;
            --ink-700: #334155;
            --ink-500: #64748b;
            --ink-300: #94a3b8;
            --blue-royal: #1d4ed8;
            --blue-vibrant: #2563eb;
            --blue-soft: #eff6ff;
            --blue-light: #dbeafe;
            --border-subtle: #e2e8f0;
            --border-hover: #cbd5e1;
            --gold-star: #f59e0b;
            --radius-pill: 9999px;
            --radius-card: 24px;
            --radius-sub: 16px;
            --shadow-subtle: 0 4px 20px -2px rgba(15, 23, 42, 0.04);
            --shadow-card: 0 20px 45px -15px rgba(15, 23, 42, 0.08);
            --shadow-float: 0 25px 50px -12px rgba(37, 99, 235, 0.18);
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
            color: var(--ink-900);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.2s ease;
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
           NAVBAR
        ---------------------------------------------------- */
        .site-nav-wrap {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(248, 250, 252, 0.88);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            padding: 16px 0;
        }

        .site-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-family: 'Outfit', sans-serif;
            font-size: 24px;
            font-weight: 800;
            color: var(--ink-900);
            letter-spacing: -0.5px;
        }

        .brand-dot {
            color: var(--blue-vibrant);
        }

        .brand-icon-box {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--blue-vibrant), var(--blue-royal));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.28);
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }

        .nav-menu a {
            font-size: 14px;
            font-weight: 600;
            color: var(--ink-700);
            position: relative;
        }

        .nav-menu a:hover {
            color: var(--blue-vibrant);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-pill-dark {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 24px;
            border-radius: var(--radius-pill);
            background: var(--ink-900);
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.16);
            transition: all 0.22s ease;
        }

        .btn-pill-dark:hover {
            background: #1e293b;
            transform: translateY(-2px);
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.24);
        }

        .btn-pill-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: var(--radius-pill);
            border: 1.5px solid var(--border-hover);
            background: #ffffff;
            color: var(--ink-700);
            font-size: 13px;
            font-weight: 700;
            transition: all 0.22s ease;
        }

        .btn-pill-outline:hover {
            border-color: var(--blue-vibrant);
            color: var(--blue-vibrant);
            transform: translateY(-2px);
        }

        /* ----------------------------------------------------
           HERO SECTION
        ---------------------------------------------------- */
        .hero-section {
            padding: 56px 0 72px;
            position: relative;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.95fr;
            align-items: center;
            gap: 48px;
        }

        .hero-text-wrap {
            position: relative;
        }

        .hero-doodle {
            position: absolute;
            top: -24px;
            left: -12px;
            width: 38px;
            height: 38px;
            color: var(--blue-vibrant);
        }

        .hero-badge-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: var(--radius-pill);
            background: var(--blue-soft);
            color: var(--blue-royal);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.3px;
            margin-bottom: 20px;
        }

        .hero-title {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(42px, 5vw, 62px);
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -1.2px;
            color: var(--ink-900);
            margin-bottom: 22px;
        }

        .hero-desc {
            font-size: 16px;
            line-height: 1.7;
            color: var(--ink-500);
            max-width: 520px;
            margin-bottom: 34px;
        }

        .hero-btns {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        /* Phone Mockup */
        .mockup-container {
            display: flex;
            justify-content: center;
            position: relative;
        }

        .phone-frame {
            width: min(100%, 360px);
            background: #ffffff;
            border-radius: 40px;
            border: 8px solid #0f172a;
            box-shadow: var(--shadow-card), 0 35px 70px -15px rgba(37, 99, 235, 0.2);
            padding: 24px 20px 28px;
            position: relative;
            overflow: hidden;
            animation: floatSlow 6s ease-in-out infinite alternate;
        }

        @keyframes floatSlow {
            0% { transform: translateY(0); }
            100% { transform: translateY(-10px); }
        }

        .phone-speaker {
            width: 70px;
            height: 5px;
            background: #e2e8f0;
            border-radius: var(--radius-pill);
            margin: 0 auto 18px;
        }

        .mockup-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .mockup-user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mockup-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #fed7aa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 800;
            color: #9a3412;
        }

        .mockup-name {
            font-size: 13px;
            font-weight: 800;
            color: var(--ink-900);
            line-height: 1.2;
        }

        .mockup-role {
            font-size: 11px;
            color: var(--ink-500);
        }

        .mockup-card-recom {
            background: #f1f5f9;
            border-radius: 20px;
            padding: 16px;
            margin-bottom: 14px;
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        .mockup-card-badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 800;
            color: var(--blue-vibrant);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .mockup-card-title {
            font-family: 'Outfit', sans-serif;
            font-size: 16px;
            font-weight: 800;
            color: var(--ink-900);
            margin-bottom: 4px;
        }

        .mockup-card-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 700;
            color: #16a34a;
            background: #dcfce7;
            padding: 3px 8px;
            border-radius: var(--radius-pill);
        }

        .mockup-schedule-card {
            background: #ffffff;
            border: 1px solid var(--border-subtle);
            border-radius: 16px;
            padding: 14px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .mockup-schedule-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--blue-soft);
            color: var(--blue-royal);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mockup-schedule-text strong {
            display: block;
            font-size: 12px;
            font-weight: 800;
            color: var(--ink-900);
        }

        .mockup-schedule-text span {
            font-size: 10px;
            color: var(--ink-500);
        }

        .mockup-btn-action {
            width: 100%;
            padding: 12px;
            background: var(--blue-vibrant);
            color: #ffffff;
            border-radius: var(--radius-pill);
            font-size: 12px;
            font-weight: 800;
            text-align: center;
        }

        /* ----------------------------------------------------
           BLUE STATS BAR (00:04 in video)
        ---------------------------------------------------- */
        .stats-bar-section {
            background: var(--blue-royal);
            color: #ffffff;
            border-radius: var(--radius-card);
            padding: 38px 48px;
            margin: 20px 0 72px;
            box-shadow: 0 20px 40px -10px rgba(29, 78, 216, 0.35);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            align-items: center;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 16px;
            border-right: 1px solid rgba(255, 255, 255, 0.18);
            padding-right: 16px;
        }

        .stat-item:last-child {
            border-right: none;
            padding-right: 0;
        }

        .stat-num {
            font-family: 'Outfit', sans-serif;
            font-size: 38px;
            font-weight: 800;
            line-height: 1;
            color: #ffffff;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            line-height: 1.35;
            color: rgba(255, 255, 255, 0.85);
        }

        /* ----------------------------------------------------
           FEATURES / THAT THE WAY TO SINFAS (00:05 in video)
        ---------------------------------------------------- */
        .features-section {
            padding: 48px 0 84px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: 0.9fr 1.3fr;
            gap: 56px;
            align-items: center;
        }

        .features-left h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 38px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.5px;
            margin-bottom: 16px;
        }

        .features-left p {
            font-size: 15px;
            color: var(--ink-500);
            max-width: 400px;
        }

        .features-cards-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .feature-card {
            background: #ffffff;
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            padding: 26px 20px;
            box-shadow: var(--shadow-subtle);
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-card);
            border-color: var(--blue-vibrant);
        }

        .feature-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--blue-soft);
            color: var(--blue-vibrant);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .feature-card:nth-child(2) .feature-icon-box {
            background: #fef3c7;
            color: #d97706;
        }

        .feature-card:nth-child(3) .feature-icon-box {
            background: #dcfce7;
            color: #15803d;
        }

        .feature-card h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 17px;
            font-weight: 800;
            color: var(--ink-900);
        }

        .feature-card p {
            font-size: 12px;
            color: var(--ink-500);
            line-height: 1.6;
        }

        /* ----------------------------------------------------
           SEARCH & DISCOVERY SECTION (00:06 - 00:08 in video)
        ---------------------------------------------------- */
        .discovery-section {
            background: #ffffff;
            border-radius: 32px;
            border: 1px solid var(--border-subtle);
            padding: 64px 54px;
            margin: 24px 0 84px;
            box-shadow: var(--shadow-card);
        }

        .discovery-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 52px;
            align-items: center;
        }

        /* Map graphic with pin bubbles */
        .map-graphic-wrap {
            position: relative;
            background: radial-gradient(circle at center, #eff6ff 0%, #f8fafc 70%);
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            height: 320px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .map-svg-bg {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0.12;
        }

        .pin-bubble {
            position: absolute;
            background: #ffffff;
            border: 2px solid var(--blue-vibrant);
            border-radius: var(--radius-pill);
            padding: 8px 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.25);
            font-size: 11px;
            font-weight: 800;
            color: var(--ink-900);
            animation: pulsePin 4s infinite ease-in-out alternate;
        }

        @keyframes pulsePin {
            0% { transform: scale(1); }
            100% { transform: scale(1.04); }
        }

        .pin-bubble.pin-1 { top: 22%; left: 16%; }
        .pin-bubble.pin-2 { top: 58%; left: 24%; }
        .pin-bubble.pin-3 { top: 34%; right: 14%; border-color: #10b981; }

        .pin-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--blue-vibrant);
        }

        .pin-bubble.pin-3 .pin-dot {
            background: #10b981;
        }

        .discovery-content h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 36px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.6px;
            margin-bottom: 16px;
        }

        .discovery-content p {
            font-size: 14px;
            color: var(--ink-500);
            line-height: 1.65;
            margin-bottom: 32px;
        }

        /* Floating Search Widget */
        .search-pill-widget {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f8fafc;
            border: 1.5px solid var(--border-subtle);
            border-radius: var(--radius-pill);
            padding: 8px 10px 8px 24px;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.04);
            gap: 16px;
        }

        .search-field {
            display: flex;
            flex-direction: column;
            gap: 2px;
            flex: 1;
        }

        .search-field-label {
            font-size: 10px;
            font-weight: 800;
            color: var(--ink-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .search-field-input {
            border: none;
            background: transparent;
            font-family: inherit;
            font-size: 13px;
            font-weight: 700;
            color: var(--ink-900);
            outline: none;
            cursor: pointer;
        }

        .search-divider {
            width: 1px;
            height: 32px;
            background: var(--border-subtle);
        }

        .search-btn-round {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--ink-900);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .search-btn-round:hover {
            background: var(--blue-vibrant);
            transform: scale(1.06);
        }

        /* ----------------------------------------------------
           COMMUNITY / KEGIATAN SEKOLAH (00:09 in video)
        ---------------------------------------------------- */
        .community-section {
            padding: 40px 0 80px;
        }

        .community-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 56px;
            align-items: center;
        }

        .community-left h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 38px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.6px;
            margin-bottom: 16px;
        }

        .community-left p {
            font-size: 15px;
            color: var(--ink-500);
            line-height: 1.7;
            margin-bottom: 28px;
        }

        /* Avatars cluster */
        .avatars-cluster {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 20px;
            background: #ffffff;
            border-radius: 28px;
            border: 1px solid var(--border-subtle);
            padding: 40px 32px;
            box-shadow: var(--shadow-subtle);
            position: relative;
        }

        .avatar-card-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--bg-canvas);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-pill);
            padding: 8px 18px 8px 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            transition: transform 0.2s ease;
        }

        .avatar-card-item:hover {
            transform: translateY(-3px);
        }

        .avatar-img-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
            color: #ffffff;
        }

        .avatar-img-circle.c1 { background: #3b82f6; }
        .avatar-img-circle.c2 { background: #10b981; }
        .avatar-img-circle.c3 { background: #f59e0b; }
        .avatar-img-circle.c4 { background: #ec4899; }

        .avatar-role-text strong {
            display: block;
            font-size: 12px;
            font-weight: 800;
            color: var(--ink-900);
        }

        .avatar-role-text span {
            font-size: 10px;
            color: var(--ink-500);
        }

        /* ----------------------------------------------------
           TESTIMONIALS SLIDER (00:10 - 00:12 in video)
        ---------------------------------------------------- */
        .testimonials-section {
            padding: 64px 0 88px;
        }

        .testimonials-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 38px;
        }

        .testimonials-header h2 {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(30px, 3.8vw, 42px);
            font-weight: 800;
            letter-spacing: -0.6px;
            color: var(--ink-900);
        }

        .slider-controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .slider-arrow-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            border: 1.5px solid var(--border-hover);
            background: #ffffff;
            color: var(--ink-900);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .slider-arrow-btn:hover {
            border-color: var(--ink-900);
            background: var(--ink-900);
            color: #ffffff;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .testimonial-card {
            background: #ffffff;
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            padding: 30px 26px;
            box-shadow: var(--shadow-subtle);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 230px;
            transition: all 0.25s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-card);
            border-color: var(--blue-vibrant);
        }

        .quote-icon {
            font-family: 'Outfit', sans-serif;
            font-size: 36px;
            font-weight: 900;
            color: var(--blue-vibrant);
            line-height: 1;
            margin-bottom: 8px;
        }

        .testimonial-text {
            font-size: 14px;
            line-height: 1.65;
            color: var(--ink-700);
            margin-bottom: 24px;
        }

        .testimonial-author-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid var(--border-subtle);
            padding-top: 16px;
        }

        .author-meta {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .author-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 13px;
        }

        .author-meta strong {
            display: block;
            font-size: 13px;
            font-weight: 800;
            color: var(--ink-900);
            line-height: 1.2;
        }

        .author-meta span {
            font-size: 11px;
            color: var(--ink-500);
        }

        .star-rating {
            display: flex;
            align-items: center;
            gap: 2px;
            color: var(--gold-star);
        }

        /* ----------------------------------------------------
           FAQ & CONTACT SECTION (00:13 - 00:14 in video)
        ---------------------------------------------------- */
        .faq-section {
            background: #ffffff;
            border-radius: 32px;
            border: 1px solid var(--border-subtle);
            padding: 64px 54px;
            margin: 20px 0 84px;
            box-shadow: var(--shadow-card);
        }

        .faq-grid {
            display: grid;
            grid-template-columns: 0.95fr 1.25fr;
            gap: 60px;
            align-items: start;
        }

        .faq-left h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 38px;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.6px;
            margin-bottom: 14px;
        }

        .faq-left p {
            font-size: 14px;
            color: var(--ink-500);
            line-height: 1.65;
            margin-bottom: 28px;
        }

        .faq-form-box {
            display: flex;
            align-items: center;
            background: var(--bg-canvas);
            border: 1.5px solid var(--border-subtle);
            border-radius: var(--radius-pill);
            padding: 6px 6px 6px 18px;
            gap: 12px;
        }

        .faq-form-input {
            flex: 1;
            border: none;
            background: transparent;
            font-family: inherit;
            font-size: 13px;
            color: var(--ink-900);
            outline: none;
        }

        .faq-accordion-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .faq-card-item {
            border: 1px solid var(--border-subtle);
            border-radius: 16px;
            background: var(--bg-canvas);
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .faq-card-item:hover {
            border-color: var(--border-hover);
        }

        .faq-question-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            font-size: 14px;
            font-weight: 700;
            color: var(--ink-900);
            text-align: left;
        }

        .faq-chevron {
            transition: transform 0.25s ease;
            color: var(--ink-500);
            flex-shrink: 0;
        }

        .faq-card-item.active .faq-chevron {
            transform: rotate(90deg);
            color: var(--blue-vibrant);
        }

        .faq-answer-content {
            display: none;
            padding: 0 22px 18px;
            font-size: 13px;
            line-height: 1.65;
            color: var(--ink-500);
        }

        .faq-card-item.active .faq-answer-content {
            display: block;
        }

        /* ----------------------------------------------------
           FOOTER (00:15 in video)
        ---------------------------------------------------- */
        .site-footer {
            background: var(--blue-royal);
            color: #ffffff;
            padding: 68px 0 28px;
            margin-top: 60px;
        }

        .footer-top-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 48px;
            padding-bottom: 52px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        .footer-brand-title {
            font-family: 'Outfit', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-desc {
            font-size: 13px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.82);
            max-width: 340px;
        }

        .footer-col h4 {
            font-family: 'Outfit', sans-serif;
            font-size: 16px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 18px;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 11px;
        }

        .footer-links a {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.8);
        }

        .footer-links a:hover {
            color: #ffffff;
            padding-left: 4px;
        }

        .footer-contact-info {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }

        .footer-bottom-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 26px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.72);
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .hero-grid,
            .features-grid,
            .discovery-grid,
            .community-grid,
            .faq-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 24px;
            }

            .stat-item:nth-child(2) {
                border-right: none;
            }

            .features-cards-row,
            .testimonials-grid {
                grid-template-columns: 1fr;
            }

            .footer-top-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }

            .stats-bar-section {
                padding: 28px 24px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .stat-item {
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.15);
                padding-bottom: 12px;
            }

            .stat-item:last-child {
                border-bottom: none;
            }

            .discovery-section,
            .faq-section {
                padding: 36px 20px;
                border-radius: 24px;
            }

            .search-pill-widget {
                flex-direction: column;
                align-items: stretch;
                border-radius: 20px;
                padding: 18px;
            }

            .search-divider {
                display: none;
            }

            .search-btn-round {
                width: 100%;
                border-radius: var(--radius-pill);
                margin-top: 8px;
            }

            .footer-top-grid {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .footer-bottom-row {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <!-- 1. NAVBAR -->
    <header class="site-nav-wrap">
        <div class="container site-nav">
            <a href="{{ url('/') }}" class="brand-logo">
                <div class="brand-icon-box">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </div>
                <span>SINFAS<span class="brand-dot">.</span></span>
            </a>

            <nav class="nav-menu">
                <a href="#beranda">Beranda</a>
                <a href="#keunggulan">Keunggulan</a>
                <a href="#pencarian">Cari Fasilitas</a>
                <a href="#kegiatan">Civitas</a>
                <a href="#ulasan">Ulasan</a>
                <a href="#faq">FAQ</a>
            </nav>

            <div class="nav-actions">
                @auth
                    @if(auth()->user()->role === 'siswa')
                        <a href="{{ route('user.dashboard') }}" class="btn-pill-dark">
                            Dashboard Siswa
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    @elseif(auth()->user()->role === 'admin_sarana')
                        <a href="{{ route('admin.dashboard') }}" class="btn-pill-dark">
                            Dashboard Admin
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <a href="{{ route('sistem.dashboard') }}" class="btn-pill-dark">
                            Dashboard Sistem
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-pill-dark">
                        Masuk (Login)
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main id="beranda">
        <!-- 2. HERO SECTION -->
        <section class="hero-section">
            <div class="container hero-grid">
                <div class="hero-text-wrap">
                    <!-- Accent doodle rays -->
                    <svg class="hero-doodle" viewBox="0 0 40 40" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <line x1="8" y1="20" x2="2" y2="20" />
                        <line x1="12" y1="12" x2="6" y2="6" />
                        <line x1="20" y1="8" x2="20" y2="2" />
                    </svg>

                    <div class="hero-badge-tag">
                        <span>LAYANAN FASILITAS SEKOLAH</span>
                    </div>

                    <h1 class="hero-title">
                        Fasilitas Sekolah Lengkap, Pinjam Tanpa Ribet!
                    </h1>

                    <p class="hero-desc">
                        Kini siswa dan guru dapat mengecek ketersediaan alat praktikum, proyektor, lab komputer, aula, hingga sarana olahraga secara cepat, transparan, dan tertib.
                    </p>

                    <div class="hero-btns">
                        <a href="{{ route('login') }}" class="btn-pill-dark" style="padding: 14px 28px; font-size: 14px;">
                            Mulai Pinjam Sekarang
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <a href="#keunggulan" class="btn-pill-outline" style="padding: 13px 26px; font-size: 14px;">
                            Pelajari Alur Pinjam
                        </a>
                    </div>
                </div>

                <!-- Right Smartphone Mockup -->
                <div class="mockup-container">
                    <div class="phone-frame">
                        <div class="phone-speaker"></div>
                        
                        <div class="mockup-header">
                            <div class="mockup-user-info">
                                <div class="mockup-avatar">SIS</div>
                                <div>
                                    <div class="mockup-name">Portal Siswa</div>
                                    <div class="mockup-role">Sistem Peminjaman</div>
                                </div>
                            </div>
                            <span style="font-size: 18px;">🔔</span>
                        </div>

                        <div class="mockup-card-recom">
                            <span class="mockup-card-badge">Fasilitas Tersedia</span>
                            <div class="mockup-card-title">Proyektor EPSON EB-X500</div>
                            <div style="font-size: 11px; color: var(--ink-500); margin-bottom: 10px;">Ruang Sarana & Prasarana</div>
                            <span class="mockup-card-status">● Kondisi Baik (Siap Pakai)</span>
                        </div>

                        <div class="mockup-schedule-card">
                            <div class="mockup-schedule-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            </div>
                            <div class="mockup-schedule-text">
                                <strong>Peminjaman Hari Ini</strong>
                                <span>Verifikasi Cepat & Online</span>
                            </div>
                        </div>

                        <a href="{{ route('login') }}" class="mockup-btn-action" style="display: block; text-decoration: none;">
                            Ajukan Peminjaman Cepat
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. BLUE STATS BAR (00:04 in video) -->
        <section class="container">
            <div class="stats-bar-section">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-num">150+</div>
                        <div class="stat-label">Total Fasilitas & Peralatan Terdata</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-num">1.2K+</div>
                        <div class="stat-label">Peminjaman Sukses & Tuntas</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-num">100%</div>
                        <div class="stat-label">Transparan & Bebas Bentrok Jadwal</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-num">4.9</div>
                        <div class="stat-label">Indeks Kepuasan Civitas Sekolah</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. KEUNGGULAN / FEATURES (00:05 in video) -->
        <section class="container features-section" id="keunggulan">
            <div class="features-grid">
                <div class="features-left">
                    <h2>Layanan Fasilitas Sekolah Terbaik!</h2>
                    <p>Nikmati kemudahan pengelolaan sarana dan prasarana dengan sistem serba digital, akurat, dan terstruktur.</p>
                </div>

                <div class="features-cards-row">
                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                        </div>
                        <h3>Pilihan Beragam</h3>
                        <p>Inventaris alat lab, audio, proyektor, aula, hingga perlengkapan olahraga siap digunakan.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </div>
                        <h3>Panduan Tertib</h3>
                        <p>Tata tertib peminjaman jelas demi menjaga keamanan dan keawetan sarana milik sekolah.</p>
                    </div>

                    <div class="feature-card">
                        <div class="feature-icon-box">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        </div>
                        <h3>Booking Cepat</h3>
                        <p>Pengajuan langsung diverifikasi staf sarpras, hemat waktu tanpa harus keliling mencari form kertas.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. SEARCH & MAP DISCOVERY (00:06 - 00:08 in video) -->
        <section class="container" id="pencarian">
            <div class="discovery-section">
                <div class="discovery-grid">
                    <!-- Visual Map / Denah -->
                    <div class="map-graphic-wrap">
                        <svg class="map-svg-bg" viewBox="0 0 200 200" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M10 50 Q 50 20, 100 50 T 190 50" />
                            <path d="M10 100 Q 50 80, 100 100 T 190 100" />
                            <path d="M10 150 Q 50 130, 100 150 T 190 150" />
                        </svg>

                        <div class="pin-bubble pin-1">
                            <span class="pin-dot"></span>
                            <span>Lab Komputer 1</span>
                        </div>
                        <div class="pin-bubble pin-2">
                            <span class="pin-dot"></span>
                            <span>Ruang Sarpras Utama</span>
                        </div>
                        <div class="pin-bubble pin-3">
                            <span class="pin-dot"></span>
                            <span>Aula Serbaguna</span>
                        </div>
                    </div>

                    <!-- Right text & Quick search pill -->
                    <div class="discovery-content">
                        <h2>Laboratorium, Aula, Sound System — Butuh yang Mana?</h2>
                        <p>Jelajahi seluruh sarana prasarana sekolah, ketahui status ketersediaan barang secara real-time, dan ajukan jadwal pemakaian Anda sekarang.</p>

                        <!-- Search Widget Bar -->
                        <div class="search-pill-widget">
                            <div class="search-field">
                                <span class="search-field-label">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    Kategori Fasilitas
                                </span>
                                <input type="text" class="search-field-input" placeholder="Pilih atau cari barang..." value="Proyektor / Lab IPA / Aula" readonly onclick="window.location='{{ route('login') }}'">
                            </div>

                            <div class="search-divider"></div>

                            <div class="search-field">
                                <span class="search-field-label">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                    Tanggal Pinjam
                                </span>
                                <input type="text" class="search-field-input" placeholder="Pilih tanggal" value="{{ date('d M Y') }}" readonly onclick="window.location='{{ route('login') }}'">
                            </div>

                            <a href="{{ route('login') }}" class="search-btn-round" title="Cari Fasilitas">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 6. COMMUNITY / CIVITAS (00:09 in video) -->
        <section class="container community-section" id="kegiatan">
            <div class="community-grid">
                <div class="community-left">
                    <h2>Mendukung Segala Prestasi & Kegiatan Sekolah</h2>
                    <p>Mulai dari kegiatan belajar harian di kelas, persiapan lomba OSN/O2SN, rapat organisasi OSIS, hingga pentas seni akbar sekolah — fasilitas yang terawat selalu siap mendukung Anda.</p>
                    <a href="{{ route('login') }}" class="btn-pill-dark">
                        Bergabung & Pinjam Fasilitas
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="avatars-cluster">
                    <div class="avatar-card-item">
                        <div class="avatar-img-circle c1">OS</div>
                        <div class="avatar-role-text">
                            <strong>Pengurus OSIS</strong>
                            <span>Peminjam Aktif</span>
                        </div>
                    </div>

                    <div class="avatar-card-item">
                        <div class="avatar-img-circle c2">GR</div>
                        <div class="avatar-role-text">
                            <strong>Guru Pembina</strong>
                            <span>Praktikum & KBM</span>
                        </div>
                    </div>

                    <div class="avatar-card-item">
                        <div class="avatar-img-circle c3">SP</div>
                        <div class="avatar-role-text">
                            <strong>Staf Sarpras</strong>
                            <span>Pengelola Fasilitas</span>
                        </div>
                    </div>

                    <div class="avatar-card-item">
                        <div class="avatar-img-circle c4">EK</div>
                        <div class="avatar-role-text">
                            <strong>Ekskul PMR / Paskibra</strong>
                            <span>Kegiatan Lapangan</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 7. TESTIMONIALS SLIDER (00:10 - 00:12 in video) -->
        <section class="container testimonials-section" id="ulasan">
            <div class="testimonials-header">
                <h2>Kepuasan Warga Sekolah Adalah Bukti Nyata.</h2>
                <div class="slider-controls">
                    <button class="slider-arrow-btn" id="prev-testi" title="Sebelumnya" aria-label="Sebelumnya">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    </button>
                    <button class="slider-arrow-btn" id="next-testi" title="Berikutnya" aria-label="Berikutnya">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </button>
                </div>
            </div>

            <div class="testimonials-grid" id="testi-container">
                <!-- Testimonial 1: Siswa / OSIS -->
                <div class="testimonial-card">
                    <div>
                        <div class="quote-icon">“</div>
                        <p class="testimonial-text">
                            "Pinjam proyektor dan sound portable buat acara pensi OSIS jadi sat-set. Tidak perlu lagi keliling cari form kertas atau nunggu guru sarpras seharian di ruang piket."
                        </p>
                    </div>
                    <div class="testimonial-author-row">
                        <div class="author-meta">
                            <div class="author-avatar" style="background: #fed7aa; color: #9a3412;">RF</div>
                            <div>
                                <strong>Rafi Pratama</strong>
                                <span>Ketua OSIS</span>
                            </div>
                        </div>
                        <div class="star-rating">
                            ★★★★★
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2: Guru Pembina -->
                <div class="testimonial-card">
                    <div>
                        <div class="quote-icon">“</div>
                        <p class="testimonial-text">
                            "Sangat terbantu saat ingin menggunakan Lab Komputer untuk praktikum. Jadwalnya transparan dan terdata, tidak ada lagi insiden bentrok jam mengajar antar kelas."
                        </p>
                    </div>
                    <div class="testimonial-author-row">
                        <div class="author-meta">
                            <div class="author-avatar" style="background: #e0e7ff; color: #3730a3;">NH</div>
                            <div>
                                <strong>Nurul Hidayati, S.Pd.</strong>
                                <span>Guru Pembina KIR</span>
                            </div>
                        </div>
                        <div class="star-rating">
                            ★★★★★
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3: Staf Sarpras -->
                <div class="testimonial-card">
                    <div>
                        <div class="quote-icon">“</div>
                        <p class="testimonial-text">
                            "Pencatatan inventaris barang jauh lebih tertib dan mudah diaudit. Bukti foto kondisi saat pengembalian membuat seluruh aset sekolah lebih awet dan aman."
                        </p>
                    </div>
                    <div class="testimonial-author-row">
                        <div class="author-meta">
                            <div class="author-avatar" style="background: #dcfce7; color: #166534;">HD</div>
                            <div>
                                <strong>Bapak Hendra</strong>
                                <span>Staf Pengelola Sarpras</span>
                            </div>
                        </div>
                        <div class="star-rating">
                            ★★★★★
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 8. FAQ & INQUIRY SECTION (00:13 - 00:14 in video) -->
        <section class="container" id="faq">
            <div class="faq-section">
                <div class="faq-grid">
                    <div class="faq-left">
                        <h2>Punya Pertanyaan Seputar SINFAS?</h2>
                        <p>Jika ada kendala peminjaman atau pertanyaan seputar tata tertib fasilitas sekolah, hubungi pengelola sarana prasarana kami.</p>

                        <form class="faq-form-box" onsubmit="event.preventDefault(); alert('Pesan Anda telah diterima tim Sarana Prasarana SINFAS. Terima kasih!');">
                            <input type="text" class="faq-form-input" placeholder="Tuliskan pertanyaan Anda..." required>
                            <button type="submit" class="btn-pill-dark" style="padding: 10px 20px; font-size: 12px;">Kirim</button>
                        </form>
                    </div>

                    <div class="faq-accordion-list">
                        <div class="faq-card-item active">
                            <button class="faq-question-btn" onclick="toggleFaq(this)">
                                <span>Apa saja syarat untuk meminjam fasilitas sekolah?</span>
                                <span class="faq-chevron">▶</span>
                            </button>
                            <div class="faq-answer-content">
                                Anda harus terdaftar sebagai siswa atau pegawai aktif di sekolah. Setiap peminjaman wajib mencantumkan nama, nomor kontak, serta tujuan/kegiatan penggunaan fasilitas.
                            </div>
                        </div>

                        <div class="faq-card-item">
                            <button class="faq-question-btn" onclick="toggleFaq(this)">
                                <span>Bagaimana jika barang yang dipinjam mengalami kerusakan?</span>
                                <span class="faq-chevron">▶</span>
                            </button>
                            <div class="faq-answer-content">
                                Pengembalian dilengkapi catatan kondisi barang dan foto dokumentasi. Jika kerusakan terjadi akibat kelalaian, peminjam wajib bertanggung jawab sesuai kesepakatan tata tertib sarpras sekolah.
                            </div>
                        </div>

                        <div class="faq-card-item">
                            <button class="faq-question-btn" onclick="toggleFaq(this)">
                                <span>Berapa lama batas maksimal waktu peminjaman alat?</span>
                                <span class="faq-chevron">▶</span>
                            </button>
                            <div class="faq-answer-content">
                                Umumnya fasilitas dipinjam sesuai jam kegiatan belajar atau agenda acara pada hari yang sama. Untuk peminjaman lebih dari 1 hari wajib menyertakan surat izin kegiatan resmi.
                            </div>
                        </div>

                        <div class="faq-card-item">
                            <button class="faq-question-btn" onclick="toggleFaq(this)">
                                <span>Apakah bisa meminjam fasilitas untuk kegiatan di hari libur?</span>
                                <span class="faq-chevron">▶</span>
                            </button>
                            <div class="faq-answer-content">
                                Bisa, asalkan kegiatan tersebut disetujui oleh pembina ekstrakurikuler atau wakasek sarana prasarana sekolah dengan melampirkan surat disposisi kegiatan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- 9. FOOTER (00:15 in video) -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-top-grid">
                <div>
                    <div class="footer-brand-title">
                        <span>SINFAS.</span>
                    </div>
                    <p class="footer-desc">
                        Sistem Informasi Fasilitas Sekolah yang menghadirkan keterbukaan, kemudahan, dan akuntabilitas peminjaman sarana prasarana bagi seluruh warga sekolah.
                    </p>
                </div>

                <div class="footer-col">
                    <h4>Kategori Fasilitas</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('login') }}">Peralatan Multimedia</a></li>
                        <li><a href="{{ route('login') }}">Laboratorium Komputer & IPA</a></li>
                        <li><a href="{{ route('login') }}">Aula & Ruang Pertemuan</a></li>
                        <li><a href="{{ route('login') }}">Sarana & Alat Olahraga</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Informasi Layanan</h4>
                    <ul class="footer-links">
                        <li><a href="#keunggulan">Alur Peminjaman</a></li>
                        <li><a href="#keunggulan">Tata Tertib Penggunaan</a></li>
                        <li><a href="#faq">Pusat Bantuan (FAQ)</a></li>
                        <li><a href="{{ route('login') }}">Portal Siswa & Guru</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Kontak Pengelola</h4>
                    <div class="footer-contact-info">
                        <p><strong>Ruang Sarana & Prasarana</strong></p>
                        <p>Gedung A, Lantai 1</p>
                        <p style="margin-top: 8px;">Senin – Jumat: 07.00 – 16.00 WIB</p>
                        <p style="margin-top: 4px;">Email: sarpras@sekolah.sch.id</p>
                    </div>
                </div>
            </div>

            <div class="footer-bottom-row">
                <p>&copy; {{ date('Y') }} SINFAS Sekolah. Seluruh hak cipta dilindungi.</p>
                <p>Mendukung Digitalisasi Sarana Prasarana Sekolah</p>
            </div>
        </div>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        function toggleFaq(btn) {
            const card = btn.closest('.faq-card-item');
            const isActive = card.classList.contains('active');
            
            // Close all
            document.querySelectorAll('.faq-card-item').forEach(c => c.classList.remove('active'));
            
            // If was not active, open it
            if (!isActive) {
                card.classList.add('active');
            }
        }

        // Testimonial arrow shuffle animation
        const testiContainer = document.getElementById('testi-container');
        document.getElementById('next-testi')?.addEventListener('click', () => {
            if (testiContainer && testiContainer.children.length > 1) {
                testiContainer.appendChild(testiContainer.firstElementChild);
            }
        });
        document.getElementById('prev-testi')?.addEventListener('click', () => {
            if (testiContainer && testiContainer.children.length > 1) {
                testiContainer.insertBefore(testiContainer.lastElementChild, testiContainer.firstElementChild);
            }
        });
    </script>
</body>
</html>