@php
    use App\Utils\Tanggal;
@endphp

@extends('pelaporan.layout.base')

@section('content')
    @php
        $data_total         = [];
        $data_rek_beban_ops = [];

        $kalkulasiMap = [
            'Sisa Hasil Usaha Operasional'   => function($d) {
                $pend = $d['Pendapatan Operasional']   ?? ['bulan_lalu'=>0,'bulan_ini'=>0,'sd_bulan_ini'=>0];
                $beban = $d['Beban Operasional']       ?? ['bulan_lalu'=>0,'bulan_ini'=>0,'sd_bulan_ini'=>0];
                return [
                    'bulan_lalu'   => $pend['bulan_lalu']   - $beban['bulan_lalu'],
                    'bulan_ini'    => $pend['bulan_ini']    - $beban['bulan_ini'],
                    'sd_bulan_ini' => $pend['sd_bulan_ini'] - $beban['sd_bulan_ini'],
                ];
            },
            'Sisa Hasil Usaha Sebelum Pajak' => function($d) {
                $shu  = $d['Sisa Hasil Usaha Operasional'] ?? ['bulan_lalu'=>0,'bulan_ini'=>0,'sd_bulan_ini'=>0];
                $pend = $d['Pendapatan Non Operasional']   ?? ['bulan_lalu'=>0,'bulan_ini'=>0,'sd_bulan_ini'=>0];
                $beban = $d['Beban Non Operasional']       ?? ['bulan_lalu'=>0,'bulan_ini'=>0,'sd_bulan_ini'=>0];
                return [
                    'bulan_lalu'   => $shu['bulan_lalu']   + ($pend['bulan_lalu']   - $beban['bulan_lalu']),
                    'bulan_ini'    => $shu['bulan_ini']    + ($pend['bulan_ini']    - $beban['bulan_ini']),
                    'sd_bulan_ini' => $shu['sd_bulan_ini'] + ($pend['sd_bulan_ini'] - $beban['sd_bulan_ini']),
                ];
            },
            'Sisa Hasil Usaha Tahun Berjalan' => function($d) {
                $shu   = $d['Sisa Hasil Usaha Sebelum Pajak'] ?? ['bulan_lalu'=>0,'bulan_ini'=>0,'sd_bulan_ini'=>0];
                $pajak = $d['Taksiran Pajak Penghasilan']     ?? ['bulan_lalu'=>0,'bulan_ini'=>0,'sd_bulan_ini'=>0];
                return [
                    'bulan_lalu'   => $shu['bulan_lalu']   - $pajak['bulan_lalu'],
                    'bulan_ini'    => $shu['bulan_ini']    - $pajak['bulan_ini'],
                    'sd_bulan_ini' => $shu['sd_bulan_ini'] - $pajak['sd_bulan_ini'],
                ];
            },
        ];

        $headerOnly = [
            'Pendapatan Operasional',
            'Beban Operasional',
        ];

        $core_number = 1;
    @endphp

    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr>
            <td style="border: 1px solid;" align="center" height="30" colspan="5" class="style3 bottom" style="font-size: 15px;">
                <div>{{ $kec->nama_lembaga_long }}</div>
                <div>SANDI LKM {{ $kec->sandi_lkm }}</div>
                <div>LAPORAN KINERJA KEUANGAN</div>
                <div>Untuk Periode Yang Berakhir Pada Tanggal {{ Tanggal::tglLatin($tgl_kondisi) }}</div>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>

    <table border="0" width="96%" cellspacing="0" cellpadding="0" style="font-size: 11px; border-color: black;">
        <thead>
            <tr style="background: rgb(232, 232, 232); font-weight: bold; font-size: 12px;">
                <th height="20">No</th>
                <th>Nama Akun</th>
                <th>Kode Akun</th>
                <th>SD. Bulan Lalu</th>
                <th>Bulan Ini</th>
                <th>SD. Bulan Ini</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($rekening_ojk as $rek_ojk)
                @php
                    $nama_akun          = trim($rek_ojk->nama_akun ?? '');
                    $isKalkulasi        = isset($kalkulasiMap[$nama_akun]);
                    $isHeaderOnly       = in_array($nama_akun, $headerOnly);

                    $total_bulan_lalu   = 0;
                    $total_bulan_ini    = 0;
                    $total_sd_bulan_ini = 0;

                    $saldo_bulan_lalu   = 0;
                    $saldo_bulan_ini    = 0;
                    $saldo_sd_bulan_ini = 0;
                @endphp

                @foreach ($rek_ojk->child as $rek_child)
                    @php
                        if (strlen($rek_child->kode) != '0') {
                            continue;
                        }

                        $bulan_lalu   = 0;
                        $bulan_ini    = 0;
                        $sd_bulan_ini = 0;

                        if (substr($rek_child->rekening, -2) != '00') {
                            foreach ($rek_child->rek as $rek) {
                                $data_saldo = $keuangan->komSaldoLR($rek, $tgl_kondisi);
                                $bulan_lalu   += $data_saldo['bulan_lalu'];
                                $bulan_ini    += $data_saldo['sd_bulan_ini'] - $data_saldo['bulan_lalu'];
                                $sd_bulan_ini += $data_saldo['sd_bulan_ini'];
                                $data_rek_beban_ops[] = $rek->kode_akun;
                            }
                        } else {
                            if ($rek_child->akun3->isNotEmpty()) {
                                foreach ($rek_child->akun3 as $akun3) {
                                    foreach ($akun3->rek as $rek) {
                                        $data_saldo = $keuangan->komSaldoLR($rek, $tgl_kondisi);
                                        $bulan_lalu   += $data_saldo['bulan_lalu'];
                                        $bulan_ini    += $data_saldo['sd_bulan_ini'] - $data_saldo['bulan_lalu'];
                                        $sd_bulan_ini += $data_saldo['sd_bulan_ini'];
                                        $data_rek_beban_ops[] = $rek->kode_akun;
                                    }
                                }
                            } else {
                                foreach ($rek_child->rek as $rek) {
                                    $data_saldo = $keuangan->komSaldoLR($rek, $tgl_kondisi);
                                    $bulan_lalu   += $data_saldo['bulan_lalu'];
                                    $bulan_ini    += $data_saldo['sd_bulan_ini'] - $data_saldo['bulan_lalu'];
                                    $sd_bulan_ini += $data_saldo['sd_bulan_ini'];
                                    $data_rek_beban_ops[] = $rek->kode_akun;
                                }
                            }
                        }

                        $saldo_bulan_lalu   += $bulan_lalu;
                        $saldo_bulan_ini    += $bulan_ini;
                        $saldo_sd_bulan_ini += $sd_bulan_ini;
                    @endphp
                @endforeach

                @php
                    if ($isKalkulasi) {
                        $hasil = $kalkulasiMap[$nama_akun]($data_total);
                        $saldo_bulan_lalu   = $hasil['bulan_lalu'];
                        $saldo_bulan_ini    = $hasil['bulan_ini'];
                        $saldo_sd_bulan_ini = $hasil['sd_bulan_ini'];
                    }

                    $data_total[$nama_akun] = [
                        'bulan_lalu'   => $saldo_bulan_lalu,
                        'bulan_ini'    => $saldo_bulan_ini,
                        'sd_bulan_ini' => $saldo_sd_bulan_ini,
                    ];

                    $isBold   = !$isHeaderOnly;
                    $this_bg  = $isHeaderOnly ? 'rgb(230, 230, 230)' : 'rgb(200, 200, 200)';

                    if ($nama_akun === 'Beban Non Operasional') {
                        $this_bg = 'rgb(255, 255, 255)';
                    }

                    $style = $isBold
                        ? 'style="font-weight: bold; background: ' . $this_bg . '; text-transform: uppercase;"'
                        : 'style="background: ' . $this_bg . ';"';
                @endphp

                <tr {!! $style !!}>
                    <td align="center">{{ $core_number }}</td>
                    <td>{{ $rek_ojk->nama_akun }}</td>
                    @if ($isHeaderOnly)
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    @else
                        <td align="center">{{ $rek_ojk->kode }}</td>
                        <td align="right">{{ number_format($saldo_bulan_lalu, 2) }}</td>
                        <td align="right">{{ number_format($saldo_bulan_ini, 2) }}</td>
                        <td align="right">{{ number_format($saldo_sd_bulan_ini, 2) }}</td>
                    @endif
                </tr>

                @php $point_number = 1; @endphp

                @foreach ($rek_ojk->child as $rek_child)
                    @php
                        if (strlen($rek_child->kode) < 1) {
                            continue;
                        }

                        $bulan_lalu   = 0;
                        $bulan_ini    = 0;
                        $sd_bulan_ini = 0;

                        foreach ($rek_child->child as $child) {
                            if (substr($child->rekening, -2) != '00') {
                                foreach ($child->rek as $rek) {
                                    $data_saldo = $keuangan->komSaldoLR($rek, $tgl_kondisi);
                                    $bulan_lalu   += $data_saldo['bulan_lalu'];
                                    $bulan_ini    += $data_saldo['sd_bulan_ini'] - $data_saldo['bulan_lalu'];
                                    $sd_bulan_ini += $data_saldo['sd_bulan_ini'];
                                    $data_rek_beban_ops[] = $rek->kode_akun;
                                }
                            } else {
                                foreach ($child->akun3 as $akun3) {
                                    foreach ($akun3->rek as $rek) {
                                        $data_saldo = $keuangan->komSaldoLR($rek, $tgl_kondisi);
                                        $bulan_lalu   += $data_saldo['bulan_lalu'];
                                        $bulan_ini    += $data_saldo['sd_bulan_ini'] - $data_saldo['bulan_lalu'];
                                        $sd_bulan_ini += $data_saldo['sd_bulan_ini'];
                                        $data_rek_beban_ops[] = $rek->kode_akun;
                                    }
                                }
                            }
                        }
                    @endphp

                    @php
                        $bg = ($point_number % 2 == 0) ? 'rgb(255, 255, 255)' : 'rgb(230, 230, 230)';
                    @endphp

                    <tr style="background: {{ $bg }}">
                        <td align="center">{{ $core_number }}.{{ $point_number }}</td>
                        <td>{{ $rek_child->nama_akun }}</td>
                        <td align="center">{{ $rek_child->kode }}</td>
                        <td align="right">{{ number_format($bulan_lalu, 2) }}</td>
                        <td align="right">{{ number_format($bulan_ini, 2) }}</td>
                        <td align="right">{{ number_format($sd_bulan_ini, 2) }}</td>
                    </tr>

                    @php
                        $point_number++;
                        $total_bulan_lalu   += $bulan_lalu;
                        $total_bulan_ini    += $bulan_ini;
                        $total_sd_bulan_ini += $sd_bulan_ini;
                    @endphp
                @endforeach

                @if ($isHeaderOnly)
                    <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                        <th height="14" colspan="3">Jumlah {{ $rek_ojk->nama_akun }}</th>
                        <th align="right">{{ number_format($total_bulan_lalu, 2) }}</th>
                        <th align="right">{{ number_format($total_bulan_ini, 2) }}</th>
                        <th align="right">{{ number_format($total_sd_bulan_ini, 2) }}</th>
                    </tr>

                    @php
                        $data_total[$nama_akun] = [
                            'bulan_lalu'   => $total_bulan_lalu,
                            'bulan_ini'    => $total_bulan_ini,
                            'sd_bulan_ini' => $total_sd_bulan_ini,
                        ];
                    @endphp
                @endif

                @php $core_number++; @endphp
            @endforeach

        </tbody>
    </table>

    <table class="p" border="0" align="center" width="96%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
        <tr>
            <td colspan="14">
                <div style="margin-top: 14px;"></div>
                {!! json_decode(str_replace('{tanggal}', $tanggal_kondisi, $kec->ttd->tanda_tangan_pelaporan), true) !!}
            </td>
        </tr>
    </table>

@endsection
