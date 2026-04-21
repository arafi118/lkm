@extends('pelaporan.layout.base')

@section('content')
    @php
        $data_total       = [];
        $data_total_saldo = [];

        $sectionMap = [
            '110' => 'Aset', '121' => 'Aset', '122' => 'Aset', '123' => 'Aset',
            '131' => 'Aset', '132' => 'Aset', '133' => 'Aset',
            '140' => 'Aset', '141' => 'Aset', '150' => 'Aset',

            '210' => 'Liabilitas', '221' => 'Liabilitas', '222' => 'Liabilitas',
            '230' => 'Liabilitas', '240' => 'Liabilitas',

            '311' => 'Ekuitas', '312' => 'Ekuitas', '320' => 'Ekuitas',
            '330' => 'Ekuitas', '331' => 'Ekuitas', '332' => 'Ekuitas',
            '341' => 'Ekuitas', '342' => 'Ekuitas',
        ];

        $getSection = function($rek_ojk) use ($sectionMap) {
            $kode = trim($rek_ojk->kode ?? '');
            if ($kode !== '' && isset($sectionMap[$kode])) {
                return $sectionMap[$kode];
            }
            $nama = strtolower($rek_ojk->nama_akun ?? '');
            foreach (['utang', 'simpanan', 'pinjaman yang diterima', 'liabilitas'] as $kw) {
                if (str_contains($nama, $kw)) return 'Liabilitas';
            }
            foreach (['modal', 'cadangan', 'saldo laba', 'hibah'] as $kw) {
                if (str_contains($nama, $kw)) return 'Ekuitas';
            }
            return 'Aset';
        };

        $currentSection = null;
        $core_number    = 1;
    @endphp

    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr>
            <td align="center" height="30" colspan="4" class="style3 bottom" style="font-size: 15px;">
                <br><b>{{ $kec->nama_lembaga_long }}</b>
                <br><b>SANDI LKM {{ $kec->sandi_lkm }}</b>
                <br><b>LAPORAN POSISI KEUANGAN</b>
                <br><b>{{ strtoupper($sub_judul) }}</b>
            </td>
        </tr>
    </table>

    <table border="0" width="96%" cellspacing="0" cellpadding="0" style="font-size: 11px; border-color: black;">
        <thead>
            <tr style="background: rgb(232, 232, 232); font-weight: bold; font-size: 12px;">
                <th height="20">No</th>
                <th>Nama Akun</th>
                <th>Kode Akun</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($rekening_ojk as $rek_ojk)
                @php
                    $thisSection    = $getSection($rek_ojk);
                    $sectionChanged = ($thisSection !== $currentSection);

                    if ($sectionChanged) {
                        $currentSection = $thisSection;
                        $data_total     = [];
                    }

                    $total_bulan_lalu   = 0;
                    $total_bulan_ini    = 0;
                    $total_sd_bulan_ini = 0;

                    $saldo_bulan_lalu   = 0;
                    $saldo_bulan_ini    = 0;
                    $saldo_sd_bulan_ini = 0;
                @endphp

                @if ($sectionChanged)
                    <tr style="background: rgb(170, 170, 170); font-weight: bold;">
                        <td></td>
                        <td><strong>{{ $currentSection }}</strong></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif

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
                                $data_saldo    = $keuangan->komSaldoLR($rek, $tgl_kondisi);
                                $bulan_lalu   += $data_saldo['bulan_lalu'];
                                $bulan_ini    += $data_saldo['sd_bulan_ini'] - $data_saldo['bulan_lalu'];
                                $sd_bulan_ini += $data_saldo['sd_bulan_ini'];
                            }
                        } else {
                            foreach ($rek_child->akun3 as $akun3) {
                                foreach ($akun3->rek as $rek) {
                                    $data_saldo    = $keuangan->komSaldoLR($rek, $tgl_kondisi);
                                    $bulan_lalu   += $data_saldo['bulan_lalu'];
                                    $bulan_ini    += $data_saldo['sd_bulan_ini'] - $data_saldo['bulan_lalu'];
                                    $sd_bulan_ini += $data_saldo['sd_bulan_ini'];
                                }
                            }
                        }

                        $saldo_bulan_lalu   += $bulan_lalu;
                        $saldo_bulan_ini    += $bulan_ini;
                        $saldo_sd_bulan_ini += $sd_bulan_ini;
                    @endphp
                @endforeach

                @php
                    $data_total[$core_number] = [
                        'bulan_lalu'   => $saldo_bulan_lalu,
                        'bulan_ini'    => $saldo_bulan_ini,
                        'sd_bulan_ini' => $saldo_sd_bulan_ini,
                    ];
                @endphp

                <tr style="background: rgb(209, 208, 208); font-weight: bold;">
                    <td height="4" align="center">{{ $core_number }}</td>
                    <td>{{ $rek_ojk->nama_akun }}</td>
                    <td align="center">{{ $rek_ojk->kode }}</td>
                    <td align="right">
                        @if ($saldo_sd_bulan_ini < 0)
                            ({{ number_format(abs($saldo_sd_bulan_ini * -1)) }})
                        @else
                            {{ number_format($saldo_sd_bulan_ini) }}
                        @endif
                    </td>
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
                                    $data_saldo    = $keuangan->komSaldoLR($rek, $tgl_kondisi);
                                    if ($rek_child->kode == '342') {
                                        $data_saldo['bulan_lalu']   = 0;
                                        $data_saldo['sd_bulan_ini'] = $keuangan->laba_rugi($tgl_kondisi);
                                    }
                                    $bulan_lalu   += $data_saldo['bulan_lalu'];
                                    $bulan_ini    += $data_saldo['sd_bulan_ini'] - $data_saldo['bulan_lalu'];
                                    $sd_bulan_ini += $data_saldo['sd_bulan_ini'];
                                }
                            } else {
                                foreach ($child->akun3 as $akun3) {
                                    foreach ($akun3->rek as $rek) {
                                        $data_saldo    = $keuangan->komSaldoLR($rek, $tgl_kondisi);
                                        $bulan_lalu   += $data_saldo['bulan_lalu'];
                                        $bulan_ini    += $data_saldo['sd_bulan_ini'] - $data_saldo['bulan_lalu'];
                                        $sd_bulan_ini += $data_saldo['sd_bulan_ini'];
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
                        <td align="right">
                            @if ($sd_bulan_ini < 0)
                                ({{ number_format(abs($sd_bulan_ini * -1), 2) }})
                            @else
                                {{ number_format($sd_bulan_ini, 2) }}
                            @endif
                        </td>
                    </tr>

                    @php
                        $point_number++;
                        $total_bulan_lalu   += $bulan_lalu;
                        $total_bulan_ini    += $bulan_ini;
                        $total_sd_bulan_ini += $sd_bulan_ini;

                        $data_total[$core_number]['bulan_lalu']   += $bulan_lalu;
                        $data_total[$core_number]['bulan_ini']    += $bulan_ini;
                        $data_total[$core_number]['sd_bulan_ini'] += $sd_bulan_ini;
                    @endphp
                @endforeach

                @php
                    $rekening_arr   = $rekening_ojk->values();
                    $next_item      = $rekening_arr[$loop->index + 1] ?? null;
                    $nextSection    = $next_item ? $getSection($next_item) : null;
                    $isEndOfSection = $loop->last || ($nextSection !== null && $nextSection !== $currentSection);
                @endphp

                @if ($isEndOfSection)
                    @php
                        $total_saldo = 0;
                        foreach ($data_total as $dt) {
                            $total_saldo += $dt['sd_bulan_ini'];
                        }
                        $data_total_saldo[$currentSection] = $data_total;
                    @endphp

                    <tr style="background: rgb(141, 139, 139); font-weight: bold;">
                        <th colspan="3">Jumlah {{ $currentSection }}</th>
                        <th align="right">
                            @if ($total_saldo < 0)
                                ({{ number_format(abs($total_saldo * -1), 2) }})
                            @else
                                {{ number_format($total_saldo, 2) }}
                            @endif
                        </th>
                    </tr>
                @endif

                @php $core_number++; @endphp
            @endforeach

            @php
                $aset       = array_values($data_total_saldo['Aset']       ?? []);
                $liabilitas = array_values($data_total_saldo['Liabilitas'] ?? []);
                $ekuitas    = array_values($data_total_saldo['Ekuitas']    ?? []);

                $saldo_aset       = array_sum(array_column($aset,       'sd_bulan_ini'));
                $saldo_liabilitas = array_sum(array_column($liabilitas, 'sd_bulan_ini'));
                $saldo_ekuitas    = array_sum(array_column($ekuitas,    'sd_bulan_ini'));

                $kas_dan_setara    = ($aset[0]['sd_bulan_ini'] ?? 0) + ($aset[1]['sd_bulan_ini'] ?? 0);
                $liabilitas_lancar = $saldo_liabilitas;

                $rasio_likuiditas   = $liabilitas_lancar > 0 ? ($kas_dan_setara / $liabilitas_lancar) * 100 : 0;
                $rasio_solvabilitas = $saldo_liabilitas  > 0 ? ($saldo_aset / $saldo_liabilitas) * 100 : 0;
            @endphp

            <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                <th colspan="3">Jumlah Liabilitas Dan Ekuitas</th>
                <th class="top left bottom" align="right">
                    {{ number_format($saldo_liabilitas + $saldo_ekuitas, 2) }}
                </th>
            </tr>

            <tr style="background: rgb(193, 193, 193); font-weight: bold;">
                <th class="left top bottom" align="center"></th>
                <th class="top left bottom" align="left">&nbsp; Rasio Likuiditas</th>
                <th class="top left bottom" align="right">&nbsp;</th>
                <th class="top left bottom right" align="right">{{ number_format($rasio_likuiditas, 2) }}%</th>
            </tr>

            <tr style="background: rgb(230, 230, 230);">
                <td class="left bottom" align="center">&nbsp; 1.</td>
                <td class="left bottom" align="left">&nbsp; Kas dan Setara Kas</td>
                <td class="left bottom" align="right">&nbsp;</td>
                <td class="left bottom right" align="right">{{ number_format($kas_dan_setara, 2) }}</td>
            </tr>
            <tr>
                <td class="left bottom" align="center">&nbsp; 2.</td>
                <td class="left bottom" align="left">&nbsp; Liabilitas Lancar</td>
                <td class="left bottom" align="right">&nbsp;</td>
                <td class="left bottom right" align="right">{{ number_format($liabilitas_lancar, 2) }}</td>
            </tr>

            <tr style="background: rgb(193, 193, 193); font-weight: bold;">
                <th class="left top bottom" align="center"></th>
                <th class="top left bottom" align="left">&nbsp; Rasio Solvabilitas</th>
                <th class="top left bottom" align="right">&nbsp;</th>
                <th class="top left bottom right" align="right">{{ number_format($rasio_solvabilitas, 2) }}%</th>
            </tr>

            <tr style="background: rgb(230, 230, 230);">
                <td class="left bottom" align="center">&nbsp; 1.</td>
                <td class="left bottom" align="left">&nbsp; Total Aset</td>
                <td class="left bottom" align="right">&nbsp;</td>
                <td class="left bottom right" align="right">{{ number_format($saldo_aset, 2) }}</td>
            </tr>
            <tr style="background: rgb(185, 184, 184); font-weight: bold;">
                <td class="left bottom" align="center">&nbsp; 2.</td>
                <td class="left bottom" align="left">&nbsp; Total Liabilitas</td>
                <td class="left bottom" align="right">&nbsp;</td>
                <td class="left bottom right" align="right">{{ number_format($saldo_liabilitas, 2) }}</td>
            </tr>

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
