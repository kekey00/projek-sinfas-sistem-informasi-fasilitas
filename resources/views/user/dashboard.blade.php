@extends('layouts.user')

@section('title', 'Mau pinjam apa hari ini? - SINFAS')

@section('styles')
<style>
    /* HERO VIBE BANNER */
    .hero-vibe-box {
        background: linear-gradient(135deg, #2C4A7C 0%, #3B5998 48%, #5B8DEF 100%);
        border-radius: 28px;
        padding: 36px 40px;
        color: #fff;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 35px -5px rgba(59, 89, 152, 0.35);
    }

    .hero-vibe-box::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(123, 167, 217, 0.35) 0%, transparent 70%);
        filter: blur(25px);
        pointer-events: none;
    }

    .hero-vibe-box::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: 20%;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(91, 141, 239, 0.28) 0%, transparent 70%);
        filter: blur(20px);
        pointer-events: none;
    }

    .hero-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        padding: 4px 14px;
        border-radius: var(--radius-pill);
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 12px;
        letter-spacing: 0.3px;
    }

    .hero-title-vibe {
        font-size: 32px;
        font-weight: 900;
        letter-spacing: -0.8px;
        line-height: 1.2;
        margin-bottom: 8px;
    }

    .hero-sub-vibe {
        font-size: 15px;
        color: rgba(255, 255, 255, 0.85);
        max-width: 620px;
        line-height: 1.6;
    }

    /* SEARCH & FILTER ROW (SESUAI MOCKUP) */
    .search-filter-shell {
        display: flex;
        flex-direction: column;
        margin-bottom: 24px;
    }

    .search-row-flex {
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
    }

    .search-input-box {
        flex: 1;
        display: flex;
        align-items: center;
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 12px;
        padding: 10px 18px;
        box-shadow: 0 1px 4px rgba(15, 23, 42, 0.04);
        transition: all 0.2s ease;
    }

    .search-input-box:focus-within {
        border-color: #5B8DEF;
        box-shadow: 0 0 0 3px rgba(91, 141, 239, 0.16);
    }

    .search-icon-svg {
        color: #94A3B8;
        margin-right: 10px;
        flex-shrink: 0;
    }

    .search-input-clean {
        flex: 1;
        border: none;
        outline: none;
        font-family: inherit;
        font-size: 14.5px;
        font-weight: 500;
        color: #1E293B;
        background: transparent;
    }

    .search-input-clean::placeholder {
        color: #94A3B8;
        font-weight: 400;
    }

    /* FILTER BUTTON & DROPDOWN */
    .filter-dropdown-container {
        position: relative;
    }

    .btn-filter-trigger {
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 12px;
        padding: 10px 18px;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 1px 4px rgba(15, 23, 42, 0.04);
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-filter-trigger:hover,
    .btn-filter-trigger.open {
        background: #F8FAFC;
        border-color: #CBD5E1;
        color: #0F172A;
    }

    .filter-dropdown-popup {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        width: 250px;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12), 0 4px 10px rgba(15, 23, 42, 0.04);
        padding: 8px;
        z-index: 100;
        max-height: 280px;
        overflow-y: auto;
        display: none;
    }

    .filter-dropdown-popup.open {
        display: block;
        animation: dropdownPop 0.18s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes dropdownPop {
        from { opacity: 0; transform: translateY(-6px) scale(0.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .filter-dropdown-popup::-webkit-scrollbar {
        width: 6px;
    }
    .filter-dropdown-popup::-webkit-scrollbar-track {
        background: #F8FAFC;
        border-radius: 4px;
    }
    .filter-dropdown-popup::-webkit-scrollbar-thumb {
        background: #94A3B8;
        border-radius: 4px;
    }

    .filter-dropdown-item {
        display: block;
        padding: 9px 14px;
        border-radius: 9px;
        font-size: 13.5px;
        font-weight: 500;
        color: #334155;
        text-decoration: none;
        transition: all 0.15s ease;
        margin-bottom: 2px;
        line-height: 1.4;
    }

    .filter-dropdown-item:hover {
        background: #F1F5F9;
        color: #0F172A;
    }

    .filter-dropdown-item.active {
        background: #EEF4FF;
        color: #3B5998;
        font-weight: 700;
    }

    /* KATEGORI CEPAT CHIPS */
    .quick-category-title {
        font-family: 'Outfit', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #0F172A;
        margin: 22px 0 14px 0;
        letter-spacing: -0.3px;
    }

    .facility-section-heading {
        margin: 24px 0 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        min-width: 0;
    }

    .facility-section-heading h2 {
        min-width: 0;
        overflow-wrap: anywhere;
        font-family: 'Outfit', sans-serif;
        font-size: 20px;
        font-weight: 800;
        color: #0F172A;
    }

    .facility-section-count {
        flex-shrink: 0;
        font-size: 13px;
        color: #94A3B8;
        font-weight: 600;
    }

    .category-chip-scroll {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .category-chip-btn {
        padding: 8px 18px;
        border-radius: var(--radius-pill);
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        color: #334155;
        transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }

    .category-chip-btn:hover {
        border-color: #5B8DEF;
        color: #3B5998;
        transform: translateY(-1px);
    }

    .category-chip-btn.active {
        background: #3B5998 !important;
        border-color: #3B5998 !important;
        color: #FFFFFF !important;
        box-shadow: 0 4px 14px rgba(59, 89, 152, 0.28) !important;
        font-weight: 700;
    }

    /* GRID FASILITAS */
    .modern-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }

    .card-facility-vibe {
        background: #FFFFFF;
        border: none;
        border-radius: 22px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08);
        position: relative;
    }

    .card-facility-vibe:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 35px -8px rgba(59, 89, 152, 0.18), 0 8px 16px -4px rgba(15, 23, 42, 0.06);
    }

    .card-image-aspect {
        position: relative;
        width: 100%;
        height: 205px;
        background: linear-gradient(135deg, #F8FAFC, #EEF4FF);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: none;
        padding: 6px 10px;
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

    /* FLOATING STATUS PILL */
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

    .status-pill-floating.empty {
        background: rgba(255, 241, 242, 0.95);
        color: #BE123C;
        border: 1px solid #FECDD3;
    }

    .status-dot-pulse {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-pill-floating.available .status-dot-pulse {
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
        background: var(--brand-gradient);
        color: #FFFFFF;
        padding: 11px 16px;
        border-radius: var(--radius-md);
        font-size: 14px;
        font-weight: 800;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 4px 14px rgba(59, 89, 152, 0.25);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        border: none;
    }

    .btn-loan-request-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(59, 89, 152, 0.4);
    }

    .btn-loan-request-modern.disabled {
        background: #E2E8F0;
        color: #94A3B8;
        box-shadow: none;
        cursor: not-allowed;
        pointer-events: none;
    }

    @media (max-width: 1120px) {
        .modern-cards-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 780px) {
        .modern-cards-grid { grid-template-columns: repeat(2, 1fr); }
        .hero-vibe-box { padding: 26px 24px; border-radius: 20px; }
        .hero-title-vibe { font-size: 26px; }
    }

    @media (max-width: 500px) {
        .modern-cards-grid { grid-template-columns: 1fr; }
        .search-row-flex { flex-direction: column; align-items: stretch; }
        .search-input-box { width: 100%; min-width: 0; }
        .search-input-clean { width: 100%; min-width: 0; }
        .filter-dropdown-container { width: 100%; }
        .btn-filter-trigger { width: 100%; justify-content: center; }
        .filter-dropdown-popup { width: min(250px, calc(100vw - 28px)); right: 0; }
        .hero-badge-pill { max-width: 100%; white-space: normal; }
        .facility-section-heading { align-items: flex-start; }
        .facility-section-heading h2 { font-size: 18px; }
    }

    /* MODERN SINFAS PAGINATION */
    .user-pagination-wrapper {
        margin-top: 36px;
        padding-top: 24px;
        border-top: 1px solid var(--border-subtle);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }
    .user-pagination-info {
        font-size: 13.5px;
        color: var(--text-muted);
        font-weight: 500;
    }
    .user-pagination-info strong {
        color: var(--text-main);
        font-weight: 700;
    }
    .user-pagination-pills {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #FFFFFF;
        padding: 5px 8px;
        border-radius: var(--radius-pill);
        border: 1.5px solid #E2E8F0;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }
    .user-page-btn {
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border-radius: var(--radius-pill);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        text-decoration: none;
        transition: all 0.18s ease;
        gap: 4px;
        border: 1px solid transparent;
        font-family: inherit;
    }
    .user-page-btn:hover:not(.disabled):not(.active) {
        background: #F1F5F9;
        color: #1E293B;
        border-color: #CBD5E1;
        transform: translateY(-1px);
    }
    .user-page-btn.active {
        background: linear-gradient(135deg, #3B5998 0%, #2C4A7C 100%);
        color: #FFFFFF !important;
        box-shadow: 0 3px 10px rgba(44, 74, 124, 0.28);
    }
    .user-page-btn.disabled {
        opacity: 0.35;
        cursor: not-allowed;
        color: #94A3B8;
    }
    .user-page-ellipsis {
        padding: 0 4px;
        color: #94A3B8;
        font-size: 13px;
    }
    /* ===== STORY HIGHLIGHTS BUBBLE ala Gen Z ===== */
    .story-highlights-bar {
        display: flex;
        align-items: flex-start;
        gap: 18px;
        padding: 8px 4px 14px;
        margin-bottom: 22px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .story-highlights-bar::-webkit-scrollbar { display: none; }

    .story-bubble-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        flex-shrink: 0;
        background: none;
        border: none;
        padding: 0;
        font-family: inherit;
        outline: none;
        -webkit-tap-highlight-color: transparent;
        transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .story-bubble-btn:hover { transform: scale(1.08); }
    .story-bubble-btn:active { transform: scale(0.95); }

    .story-ring {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        padding: 3px;
    }
    .story-ring::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        z-index: 0;
    }
    /* Gradient variants */
    .story-ring.ring-emerald::before { background: conic-gradient(#10B981, #34D399, #6EE7B7, #10B981); }
    .story-ring.ring-fire::before { background: conic-gradient(#F97316, #EF4444, #F59E0B, #F97316); }
    .story-ring.ring-electric::before { background: conic-gradient(#3B82F6, #06B6D4, #8B5CF6, #3B82F6); }
    .story-ring.ring-neon::before { background: conic-gradient(#A855F7, #EC4899, #6366F1, #A855F7); }
    .story-ring.ring-gold::before { background: conic-gradient(#F59E0B, #EAB308, #D97706, #F59E0B); }
    .story-ring.ring-overdue::before { background: conic-gradient(#EF4444, #F87171, #DC2626, #EF4444); }

    .story-ring-inner {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        z-index: 1;
        position: relative;
        box-shadow: inset 0 0 0 2.5px #fff;
    }

    /* Active badge dot */
    .story-badge-dot {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #10B981;
        border: 2.5px solid #FFFFFF;
        z-index: 3;
        animation: badgePulse 2s ease-in-out infinite;
    }
    .story-badge-dot.overdue { background: #EF4444; }
    .story-badge-dot.pending { background: #F59E0B; }

    @keyframes badgePulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
        50% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
    }

    .story-badge-count {
        position: absolute;
        top: -2px;
        right: -4px;
        min-width: 20px;
        height: 20px;
        padding: 0 5px;
        border-radius: 10px;
        background: linear-gradient(135deg, #EF4444, #DC2626);
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 3;
        border: 2px solid #FFFFFF;
        line-height: 1;
    }

    .story-bubble-label {
        font-size: 11px;
        font-weight: 700;
        color: #475569;
        max-width: 76px;
        text-align: center;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ===== STORY VIEWER MODAL (Glassmorphism) ===== */
    .story-modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(0, 0, 0, 0.65);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        animation: storyFadeIn 0.3s ease forwards;
    }
    .story-modal-overlay.active { display: flex; }

    @keyframes storyFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .story-modal-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 28px;
        width: 100%;
        max-width: 420px;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: 0 32px 64px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(255, 255, 255, 0.1);
        animation: storySlideUp 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        position: relative;
    }

    @keyframes storySlideUp {
        from { opacity: 0; transform: translateY(40px) scale(0.96); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .story-modal-header {
        padding: 24px 24px 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .story-modal-title {
        font-size: 20px;
        font-weight: 900;
        color: #0F172A;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .story-modal-close {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #F1F5F9;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748B;
        transition: all 0.15s ease;
        font-family: inherit;
    }
    .story-modal-close:hover { background: #E2E8F0; color: #0F172A; transform: rotate(90deg); }

    .story-modal-body {
        padding: 20px 24px 28px;
    }

    /* Progress bar for story modal top */
    .story-progress-bar {
        display: flex;
        gap: 4px;
        padding: 16px 24px 0;
    }
    .story-progress-segment {
        flex: 1;
        height: 3px;
        border-radius: 2px;
        background: #E2E8F0;
    }
    .story-progress-segment.active {
        background: linear-gradient(90deg, #3B82F6, #8B5CF6);
    }

    /* Story card items inside modal */
    .story-loan-item {
        background: linear-gradient(135deg, #F8FAFC 0%, #EEF4FF 100%);
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all 0.2s ease;
    }
    .story-loan-item:hover { transform: translateX(4px); border-color: #CBD5E1; }

    .story-loan-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .story-loan-icon.green { background: #ECFDF5; }
    .story-loan-icon.amber { background: #FFFBEB; }
    .story-loan-icon.red { background: #FFF1F2; }
    .story-loan-icon.blue { background: #EEF4FF; }

    .story-loan-info { flex: 1; min-width: 0; }
    .story-loan-name {
        font-size: 14px;
        font-weight: 700;
        color: #0F172A;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .story-loan-meta {
        font-size: 12px;
        color: #64748B;
        margin-top: 2px;
        font-weight: 500;
    }

    .story-loan-countdown {
        font-size: 12px;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 8px;
        flex-shrink: 0;
        white-space: nowrap;
    }
    .story-loan-countdown.safe { background: #ECFDF5; color: #047857; }
    .story-loan-countdown.warn { background: #FFFBEB; color: #B45309; }
    .story-loan-countdown.danger { background: #FFF1F2; color: #BE123C; }

    .story-empty-state {
        text-align: center;
        padding: 30px 10px;
    }
    .story-empty-emoji { font-size: 48px; margin-bottom: 12px; }
    .story-empty-text { font-size: 15px; font-weight: 700; color: #0F172A; margin-bottom: 4px; }
    .story-empty-sub { font-size: 13px; color: #64748B; }

    /* Info card inside story modal */
    .story-info-card {
        background: linear-gradient(135deg, #F8FAFC, #EEF4FF);
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 18px;
        margin-bottom: 12px;
    }
    .story-info-card .info-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 0;
    }
    .story-info-card .info-row:not(:last-child) {
        border-bottom: 1px solid #E2E8F0;
    }
    .story-info-card .info-icon {
        font-size: 20px;
        width: 36px;
        text-align: center;
        flex-shrink: 0;
    }
    .story-info-card .info-text {
        font-size: 13.5px;
        font-weight: 600;
        color: #334155;
    }
    .story-info-card .info-text strong {
        color: #0F172A;
        font-weight: 800;
    }

    /* Step guide cards */
    .story-step-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .story-step-card {
        background: linear-gradient(135deg, #F8FAFC, #EEF4FF);
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 16px 14px;
        text-align: center;
        transition: all 0.2s ease;
    }
    .story-step-card:hover { transform: translateY(-2px); border-color: #CBD5E1; }
    .story-step-num {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3B5998, #5B8DEF);
        color: #fff;
        font-size: 13px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
    }
    .story-step-text {
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        line-height: 1.4;
    }

    /* Stats card inside rekor story */
    .story-stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .story-stat-card {
        background: linear-gradient(135deg, #F8FAFC, #EEF4FF);
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 18px 14px;
        text-align: center;
    }
    .story-stat-number {
        font-size: 28px;
        font-weight: 900;
        color: #0F172A;
        line-height: 1;
        margin-bottom: 4px;
    }
    .story-stat-label {
        font-size: 11.5px;
        font-weight: 600;
        color: #64748B;
    }
    .story-stat-card.highlight {
        background: linear-gradient(135deg, #3B5998 0%, #5B8DEF 100%);
        border-color: transparent;
    }
    .story-stat-card.highlight .story-stat-number { color: #fff; }
    .story-stat-card.highlight .story-stat-label { color: rgba(255,255,255,0.8); }

    /* Responsive adjustments for story bubbles */
    @media (max-width: 500px) {
        .story-highlights-bar { gap: 14px; }
        .story-ring { width: 62px; height: 62px; }
        .story-ring-inner { font-size: 24px; }
        .story-bubble-label { font-size: 10px; max-width: 64px; }
        .story-modal-card { max-width: 100%; border-radius: 22px; }
        .story-step-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

    <!-- VIBRANT HERO BANNER -->
    <div class="hero-vibe-box">
        <div class="hero-badge-pill">
            <span>👋 Selamat datang, {{ Auth::user()->nama ?? 'User' }}</span>
        </div>
        <h1 class="hero-title-vibe">Mau pinjam apa hari ini? ✨</h1>
        <p class="hero-sub-vibe">
            Pinjam proyektor, mic, kamera, atau inventaris sekolah tanpa ribet manual. Cepat, instan, & tercatat otomatis!
        </p>
    </div>

    <!-- ===== STORY HIGHLIGHTS BUBBLE BAR (Gen Z ala IG/TikTok) ===== -->
    @php
        $hasOverdue = $userActiveLoans->contains(function($loan) {
            return \Carbon\Carbon::parse($loan->tanggal_kembali)->isPast();
        });
        $activeCount = $userActiveLoans->count();
    @endphp

    <div class="story-highlights-bar" id="storyHighlightsBar">
        {{-- Bubble 1: Pinjaman Aktifmu --}}
        <button class="story-bubble-btn" onclick="openStoryModal('pinjaman')" id="story-btn-pinjaman" aria-label="Lihat pinjaman aktif">
            <div class="story-ring {{ $hasOverdue ? 'ring-overdue' : 'ring-emerald' }}">
                <div class="story-ring-inner">📦</div>
                @if($activeCount > 0)
                    <span class="story-badge-dot {{ $hasOverdue ? 'overdue' : '' }}"></span>
                @endif
                @if($activeCount > 0)
                    <span class="story-badge-count">{{ $activeCount }}</span>
                @endif
            </div>
            <span class="story-bubble-label">Pinjamanmu</span>
        </button>

        {{-- Bubble 2: Sering Dipinjam --}}
        <button class="story-bubble-btn" onclick="openStoryModal('popular')" id="story-btn-popular" aria-label="Lihat barang paling populer">
            <div class="story-ring ring-fire">
                <div class="story-ring-inner">🔥</div>
            </div>
            <span class="story-bubble-label">Paling Hits</span>
        </button>

        {{-- Bubble 3: Jam Sarana --}}
        <button class="story-bubble-btn" onclick="openStoryModal('jadwal')" id="story-btn-jadwal" aria-label="Lihat jadwal operasional">
            <div class="story-ring ring-electric">
                <div class="story-ring-inner">🕒</div>
            </div>
            <span class="story-bubble-label">Jam Sarana</span>
        </button>

        {{-- Bubble 4: Lifehack Pinjam --}}
        <button class="story-bubble-btn" onclick="openStoryModal('panduan')" id="story-btn-panduan" aria-label="Panduan meminjam">
            <div class="story-ring ring-neon">
                <div class="story-ring-inner">💡</div>
            </div>
            <span class="story-bubble-label">Cara Pinjam</span>
        </button>

        {{-- Bubble 5: Rekor Kamu --}}
        <button class="story-bubble-btn" onclick="openStoryModal('rekor')" id="story-btn-rekor" aria-label="Lihat statistik aktivitas">
            <div class="story-ring ring-gold">
                <div class="story-ring-inner">⭐</div>
                @if($userPendingLoans > 0)
                    <span class="story-badge-dot pending"></span>
                @endif
            </div>
            <span class="story-bubble-label">Rekor Kamu</span>
        </button>
    </div>

    <!-- ===== STORY MODAL: Pinjaman Aktif ===== -->
    <div class="story-modal-overlay" id="storyModal-pinjaman" onclick="closeStoryModal(event, 'pinjaman')">
        <div class="story-modal-card" onclick="event.stopPropagation()">
            <div class="story-progress-bar">
                <div class="story-progress-segment active"></div>
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment"></div>
            </div>
            <div class="story-modal-header">
                <div class="story-modal-title">📦 Pinjaman Aktifmu</div>
                <button class="story-modal-close" onclick="closeStoryModal(null, 'pinjaman')" aria-label="Tutup">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="story-modal-body">
                @if($userActiveLoans->count() > 0)
                    @foreach($userActiveLoans as $loan)
                        @php
                            $kembali = \Carbon\Carbon::parse($loan->tanggal_kembali);
                            $now = \Carbon\Carbon::now();
                            $diffDays = $now->diffInDays($kembali, false);
                            $isOverdue = $diffDays < 0;
                            $isWarn = !$isOverdue && $diffDays <= 2;
                            $countdownClass = $isOverdue ? 'danger' : ($isWarn ? 'warn' : 'safe');
                            $iconClass = $isOverdue ? 'red' : ($isWarn ? 'amber' : 'green');
                            $countdownText = $isOverdue ? 'Terlambat ' . abs($diffDays) . ' hari!' : ($diffDays == 0 ? 'Hari ini!' : $diffDays . ' hari lagi');
                        @endphp
                        <div class="story-loan-item">
                            <div class="story-loan-icon {{ $iconClass }}">
                                {{ $isOverdue ? '⚠️' : '📋' }}
                            </div>
                            <div class="story-loan-info">
                                <div class="story-loan-name">{{ $loan->barang->nama_barang ?? 'Barang' }}</div>
                                <div class="story-loan-meta">Kembali: {{ $kembali->format('d M Y') }}</div>
                            </div>
                            <span class="story-loan-countdown {{ $countdownClass }}">{{ $countdownText }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="story-empty-state">
                        <div class="story-empty-emoji">✨</div>
                        <div class="story-empty-text">Bebas Tanggungan!</div>
                        <div class="story-empty-sub">Kamu tidak punya pinjaman aktif. Yuk pinjam sesuatu!</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- ===== STORY MODAL: Paling Hits ===== -->
    <div class="story-modal-overlay" id="storyModal-popular" onclick="closeStoryModal(event, 'popular')">
        <div class="story-modal-card" onclick="event.stopPropagation()">
            <div class="story-progress-bar">
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment active"></div>
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment"></div>
            </div>
            <div class="story-modal-header">
                <div class="story-modal-title">🔥 Paling Hits</div>
                <button class="story-modal-close" onclick="closeStoryModal(null, 'popular')" aria-label="Tutup">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="story-modal-body">
                <div class="story-info-card">
                    <div class="info-row">
                        <span class="info-icon">🏆</span>
                        <span class="info-text">Lihat barang yang <strong>paling sering dipinjam</strong> sama teman-teman kamu!</span>
                    </div>
                </div>
                <a href="{{ route('user.dashboard', ['kategori' => 'sering_dipinjam']) }}" class="btn-loan-request-modern" style="margin-top:12px; text-decoration:none;" onclick="closeStoryModal(null, 'popular')">
                    <span>🔥 Lihat Barang Hits</span>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- ===== STORY MODAL: Jam Sarana ===== -->
    <div class="story-modal-overlay" id="storyModal-jadwal" onclick="closeStoryModal(event, 'jadwal')">
        <div class="story-modal-card" onclick="event.stopPropagation()">
            <div class="story-progress-bar">
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment active"></div>
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment"></div>
            </div>
            <div class="story-modal-header">
                <div class="story-modal-title">🕒 Jam Sarana</div>
                <button class="story-modal-close" onclick="closeStoryModal(null, 'jadwal')" aria-label="Tutup">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="story-modal-body">
                <div class="story-info-card">
                    <div class="info-row">
                        <span class="info-icon">🏫</span>
                        <span class="info-text"><strong>Lokasi:</strong> Ruang Sarana & Prasarana</span>
                    </div>
                    <div class="info-row">
                        <span class="info-icon">🕐</span>
                        <span class="info-text"><strong>Senin - Jumat:</strong> 07.00 - 16.00 WIB</span>
                    </div>
                    <div class="info-row">
                        <span class="info-icon">🚫</span>
                        <span class="info-text"><strong>Sabtu & Minggu:</strong> Tutup</span>
                    </div>
                    <div class="info-row">
                        <span class="info-icon">📱</span>
                        <span class="info-text">Ajukan online kapan saja, diproses saat <strong>jam kerja</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== STORY MODAL: Panduan Pinjam ===== -->
    <div class="story-modal-overlay" id="storyModal-panduan" onclick="closeStoryModal(event, 'panduan')">
        <div class="story-modal-card" onclick="event.stopPropagation()">
            <div class="story-progress-bar">
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment active"></div>
                <div class="story-progress-segment"></div>
            </div>
            <div class="story-modal-header">
                <div class="story-modal-title">💡 Cara Pinjam</div>
                <button class="story-modal-close" onclick="closeStoryModal(null, 'panduan')" aria-label="Tutup">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="story-modal-body">
                <div class="story-step-grid">
                    <div class="story-step-card">
                        <div class="story-step-num">1</div>
                        <div class="story-step-text">Pilih barang yang mau dipinjam</div>
                    </div>
                    <div class="story-step-card">
                        <div class="story-step-num">2</div>
                        <div class="story-step-text">Klik "Pinjam Fasilitas" & isi form</div>
                    </div>
                    <div class="story-step-card">
                        <div class="story-step-num">3</div>
                        <div class="story-step-text">Tunggu verifikasi dari Admin Sarpras</div>
                    </div>
                    <div class="story-step-card">
                        <div class="story-step-num">4</div>
                        <div class="story-step-text">Ambil barang & kembalikan tepat waktu!</div>
                    </div>
                </div>
                <div class="story-info-card" style="margin-top: 14px;">
                    <div class="info-row">
                        <span class="info-icon">💡</span>
                        <span class="info-text"><strong>Tips:</strong> Ajukan pinjaman minimal <strong>1 hari sebelum</strong> agar tidak antre ya!</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== STORY MODAL: Rekor Kamu ===== -->
    <div class="story-modal-overlay" id="storyModal-rekor" onclick="closeStoryModal(event, 'rekor')">
        <div class="story-modal-card" onclick="event.stopPropagation()">
            <div class="story-progress-bar">
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment"></div>
                <div class="story-progress-segment active"></div>
            </div>
            <div class="story-modal-header">
                <div class="story-modal-title">⭐ Rekor Kamu</div>
                <button class="story-modal-close" onclick="closeStoryModal(null, 'rekor')" aria-label="Tutup">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                </button>
            </div>
            <div class="story-modal-body">
                <div class="story-stats-grid">
                    <div class="story-stat-card highlight">
                        <div class="story-stat-number">{{ $userTotalLoans }}</div>
                        <div class="story-stat-label">Total Pinjaman</div>
                    </div>
                    <div class="story-stat-card">
                        <div class="story-stat-number">{{ $userActiveLoans->count() }}</div>
                        <div class="story-stat-label">Sedang Dipinjam</div>
                    </div>
                    <div class="story-stat-card">
                        <div class="story-stat-number">{{ $userPendingLoans }}</div>
                        <div class="story-stat-label">Menunggu Verifikasi</div>
                    </div>
                    <div class="story-stat-card">
                        <div class="story-stat-number">{{ max(0, $userTotalLoans - $userActiveLoans->count() - $userPendingLoans) }}</div>
                        <div class="story-stat-label">Sudah Selesai</div>
                    </div>
                </div>
                @if($userTotalLoans >= 10)
                    <div class="story-info-card" style="margin-top: 14px;">
                        <div class="info-row">
                            <span class="info-icon">🏅</span>
                            <span class="info-text">Wah, kamu <strong>pengguna aktif</strong> SINFAS! Terus gunakan fasilitas sekolah ya! 🎉</span>
                        </div>
                    </div>
                @elseif($userTotalLoans == 0)
                    <div class="story-info-card" style="margin-top: 14px;">
                        <div class="info-row">
                            <span class="info-icon">👋</span>
                            <span class="info-text">Belum pernah pinjam? <strong>Coba sekarang!</strong> Pilih barang di katalog bawah 👇</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>


    @php
        if (!function_exists('getKatIcon')) {
            function getKatIcon($name) {
                $l = strtolower($name);
                if (str_contains($l, 'audio') || str_contains($l, 'sound') || str_contains($l, 'suara') || str_contains($l, 'speaker')) return '🎤';
                if (str_contains($l, 'kabel') || str_contains($l, 'adapter') || str_contains($l, 'colokan')) return '🔌';
                if (str_contains($l, 'kamera') || str_contains($l, 'foto') || str_contains($l, 'video') || str_contains($l, 'dokumentasi')) return '📷';
                if (str_contains($l, 'lab') || str_contains($l, 'multimedia') || str_contains($l, 'elektronik') || str_contains($l, 'komputer') || str_contains($l, 'laptop')) return '💻';
                if (str_contains($l, 'proyektor') || str_contains($l, 'presentasi') || str_contains($l, 'visual')) return '💡';
                if (str_contains($l, 'furnitur') || str_contains($l, 'furniture') || str_contains($l, 'meja') || str_contains($l, 'kursi')) return '🪑';
                if (str_contains($l, 'olahraga') || str_contains($l, 'sport') || str_contains($l, 'bola')) return '⚽';
                if (str_contains($l, 'listrik') || str_contains($l, 'kelistrikan')) return '⚡';
                return '📦';
            }
        }

        $activeKat = request('kategori');
        $isAll = empty($activeKat);
        $isPopular = ($activeKat === 'sering_dipinjam');
    @endphp

    <!-- SEARCH & FILTER ROW -->
    <div class="search-filter-shell">
        <form method="GET" action="{{ route('user.dashboard') }}" id="search-form" class="search-row-flex">
            <input type="hidden" name="kategori" value="{{ $activeKat }}">
            
            <div class="search-input-box">
                <svg class="search-icon-svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="q" value="{{ request('q') }}" class="search-input-clean"
                       placeholder="Cari alat, kategori, atau status..." id="input-search">
            </div>

            <!-- FILTER BUTTON & DROPDOWN -->
            <div class="filter-dropdown-container">
                <button type="button" class="btn-filter-trigger {{ $activeKat ? 'open' : '' }}" id="btnFilterTrigger" onclick="toggleFilterDropdown(event)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="6" y1="12" x2="18" y2="12"></line>
                        <line x1="10" y1="18" x2="14" y2="18"></line>
                    </svg>
                    <span>Filter</span>
                </button>

                <!-- Dropdown Menu -->
                <div class="filter-dropdown-popup" id="filterDropdownMenu">
                    <a href="{{ route('user.dashboard', ['q' => request('q')]) }}"
                       class="filter-dropdown-item {{ $isAll ? 'active' : '' }}">
                        Semua Kategori (Beranda)
                    </a>
                    <a href="{{ route('user.dashboard', ['kategori' => 'sering_dipinjam', 'q' => request('q')]) }}"
                       class="filter-dropdown-item {{ $isPopular ? 'active' : '' }}">
                        🔥 Sering Dipinjam
                    </a>
                    @foreach($kategoris as $kat)
                        <a href="{{ route('user.dashboard', ['kategori' => $kat->id_kategori, 'q' => request('q')]) }}"
                           class="filter-dropdown-item {{ $activeKat == $kat->id_kategori ? 'active' : '' }}">
                            {{ $kat->nama_kategori }}
                        </a>
                    @endforeach
                </div>
            </div>
        </form>

        <!-- KATEGORI CEPAT -->
        <div class="quick-category-section">
            <h3 class="quick-category-title">Kategori Cepat</h3>
            <div class="category-chip-scroll">
                <a href="{{ route('user.dashboard', ['q' => request('q')]) }}"
                   class="category-chip-btn {{ $isAll ? 'active' : '' }}">
                    <span>✨ Semua</span>
                </a>
                <a href="{{ route('user.dashboard', ['kategori' => 'sering_dipinjam', 'q' => request('q')]) }}"
                   class="category-chip-btn {{ $isPopular ? 'active' : '' }}">
                    <span>🔥 Sering Dipinjam</span>
                </a>
                @foreach($kategoris as $kat)
                    <a href="{{ route('user.dashboard', ['kategori' => $kat->id_kategori, 'q' => request('q')]) }}"
                       class="category-chip-btn {{ $activeKat == $kat->id_kategori ? 'active' : '' }}">
                        <span>{{ getKatIcon($kat->nama_kategori) }} {{ $kat->nama_kategori }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- SECTION TITLE -->
    <div class="facility-section-heading">
        <h2 style="margin: 0; display: flex; align-items: center; gap: 8px;">
            @if($isPopular)
                🔥 Sering Dipinjam
            @elseif(!empty($activeKat))
                @php
                    $currentKat = $kategoris->firstWhere('id_kategori', $activeKat);
                @endphp
                {{ $currentKat ? (getKatIcon($currentKat->nama_kategori) . ' ' . $currentKat->nama_kategori) : 'Fasilitas' }}
            @elseif(request()->filled('q'))
                🔍 Hasil Pencarian: "{{ request('q') }}"
            @else
                ✨ Semua Fasilitas
            @endif
        </h2>
        <span class="facility-section-count">
            {{ $barangs->total() }} fasilitas
        </span>
    </div>

    <!-- CARDS GRID -->
    <div class="modern-cards-grid">
        @forelse($barangs as $b)
            @php
                $isAvailable = $b->jumlah_baik > 0;
            @endphp
            <div class="card-facility-vibe" id="card-item-{{ $b->kode_barang }}">
                <div class="card-image-aspect">
                    <span class="status-pill-floating {{ $isAvailable ? 'available' : 'empty' }}">
                        <span class="status-dot-pulse"></span>
                        <span>{{ $isAvailable ? 'Tersedia' : 'Habis' }}</span>
                    </span>

                    @if($b->foto)
                        <img src="{{ asset('storage/' . $b->foto) }}" alt="{{ $b->nama_barang }}" loading="lazy" onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='block';">
                        <svg style="display:none;" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#5B8DEF" stroke-width="1.6">
                            <rect x="2" y="7" width="20" height="14" rx="2"/><circle cx="12" cy="14" r="3"/><path d="M12 3v4"/><path d="M8 3h8"/>
                        </svg>
                    @else
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#5B8DEF" stroke-width="1.6">
                            <rect x="2" y="7" width="20" height="14" rx="2"/><circle cx="12" cy="14" r="3"/><path d="M12 3v4"/><path d="M8 3h8"/>
                        </svg>
                    @endif
                </div>

                <div class="card-detail-body">
                    <h3 class="card-item-title">{{ $b->nama_barang }}</h3>
                    <div class="card-item-tag">
                        <span>#</span>
                        <span>{{ $b->kategori->nama_kategori ?? 'Umum' }}</span>
                        <span>&bull;</span>
                        <span>{{ $b->jumlah_baik }} unit baik</span>
                    </div>

                    @if($isAvailable)
                        <a href="{{ route('user.barang.show', $b->kode_barang) }}" class="btn-loan-request-modern" id="btn-request-{{ $b->kode_barang }}">
                            <span>Pinjam Fasilitas</span>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </a>
                    @else
                        <button type="button" class="btn-loan-request-modern disabled">
                            <span>Stok Habis</span>
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; background:#FFFFFF; border: 2px dashed #CBD5E1; border-radius: 24px; padding: 60px 20px; text-align: center; color: var(--text-muted);">
                <div style="font-size: 44px; margin-bottom: 12px;">🔍</div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--text-main); margin-bottom: 6px;">Fasilitas Tidak Ditemukan</h3>
                <p style="font-size: 14px; margin-bottom: 18px;">Coba gunakan kata kunci lain atau pilih chip kategori di atas.</p>
                <a href="{{ route('user.dashboard') }}" class="btn-genz-primary">
                    Reset Pencarian
                </a>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION SINFAS MODERN -->
    @if($barangs->hasPages())
        <div class="user-pagination-wrapper">
            <div class="user-pagination-info">
                Menampilkan <strong>{{ $barangs->firstItem() ?? 0 }}</strong> &ndash; <strong>{{ $barangs->lastItem() ?? 0 }}</strong> dari <strong>{{ $barangs->total() }}</strong> fasilitas
            </div>
            <div class="user-pagination-pills">
                {{-- Tombol Sebelumnya --}}
                @if($barangs->onFirstPage())
                    <span class="user-page-btn disabled" aria-disabled="true">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Prev</span>
                    </span>
                @else
                    <a href="{{ $barangs->previousPageUrl() }}" class="user-page-btn" rel="prev">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Prev</span>
                    </a>
                @endif

                {{-- Nomor Halaman --}}
                @for($p = 1; $p <= $barangs->lastPage(); $p++)
                    @if($p == 1 || $p == $barangs->lastPage() || ($p >= $barangs->currentPage() - 1 && $p <= $barangs->currentPage() + 1))
                        @if($p == $barangs->currentPage())
                            <span class="user-page-btn active" aria-current="page">{{ $p }}</span>
                        @else
                            <a href="{{ $barangs->url($p) }}" class="user-page-btn">{{ $p }}</a>
                        @endif
                    @elseif($p == 2 || $p == $barangs->lastPage() - 1)
                        <span class="user-page-ellipsis">&hellip;</span>
                    @endif
                @endfor

                {{-- Tombol Selanjutnya --}}
                @if($barangs->hasMorePages())
                    <a href="{{ $barangs->nextPageUrl() }}" class="user-page-btn" rel="next">
                        <span>Next</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </a>
                @else
                    <span class="user-page-btn disabled" aria-disabled="true">
                        <span>Next</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </span>
                @endif
            </div>
        </div>
    @endif

    <script>
        function toggleFilterDropdown(event) {
            event.stopPropagation();
            const menu = document.getElementById('filterDropdownMenu');
            const btn = document.getElementById('btnFilterTrigger');
            if (menu) {
                menu.classList.toggle('open');
                if (btn) btn.classList.toggle('open');
            }
        }

        document.addEventListener('click', function(e) {
            const menu = document.getElementById('filterDropdownMenu');
            const btn = document.getElementById('btnFilterTrigger');
            if (menu && menu.classList.contains('open')) {
                if (!menu.contains(e.target) && !btn.contains(e.target)) {
                    menu.classList.remove('open');
                    if (btn) btn.classList.remove('open');
                }
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const menu = document.getElementById('filterDropdownMenu');
                const btn = document.getElementById('btnFilterTrigger');
                if (menu) menu.classList.remove('open');
                if (btn) btn.classList.remove('open');
                // Also close any open story modal
                closeAllStoryModals();
            }
        });

        /* ===== STORY MODAL CONTROLLERS ===== */
        const storyTypes = ['pinjaman', 'popular', 'jadwal', 'panduan', 'rekor'];

        function openStoryModal(type) {
            closeAllStoryModals();
            const modal = document.getElementById('storyModal-' + type);
            if (modal) {
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeStoryModal(event, type) {
            if (event && event.target !== event.currentTarget) return;
            const modal = document.getElementById('storyModal-' + type);
            if (modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        }

        function closeAllStoryModals() {
            storyTypes.forEach(function(type) {
                const modal = document.getElementById('storyModal-' + type);
                if (modal) modal.classList.remove('active');
            });
            document.body.style.overflow = '';
        }

        function navigateStory(direction) {
            let currentIndex = -1;
            storyTypes.forEach(function(type, i) {
                const modal = document.getElementById('storyModal-' + type);
                if (modal && modal.classList.contains('active')) {
                    currentIndex = i;
                }
            });

            if (currentIndex === -1) return;

            let nextIndex = currentIndex + direction;
            if (nextIndex < 0) nextIndex = storyTypes.length - 1;
            if (nextIndex >= storyTypes.length) nextIndex = 0;

            openStoryModal(storyTypes[nextIndex]);
        }

        // Swipe support for mobile story navigation
        (function() {
            let touchStartX = 0;
            let touchEndX = 0;

            document.addEventListener('touchstart', function(e) {
                const activeModal = document.querySelector('.story-modal-overlay.active');
                if (activeModal) touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });

            document.addEventListener('touchend', function(e) {
                const activeModal = document.querySelector('.story-modal-overlay.active');
                if (!activeModal) return;
                touchEndX = e.changedTouches[0].screenX;
                const diff = touchStartX - touchEndX;
                if (Math.abs(diff) > 60) {
                    navigateStory(diff > 0 ? 1 : -1);
                }
            }, { passive: true });
        })();
    </script>
@endsection
