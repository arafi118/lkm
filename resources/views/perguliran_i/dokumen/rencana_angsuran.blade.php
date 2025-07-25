@php
    use App\Utils\Tanggal;
    $jumlah_angsuran = 0;

    if (Request::get('status') == 'P') {
        $alokasi = $pinkel->proposal;
        $tanggal = 'Tanggal Proposal';
        $tgl = $pinkel->tgl_proposal;
    }

    if (Request::get('status') == 'V') {
        $alokasi = $pinkel->verifikasi;
        $tanggal = 'Tanggal Verifikasi';
        $tgl = $pinkel->tgl_verifikasi;
    }

    if (Request::get('status') == 'W') {
        $alokasi = $pinkel->alokasi;
        $tanggal = 'Tanggal Cair';
        $tgl = $pinkel->tgl_cair;
    }

    if (Request::get('status') == 'A') {
        $alokasi = $pinkel->alokasi;
        $tanggal = 'Tanggal Cair';
        $tgl = $pinkel->tgl_cair;
    }

    $saldo_pokok = $alokasi;
    $alokasi_pinjaman = $alokasi;
    $saldo_jasa = $keuangan->pembulatan(($saldo_pokok * $pinkel->pros_jasa) / 100);

    $sum_pokok = 0;
    $sum_jasa = 0;

    $jenisAngsuran = 'Bulan';
    if (in_array($pinkel->sistem_angsuran, ['12', '25'])) {
        $jenisAngsuran = 'Minggu';
    }
@endphp

@extends('perguliran_i.dokumen.layout.base')

@section('content')
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr class="b">
            <td colspan="3" align="center">
                <div style="font-size: 18px;">
                    <b>RENCANA ANGSURAN</b>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="5"></td>
        </tr>
    </table>
    <table border="0" width="100%" align="center"cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr>
            <td width="90">Nama Calon Nasabah</td>
            <td width="5" align="center">:</td>
            <td>
                <b>{{ $pinkel->anggota->namadepan }} </b>
            </td>
            <td width="90">Jangka Waktu</td>
            <td width="5" align="center">:</td>
            <td>
                <b>{{ $pinkel->jangka }} {{ $jenisAngsuran }}</b>
            </td>
        </tr>
        <tr>
            <td>No Register</td>
            <td align="center">:</td>
            <td>
                <b>{{ $pinkel->id }}</b>
            </td>
            <td>Sistem Angsuran</td>
            <td align="center">:</td>
            <td>
                <b>{{ $pinkel->sis_pokok->nama_sistem }} {{ round($pinkel->jangka / $pinkel->sis_pokok->sistem) }} Kali</b>
            </td>
        </tr>
        <tr>
            <td>{{ $tanggal }}</td>
            <td align="center">:</td>
            <td>
                <b>{{ Tanggal::tglLatin($tgl) }}</b>
            </td>
            <td>Jenis Jasa</td>
            <td align="center">:</td>
            <td>
                <b>{{ $pinkel->jasa->nama_jj }}</b>
            </td>
        </tr>
        <tr>
            <td>Nilai Kredit</td>
            <td align="center">:</td>
            <td>
                <b>Rp. {{ number_format($alokasi_pinjaman) }}</b>
            </td>
            <td>Prosentase Jasa</td>
            <td align="center">:</td>
            <td>
                <b>{{ round($pinkel->pros_jasa / $pinkel->jangka, 2) }}% per {{ $jenisAngsuran }}</b>
            </td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
    </table>

    <table border="0" width="100%" align="center"cellspacing="0" cellpadding="0"
        style="font-size: 11px; table-layout: fixed;">
        <tr style="background: rgb(232, 232, 232)">
            <th class="l t b" height="20" width="5%" align="center">Ke</th>
            <th class="l t b" width="13%" align="center">Tanggal</th>
            <th class="l t b" width="13%" align="center">Pokok</th>
            <th class="l t b" width="13%" align="center">Jasa</th>
            <th class="l t b" width="15%" align="center">Jumlah</th>
            <th class="l t b" width="15%" align="center">Total Target</th>
            <th class="l t b" width="13%" align="center">Saldo Pokok</th>
            <th class="l t b r" width="13%" align="center">Saldo Jasa</th>
        </tr>
        @foreach ($rencana as $ra)
            @php
                $wajib_angsur = $ra->wajib_pokok + $ra->wajib_jasa;
                $jumlah_angsuran += $wajib_angsur;
                $saldo_pokok -= $ra->wajib_pokok;
                $saldo_jasa -= $ra->wajib_jasa;

                if ($pinkel->jenis_jasa == '2') {
                    $saldo_jasa = ($saldo_pokok * $pinkel->pros_jasa) / 100;
                }

                $sum_pokok += $ra->wajib_pokok;
                $sum_jasa += $ra->wajib_jasa;
            @endphp
            <tr>
                <td class="l" align="center">{{ $ra->angsuran_ke }}</td>
                <td class="l" align="center">{{ Tanggal::tglIndo($ra->jatuh_tempo) }}</td>
                <td class="l" align="right">{{ number_format($ra->wajib_pokok) }}</td>
                <td class="l" align="right">{{ number_format($ra->wajib_jasa) }}</td>
                <td class="l" align="right">{{ number_format($wajib_angsur) }}</td>
                <td class="l" align="right">{{ number_format($jumlah_angsuran) }}</td>
                <td class="l" align="right">{{ number_format($saldo_pokok) }}</td>
                <td class="l r" align="right">{{ number_format($saldo_jasa) }}</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="8" style="padding: 0px !important;">
                <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0"
                    style="font-size: 11px; table-layout: fixed;">
                    <tr style="font-weight: bold;">
                        <td class="l t b" width="18%" height="15" align="center" colspan="2">Jumlah</td>
                        <td class="l t b" width="13%" align="right">{{ number_format($sum_pokok) }}</td>
                        <td class="l t b" width="13%" align="right">
                            {{ number_format($sum_jasa) }}
                        </td>
                        <td class="l t b" width="15%" align="right">{{ number_format($jumlah_angsuran) }}</td>
                        <td class="l t b" width="15%" align="right">{{ number_format($jumlah_angsuran) }}</td>
                        <td class="l t b" width="13%" align="right">{{ number_format($saldo_pokok) }}</td>
                        <td class="l t b r" width="13%" align="right">{{ number_format($saldo_jasa) }}</td>
                    </tr>
                </table>
                <br><br>
                <table class="p" border="0" width="100%" cellspacing="0" cellpadding="0"
                    style="font-size: 11px;">

                    <tr>
                        <td width="55%">&nbsp;</td>
                        <td align="center">
                            {{ $kec->nama_kec }}, {{ Tanggal::tglLatin($tgl) }}
                        </td>
                    </tr>

                    <tr>
                        <td width="55%">&nbsp;</td>
                        <td align="center">
                            Nasabah
                        </td>

                    </tr>
                    <tr>
                        <td width="55%">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="55%">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="55%">&nbsp;</td>
                        <td align="center">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="55%">&nbsp;</td>
                        <td align="center">
                            <b>{{ $pinkel->anggota->namadepan }}</b>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
