@php
    $array_saldo = [];
    $j_saldo     = 0;
    $total1      = 0;
    $total2      = 0;
    $total3      = 0;
@endphp

@extends('pelaporan.layout.base')

@section('content')
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr>
            <td colspan="3" align="center">
                <div style="font-size: 18px;"><b>REKAPITULASI ARUS KAS</b></div>
                <div style="font-size: 16px;"><b>{{ strtoupper($sub_judul) }}</b></div>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="5"></td>
        </tr>
    </table>

    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr style="background: rgb(200, 200, 200)">
            <th colspan="2">Nama Akun</th>
            <th align="right">Jumlah</th>
        </tr>

        @foreach ($arus_kas as $ak)
            @php
                $dot = substr($ak->nama_akun, 1, 1);
                $bg  = ($dot == '.') ? '150, 150, 150' : '128, 128, 128';

                $isSaldoAwal      = $ak->super_sub == '1';
                $isHeaderSection  = $ak->super_sub != '0';
                $isTotalOperasi   = $ak->tipe == 'total_operasi';
                $isTotalInvestasi = $ak->tipe == 'total_investasi';
                $isTotalPendanaan = $ak->tipe == 'total_pendanaan';
                $isTtd            = $ak->tipe == 'ttd';

                $skipTotal = $isSaldoAwal || $isHeaderSection;
            @endphp

            <tr><td colspan="3" height="3"></td></tr>

            <tr style="background: rgb({{ $bg }})">
                <td width="5%" align="center">{{ $keuangan->romawi($ak->super_sub) }}</td>
                <td width="80%">
                    @if ($isSaldoAwal)
                        {{ $ak->nama_akun }} {{ $awal }}
                    @else
                        {{ $ak->nama_akun }}
                    @endif
                </td>
                <td width="15%" align="right">
                    @if ($isSaldoAwal)
                        {{ number_format($saldo_bulan_lalu, 2) }}
                    @endif
                </td>
            </tr>

            @foreach ($ak->child as $child)
                @php
                    $bgChild    = ($loop->iteration % 2 == 0) ? '240, 240, 240' : '200, 200, 200';
                    $nilaiTotal = 0;
                    foreach ($lokasi_list as $lokasiId) {
                        $nilaiTotal += $data_perlokasi[$lokasiId]['child_values'][$child->rekening] ?? 0;
                    }
                    $j_saldo += $nilaiTotal;
                @endphp
                <tr style="background: rgb({{ $bgChild }})">
                    <td align="center">&nbsp;</td>
                    <td>{{ $child->nama_akun }}</td>
                    <td align="right">{{ number_format($nilaiTotal, 2) }}</td>
                </tr>
            @endforeach

            @if (!$skipTotal)
                @if ($isTtd)
                    <tr>
                        <td colspan="3" style="padding: 0px !important;">
                            <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
                                <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                                    <td width="5%" align="center">&nbsp;</td>
                                    <td width="80%">Jumlah {{ $ak->nama_akun }}</td>
                                    <td width="15%" align="right">{{ number_format($j_saldo, 2) }}</td>
                                </tr>
                            </table>
                            <div style="margin-top: 24px;"></div>
                            {!! json_decode($kec->ttd->tanda_tangan_pelaporan, true) !!}
                        </td>
                    </tr>
                @else
                    <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                        <td align="center">&nbsp;</td>
                        <td>Jumlah {{ $ak->nama_akun }}</td>
                        <td align="right">{{ number_format($j_saldo, 2) }}</td>
                    </tr>
                @endif
                @php
                    $array_saldo[] = $j_saldo;
                    $j_saldo = 0;
                @endphp
            @endif

            @if ($isTotalOperasi)
                @php
                    $total1 = ($array_saldo[0] ?? 0) - (($array_saldo[1] ?? 0) + ($array_saldo[2] ?? 0));
                @endphp
                <tr style="background: rgb(128, 128, 128)">
                    <td align="center">&nbsp;</td>
                    <td>Kas Bersih yang diperoleh dari aktivitas Operasi (A-B-C)</td>
                    <td align="right">{{ number_format($total1, 2) }}</td>
                </tr>
            @endif

            @if ($isTotalInvestasi)
                @php
                    $total2 = ($array_saldo[3] ?? 0) - ($array_saldo[4] ?? 0);
                @endphp
                <tr style="background: rgb(128, 128, 128)">
                    <td align="center">&nbsp;</td>
                    <td>Kas Bersih yang diperoleh dari aktivitas Investasi (A-B)</td>
                    <td align="right">{{ number_format($total2, 2) }}</td>
                </tr>
            @endif

            @if ($isTotalPendanaan)
                @php
                    $total3 = ($array_saldo[5] ?? 0) - ($array_saldo[6] ?? 0);
                @endphp
                <tr style="background: rgb(128, 128, 128)">
                    <td align="center">&nbsp;</td>
                    <td>Kas Bersih yang diperoleh dari aktivitas Pendanaan (A-B)</td>
                    <td align="right">{{ number_format($total3, 2) }}</td>
                </tr>
            @endif

        @endforeach

        <tr>
            <td colspan="3" style="padding: 0px !important;">
                <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
                    <tr style="background: rgb(128, 128, 128)">
                        <td width="5%" align="center">&nbsp;</td>
                        <td width="80%">Kenaikan (Penurunan) Kas</td>
                        <td width="15%" align="right">{{ number_format($total1 + $total2 + $total3, 2) }}</td>
                    </tr>
                    <tr style="background: rgb(128, 128, 128)">
                        <td align="center">&nbsp;</td>
                        <td>SALDO AKHIR KAS SETARA KAS</td>
                        <td align="right">{{ number_format($total1 + $total2 + $total3 + $saldo_bulan_lalu, 2) }}</td>
                    </tr>
                </table>

                <div style="margin-top: 16px;"></div>
                {!! json_decode(str_replace('{tanggal}', $tanggal_kondisi, $kec->ttd->tanda_tangan_pelaporan), true) !!}
            </td>
        </tr>
    </table>
                <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;page-break-inside: avoid; break-inside: avoid;">
                    <tr>
                        <td width="50%" align="center">
                            <strong>Diperiksa Oleh:</strong>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p><u>Ardiansyah Asdar STP.MM</u></p>
                            Ketua Dewan Pengawas
                        </td>
                        <td width="50%" align="center">
                            <strong>Dilaporkan Oleh:</strong>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p><u>Basuki</u></p>
                            Manajer
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <p>&nbsp;</p>
                            <strong>Mengetahui/Menyetujui:</strong>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p><u>Eko Susanto</u></p>
                            Ketua Koperasi
                        </td>
                    </tr>
                </table>
@endsection
