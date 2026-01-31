<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Deposito</title>
    
    <style type="text/css">
    body {
        font-family: 'Times New Roman', Times, serif;
        margin: 0;
        padding: 20px;
        background-color: #fff;
    }
    
    .container {
        width: 21cm;
        margin: 0 auto;
        padding: 30px;
        border: 3px double #000;
        background-color: #fff;
    }
    
    .header {
        text-align: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #000;
        padding-bottom: 20px;
    }
    
    .logo {
        width: 80px;
        height: 80px;
        margin: 0 auto 10px;
    }
    
    .company-name {
        font-size: 24px;
        font-weight: bold;
        color: #000;
        margin: 10px 0;
    }
    
    .company-address {
        font-size: 12px;
        color: #333;
        line-height: 1.5;
    }
    
    .certificate-title {
        text-align: center;
        font-size: 28px;
        font-weight: bold;
        margin: 30px 0;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #1a5490;
    }
    
    .certificate-number {
        text-align: center;
        font-size: 14px;
        margin-bottom: 20px;
        font-weight: bold;
    }
    
    .content {
        margin: 30px 0;
        line-height: 2;
    }
    
    .detail-table {
        width: 100%;
        margin: 20px 0;
        border-collapse: collapse;
    }
    
    .detail-table td {
        padding: 8px;
        font-size: 14px;
    }
    
    .detail-table td:first-child {
        width: 200px;
        font-weight: bold;
    }
    
    .detail-table td:nth-child(2) {
        width: 20px;
        text-align: center;
    }
    
    .amount-box {
        border: 2px solid #000;
        padding: 15px;
        margin: 20px 0;
        text-align: center;
        background-color: #f5f5f5;
    }
    
    .amount-label {
        font-size: 14px;
        font-weight: bold;
    }
    
    .amount-value {
        font-size: 24px;
        font-weight: bold;
        color: #1a5490;
        margin: 10px 0;
    }
    
    .amount-words {
        font-size: 14px;
        font-style: italic;
        margin-top: 10px;
    }
    
    .terms {
        margin: 30px 0;
        padding: 15px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
    }
    
    .terms-title {
        font-weight: bold;
        margin-bottom: 10px;
        font-size: 14px;
    }
    
    .terms-list {
        font-size: 12px;
        line-height: 1.8;
        padding-left: 20px;
    }
    
    .signature-section {
        margin-top: 50px;
        display: table;
        width: 100%;
    }
    
    .signature-box {
        display: table-cell;
        width: 50%;
        text-align: center;
        padding: 10px;
    }
    
    .signature-label {
        font-size: 14px;
        margin-bottom: 80px;
    }
    
    .signature-name {
        font-size: 14px;
        font-weight: bold;
        border-top: 1px solid #000;
        display: inline-block;
        padding-top: 5px;
        min-width: 200px;
    }
    
    .footer {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #ccc;
        text-align: center;
        font-size: 10px;
        color: #666;
    }
    
    .watermark {
        position: relative;
        opacity: 0.05;
        font-size: 100px;
        text-align: center;
        transform: rotate(-45deg);
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        z-index: -1;
        font-weight: bold;
    }
    
    @media print {
        body {
            padding: 0;
        }
        .container {
            border: none;
            page-break-after: always;
        }
    }
    </style>
</head>

<body>
    
    <div class="container">
        <!-- Watermark -->
        <div class="watermark">DEPOSITO</div>
        
        <!-- Header -->
        <div class="header">
            {{-- Uncomment jika ada logo --}}
            {{-- <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo"> --}}
            
            <div class="company-name">
                KOPERASI SIMPAN PINJAM<br>
                "MAJU BERSAMA SEJAHTERA"
            </div>
            <div class="company-address">
                Jl. Raya Merdeka No. 123, Jakarta Pusat 10110<br>
                Telp: (021) 5551234 | Email: info@koperasimbs.co.id
            </div>
        </div>
        
        <!-- Certificate Title -->
        <div class="certificate-title">
            SERTIFIKAT DEPOSITO
        </div>
        
        <!-- Certificate Number -->
        <div class="certificate-number">
            No. Sertifikat: DEP/2026/00125
        </div>
        
        <!-- Content -->
        <div class="content">
            <p style="text-align: justify; text-indent: 50px;">
                Sertifikat Deposito ini diterbitkan oleh <strong>KOPERASI SIMPAN PINJAM "MAJU BERSAMA SEJAHTERA"</strong> 
                sebagai bukti bahwa telah menerima simpanan deposito dari:
            </p>
            
            <table class="detail-table">
                <tr>
                    <td>Nama Penyimpan</td>
                    <td>:</td>
                    <td><strong>Budi Santoso</strong></td>
                </tr>
                <tr>
                    <td>Nomor Anggota</td>
                    <td>:</td>
                    <td>AGT-2024-00456</td>
                </tr>
                <tr>
                    <td>Nomor Rekening Deposito</td>
                    <td>:</td>
                    <td><strong>3501-0125-789</strong></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>Jl. Mawar No. 45, RT 05/RW 03, Kelurahan Sukamaju, Kecamatan Cilandak</td>
                </tr>
                <tr>
                    <td>Nomor Identitas (KTP)</td>
                    <td>:</td>
                    <td>3174012508850001</td>
                </tr>
            </table>
            
            <!-- Amount Box -->
            <div class="amount-box">
                <div class="amount-label">NOMINAL DEPOSITO</div>
                <div class="amount-value">
                    Rp 50.000.000
                </div>
                <div class="amount-words">
                    (Lima Puluh Juta Rupiah)
                </div>
            </div>
            
            <table class="detail-table">
                <tr>
                    <td>Tanggal Pembukaan</td>
                    <td>:</td>
                    <td>15 Januari 2026</td>
                </tr>
                <tr>
                    <td>Jangka Waktu</td>
                    <td>:</td>
                    <td><strong>12 Bulan</strong></td>
                </tr>
                <tr>
                    <td>Tanggal Jatuh Tempo</td>
                    <td>:</td>
                    <td><strong>15 Januari 2027</strong></td>
                </tr>
                <tr>
                    <td>Suku Bunga</td>
                    <td>:</td>
                    <td><strong>7.5% per tahun</strong></td>
                </tr>
                <tr>
                    <td>Pembayaran Bunga</td>
                    <td>:</td>
                    <td>Dibayarkan setiap bulan</td>
                </tr>
            </table>
        </div>
        
        <!-- Terms and Conditions -->
        <div class="terms">
            <div class="terms-title">SYARAT DAN KETENTUAN:</div>
            <ol class="terms-list">
                <li>Deposito ini tidak dapat dicairkan sebelum jatuh tempo kecuali dengan persetujuan koperasi dan dikenakan penalti.</li>
                <li>Perpanjangan deposito (roll over) dapat dilakukan secara otomatis atau atas permintaan penyimpan.</li>
                <li>Bunga deposito akan dipotong pajak sesuai ketentuan yang berlaku.</li>
                <li>Pencairan deposito harus disertai dengan sertifikat asli dan identitas penyimpan.</li>
                <li>Sertifikat ini harus disimpan dengan baik dan tidak dapat dipindahtangankan.</li>
                <li>Apabila terjadi kehilangan sertifikat, segera laporkan kepada koperasi untuk pemblokiran.</li>
            </ol>
        </div>
        
        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-label">
                    Jakarta, 15 Januari 2026<br>
                    Penyimpan,
                </div>
                <div class="signature-name">
                    Budi Santoso
                </div>
            </div>
            
            <div class="signature-box">
                <div class="signature-label">
                    Mengetahui,<br>
                    Pimpinan Koperasi
                </div>
                <div class="signature-name">
                    Ir. Siti Rahayu, M.M.
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            Dokumen ini dicetak secara otomatis pada 31 Januari 2026, 14:30 WIB<br>
            KOPERASI SIMPAN PINJAM "MAJU BERSAMA SEJAHTERA" - Terdaftar dan diawasi oleh Kementerian Koperasi dan UKM
        </div>
    </div>
    
</body>
</html>
