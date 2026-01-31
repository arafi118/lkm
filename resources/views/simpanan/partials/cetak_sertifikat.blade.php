@php
function terbilang($angka) {
    $angka = abs($angka);
    $bilangan = array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas');
    
    if ($angka < 12) {
        return $bilangan[$angka];
    } else if ($angka < 20) {
        return $bilangan[$angka - 10] . ' Belas';
    } else if ($angka < 100) {
        return $bilangan[$angka / 10] . ' Puluh ' . $bilangan[$angka % 10];
    } else if ($angka < 200) {
        return 'Seratus ' . terbilang($angka - 100);
    } else if ($angka < 1000) {
        return $bilangan[$angka / 100] . ' Ratus ' . terbilang($angka % 100);
    } else if ($angka < 2000) {
        return 'Seribu ' . terbilang($angka - 1000);
    } else if ($angka < 1000000) {
        return terbilang($angka / 1000) . ' Ribu ' . terbilang($angka % 1000);
    } else if ($angka < 1000000000) {
        return terbilang($angka / 1000000) . ' Juta ' . terbilang($angka % 1000000);
    } else if ($angka < 1000000000000) {
        return terbilang($angka / 1000000000) . ' Miliar ' . terbilang($angka % 1000000000);
    } else if ($angka < 1000000000000000) {
        return terbilang($angka / 1000000000000) . ' Triliun ' . terbilang($angka % 1000000000000);
    }
    
    return '';
}
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Deposito - {{ $simpanan->anggota->namadepan }}</title>
    
    <style type="text/css">
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Times New Roman', Times, serif;
        background-color: #fff;
        padding: 0;
    }
    
    .container {
        width: 8.5in;
        height: 11in;
        margin: 0 auto;
        padding: 0.5in 0.6in;
        background-color: #fff;
    }
    
    .header {
        text-align: center;
        border-bottom: 3px solid #000;
        padding-bottom: 8px;
        margin-bottom: 15px;
    }
    
    .company-name {
        font-size: 20px;
        font-weight: bold;
        color: #000;
        margin-bottom: 3px;
    }
    
    .company-address {
        font-size: 10px;
        color: #333;
        line-height: 1.3;
    }
    
    .certificate-title {
        text-align: center;
        font-size: 22px;
        font-weight: bold;
        margin: 20px 0 10px 0;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #1a5490;
    }
    
    .certificate-number {
        text-align: center;
        font-size: 11px;
        margin-bottom: 15px;
        font-weight: bold;
    }
    
    .intro-text {
        text-align: justify;
        font-size: 11px;
        margin-bottom: 12px;
        line-height: 1.4;
    }
    
    .detail-table {
        width: 100%;
        margin-bottom: 12px;
        border-collapse: collapse;
    }
    
    .detail-table td {
        padding: 3px 5px;
        font-size: 11px;
        vertical-align: top;
    }
    
    .detail-table td:first-child {
        width: 180px;
        font-weight: bold;
    }
    
    .detail-table td:nth-child(2) {
        width: 15px;
        text-align: center;
    }
    
    .amount-box {
        border: 2px solid #000;
        padding: 12px;
        margin: 12px 0;
        text-align: center;
        background-color: #f5f5f5;
    }
    
    .amount-label {
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .amount-value {
        font-size: 20px;
        font-weight: bold;
        color: #1a5490;
        margin: 5px 0;
    }
    
    .amount-words {
        font-size: 11px;
        font-style: italic;
        margin-top: 5px;
    }
    
    .terms {
        margin: 12px 0;
        padding: 10px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
    }
    
    .terms-title {
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 11px;
    }
    
    .terms-list {
        font-size: 9px;
        line-height: 1.5;
        padding-left: 15px;
        margin: 0;
    }
    
    .terms-list li {
        margin-bottom: 2px;
    }
    
    .signature-section {
        margin-top: 25px;
        display: table;
        width: 100%;
    }
    
    .signature-box {
        display: table-cell;
        width: 50%;
        text-align: center;
        padding: 5px;
        vertical-align: top;
    }
    
    .signature-label {
        font-size: 11px;
        margin-bottom: 50px;
    }
    
    .signature-name {
        font-size: 11px;
        font-weight: bold;
        border-top: 1px solid #000;
        display: inline-block;
        padding-top: 3px;
        min-width: 180px;
    }
    
    .footer {
        margin-top: 15px;
        padding-top: 10px;
        border-top: 1px solid #ccc;
        text-align: center;
        font-size: 8px;
        color: #666;
    }
    
    .error-message {
        text-align: center;
        padding: 40px;
        margin: 80px auto;
        max-width: 500px;
    }
    
    .error-icon {
        font-size: 60px;
        color: #e74c3c;
        margin-bottom: 15px;
    }
    
    .error-title {
        font-size: 20px;
        font-weight: bold;
        color: #e74c3c;
        margin-bottom: 12px;
    }
    
    .error-text {
        font-size: 14px;
        color: #555;
        line-height: 1.6;
    }
    
    @media print {
        @page {
            size: letter;
            margin: 0;
        }
        
        body {
            margin: 0;
            padding: 0;
        }
        
        .container {
            width: 100%;
            height: 100%;
            padding: 0.5in 0.6in;
            page-break-after: always;
        }
    }
    </style>
</head>

<body onload="window.print()">
    
    @if($simpanan->js->file == 2)
    <div class="container">
        
        <!-- Header -->
        <div class="header">
            <div class="company-name">
                {{ strtoupper($kec->nama_lembaga_long) }}
            </div>
            <div class="company-address">
                {{ $kec->alamat_kec }}<br>
                Telp: {{ $kec->telpon_kec }} | Email: {{ $kec->email_kec }}
                @if($kec->web_kec)
                | Website: {{ $kec->web_kec }}
                @endif
            </div>
        </div>
        
        <!-- Certificate Title -->
        <div class="certificate-title">
            SERTIFIKAT DEPOSITO
        </div>
        
        <!-- Certificate Number -->
        <div class="certificate-number">
            No. Sertifikat: {{ $simpanan->nomor_rekening }}
        </div>
        
        <!-- Intro Text -->
        <div class="intro-text">
            Sertifikat Deposito ini diterbitkan oleh <strong>{{ strtoupper($kec->nama_lembaga_long) }}</strong> sebagai bukti bahwa telah menerima simpanan deposito dari:
        </div>
        
        <!-- Member Details -->
        <table class="detail-table">
            <tr>
                <td>Nama Penyimpan</td>
                <td>:</td>
                <td><strong>{{ strtoupper($simpanan->anggota->namadepan) }}</strong></td>
            </tr>
            <tr>
                <td>Nomor Identitas (NIK)</td>
                <td>:</td>
                <td>{{ $simpanan->anggota->nik }}</td>
            </tr>
            <tr>
                <td>Nomor Anggota</td>
                <td>:</td>
                <td>{{ $simpanan->nia }}</td>
            </tr>
            <tr>
                <td>Nomor Rekening Deposito</td>
                <td>:</td>
                <td><strong>{{ $simpanan->nomor_rekening }}</strong></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $simpanan->anggota->alamat }}, {{ $simpanan->anggota->domisi }}</td>
            </tr>
            <tr>
                <td>Jenis Simpanan</td>
                <td>:</td>
                <td>{{ $simpanan->js->nama_js }}</td>
            </tr>
        </table>
        
        <!-- Amount Box -->
        <div class="amount-box">
            <div class="amount-label">NOMINAL DEPOSITO</div>
            <div class="amount-value">
                Rp {{ number_format($simpanan->jumlah, 0, ',', '.') }}
            </div>
            <div class="amount-words">
                ({{ ucwords(terbilang($simpanan->jumlah)) }} Rupiah)
            </div>
        </div>
        
        <!-- Deposit Details -->
        <table class="detail-table">
            <tr>
                <td>Tanggal Pembukaan</td>
                <td>:</td>
                <td>{{ \Carbon\Carbon::parse($simpanan->tgl_buka)->isoFormat('D MMMM YYYY') }}</td>
            </tr>
            <tr>
                <td>Jangka Waktu</td>
                <td>:</td>
                <td><strong>{{ $simpanan->jangka }} Bulan</strong></td>
            </tr>
            <tr>
                <td>Tanggal Jatuh Tempo</td>
                <td>:</td>
                <td><strong>{{ \Carbon\Carbon::parse($simpanan->tgl_tutup)->isoFormat('D MMMM YYYY') }}</strong></td>
            </tr>
            <tr>
                <td>Suku Bunga</td>
                <td>:</td>
                <td><strong>{{ $simpanan->bunga }}%</strong></td>
            </tr>
            <tr>
                <td>Pajak Bunga</td>
                <td>:</td>
                <td>{{ $simpanan->pajak }}%</td>
            </tr>
        </table>
        
        <!-- Terms and Conditions -->
        <div class="terms">
            <div class="terms-title">SYARAT DAN KETENTUAN:</div>
            <ol class="terms-list">
                <li>Deposito ini tidak dapat dicairkan sebelum jatuh tempo kecuali dengan persetujuan {{ $kec->nama_lembaga_sort }} dan dikenakan penalti.</li>
                <li>Perpanjangan deposito (roll over) dapat dilakukan secara otomatis atau atas permintaan penyimpan.</li>
                <li>Bunga deposito akan dipotong pajak sebesar {{ $simpanan->pajak }}% sesuai ketentuan yang berlaku.</li>
                <li>Pencairan deposito harus disertai dengan sertifikat asli dan identitas penyimpan.</li>
                <li>Sertifikat ini harus disimpan dengan baik dan tidak dapat dipindahtangankan tanpa seizin {{ $kec->nama_lembaga_sort }}.</li>
            </ol>
        </div>
        
        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-label">
                    {{ \Carbon\Carbon::parse($simpanan->tgl_buka)->isoFormat('D MMMM YYYY') }}<br>
                    Penyimpan,
                </div>
                <div class="signature-name">
                    {{ strtoupper($simpanan->anggota->namadepan) }}
                </div>
            </div>
            
            <div class="signature-box">
                <div class="signature-label">
                    Mengetahui,<br>
                    {{ $kec->sebutan_level_1 ?? 'Pimpinan' }}
                </div>
                <div class="signature-name">
                    {{ strtoupper($dir->namadepan) }} {{ strtoupper($dir->namabelakang) }}
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            Dokumen ini dicetak secara otomatis pada {{ now()->isoFormat('D MMMM YYYY, HH:mm') }} WIB<br>
            {{ strtoupper($kec->nama_lembaga_long) }} - {{ $kec->nomor_bh }}
        </div>
    </div>
    
    @else
    
    <div class="container">
        <div class="error-message">
            <div class="error-icon">⚠️</div>
            <div class="error-title">AKSES DITOLAK</div>
            <div class="error-text">
                <p><strong>Maaf, dokumen ini tidak dapat dicetak.</strong></p>
                <p>Sertifikat deposito hanya dapat dicetak untuk simpanan berjenis <strong>Deposito</strong>.</p>
                <p>Rekening dengan nomor <strong>{{ $simpanan->nomor_rekening }}</strong> berjenis <strong>{{ $simpanan->js->nama_js }}</strong>.</p>
                <p style="margin-top: 20px; font-size: 12px; color: #999;">
                    Silakan hubungi petugas {{ $kec->nama_lembaga_sort }} untuk informasi lebih lanjut.
                </p>
            </div>
        </div>
    </div>
    
    @endif
    
</body>
</html>
