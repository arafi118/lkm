@extends('pelaporan.layout.base')

@section('content')
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr>
            <td colspan="3" align="center">
                <div style="font-size: 18px;">
                    <b>LAPORAN PERUBAHAN MODAL</b>
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

    <table width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr style="background: rgb(74, 74, 74); color: #fff;">
            <th width="5%" height="20">No</th>
            <th width="55%">Rekening Modal</th>
            <th width="20%">&nbsp;</th>
            <th width="20%">&nbsp;</th>
        </tr>

        @php
            $group = '';
            $section = '';

            $nomor = 1;
            $jumlah_saldo = 0;
        @endphp
        @foreach ($rekening[0] as $key_rek => $rek)
            @php
                $section = explode(' ', $rek->nama_akun)[0];
            @endphp

            @if ($loop->iteration > 1 && $section != $group && $group != '')
                <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                    <td align="right" colspan="3" height="15">
                        <b>Jumlah</b>
                    </td>
                    <td align="right">
                        <b>{{ number_format($jumlah_saldo, 2) }}</b>
                    </td>
                </tr>

                @php
                    $nomor = 1;
                    $jumlah_saldo = 0;
                @endphp
            @endif

            @php
                $child = [];
                $sumSaldoModal = 0;
                foreach ($kecamatan as $kec) {
                    $rekKecamatan = $rekening[$kec->id][$key_rek];

                    if ($rekKecamatan->kode_akun == '3.2.02.01') {
                        $saldoKecamatan = $laba_rugi[$kec->id];
                    } else {
                        $saldoKecamatan = $keuangan->komSaldo($rekKecamatan);
                    }

                    $child[] = [
                        'nama' => $rek->nama_akun . ' ' . $kec->nama_kec,
                        'saldo' => $saldoKecamatan,
                    ];
                    $sumSaldoModal += $saldoKecamatan;
                }
            @endphp
            <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                <td align="center">{{ $nomor++ }}</td>
                <td>{{ $rek->nama_akun }}</td>
                <td></td>
                <td align="right">{{ number_format($sumSaldoModal, 2) }}</td>
            </tr>

            @foreach ($child as $ch)
                @php
                    $bg = 'rgb(230, 230, 230)';
                    if ($loop->iteration % 2 == 0) {
                        $bg = 'rgba(255, 255, 255)';
                    }
                @endphp
                <tr style="background: {{ $bg }};">
                    <td align="center"></td>
                    <td>{{ $ch['nama'] }}</td>
                    <td align="right">{{ number_format($ch['saldo'], 2) }}</td>
                    <td>&nbsp;</td>
                </tr>
            @endforeach

            @php
                $group = $section;
            @endphp
        @endforeach

        <tr style="background: rgb(167, 167, 167); font-weight: bold;">
            <td align="right" colspan="3" height="15">
                <b>Jumlah</b>
            </td>
            <td align="right">
                <b>{{ number_format($jumlah_saldo, 2) }}</b>
            </td>
        </tr>

        @php
            $group = '';
            $section = '';

            $nomor = 1;
            $jumlah_saldo = 0;
        @endphp
        @foreach ($rekening2[0] as $key_rek => $rek)
            @php
                $child = [];
                $sumSaldoModal = 0;
                foreach ($kecamatan as $kec) {
                    $rekKecamatan = $rekening2[$kec->id][$key_rek];

                    if ($rekKecamatan->kode_akun == '3.2.02.01') {
                        $saldoKecamatan = $laba_rugi[$kec->id];
                    } else {
                        $saldoKecamatan = $keuangan->komSaldo($rekKecamatan);
                    }

                    $child[] = [
                        'nama' => $rek->nama_akun . ' ' . $kec->nama_kec,
                        'saldo' => $saldoKecamatan,
                    ];
                    $sumSaldoModal += $saldoKecamatan;
                }
            @endphp
            <tr style="background: rgb(167, 167, 167); font-weight: bold;">
                <td align="center">{{ $nomor++ }}</td>
                <td>{{ $rek->nama_akun }}</td>
                <td></td>
                <td align="right">{{ number_format($sumSaldoModal, 2) }}</td>
            </tr>

            @foreach ($child as $ch)
                @php
                    $bg = 'rgb(230, 230, 230)';
                    if ($loop->iteration % 2 == 0) {
                        $bg = 'rgba(255, 255, 255)';
                    }
                @endphp
                <tr style="background: {{ $bg }};">
                    <td align="center"></td>
                    <td>{{ $ch['nama'] }}</td>
                    <td align="right">{{ number_format($ch['saldo'], 2) }}</td>
                    <td>&nbsp;</td>
                </tr>
            @endforeach
        @endforeach

        <tr style="background: rgb(167, 167, 167); font-weight: bold;">
            <td align="right" colspan="3" height="15">
                <b>Jumlah</b>
            </td>
            <td align="right">
                <b>{{ number_format($jumlah_saldo, 2) }}</b>
            </td>
        </tr>

    </table>
@endsection
