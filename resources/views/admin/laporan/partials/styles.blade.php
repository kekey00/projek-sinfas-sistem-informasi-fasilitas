<style>
    .report-header { display:flex; justify-content:space-between; align-items:flex-end; gap:20px; margin-bottom:24px; padding:26px 28px; border-radius:22px; color:#fff; background:linear-gradient(120deg,#102A43,#1F4E5F 58%,#287271); box-shadow:0 16px 32px rgba(16,42,67,.16); }
    .report-kicker { color:#A7F3D0; font-size:11px; font-weight:800; letter-spacing:1.4px; text-transform:uppercase; margin-bottom:8px; }
    .report-title { font-family:'Outfit',sans-serif; font-size:28px; font-weight:700; letter-spacing:-.4px; margin-bottom:5px; }
    .report-subtitle { color:rgba(255,255,255,.72); font-size:13.5px; }
    .report-mark { width:52px; height:52px; border:1px solid rgba(255,255,255,.22); border-radius:16px; display:grid; place-items:center; color:#D1FAE5; background:rgba(255,255,255,.1); }
    .report-actions { display:flex; gap:8px; margin-top:16px; position:relative; z-index:1; }
    .report-action { display:inline-flex; align-items:center; gap:7px; height:36px; border-radius:9px; padding:0 13px; font:inherit; font-size:12px; font-weight:700; text-decoration:none; cursor:pointer; }
    .report-action.back { color:#E0F2FE; border:1px solid rgba(255,255,255,.25); background:rgba(255,255,255,.09); }
    .report-action.print { color:#D1FAE5; border:1px solid rgba(255,255,255,.25); background:rgba(255,255,255,.09); }
    .report-action.pdf { color:#102A43; border:1px solid #A7F3D0; background:#D1FAE5; }
    .report-card { background:#fff; border:1px solid #E5E7EB; border-radius:20px; box-shadow:0 8px 22px rgba(15,23,42,.055); overflow:hidden; margin-bottom:20px; position:relative; }
    .report-card::before { content:''; position:absolute; left:0; top:0; bottom:0; width:4px; background:#287271; }
    .report-card.orange::before { background:#D97706; } .report-card.red::before { background:#E11D48; } .report-card.blue::before { background:#2563EB; }
    .report-card-header { padding:22px 26px 19px; border-bottom:1px solid #EEF2F4; display:flex; align-items:flex-start; gap:13px; }
    .report-index { flex:0 0 auto; width:30px; height:30px; border-radius:10px; display:grid; place-items:center; color:#fff; background:#287271; font-size:12px; font-weight:800; }
    .orange .report-index { background:#D97706; } .red .report-index { background:#E11D48; } .blue .report-index { background:#2563EB; }
    .report-card-title { font-family:'Outfit',sans-serif; color:#102A43; font-size:18px; font-weight:700; }
    .report-card-description { color:#64748B; font-size:13px; line-height:1.55; margin-top:5px; }
    .report-filter { display:grid; grid-template-columns:repeat(3,1fr) auto; gap:12px; padding:18px 26px; background:#F7FAFA; border-bottom:1px solid #E5EFEE; align-items:end; }
    .report-field { display:flex; flex-direction:column; gap:6px; } .report-field label { color:#334155; font-size:12px; font-weight:700; }
    .report-field input,.report-field select { width:100%; height:38px; border:1px solid #CBD5E1; border-radius:8px; padding:0 10px; color:#334155; background:#fff; font:inherit; font-size:13px; }
    .report-button { height:38px; border:0; border-radius:9px; padding:0 18px; color:#fff; background:#287271; font:inherit; font-size:13px; font-weight:700; cursor:pointer; box-shadow:0 5px 12px rgba(40,114,113,.2); }
    .report-summary { display:grid; grid-template-columns:repeat(3,minmax(0,180px)); gap:12px; padding:20px 26px 0; }
    .summary-box { padding:14px 16px; border-radius:12px; background:#F0FDFA; border:1px solid #CCFBF1; } .summary-label { color:#64748B; font-size:12px; } .summary-value { color:#115E59; font-family:'Outfit',sans-serif; font-size:25px; font-weight:700; margin-top:3px; }
    .report-table-wrap { overflow-x:auto; padding:20px 26px 24px; } .report-table { width:100%; border-collapse:collapse; min-width:600px; }
    .report-table th { background:#F8FAFC; color:#64748B; font-size:10.5px; letter-spacing:.7px; text-align:left; text-transform:uppercase; padding:12px 14px; } .report-table td { border-bottom:1px solid #F1F5F9; color:#334155; font-size:13px; padding:13px 14px; } .report-table tbody tr:hover { background:#F8FCFC; } .report-table tr:last-child td { border-bottom:0; }
    .count-pill { display:inline-flex; min-width:30px; justify-content:center; padding:4px 9px; border-radius:999px; color:#1D4ED8; background:#DBEAFE; font-weight:700; } .empty-report { color:#64748B; font-size:13px; padding:28px 14px; text-align:center; }
    .trend-chart { height:230px; position:relative; margin:0 26px 24px; } .trend-title { color:#334155; font-size:14px; font-weight:700; margin:0 26px 10px; }
    .catalog-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:18px; } .catalog-card { display:flex; flex-direction:column; min-height:220px; padding:24px; border:1px solid #E5E7EB; border-radius:18px; background:#fff; box-shadow:0 8px 22px rgba(15,23,42,.055); position:relative; overflow:hidden; } .catalog-card::after { content:''; position:absolute; right:-35px; top:-35px; width:120px; height:120px; border:20px solid rgba(40,114,113,.08); border-radius:50%; } .catalog-number { color:#287271; font-size:12px; font-weight:800; letter-spacing:1px; } .catalog-title { color:#102A43; font-family:'Outfit',sans-serif; font-size:19px; font-weight:700; line-height:1.25; margin:12px 0 8px; max-width:260px; } .catalog-description { color:#64748B; font-size:13px; line-height:1.55; flex:1; max-width:390px; } .catalog-link { display:inline-flex; align-items:center; gap:7px; color:#287271; font-size:13px; font-weight:700; text-decoration:none; margin-top:18px; } .catalog-link:hover { color:#115E59; }
    .report-document-heading { background:#fff; border:1px solid #CBD5E1; border-top:4px solid #243B5A; padding:22px 26px 18px; margin-bottom:18px; color:#1E293B; }
    .document-school-brand { display:flex; align-items:center; justify-content:center; gap:13px; padding-bottom:15px; border-bottom:1px solid #CBD5E1; }
    .document-school-logo { flex:none; }
    .document-school-name { display:flex; flex-direction:column; color:#334155; font-size:12px; line-height:1.45; }
    .document-school-name strong { color:#102A43; font-family:'Outfit',sans-serif; font-size:17px; }
    .document-heading-content { text-align:center; padding:16px 0 12px; }
    .document-number { color:#475569; font-size:11px; font-weight:700; letter-spacing:.8px; }
    .report-document-heading .report-title { color:#102A43; font-size:21px; margin:5px 0; letter-spacing:0; }
    .report-document-heading .report-subtitle { color:#475569; font-size:12.5px; }
    .document-metadata { display:grid; grid-template-columns:repeat(3,1fr); border-top:1px solid #CBD5E1; border-bottom:1px solid #CBD5E1; }
    .document-metadata div { padding:9px 12px; border-right:1px solid #E2E8F0; }
    .document-metadata div:last-child { border-right:0; }
    .document-metadata dt { color:#64748B; font-size:10px; font-weight:700; text-transform:uppercase; }
    .document-metadata dd { color:#1E293B; font-size:12px; font-weight:600; margin:3px 0 0; }
    .report-card.formal-report { border:1px solid #CBD5E1; border-radius:4px; box-shadow:none; }
    .report-card.formal-report::before { display:none; }
    .formal-report .report-card-header { background:#F8FAFC; padding:16px 20px; }
    .formal-report .report-index { width:27px; height:27px; border-radius:3px; background:#243B5A; }
    .formal-report .report-card-title { color:#1E293B; font-family:inherit; font-size:15px; }
    .formal-report .report-card-description { color:#475569; }
    .formal-report .report-filter { background:#F8FAFC; border-color:#CBD5E1; }
    .formal-report .summary-box { background:#F8FAFC; border:1px solid #CBD5E1; border-radius:3px; }
    .formal-report .summary-value { color:#243B5A; font-family:inherit; font-size:22px; }
    .formal-report .report-table th { background:#243B5A; color:#fff; letter-spacing:.3px; }
    .formal-report .report-table td { border:1px solid #D7DEE8; }
    .formal-report .report-table tbody tr:hover { background:transparent; }
    @media print {
        .report-document-heading { border:0; border-top:0; padding:0 0 12px; margin-bottom:14px; }
        .document-school-brand { justify-content:center; }
        .report-card.formal-report { border:1px solid #9CA3AF; }
        .formal-report .report-card-header { background:#F1F5F9 !important; }
        .formal-report .report-table th { background:#E5E7EB !important; color:#111827 !important; }
    }
    @media(max-width:800px){ .report-header{align-items:flex-start;padding:22px 20px}.report-title{font-size:23px}.report-mark{display:none}.report-filter{grid-template-columns:1fr}.report-summary{grid-template-columns:1fr 1fr;padding-left:20px;padding-right:20px}.report-card-header{padding:18px 20px}.report-table-wrap{padding:16px 20px 20px}.trend-chart{margin-left:20px;margin-right:20px}.trend-title{margin-left:20px}.catalog-grid{grid-template-columns:1fr} }
    @media print { .sidebar,.topbar,.report-filter,.report-actions,.report-mark { display:none !important; } .main-wrapper { margin:0 !important; } .page-content { padding:0 !important; } .report-header { color:#102A43; background:#fff; box-shadow:none; border-bottom:2px solid #102A43; border-radius:0; padding:0 0 14px; } .report-title { color:#102A43; } .report-subtitle { color:#475569; } .report-card { box-shadow:none; break-inside:avoid; } }
</style>
