<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SINFAS membantu siswa menemukan dan meminjam fasilitas sekolah dengan lebih mudah.">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/sinfas-logo.svg'))) }}">
    <title>SINFAS — Fasilitas sekolah, lebih gampang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #0f172a;
            --paper: #f1f5fa;
            --primary: #4f46e5;
            --primary-dark: #2c4a7c;
            --primary-soft: #eef2ff;
            --cyan: #06b6d4;
            --muted: #64748b;
            --border: #e2e8f0;
            --brand-gradient: linear-gradient(135deg, #6b8dd6 0%, #4f46e5 52%, #2c4a7c 100%);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            color: var(--ink);
            background: var(--paper);
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            background-image: linear-gradient(rgba(15, 23, 42, .025) 1px, transparent 1px), linear-gradient(90deg, rgba(15, 23, 42, .025) 1px, transparent 1px), radial-gradient(at 0% 0%, rgba(107, 141, 214, .16) 0, transparent 42%), radial-gradient(at 100% 100%, rgba(79, 70, 229, .09) 0, transparent 46%);
            background-size: 34px 34px, 34px 34px, auto, auto;
        }
        a { color: inherit; text-decoration: none; }
        .site-header {
            position: sticky;
            top: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: 82px;
            margin: 0;
            padding: 0 max(32px, calc((100vw - 1280px) / 2));
            border-bottom: 1px solid rgba(226, 232, 240, .85);
            background: rgba(248, 250, 252, .92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow: 0 4px 20px rgba(15, 23, 42, .04);
        }
        .brand { display: inline-flex; align-items: center; gap: 11px; }
        .brand-mark {
            display: grid;
            width: 44px;
            height: 44px;
            place-items: center;
            border-radius: 14px;
            background: var(--brand-gradient);
            color: #fff;
            box-shadow: 0 4px 14px rgba(79, 70, 229, .25);
            object-fit: cover;
        }
        .brand-text { display: inline-flex; flex-direction: column; }
        .brand-name {
            font: 800 23px/1 'Outfit', sans-serif;
            letter-spacing: 0;
            color: var(--primary-dark);
        }
        .brand-caption { margin-top: 4px; color: var(--muted); font-size: 10px; font-weight: 600; line-height: 1; }
        .main-nav { display: flex; align-items: center; gap: 4px; padding: 4px; border: 1px solid var(--border); border-radius: 9999px; background: rgba(241, 245, 249, .8); color: #475569; font-size: 13px; font-weight: 700; }
        .main-nav a { padding: 9px 16px; border-radius: 9999px; transition: color .18s ease, background .18s ease; }
        .main-nav a:hover { color: var(--primary); background: #fff; }
        .login-link:hover { color: var(--primary); }
        .header-actions { display: flex; align-items: center; gap: 18px; font-size: 13px; font-weight: 700; }
        .button {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0 20px;
            border: 0;
            border-radius: 12px;
            background: linear-gradient(135deg, #5b63e9 0%, #4f46e5 48%, #1d4ed8 100%);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(44, 74, 124, .24);
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .button:hover { transform: translateY(-3px); box-shadow: 0 12px 26px rgba(79, 70, 229, .32); }
        .button svg { width: 17px; height: 17px; }
        .hero {
            position: relative;
            isolation: isolate;
            display: flex;
            width: min(calc(100% - 48px), 1240px);
            min-height: clamp(540px, calc(100svh - 108px), 680px);
            align-items: center;
            overflow: hidden;
            margin: 24px auto 0;
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 32px;
            background: var(--primary-dark);
            color: #fff;
            box-shadow: 0 24px 48px -12px rgba(44, 74, 124, .42);
        }
        .hero::before { position: absolute; inset: 0; z-index: 1; background: linear-gradient(90deg, transparent 0 56%, rgba(103, 232, 249, .08) 56.1%, transparent 56.3%), linear-gradient(180deg, rgba(255,255,255,.1), transparent 18%); content: ''; pointer-events: none; }
        .hero::after { position: absolute; top: 22px; right: 28px; width: 110px; height: 110px; border: 1px solid rgba(255,255,255,.18); border-radius: 50%; box-shadow: 0 0 0 18px rgba(255,255,255,.025), 0 0 0 36px rgba(255,255,255,.02); content: ''; pointer-events: none; }
        .hero-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center 44%;
            animation: image-breathe 12s ease-in-out infinite alternate;
        }
        .hero-shade {
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, rgba(14, 31, 64, .96) 0%, rgba(28, 51, 90, .86) 43%, rgba(79, 70, 229, .46) 100%);
        }
        .hero-inner {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: minmax(0, 1.15fr) minmax(320px, .85fr);
            align-items: center;
            gap: 48px;
            width: min(calc(100% - 80px), 1120px);
            margin: 0 auto;
            padding: 56px 0 76px;
        }
        .hero-copy-block { animation: copy-arrive .55s both cubic-bezier(.2,.8,.2,1); }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 26px;
            padding: 7px 13px;
            border: 1px solid rgba(255, 255, 255, .28);
            border-radius: 9999px;
            background: rgba(255, 255, 255, .13);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .5px;
        }
        .eyebrow::before { width: 7px; height: 7px; border-radius: 50%; background: var(--cyan); content: ''; }
        h1, h2, h3, p { margin-top: 0; }
        h1 {
            max-width: 650px;
            margin-bottom: 20px;
            font: 800 clamp(54px, 6vw, 78px)/.98 'Outfit', sans-serif;
            letter-spacing: 0;
            text-shadow: 0 6px 22px rgba(15, 23, 42, .2);
        }
        h1 span { color: #67e8f9; }
        .hero-copy { max-width: 520px; margin-bottom: 32px; color: rgba(255,255,255,.84); font-size: 16px; line-height: 1.75; }
        .hero-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 14px; }
        .hero-secondary { display: inline-flex; align-items: center; gap: 9px; padding: 12px 16px; border: 1px solid rgba(255,255,255,.38); border-radius: 10px; background: rgba(255,255,255,.1); color: #fff; font-size: 13px; font-weight: 700; transition: background .18s ease; }
        .hero-secondary svg { width: 16px; height: 16px; }
        .hero-secondary:hover { background: rgba(255,255,255,.2); }
        .hero-product-card {
            position: relative;
            padding: 26px;
            border: 1px solid rgba(255,255,255,.68);
            border-radius: 26px;
            background: rgba(255,255,255,.94);
            color: var(--ink);
            box-shadow: 0 24px 60px rgba(15, 23, 42, .24);
            backdrop-filter: blur(16px);
            animation: card-arrive .75s .16s both cubic-bezier(.2,.8,.2,1);
            transition: transform .28s ease, box-shadow .28s ease;
        }
        .hero-product-card:hover { transform: translateY(-8px) rotate(-.5deg); box-shadow: 0 30px 70px rgba(15, 23, 42, .3); }
        .hero-product-card::before { position: absolute; top: -1px; left: 28px; right: 28px; height: 3px; border-radius: 0 0 999px 999px; background: linear-gradient(90deg, #22d3ee, #818cf8, #f472b6); content: ''; }
        .product-card-top { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
        .product-card-mark { display: grid; width: 42px; height: 42px; flex: 0 0 auto; place-items: center; border-radius: 13px; background: var(--primary-soft); color: var(--primary); }
        .product-card-mark svg { width: 22px; height: 22px; }
        .product-card-header-text { display: flex; flex-direction: column; gap: 2px; }
        .product-card-kicker { display: block; color: var(--primary); font-size: 10px; font-weight: 800; letter-spacing: .7px; text-transform: uppercase; }
        .product-card-heading { display: block; margin: 0; font: 700 14px/1.3 'Outfit', sans-serif; color: var(--ink); }
        .product-card-title { max-width: 290px; margin-bottom: 20px; font: 700 24px/1.15 'Outfit', sans-serif; }
        .product-list { border-top: 1px solid var(--border); }
        .product-row { display: flex; align-items: center; gap: 13px; padding: 14px 0; border-bottom: 1px solid var(--border); }
        .product-row-icon { display: grid; width: 38px; height: 38px; flex: 0 0 auto; place-items: center; border-radius: 12px; background: #eef2ff; color: var(--primary); }
        .product-row:nth-child(2) .product-row-icon { background: #ecfeff; color: #0891b2; }
        .product-row:nth-child(3) .product-row-icon { background: #fdf2f8; color: #db2777; }
        .product-row-icon svg { width: 19px; height: 19px; }
        .product-row-copy { display: grid; gap: 3px; }
        .product-row-copy strong { font-size: 12px; font-weight: 800; }
        .product-row-copy span { color: var(--muted); font-size: 10px; }
        .product-row-check { width: 17px; height: 17px; margin-left: auto; color: #10b981; }
        .product-card-foot { display: flex; align-items: center; gap: 8px; margin-top: 18px; color: var(--muted); font-size: 10px; font-weight: 600; }
        .product-card-foot svg { width: 15px; height: 15px; color: var(--primary); }
        @keyframes copy-arrive { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes card-arrive { from { opacity: 0; transform: translateY(18px) rotate(1deg); } to { opacity: 1; transform: translateY(0) rotate(0); } }
        @keyframes image-breathe { from { transform: scale(1); } to { transform: scale(1.045); } }
        .hero-live { position: absolute; top: 30px; right: max(42px, calc((100% - 1120px) / 2)); z-index: 3; display: inline-flex; align-items: center; gap: 8px; padding: 8px 11px; border: 1px solid rgba(255,255,255,.23); border-radius: 999px; background: rgba(15,23,42,.24); color: rgba(255,255,255,.9); font-size: 10px; font-weight: 800; letter-spacing: .5px; backdrop-filter: blur(12px); }
        .hero-live::before { width: 7px; height: 7px; border-radius: 50%; background: #34d399; box-shadow: 0 0 0 4px rgba(52,211,153,.16); content: ''; }
        .hero-note {
            position: absolute;
            right: auto;
            left: max(40px, calc((100% - 1120px) / 2));
            bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 9px 13px;
            border: 1px solid rgba(255,255,255,.22);
            border-radius: 9999px;
            background: rgba(15, 23, 42, .24);
            color: rgba(255,255,255,.9);
            font-size: 11px;
            font-weight: 600;
        }
        .note-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--cyan); }
        .hero-proof { display: flex; align-items: center; gap: 12px; margin-top: 30px; color: rgba(255,255,255,.72); font-size: 11px; font-weight: 600; }
        .proof-avatars { display: flex; padding-left: 7px; }
        .proof-avatar { display: grid; width: 28px; height: 28px; margin-left: -7px; place-items: center; border: 2px solid rgba(255,255,255,.75); border-radius: 50%; background: #a5b4fc; color: #1e1b4b; font: 800 10px 'Outfit', sans-serif; }
        .proof-avatar:nth-child(2) { background: #67e8f9; }
        .proof-avatar:nth-child(3) { background: #fcd34d; }
        .proof-avatar:nth-child(4) { background: #f9a8d4; }
        .hero-stat { position: absolute; right: 36px; bottom: 31px; display: flex; align-items: center; gap: 9px; color: rgba(255,255,255,.86); font-size: 11px; font-weight: 700; }
        .hero-stat strong { color: #67e8f9; font: 800 18px 'Outfit', sans-serif; }
        .intro-strip {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
            width: min(100% - 64px, 1280px);
            margin: 0 auto;
            padding: 34px 0;
            border-bottom: 1px solid var(--border);
        }
        .intro-copy { display: grid; gap: 7px; }
        .intro-strip p { max-width: 560px; margin: 0; color: var(--muted); font-size: 13px; line-height: 1.6; }
        .intro-tag { flex: 0 0 auto; color: var(--primary); font: 700 13px 'Outfit', sans-serif; }
        .trust-stats { display: flex; align-items: center; gap: 24px; }
        .trust-stat { display: grid; gap: 2px; }
        .trust-stat strong { font: 800 22px/1 'Outfit', sans-serif; color: var(--ink); }
        .trust-stat span { color: var(--muted); font-size: 10px; font-weight: 700; }
        .steps-section { padding: 104px 32px 112px; }
        .steps-wrap { width: min(100%, 1280px); margin: 0 auto; }
        .section-heading { display: flex; align-items: end; justify-content: space-between; gap: 36px; margin-bottom: 46px; }
        .section-kicker { margin-bottom: 12px; color: var(--primary); font-size: 11px; font-weight: 800; }
        h2 { max-width: 570px; margin-bottom: 0; font: 700 42px/1.08 'Outfit', sans-serif; letter-spacing: 0; }
        .section-heading > p { max-width: 340px; margin: 0 0 4px; color: var(--muted); font-size: 14px; line-height: 1.7; }
        .steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .step { min-height: 222px; padding: 24px 26px 26px; border: 1px solid #e8eef6; border-radius: 20px; background: rgba(255,255,255,.88); box-shadow: 0 8px 24px -12px rgba(30, 41, 80, .22), 0 1px 3px rgba(0, 0, 0, .03); transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease; }
        .step:hover { transform: translateY(-6px); border-color: #c7d2fe; box-shadow: 0 18px 34px -16px rgba(79, 70, 229, .34); }
        .step + .step { padding-left: 24px; border-left: 1px solid #e8eef6; }
        .step-number { display: flex; align-items: center; justify-content: space-between; margin-bottom: 32px; color: var(--primary); font: 700 13px 'Outfit', sans-serif; }
        .step-number svg { width: 22px; height: 22px; }
        h3 { margin-bottom: 9px; font: 700 20px 'Outfit', sans-serif; }
        .step p { max-width: 310px; margin: 0; color: var(--muted); font-size: 13px; line-height: 1.7; }
        .faq-section { padding: 100px 32px 108px; border-top: 1px solid rgba(226, 232, 240, .8); border-bottom: 1px solid rgba(226, 232, 240, .8); background: rgba(255, 255, 255, .72); scroll-margin-top: 82px; }
        .faq-wrap { display: grid; grid-template-columns: minmax(260px, .82fr) minmax(0, 1.18fr); align-items: start; gap: 76px; width: min(100%, 1160px); margin: 0 auto; }
        .faq-intro h2 { margin-bottom: 16px; font-size: 40px; }
        .faq-intro > p:not(.section-kicker) { max-width: 380px; margin-bottom: 24px; color: var(--muted); font-size: 14px; line-height: 1.75; }
        .faq-login-link { display: inline-flex; align-items: center; gap: 8px; color: var(--primary); font-size: 13px; font-weight: 800; }
        .faq-login-link svg { width: 16px; height: 16px; transition: transform .18s ease; }
        .faq-login-link:hover svg { transform: translateX(4px); }
        .faq-list { border-top: 1px solid var(--border); }
        .faq-item { border-bottom: 1px solid var(--border); }
        .faq-item summary { display: flex; align-items: center; justify-content: space-between; gap: 20px; padding: 21px 0; color: var(--ink); cursor: pointer; font-size: 14px; font-weight: 800; list-style: none; }
        .faq-item summary::-webkit-details-marker { display: none; }
        .faq-item summary::after { content: '+'; flex: 0 0 auto; color: var(--primary); font: 500 24px/1 'Outfit', sans-serif; }
        .faq-item[open] summary::after { content: '-'; }
        .faq-item summary:hover { color: var(--primary); }
        .faq-item summary:focus-visible { border-radius: 4px; outline: 2px solid var(--primary); outline-offset: 4px; }
        .faq-answer { max-width: 600px; padding: 0 42px 21px 0; color: var(--muted); font-size: 13px; line-height: 1.75; }
        .closing-band { display: flex; align-items: center; justify-content: space-between; gap: 28px; margin: 0 max(24px, calc((100vw - 1280px) / 2)); padding: 34px 42px; border-radius: 24px; background: linear-gradient(110deg, #1e3a8a 0%, #4338ca 52%, #6d28d9 100%); color: #fff; box-shadow: 0 18px 36px -12px rgba(44, 74, 124, .42); }
        .closing-band p { margin: 0; font: 600 21px 'Outfit', sans-serif; }
        .closing-band .button { flex: 0 0 auto; }
        footer { display: flex; align-items: center; justify-content: space-between; gap: 20px; width: min(100% - 64px, 1280px); min-height: 82px; margin: 0 auto; color: var(--muted); font-size: 11px; }
        .footer-brand { display: inline-flex; align-items: center; gap: 8px; color: var(--primary-dark); font: 700 14px 'Outfit', sans-serif; }
        .footer-brand img { width: 28px; height: 28px; border-radius: 8px; }

        @media (max-width: 760px) {
            .site-header { height: 72px; padding: 0 18px; }
            .brand-name { font-size: 20px; }
            .main-nav, .login-link { display: none; }
            .header-actions { gap: 0; }
            .header-actions .button { min-height: 40px; padding: 0 14px; font-size: 12px; }
            .hero { width: calc(100% - 28px); min-height: 0; align-items: flex-start; margin-top: 14px; border-radius: 22px; }
            .hero-image { object-position: 58% center; }
            .hero::after { top: 76px; right: -34px; width: 90px; height: 90px; }
            .hero-shade { background: linear-gradient(110deg, rgba(28, 51, 90, .92), rgba(44, 74, 124, .78) 62%, rgba(79, 70, 229, .48)); }
            .hero-inner { display: block; width: calc(100% - 40px); padding: 58px 0 76px; }
            h1 { max-width: 560px; font-size: 54px; }
            .hero-copy { max-width: 420px; font-size: 14px; }
            .hero-product-card { margin-top: 24px; padding: 18px; border-radius: 18px; animation-delay: .08s; }
            .product-card-top { margin-bottom: 13px; }
            .product-card-title { margin-bottom: 14px; font-size: 20px; }
            .product-row { padding: 9px 0; }
            .hero-note { display: none; }
            .hero-live { top: 20px; right: 20px; }
            .hero-stat { right: 20px; bottom: 22px; }
            .intro-strip { width: calc(100% - 40px); align-items: flex-start; flex-direction: column; gap: 10px; padding: 22px 0; }
            .trust-stats { width: 100%; justify-content: space-between; gap: 12px; }
            .trust-stat strong { font-size: 20px; }
            .steps-section { padding: 70px 20px 76px; }
            .section-heading { align-items: flex-start; flex-direction: column; gap: 16px; margin-bottom: 30px; }
            h2 { font-size: 34px; }
            .steps-grid { grid-template-columns: 1fr; }
            .step, .step + .step { min-height: 0; padding: 20px; border: 1px solid #e8eef6; }
            .step-number { margin-bottom: 18px; }
            .faq-section { padding: 70px 20px 76px; }
            .faq-wrap { grid-template-columns: 1fr; gap: 30px; }
            .faq-intro h2 { font-size: 34px; }
            .faq-item summary { padding: 18px 0; font-size: 13px; }
            .faq-answer { padding-right: 28px; }
            .closing-band { align-items: flex-start; flex-direction: column; padding: 30px 20px; }
            .closing-band p { font-size: 19px; }
            footer { width: calc(100% - 40px); min-height: 76px; }
        }
        @media (max-width: 420px) {
            h1 { font-size: 43px; }
            .hero-inner { padding: 48px 0 64px; }
            .hero-secondary { display: none; }
            .hero-live { top: 16px; right: 16px; font-size: 9px; }
            .hero-stat { display: none; }
            .hero-product-card { margin-top: 20px; padding: 16px; }
            .product-card-top { margin-bottom: 10px; }
            .product-card-title { margin-bottom: 10px; font-size: 18px; }
            .product-row { padding: 7px 0; }
            .product-row-icon { width: 32px; height: 32px; }
            .product-row-copy span, .product-card-foot { display: none; }
            .button { min-height: 44px; }
            footer { align-items: flex-start; flex-direction: column; justify-content: center; gap: 6px; padding: 16px 0; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; animation-duration: .01ms !important; animation-delay: 0ms !important; }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <a class="brand" href="{{ url('/') }}" aria-label="SINFAS, beranda">
            @include('components.sinfas-logo', ['class' => 'brand-mark'])
            <span class="brand-text"><span class="brand-name">SINFAS</span><span class="brand-caption">Sistem Informasi Fasilitas</span></span>
        </a>
        <nav class="main-nav" aria-label="Navigasi utama">
            <a href="#cara-kerja">Cara kerja</a>
            <a href="#tentang">Tentang SINFAS</a>
            <a href="#pertanyaan">FAQ</a>
        </nav>
        <div class="header-actions">
            <a class="button" href="{{ route('login') }}">
                Masuk
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 12h14"></path>
                    <path d="m12 5 7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </header>

    <main>
        <section class="hero" id="tentang">
            <img class="hero-image" src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=2200&q=88" alt="Ruang kelas sekolah dengan fasilitas belajar" fetchpriority="high">
            <div class="hero-live">SISTEM AKTIF</div>
            <div class="hero-shade" aria-hidden="true"></div>
            <div class="hero-inner">
                <div class="hero-copy-block">
                    <p class="eyebrow">FASILITAS SEKOLAH, DALAM GENGGAMAN</p>
                    <h1>Cari fasilitas,<br><span>ajukan peminjaman.</span></h1>
                    <p class="hero-copy">Temukan fasilitas sekolah, ajukan peminjaman, dan pantau statusnya sampai selesai.</p>
                    <div class="hero-actions">
                        <a class="button" href="{{ route('login') }}">Cari fasilitas <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
                        <a class="hero-secondary" href="#cara-kerja">Lihat cara kerjanya <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14m7-7-7 7-7-7"/></svg></a>
                    </div>
                    <div class="hero-proof">
                        <span class="proof-avatars" aria-hidden="true"><span class="proof-avatar">A</span><span class="proof-avatar">N</span><span class="proof-avatar">R</span><span class="proof-avatar">+</span></span>
                        <span>Dipakai untuk kegiatan sekolah yang lebih tertata</span>
                    </div>
                </div>
            <aside class="hero-product-card" aria-label="Alur peminjaman di SINFAS">
                <div class="product-card-top">
                    <span class="product-card-mark" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19V5h16v14zM8 9h8M8 13h5"/><path d="m15 16 1.5 1.5L20 14"/></svg></span>
                    <div class="product-card-header-text">
                        <span class="product-card-kicker">PORTAL PEMINJAMAN FASILITAS</span>
                        <span class="product-card-heading">Ajukan fasilitas sekolah</span>
                    </div>
                </div>
                <p class="product-card-title">Cari, pinjam, dan pantau fasilitas.</p>
                <div class="product-list">
                    <div class="product-row">
                        <span class="product-row-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 4.5 4.5M8 10.8h5.6M10.8 8v5.6"/></svg></span>
                        <span class="product-row-copy"><strong>Temukan fasilitas</strong><span>Lihat detail dan ketersediaan</span></span>
                        <svg class="product-row-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>
                    </div>
                    <div class="product-row">
                        <span class="product-row-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h5"/></svg></span>
                        <span class="product-row-copy"><strong>Ajukan peminjaman</strong><span>Lengkapi kebutuhan dan jadwal</span></span>
                        <svg class="product-row-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>
                    </div>
                    <div class="product-row">
                        <span class="product-row-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-5 5"/></svg></span>
                        <span class="product-row-copy"><strong>Pantau pengajuan</strong><span>Cek status sampai pengembalian</span></span>
                        <svg class="product-row-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>
                    </div>
                </div>
                <div class="product-card-foot"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11z"/><path d="m9 12 2 2 4-4"/></svg>Pengajuanmu tersimpan dan mudah dipantau</div>
            </aside>
            </div>
            <div class="hero-note"><span class="note-dot" aria-hidden="true"></span>Semua kebutuhan kegiatan, lebih terorganisir</div>
            <div class="hero-stat"><strong>24/7</strong><span>Akses katalog<br>kapan saja</span></div>
        </section>

        <div class="intro-strip">
            <div class="intro-copy">
                <span class="intro-tag">SATU PLATFORM. BANYAK KEMUNGKINAN.</span>
                <p>Dari tugas kelompok sampai acara sekolah, temukan fasilitas yang bisa bantu ide kamu jalan.</p>
            </div>
            <div class="trust-stats" aria-label="Keunggulan SINFAS">
                <span class="trust-stat"><strong>3</strong><span>Langkah mudah</span></span>
                <span class="trust-stat"><strong>1</strong><span>Portal terpadu</span></span>
                <span class="trust-stat"><strong>100%</strong><span>Lebih terpantau</span></span>
            </div>
        </div>

        <section class="steps-section" id="cara-kerja">
            <div class="steps-wrap">
                <div class="section-heading">
                    <div><p class="section-kicker">GAMPANG BANGET, SERIUS.</p><h2>Tiga langkah, langsung siap beraksi.</h2></div>
                    <p>Proses peminjaman yang jelas bikin kamu bisa fokus ke hal yang paling penting: acaranya.</p>
                </div>
                <div class="steps-grid">
                    <article class="step">
                        <div class="step-number"><span>01 / TEMUKAN</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 4.5 4.5M8 10.8h5.6M10.8 8v5.6"/></svg></div>
                        <h3>Pilih yang kamu perlu</h3>
                        <p>Jelajahi daftar fasilitas dan cek detail barang sebelum mengajukan.</p>
                    </article>
                    <article class="step">
                        <div class="step-number"><span>02 / AJUKAN</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h5"/></svg></div>
                        <h3>Kirim permintaanmu</h3>
                        <p>Isi kebutuhan dan jadwal peminjaman lewat akunmu.</p>
                    </article>
                    <article class="step">
                        <div class="step-number"><span>03 / GAS!</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 7 10 17l-5-5"/><path d="M21 12a9 9 0 1 1-5.3-8.2"/></svg></div>
                        <h3>Pantau statusnya</h3>
                        <p>Lihat perkembangan pengajuan dan kelola pengembalian di satu tempat.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="faq-section" id="pertanyaan" aria-labelledby="faq-title">
            <div class="faq-wrap">
                <div class="faq-intro">
                    <p class="section-kicker">INFO PEMINJAMAN</p>
                    <h2 id="faq-title">Masih ada yang ingin ditanyakan?</h2>
                    <p>Kenali alur akses, pengajuan, dan pengembalian fasilitas sekolah melalui SINFAS.</p>
                    <a class="faq-login-link" href="{{ route('login') }}">
                        Masuk ke akun SINFAS
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"></path><path d="m12 5 7 7-7 7"></path></svg>
                    </a>
                </div>
                <div class="faq-list">
                    <details class="faq-item">
                        <summary>Bagaimana cara mulai mengajukan peminjaman?</summary>
                        <div class="faq-answer">Masuk dengan akun sekolah, pilih fasilitas yang dibutuhkan, lalu isi tanggal dan keperluan peminjaman. Pengajuan akan menunggu pemeriksaan admin.</div>
                    </details>
                    <details class="faq-item">
                        <summary>Bagaimana jika saya belum memiliki akun?</summary>
                        <div class="faq-answer">Akun pengguna dikelola oleh pihak sekolah. Hubungi admin sekolah untuk mendapatkan informasi akses akun SINFAS.</div>
                    </details>
                    <details class="faq-item">
                        <summary>Di mana saya bisa melihat status pengajuan?</summary>
                        <div class="faq-answer">Setelah masuk, buka halaman status pengajuan untuk melihat perkembangan permintaan peminjamanmu.</div>
                    </details>
                    <details class="faq-item">
                        <summary>Apa yang dilakukan saat mengembalikan fasilitas?</summary>
                        <div class="faq-answer">Laporkan tanggal pengembalian dan kondisi barang melalui akunmu. Admin akan memeriksa laporan sebelum menyelesaikan proses pengembalian.</div>
                    </details>
                </div>
            </div>
        </section>

        <section class="closing-band">
            <p>Udah siap bikin sesuatu yang keren?</p>
            <a class="button" href="{{ route('login') }}">Masuk ke SINFAS <span aria-hidden="true">↗</span></a>
        </section>
    </main>

    <footer>
        <span class="footer-brand">@include('components.sinfas-logo', ['class' => 'footer-logo'])SINFAS</span>
        <span>Kelola fasilitas sekolah, bareng-bareng.</span>
    </footer>
</body>
</html>