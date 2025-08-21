@php
    use App\Utils\Tanggal;
@endphp

@extends('perguliran_i.dokumen.layout.base')

@section('content')
    <style>
        .break {
            page-break-after: always;
        }
    </style>
    @foreach ($pinjaman as $pinj)
        @php
            $waktu = date('H:i');
            $tempat = 'Kantor DBM';

            $wt_cair = explode('_', $pinj->pinkel->wt_cair);
            if (count($wt_cair) == 1) {
                $waktu = $wt_cair[0];
            }

            if (count($wt_cair) == 2) {
                $waktu = $wt_cair[0];
                $tempat = $wt_cair[1];
            }
        @endphp

        @if ($loop->iteration > 1)
            <div class="break">&nbsp;</div>
        @endif
        <div style="text-align: center; font-size: 18pt; margin-bottom: 12pt; text-transform: uppercase;">
            <div>Bukti Transaksi</div>
            <div>Pinjaman Kelompok</div>
        </div>

        <div style="padding: 60pt; padding-top: 0pt; border: 1pt solid #000; height: 82%;">
            <table border="0" width="100%" class="p">
                <tr>
                    <td colspan="3" height="40" align="center" style="text-transform: uppercase; font-size: 16pt;">
                        <b>K u i t a n s i</b>
                    </td>
                </tr>
                <tr>
                    <td width="90">Telah Diterima Dari</td>
                    <td width="10" align="center">:</td>
                    <td class="b">
                        {{ $kec->sebutan_level_3 }} {{ $kec->nama_lembaga_sort }}
                    </td>
                </tr>
                <tr>
                    <td>Uang Sebanyak</td>
                    <td align="center">:</td>
                    <td class="b">
                        {{ $keuangan->terbilang($pinj->alokasi) }} Rupiah
                    </td>
                </tr>
                <tr>
                    <td>Untuk Pembayaran</td>
                    <td align="center">:</td>
                    <td class="b">
                        Pencairan Nasabah Kelompok {{ $pinj->pinkel->kelompok->nama_kelompok }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td class="b">

                        a.n. {{ $pinj->anggota->namadepan }} NIK. {{ $pinj->anggota->nik }}

                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td class="b">
                        Beralamat Di {{ $pinj->anggota->alamat }}
                        {{ $pinj->anggota->d->sebutan_desa->sebutan_desa }}
                        {{ $pinj->anggota->d->nama_desa }}
                    </td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td class="b">
                        Loan ID. {{ $pinj->pinkel->id }} &mdash; SPK No. {{ $pinj->pinkel->spk_no }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td colspan="2" class="t b" align="center">
                        Rp. {{ number_format($pinj->alokasi) }}
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>

            <table border="0" width="100%" style="font-size: 11pt;">
                <tr>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                    <td width="10%">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="6">&nbsp;</td>
                    <td colspan="3" align="center">
                        {{ $kec->nama_kec }}, {{ Tanggal::tglLatin($pinj->tgl_cair) }}
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="3">
                        &nbsp;
                    </td>
                    <td align="center" colspan="3">
                        &nbsp;
                    </td>
                    <td align="center" colspan="3">
                        Diterima Oleh
                    </td>
                </tr>
                <tr>
                    <td align="center" colspan="3">
                        &nbsp;
                    </td>
                    <td align="center" colspan="3">
                        &nbsp;
                    </td>
                    <td align="center" colspan="3">
                        Anggota Nasabah
                    </td>
                </tr>
                <tr>
                    <td colspan="9" height="55">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" colspan="3">
                        <b>&nbsp;</b>
                    </td>
                    <td align="center" colspan="3">
                        <b>&nbsp;</b>
                    </td>
                    <td align="center" colspan="3">
                        <b>{{ $pinj->anggota->namadepan }}</b>
                    </td>
                </tr>
            </table>
        </div>
    @endforeach
@endsection
