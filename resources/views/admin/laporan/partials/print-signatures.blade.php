<div class="print-only print-signatures-wrap">
    <table class="print-signature-table">
        <tr>
            <td class="print-sig-col-left">
                <div class="print-sig-box">
                    <div class="print-sig-date">&nbsp;</div>
                    <div class="print-sig-role">Mengetahui,<br>Kepala Sekolah SMK SINFAS</div>
                    <div class="print-sig-name">Drs. H. Mulyadi, M.Pd.</div>
                    <div class="print-sig-nip">NIP. 19780512 200501 1 004</div>
                </div>
            </td>
            <td class="print-sig-col-right">
                <div class="print-sig-box">
                    <div class="print-sig-date">Bandung, {{ now()->format('d/m/Y') }}</div>
                    <div class="print-sig-role">Penanggung Jawab Sarpras,<br>Staf Pengelola Fasilitas</div>
                    <div class="print-sig-name">{{ auth()->user()->nama ?? 'Administrator Sarpras' }}</div>
                    <div class="print-sig-nip">NIP/ID: {{ auth()->user()->nip ?? auth()->user()->username ?? 'STF-SARPRAS-01' }}</div>
                </div>
            </td>
        </tr>
    </table>

    <div class="print-doc-footer">
        <table style="width: 100%; border: none; border-collapse: collapse;">
            <tr>
                <td style="text-align: left; font-size: 8px; color: #94A3B8; border: none; padding: 0;">
                    Dokumen resmi yang dihasilkan secara otomatis oleh <strong>SINFAS (Sistem Informasi Fasilitas)</strong>.
                </td>
                <td style="text-align: right; font-size: 8px; color: #94A3B8; border: none; padding: 0;">
                    Validitas Terverifikasi Sistem
                </td>
            </tr>
        </table>
    </div>
</div>
