@php
    $array_saldo = [];
    $j_saldo = 0;
    $total1 = 0;
    $total2 = 0;
    $total3 = 0;
@endphp

@extends('pelaporan.layout.base')

@section('content')
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr>
            <td colspan="3" align="center">
                <div style="font-size: 18px;">
                    <b>ARUS KAS</b>
                </div>
                <div style="font-size: 16px;">
                    <b>{{ strtoupper($sub_judul) }}</b>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="5"></td>
        </tr>

    </table>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr style="background: rgb(200, 200, 200)">
            <th colspan="2">Nama Akun</th>
            <th>Jumlah</th>
        </tr>

        @foreach ($arus_kas as $ak)
            @php
                $dot = substr($ak->nama_akun, 1, 1);
                if ($dot == '.') {
                    $bg = '150, 150, 150';
                } else {
                    $bg = '128, 128, 128';
                }

                $section = false;

                // Deteksi tipe baris berdasarkan kolom `tipe` dan `super_sub`
                $isSaldoAwal     = $ak->super_sub == '1';
                $isHeaderSection = $ak->super_sub != '0';   // PENGELUARAN, INVESTASI, PENDANAAN, dll
                $isTotalOperasi  = $ak->tipe == 'total_operasi';
                $isTotalInvestasi= $ak->tipe == 'total_investasi';
                $isTotalPendanaan= $ak->tipe == 'total_pendanaan';
                $isTtd           = $ak->tipe == 'ttd';

                // Baris yang skip total (tidak punya child akumulasi)
                $skipTotal = $isSaldoAwal || $isHeaderSection;
            @endphp
            <tr>
                <td colspan="3" height="3"></td>
            </tr>
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
                    $arus_kas = $keuangan->arus_kas($child->rekening, $tgl_kondisi, $jenis);
                    if ($loop->iteration % 2 == 0) {
                        $bg = '240, 240, 240';
                    } else {
                        $bg = '200, 200, 200';
                    }

                    $section = true;
                    $j_saldo += $arus_kas;
                @endphp
                <tr style="background: rgb({{ $bg }})">
                    <td align="center">&nbsp;</td>
                    <td>{{ $child->nama_akun }}</td>
                    <td align="right">{{ number_format($arus_kas, 2) }}</td>
                </tr>
            @endforeach

            {{-- Tampilkan baris total jumlah per sub-section --}}
            @if (!$skipTotal)
                @if ($isTtd)
                    <tr>
                        <td colspan="3" style="padding: 0px !important;">
                            <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0"
                                style="font-size: 11px;">
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

            {{-- Kas Bersih Operasi: muncul setelah total_operasi --}}
            @if ($isTotalOperasi)
                @php
                    // index 0 = A. Penerimaan Operasi
                    // index 1 = B. Pencairan Piutang
                    // index 2 = C. Pengeluaran Operasi
                    $total1 = ($array_saldo[0] ?? 0) - (($array_saldo[1] ?? 0) + ($array_saldo[2] ?? 0));
                @endphp
                <tr style="background: rgb(128, 128, 128)">
                    <td align="center">&nbsp;</td>
                    <td>Kas Bersih yang diperoleh dari aktivitas Operasi (A-B-C)</td>
                    <td align="right">{{ number_format($total1, 2) }}</td>
                </tr>
            @endif

            {{-- Kas Bersih Investasi: muncul setelah total_investasi --}}
            @if ($isTotalInvestasi)
                @php
                    // index 3 = A. Penerimaan Investasi
                    // index 4 = B. Pengeluaran Investasi
                    $total2 = ($array_saldo[3] ?? 0) - ($array_saldo[4] ?? 0);
                @endphp
                <tr style="background: rgb(128, 128, 128)">
                    <td align="center">&nbsp;</td>
                    <td>Kas Bersih yang diperoleh dari aktivitas Investasi (A-B)</td>
                    <td align="right">{{ number_format($total2, 2) }}</td>
                </tr>
            @endif

            {{-- Kas Bersih Pendanaan: muncul setelah total_pendanaan --}}
            @if ($isTotalPendanaan)
                @php
                    // index 5 = A. Penerimaan Pendanaan
                    // index 6 = B. Pengeluaran Pendanaan
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
                <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0"
                    style="font-size: 11px;">
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
@endsection
