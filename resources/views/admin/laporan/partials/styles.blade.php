<style>
    .report-header { display:flex; justify-content:space-between; align-items:flex-end; gap:20px; margin-bottom:24px; padding:26px 28px; border-radius:22px; color:#fff; background:linear-gradient(120deg,#2F578A,#232F72 58%,#121358); box-shadow:0 16px 32px rgba(18,19,88,.16); }
    .report-kicker { color:#93C5FD; font-size:11px; font-weight:800; letter-spacing:1.4px; text-transform:uppercase; margin-bottom:8px; }
    .report-title { font-family:'Outfit',sans-serif; font-size:28px; font-weight:700; letter-spacing:-.4px; margin-bottom:5px; }
    .report-subtitle { color:rgba(255,255,255,.78); font-size:13.5px; }
    .report-mark { width:52px; height:52px; border:1px solid rgba(255,255,255,.22); border-radius:16px; display:grid; place-items:center; color:#BFDBFE; background:rgba(255,255,255,.1); }
    .report-actions { display:flex; gap:8px; margin-top:16px; position:relative; z-index:1; }
    .report-action { display:inline-flex; align-items:center; gap:7px; height:36px; border-radius:9px; padding:0 13px; font:inherit; font-size:12px; font-weight:700; text-decoration:none; cursor:pointer; }
    .report-action.back { color:#E0F2FE; border:1px solid rgba(255,255,255,.25); background:rgba(255,255,255,.09); }
    .report-action.print { color:#E0F2FE; border:1px solid rgba(255,255,255,.25); background:rgba(255,255,255,.09); }
    .report-action.pdf { color:#121358; border:1px solid #93C5FD; background:#DBEAFE; }
    .report-card { background:#fff; border:1px solid #E5E7EB; border-radius:20px; box-shadow:0 8px 22px rgba(15,23,42,.055); overflow:hidden; margin-bottom:20px; position:relative; }
    .report-card::before { content:''; position:absolute; left:0; top:0; bottom:0; width:4px; background:#232F72; }
    .report-card.orange::before { background:#D97706; } .report-card.red::before { background:#E11D48; } .report-card.blue::before { background:#2563EB; }
    .report-card-header { padding:22px 26px 19px; border-bottom:1px solid #EEF2F4; display:flex; align-items:flex-start; gap:13px; }
    .report-index { flex:0 0 auto; width:30px; height:30px; border-radius:10px; display:grid; place-items:center; color:#fff; background:#232F72; font-size:12px; font-weight:800; }
    .orange .report-index { background:#D97706; } .red .report-index { background:#E11D48; } .blue .report-index { background:#2563EB; }
    .report-card-title { font-family:'Outfit',sans-serif; color:#121358; font-size:18px; font-weight:700; }
    .report-card-description { color:#64748B; font-size:13px; line-height:1.55; margin-top:5px; }
    .report-filter { display:grid; grid-template-columns:repeat(3,1fr) auto; gap:12px; padding:18px 26px; background:#F8FAFC; border-bottom:1px solid #E2E8F0; align-items:end; }
    .report-field { display:flex; flex-direction:column; gap:6px; } .report-field label { color:#334155; font-size:12px; font-weight:700; }
    .report-field input,.report-field select { width:100%; height:38px; border:1px solid #CBD5E1; border-radius:8px; padding:0 10px; color:#334155; background:#fff; font:inherit; font-size:13px; }
    .report-button { height:38px; border:0; border-radius:9px; padding:0 18px; color:#fff; background:#232F72; font:inherit; font-size:13px; font-weight:700; cursor:pointer; box-shadow:0 5px 12px rgba(35,47,114,.25); }
    .report-summary { display:grid; grid-template-columns:repeat(3,minmax(0,180px)); gap:12px; padding:20px 26px 0; }
    .summary-box { padding:14px 16px; border-radius:12px; background:#F0F4FA; border:1px solid #D6E2F0; } .summary-label { color:#64748B; font-size:12px; } .summary-value { color:#232F72; font-family:'Outfit',sans-serif; font-size:25px; font-weight:700; margin-top:3px; }
    .report-table-wrap { overflow-x:auto; padding:20px 26px 24px; } .report-table { width:100%; border-collapse:collapse; min-width:600px; }
    .report-table th { background:#F8FAFC; color:#64748B; font-size:10.5px; letter-spacing:.7px; text-align:left; text-transform:uppercase; padding:12px 14px; } .report-table td { border-bottom:1px solid #F1F5F9; color:#334155; font-size:13px; padding:13px 14px; } .report-table tbody tr:hover { background:#F8FCFC; } .report-table tr:last-child td { border-bottom:0; }
    .count-pill { display:inline-flex; min-width:30px; justify-content:center; padding:4px 9px; border-radius:999px; color:#1D4ED8; background:#DBEAFE; font-weight:700; } .empty-report { color:#64748B; font-size:13px; padding:28px 14px; text-align:center; }
    .trend-chart { height:230px; position:relative; margin:0 26px 24px; } .trend-title { color:#334155; font-size:14px; font-weight:700; margin:0 26px 10px; }
    .catalog-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:18px; } .catalog-card { display:flex; flex-direction:column; min-height:220px; padding:24px; border:1px solid #E5E7EB; border-radius:18px; background:#fff; box-shadow:0 8px 22px rgba(15,23,42,.055); position:relative; overflow:hidden; } .catalog-card::after { content:''; position:absolute; right:-35px; top:-35px; width:120px; height:120px; border:20px solid rgba(47,87,138,.08); border-radius:50%; } .catalog-number { color:#232F72; font-size:12px; font-weight:800; letter-spacing:1px; } .catalog-title { color:#121358; font-family:'Outfit',sans-serif; font-size:19px; font-weight:700; line-height:1.25; margin:12px 0 8px; max-width:260px; } .catalog-description { color:#64748B; font-size:13px; line-height:1.55; flex:1; max-width:390px; } .catalog-link { display:inline-flex; align-items:center; gap:7px; color:#2F578A; font-size:13px; font-weight:700; text-decoration:none; margin-top:18px; } .catalog-link:hover { color:#121358; }
    @media(max-width:800px){ .report-header{align-items:flex-start;padding:22px 20px}.report-title{font-size:23px}.report-mark{display:none}.report-filter{grid-template-columns:1fr}.report-summary{grid-template-columns:1fr 1fr;padding-left:20px;padding-right:20px}.report-card-header{padding:18px 20px}.report-table-wrap{padding:16px 20px 20px}.trend-chart{margin-left:20px;margin-right:20px}.trend-title{margin-left:20px}.catalog-grid{grid-template-columns:1fr} }
    @media print { .sidebar,.topbar,.report-filter,.report-actions,.report-mark { display:none !important; } .main-wrapper { margin:0 !important; } .page-content { padding:0 !important; } .report-header { color:#121358; background:#fff; box-shadow:none; border-bottom:2px solid #121358; border-radius:0; padding:0 0 14px; } .report-title { color:#121358; } .report-subtitle { color:#475569; } .report-card { box-shadow:none; break-inside:avoid; } }
</style>
