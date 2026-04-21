<!DOCTYPE html>
<html>

<head>
    <title>Daftar Rincian Tabungan</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
        }

        table {
            border-collapse: collapse;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .border {
            border: 1px solid black;
        }

        .header {
            font-size: 16px;
            font-weight: bold;
        }

        .ttd {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <table width="95%" align="center">
        <tr>
            <td class="center header">
                DAFTAR RINCIAN TABUNGAN
            </td>
        </tr>
    </table>

    <br>

    <!-- INFORMASI -->
    <table width="95%" align="center">
        <tr>
            <td width="20%">NAMA LKM</td>
            <td width="80%">: LKM CONTOH</td>
        </tr>
        <tr>
            <td>SANDI LKM</td>
            <td>: 123456</td>
        </tr>
        <tr>
            <td>PERIODE LAPORAN</td>
            <td>: 31 DESEMBER 2026</td>
        </tr>
    </table>

    <br>

    <!-- TABEL UTAMA -->
    <table width="95%" align="center">
        <thead>
            <tr>
                <th class="border center">NO</th>
                <th class="border center">NAMA ANGGOTA</th>
                <th class="border center">JENIS ANGGOTA</th>
                <th class="border center">NIA</th>
                <th class="border center">NIK</th>
                <th class="border center">JENIS SIMPANAN</th>
                <th class="border center">SALDO AKHIR</th>
                <th class="border center">TGL BUKA</th>
                <th class="border center">TGL TUTUP</th>
                <th class="border center">BUNGA (%)</th>
                <th class="border center">BUNGA (%)</th>
                <th class="border center">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            $total = 0;
            @endphp

            @foreach($jenis_simpanan as $jenis)
            @foreach($jenis->simpanan as $simpanan)
            @php
            $jumlah = $simpanan->saldo ?? 0; // sesuaikan field saldo kamu
            $total += $jumlah;
            @endphp
            <tr>
                <td class="border center">{{ $no++ }}</td>
                <td class="border">{{ $simpanan->namadepan }}</td>
                <td class="border center">Individu</td>
                <td class="border center">{{ $simpanan->nia }}</td>
                <td class="border center">{{ $simpanan->nik }}</td>
                <td class="border center">{{ $jenis->nama }}</td>
                <td class="border right">{{ number_format($jumlah, 0, ',', '.') }}</td>
                <td class="border center">
                    {{ date('d-m-Y', strtotime($simpanan->tgl_buka)) }}
                </td>
                <td class="border center">
                    {{ $simpanan->tgl_tutup ? date('d-m-Y', strtotime($simpanan->tgl_tutup)) : '-' }}
                </td>
                <td class="border center">
                    {{ $simpanan->bunga ?? '0' }}%
                </td>
                <td class="border center">
                    {{ $simpanan->bunga ?? '0' }}%
                </td>
                <td class="border">
                    {{ $simpanan->keterangan ?? '-' }}
                </td>
            </tr>
            @endforeach
            @endforeach

            <!-- TOTAL -->
            <tr>
                <td colspan="6" class="border center"><b>JUMLAH</b></td>
                <td class="border right">
                    <b>{{ number_format($total, 0, ',', '.') }}</b>
                </td>
                <td colspan="5" class="border"></td>
            </tr>
        </tbody>
    </table>

    <br><br>

    <!-- TANDA TANGAN -->
    <table width="95%" align="center">
        <tr>
            <td width="60%"></td>
            <td class="center">
                Sruweng, 31 DESEMBER 2026
                <br><br>
                Direktur Utama
                <br><br><br><br>
                <b>Wati Kusuma, SE, MSi, Ak, CA</b>
            </td>
        </tr>
    </table>

</body>

</html>