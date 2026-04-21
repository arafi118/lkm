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

    <table width="95%" align="center">
        <tr>
            <td width="20%">NAMA LKM</td>
            <td width="80%">: {{ $kec->nama_kec }}</td>
        </tr>
        <tr>
            <td>SANDI LKM</td>
            <td>: {{ $kec->sandi_lkm }}</td>
        </tr>
        <tr>
            <td>PERIODE LAPORAN</td>
            <td>: {{ $sub_judul }}</td>
        </tr>
    </table>

    <br>

    <table width="95%" align="center">
        <thead>
            <tr>
                <th class="border center">NO</th>
                <th class="border center">NAMA ANGGOTA</th>
                <th class="border center">JENIS ANGGOTA</th>
                <th class="border center">CIF</th>
                <th class="border center">NIK</th>
                <th class="border center">JENIS SIMPANAN</th>
                <th class="border center">SALDO AKHIR</th>
                <th class="border center">TGL BUKA</th>
                <th class="border center">TGL TUTUP</th>
                <th class="border center">BUNGA (%)</th>
                <th class="border center">PAJAK (%)</th>
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
                    $jumlah = $simpanan->realSimpananTerbesar->sum ?? 0;
                    $total += $jumlah;
                    @endphp
                    <tr>
                        <td class="border center">{{ $no++ }}</td>
                        <td class="border">{{ $simpanan->namadepan }}</td>
                        <td class="border center">ANGGOTA</td>
                        <td class="border center">{{ $simpanan->id }}</td>
                        <td class="border center">{{ $simpanan->nik }}</td>
                        <td class="border center">{{$jenis->nama_js}}</td>
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
                            {{ $simpanan->pajak ?? '0' }}%
                        </td>
                        <td class="border">
                            {{ $simpanan->keterangan ?? '-' }}
                        </td>
                    </tr>
                @endforeach
            @endforeach

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
    
    <table class="p" border="0" align="center" width="96%" cellspacing="0" cellpadding="0" style="font-size: 12px;"> 
        <tr>
            <td colspan="14">
                <div style="margin-top: 14px;"></div>
                {!! json_decode(str_replace('{tanggal}', $tanggal_kondisi, $kec->ttd->tanda_tangan_pelaporan), true) !!}
            </td>
        </tr>
    </table>

</body>

</html>
