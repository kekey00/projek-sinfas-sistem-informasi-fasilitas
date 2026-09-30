<style>
    .report-header { display:flex; justify-content:space-between; align-items:flex-end; gap:20px; margin-bottom:24px; padding:26px 28px; border-radius:22px; color:#fff; background:linear-gradient(120deg,#121358,#232F72 58%,#2F578A); box-shadow:0 16px 32px rgba(18,19,88,.16); }
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
    .print-only { display: none; }
    @media(max-width:800px){ .report-header{align-items:flex-start;padding:22px 20px}.report-title{font-size:23px}.report-mark{display:none}.report-filter{grid-template-columns:1fr}.report-summary{grid-template-columns:1fr 1fr;padding-left:20px;padding-right:20px}.report-card-header{padding:18px 20px}.report-table-wrap{padding:16px 20px 20px}.trend-chart{margin-left:20px;margin-right:20px}.trend-title{margin-left:20px}.catalog-grid{grid-template-columns:1fr} }
    @media print {
        @page {
            size: auto;
            margin: 12mm 15mm 12mm 15mm;
        }
        html, body {
            background: #FFFFFF !important;
            color: #1E293B !important;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif !important;
            font-size: 9.5px !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .admin-layout, .main-wrapper, .page-content {
            margin: 0 !important;
            padding: 0 !important;
            background: #FFFFFF !important;
            display: block !important;
            width: 100% !important;
        }
        .sidebar, .topbar, .report-header, .report-filter, .report-actions, .report-mark, .trend-chart, .trend-title {
            display: none !important;
        }
        .print-only {
            display: block !important;
        }

        /* Kop Surat Resmi di Print Web */
        .print-kop-table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin-bottom: 0 !important;
            border: none !important;
        }
        .print-kop-table td {
            border: none !important;
            padding: 0 !important;
        }
        .print-kop-center {
            text-align: center !important;
            padding: 0 12px !important;
        }
        .print-kop-instansi {
            font-size: 8.5px !important;
            font-weight: 700 !important;
            color: #475569 !important;
            letter-spacing: 1.2px !important;
            text-transform: uppercase !important;
        }
        .print-kop-sekolah {
            font-size: 17px !important;
            font-weight: 800 !important;
            color: #121358 !important;
            letter-spacing: 0.5px !important;
            margin: 2px 0 3px 0 !important;
            text-transform: uppercase !important;
        }
        .print-kop-unit {
            font-size: 10.5px !important;
            font-weight: 700 !important;
            color: #232F72 !important;
            letter-spacing: 0.4px !important;
            text-transform: uppercase !important;
        }
        .print-side-badge {
            display: inline-block !important;
            padding: 4px 8px !important;
            background: #F0F4FA !important;
            border: 1px solid #CBD5E1 !important;
            border-radius: 6px !important;
            font-size: 8px !important;
            font-weight: 700 !important;
            color: #232F72 !important;
            text-align: center !important;
            line-height: 1.2 !important;
        }
        .print-kop-divider-thick {
            height: 2.5px !important;
            background: #121358 !important;
            margin-top: 8px !important;
        }
        .print-kop-divider-thin {
            height: 0.8px !important;
            background: #2F578A !important;
            margin-top: 1.5px !important;
            margin-bottom: 12px !important;
        }

        /* Judul Dokumen Cetak */
        .print-doc-title-wrap {
            text-align: center !important;
            margin-bottom: 12px !important;
        }
        .print-doc-title {
            font-size: 14px !important;
            font-weight: 800 !important;
            color: #121358 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.6px !important;
        }
        .print-doc-subtitle {
            font-size: 9px !important;
            color: #64748B !important;
            margin-top: 3px !important;
            font-style: italic !important;
        }

        /* Metadata Cetak */
        .print-meta-table {
            width: 100% !important;
            border-collapse: collapse !important;
            background: #F8FAFC !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 6px !important;
            margin-bottom: 14px !important;
        }
        .print-meta-table td {
            padding: 6px 12px !important;
            font-size: 8.5px !important;
            color: #334155 !important;
            border: none !important;
        }
        .print-meta-label {
            color: #64748B !important;
        }
        .print-meta-value {
            font-weight: 700 !important;
            color: #0F172A !important;
        }

        /* Kartu & Ringkasan */
        .report-card {
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .report-card::before, .report-card-header, .report-index {
            display: none !important;
        }
        .report-summary {
            display: flex !important;
            gap: 10px !important;
            padding: 0 !important;
            margin-bottom: 14px !important;
        }
        .summary-box {
            flex: 1 !important;
            background: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            border-top: 3px solid #232F72 !important;
            border-radius: 6px !important;
            padding: 6px 10px !important;
        }
        .summary-label {
            font-size: 7.5px !important;
            font-weight: 700 !important;
            color: #64748B !important;
            text-transform: uppercase !important;
        }
        .summary-value {
            font-size: 15px !important;
            font-weight: 800 !important;
            color: #121358 !important;
            margin-top: 2px !important;
        }

        /* Tabel Data */
        .report-table-wrap {
            padding: 0 !important;
            margin-bottom: 14px !important;
            overflow: visible !important;
        }
        .report-table {
            width: 100% !important;
            border-collapse: collapse !important;
            font-size: 9px !important;
        }
        .report-table th {
            background: #121358 !important;
            color: #FFFFFF !important;
            font-size: 8px !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            padding: 7px 8px !important;
            border: 1px solid #121358 !important;
        }
        .report-table td {
            padding: 6px 8px !important;
            border: 1px solid #E2E8F0 !important;
            color: #334155 !important;
            font-size: 9px !important;
        }
        .report-table tbody tr:nth-child(even) td {
            background-color: #F8FAFC !important;
        }
        .count-pill {
            display: inline-block !important;
            padding: 2.5px 7px !important;
            border-radius: 4px !important;
            font-size: 8px !important;
            font-weight: 700 !important;
            background: #DBEAFE !important;
            color: #1E40AF !important;
            border: 1px solid #93C5FD !important;
        }

        /* Pengesahan Tanda Tangan */
        .print-signatures-wrap {
            margin-top: 15px !important;
            page-break-inside: avoid !important;
        }
        .print-signature-table {
            width: 100% !important;
            border-collapse: collapse !important;
            border: none !important;
        }
        .print-signature-table td {
            border: none !important;
            padding: 0 !important;
            vertical-align: top !important;
            font-size: 9px !important;
        }
        .print-sig-col-left {
            width: 50% !important;
            text-align: left !important;
        }
        .print-sig-col-right {
            width: 50% !important;
            text-align: right !important;
        }
        .print-sig-box {
            display: inline-block !important;
            text-align: left !important;
            min-width: 200px !important;
        }
        .print-sig-date {
            margin-bottom: 2px !important;
            color: #475569 !important;
            height: 14px !important;
            line-height: 14px !important;
        }
        .print-sig-role {
            font-weight: 700 !important;
            color: #0F172A !important;
            margin-bottom: 45px !important;
        }
        .print-sig-name {
            font-weight: 700 !important;
            text-decoration: underline !important;
            color: #0F172A !important;
        }
        .print-sig-nip {
            font-size: 8px !important;
            color: #64748B !important;
            margin-top: 2px !important;
        }
        .print-doc-footer {
            margin-top: 14px !important;
            padding-top: 6px !important;
            border-top: 0.8px dashed #CBD5E1 !important;
        }
    }
</style>
