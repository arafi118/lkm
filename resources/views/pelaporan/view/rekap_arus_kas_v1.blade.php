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
            <td colspan="{{ 3 + count($lokasi_list) }}" align="center">
                <div style="font-size: 18px;"><b>REKAPITULASI ARUS KAS</b></div>
                <div style="font-size: 16px;"><b>{{ strtoupper($sub_judul) }}</b></div>
            </td>
        </tr>
        <tr>
            <td colspan="{{ 3 + count($lokasi_list) }}" height="5"></td>
        </tr>
    </table>

        <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">

                <tr style="background: rgb(200, 200, 200)">
            <th colspan="2">Nama Akun</th>
            @foreach ($lokasi_list as $lokasiId)
                <th align="right">{{ $kecamatan_list[$lokasiId]->nama_kecamatan ?? $lokasiId }}</th>
            @endforeach
            <th align="right">Total</th>
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

            <tr><td colspan="{{ 3 + count($lokasi_list) }}" height="3"></td></tr>

                        <tr style="background: rgb({{ $bg }})">
                <td width="5%" align="center">{{ $keuangan->romawi($ak->super_sub) }}</td>
                <td width="{{ 50 - (count($lokasi_list) * 5) }}%">
                    @if ($isSaldoAwal)
                        {{ $ak->nama_akun }} {{ $awal }}
                    @else
                        {{ $ak->nama_akun }}
                    @endif
                </td>
                @foreach ($lokasi_list as $lokasiId)
                    <td align="right">
                        @if ($isSaldoAwal)
                            {{ number_format($data_perlokasi[$lokasiId]['saldo_bulan_lalu'] ?? 0, 2) }}
                        @endif
                    </td>
                @endforeach
                <td align="right">
                    @if ($isSaldoAwal)
                        {{ number_format($saldo_bulan_lalu, 2) }}
                    @endif
                </td>
            </tr>

                        @foreach ($ak->child as $child)
                @php
                    $bgChild = ($loop->iteration % 2 == 0) ? '240, 240, 240' : '200, 200, 200';

                    $nilaiPerLokasi = [];
                    $nilaiTotal     = 0;
                    foreach ($lokasi_list as $lokasiId) {
                        $nilai                  = $data_perlokasi[$lokasiId]['child_values'][$child->rekening] ?? 0;
                        $nilaiPerLokasi[$lokasiId] = $nilai;
                        $nilaiTotal             += $nilai;
                    }

                    $j_saldo += $nilaiTotal;
                @endphp
                <tr style="background: rgb({{ $bgChild }})">
                    <td align="center">&nbsp;</td>
                    <td>{{ $child->nama_akun }}</td>
                    @foreach ($lokasi_list as $lokasiId)
                        <td align="right">{{ number_format($nilaiPerLokasi[$lokasiId], 2) }}</td>
                    @endforeach
                    <td align="right">{{ number_format($nilaiTotal, 2) }}</td>
                </tr>
            @endforeach

                        @if (!$skipTotal)
                @if ($isTtd)
                    <tr>
                        <td colspan="{{ 3 + count($lokasi_list) }}" style="padding: 0px !important;">
                            <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
                                <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                                    <td width="5%" align="center">&nbsp;</td>
                                    <td>Jumlah {{ $ak->nama_akun }}</td>
                                    @foreach ($lokasi_list as $lokasiId)
                                        @php
                                            $jSaldoLokasi = 0;
                                            foreach ($ak->child as $child) {
                                                $jSaldoLokasi += $data_perlokasi[$lokasiId]['child_values'][$child->rekening] ?? 0;
                                            }
                                        @endphp
                                        <td align="right">{{ number_format($jSaldoLokasi, 2) }}</td>
                                    @endforeach
                                    <td align="right">{{ number_format($j_saldo, 2) }}</td>
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
                        @foreach ($lokasi_list as $lokasiId)
                            @php
                                $jSaldoLokasi = 0;
                                foreach ($ak->child as $child) {
                                    $jSaldoLokasi += $data_perlokasi[$lokasiId]['child_values'][$child->rekening] ?? 0;
                                }
                            @endphp
                            <td align="right">{{ number_format($jSaldoLokasi, 2) }}</td>
                        @endforeach
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
                    @foreach ($lokasi_list as $lokasiId)
                        @php
                            $saldoLokasi0 = 0;
                            $saldoLokasi1 = 0;
                            $saldoLokasi2 = 0;
                            $counterSection = 0;
                            foreach ($arus_kas as $akLoop) {
                                $skipTotalLoop = ($akLoop->super_sub == '1') || ($akLoop->super_sub != '0');
                                if ($akLoop->tipe == 'total_operasi') break;
                                if (!$skipTotalLoop) {
                                    $saldoLokasiTmp = 0;
                                    foreach ($akLoop->child as $childLoop) {
                                        $saldoLokasiTmp += $data_perlokasi[$lokasiId]['child_values'][$childLoop->rekening] ?? 0;
                                    }
                                    if ($counterSection == 0) $saldoLokasi0 = $saldoLokasiTmp;
                                    if ($counterSection == 1) $saldoLokasi1 = $saldoLokasiTmp;
                                    if ($counterSection == 2) $saldoLokasi2 = $saldoLokasiTmp;
                                    $counterSection++;
                                }
                            }
                            $total1Lokasi = $saldoLokasi0 - ($saldoLokasi1 + $saldoLokasi2);
                        @endphp
                        <td align="right">{{ number_format($total1Lokasi, 2) }}</td>
                    @endforeach
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
                    @foreach ($lokasi_list as $lokasiId)
                        @php
                            $counterSection2 = 0;
                            $saldoLokasi3 = 0;
                            $saldoLokasi4 = 0;
                            foreach ($arus_kas as $akLoop) {
                                $skipTotalLoop = ($akLoop->super_sub == '1') || ($akLoop->super_sub != '0');
                                if ($akLoop->tipe == 'total_investasi') break;
                                if (!$skipTotalLoop && $akLoop->tipe != 'total_operasi') {
                                    $saldoLokasiTmp = 0;
                                    foreach ($akLoop->child as $childLoop) {
                                        $saldoLokasiTmp += $data_perlokasi[$lokasiId]['child_values'][$childLoop->rekening] ?? 0;
                                    }
                                    if ($counterSection2 == 0) $saldoLokasi3 = $saldoLokasiTmp;
                                    if ($counterSection2 == 1) $saldoLokasi4 = $saldoLokasiTmp;
                                    $counterSection2++;
                                }
                            }
                            $total2Lokasi = $saldoLokasi3 - $saldoLokasi4;
                        @endphp
                        <td align="right">{{ number_format($total2Lokasi, 2) }}</td>
                    @endforeach
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
                    @foreach ($lokasi_list as $lokasiId)
                        @php
                            $counterSection3 = 0;
                            $saldoLokasi5 = 0;
                            $saldoLokasi6 = 0;
                            foreach ($arus_kas as $akLoop) {
                                $skipTotalLoop = ($akLoop->super_sub == '1') || ($akLoop->super_sub != '0');
                                if ($akLoop->tipe == 'total_pendanaan') break;
                                if (!$skipTotalLoop && $akLoop->tipe != 'total_operasi' && $akLoop->tipe != 'total_investasi') {
                                    $saldoLokasiTmp = 0;
                                    foreach ($akLoop->child as $childLoop) {
                                        $saldoLokasiTmp += $data_perlokasi[$lokasiId]['child_values'][$childLoop->rekening] ?? 0;
                                    }
                                    if ($counterSection3 == 0) $saldoLokasi5 = $saldoLokasiTmp;
                                    if ($counterSection3 == 1) $saldoLokasi6 = $saldoLokasiTmp;
                                    $counterSection3++;
                                }
                            }
                            $total3Lokasi = $saldoLokasi5 - $saldoLokasi6;
                        @endphp
                        <td align="right">{{ number_format($total3Lokasi, 2) }}</td>
                    @endforeach
                    <td align="right">{{ number_format($total3, 2) }}</td>
                </tr>
            @endif

        @endforeach

                <tr>
            <td colspan="{{ 3 + count($lokasi_list) }}" style="padding: 0px !important;">
                <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
                    <tr style="background: rgb(128, 128, 128)">
                        <td width="5%" align="center">&nbsp;</td>
                        <td width="auto">Kenaikan (Penurunan) Kas</td>
                        @foreach ($lokasi_list as $lokasiId)
                            @php
                                $sArr = [];
                                $jS   = 0;
                                $t1L  = 0;
                                $t2L  = 0;
                                $t3L  = 0;
                                foreach ($arus_kas as $akL) {
                                    $skipL = ($akL->super_sub == '1') || ($akL->super_sub != '0');
                                    if (!$skipL) {
                                        $jS = 0;
                                        foreach ($akL->child as $chL) {
                                            $jS += $data_perlokasi[$lokasiId]['child_values'][$chL->rekening] ?? 0;
                                        }
                                        $sArr[] = $jS;
                                    }
                                    if ($akL->tipe == 'total_operasi') {
                                        $t1L = ($sArr[0] ?? 0) - (($sArr[1] ?? 0) + ($sArr[2] ?? 0));
                                    }
                                    if ($akL->tipe == 'total_investasi') {
                                        $t2L = ($sArr[3] ?? 0) - ($sArr[4] ?? 0);
                                    }
                                    if ($akL->tipe == 'total_pendanaan') {
                                        $t3L = ($sArr[5] ?? 0) - ($sArr[6] ?? 0);
                                    }
                                }
                                $kenaikanLokasi = $t1L + $t2L + $t3L;
                                $saldoAkhirLokasi = $kenaikanLokasi + ($data_perlokasi[$lokasiId]['saldo_bulan_lalu'] ?? 0);
                            @endphp
                            <td align="right">{{ number_format($kenaikanLokasi, 2) }}</td>
                        @endforeach
                        <td align="right">{{ number_format($total1 + $total2 + $total3, 2) }}</td>
                    </tr>
                    <tr style="background: rgb(128, 128, 128)">
                        <td align="center">&nbsp;</td>
                        <td>SALDO AKHIR KAS SETARA KAS</td>
                        @foreach ($lokasi_list as $lokasiId)
                            @php
                                $sArrF = [];
                                $jSF   = 0;
                                $t1F   = 0; $t2F = 0; $t3F = 0;
                                foreach ($arus_kas as $akF) {
                                    $skipF = ($akF->super_sub == '1') || ($akF->super_sub != '0');
                                    if (!$skipF) {
                                        $jSF = 0;
                                        foreach ($akF->child as $chF) {
                                            $jSF += $data_perlokasi[$lokasiId]['child_values'][$chF->rekening] ?? 0;
                                        }
                                        $sArrF[] = $jSF;
                                    }
                                    if ($akF->tipe == 'total_operasi')   $t1F = ($sArrF[0] ?? 0) - (($sArrF[1] ?? 0) + ($sArrF[2] ?? 0));
                                    if ($akF->tipe == 'total_investasi') $t2F = ($sArrF[3] ?? 0) - ($sArrF[4] ?? 0);
                                    if ($akF->tipe == 'total_pendanaan') $t3F = ($sArrF[5] ?? 0) - ($sArrF[6] ?? 0);
                                }
                                $saldoAkhirF = $t1F + $t2F + $t3F + ($data_perlokasi[$lokasiId]['saldo_bulan_lalu'] ?? 0);
                            @endphp
                            <td align="right">{{ number_format($saldoAkhirF, 2) }}</td>
                        @endforeach
                        <td align="right">{{ number_format($total1 + $total2 + $total3 + $saldo_bulan_lalu, 2) }}</td>
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
            </td>
        </tr>
    </table>
@endsection
