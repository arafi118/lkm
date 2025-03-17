@php
    use App\Utils\Tanggal;

    $jaminan = json_decode($pinkel->jaminan, true);
@endphp

@extends('perguliran_i.dokumen.layout.base')

@section('content')
    <style>
        /* styles.css */
        .centered-text {
            font-size: 10px;
            text-align: center;
            text-align: justify;
        }
    </style>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 12px;">
        <br>
        <tr>
            <td colspan="3" align="center">
                <div style="font-size: 14px;">
                    <b> SURAT PERNYATAAN</b>
                </div>
                <div style="font-size: 12px;">
                    No. ............
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="5"> </td>
        </tr>
    </table>

    <div class="centered-text">
        Yang bertanda tangan di bawah ini :
    </div><br>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">
        <tr>
            <td width="5"> &nbsp; </td>
            <td width="90"> Nama Lengkap </td>
            <td width="10" align="center"> : </td>
            <td> {{ $pinkel->anggota->namadepan }} </td>
        </tr>
        <tr>
            <td width="5"> &nbsp; </td>
            <td> NIK </td>
            <td align="center"> : </td>
            <td> {{ $pinkel->anggota->nik }} </td>
        </tr>
        <tr>
            <td width="5"> &nbsp; </td>
            <td> Tempat, Tanggal lahir </td>
            <td align="center"> : </td>
            <td> {{ $pinkel->anggota->tempat_lahir }},
                {{ \Carbon\Carbon::parse($pinkel->anggota->tgl_lahir)->locale('id')->translatedFormat('d F Y') }}
            </td>
        </tr>
        <tr>
            <td width="5"> &nbsp; </td>
            <td> Alamat </td>
            <td align="center"> : </td>
            <td> {{ $pinkel->anggota->alamat }} </td>
        </tr>
        <tr>
            <td width="5"> &nbsp; </td>
            <td> No. Telepon </td>
            <td align="center"> : </td>
            <td> {{ $pinkel->anggota->hp }} </td>
        </tr>
        <tr>
            <td width="5"> &nbsp; </td>
            <td>Pekerjaan</td>
            <td align="center"> : </td>
            <td class="style27">
                @if (is_numeric($pinkel->anggota->usaha))
                    {{ $pinkel->anggota->u->nama_usaha }}
                @else
                    {{ $pinkel->anggota->usaha }}
                @endif
            </td>
        </tr>
    </table><br>
    <div class="centered-text">
        Mengajukan permohan pembiayaan /kredit barang kepada Unit Pembiayaan {{ $kec->nama_lembaga_sort }} yang berupa :
    </div><br>
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;">

        <tr>
            <td width="5"> &nbsp; </td>
            <td width="90"> Jenis Barang </td>
            <td width="10" align="center"> : </td>
            <td> {{ $pinkel->jpp->nama_jpp }} </td>
        </tr>
        <tr>
            <td width="5"> &nbsp; </td>
            <td width="90"> Nama Barang </td>
            <td width="10" align="center"> : </td>
            <td> {{ $pinkel->nama_barang }} </td>
        </tr>
        <tr>
            <td width="5"> &nbsp; </td>
            <td width="90"> Harga </td>
            <td width="10" align="center"> : </td>
            <td>Rp. {{ number_format($pinkel->harga, 2) }} </td>
        </tr>
        <tr>
            <td width="5"> &nbsp; </td>
            <td> Jumlah Angsuran </td>
            <td align="center"> : </td>
            <td>Rp. {{ number_format($pinkel->alokasi, 2) }}
            </td>
        </tr>
        <tr>
            <td width="5"> &nbsp; </td>
            <td> Jangka Waktu (Bulan) </td>
            <td align="center"> : </td>
            <td> {{ $pinkel->jangka }} Bulan </td>
        </tr>
        <tr>
            <td width="5"> &nbsp; </td>
            <td> Jaminan</td>
            <td align="center"> : </td>
            <td>(
                @if ($jaminan['jenis_jaminan'] == '1')
                    Nomor Sertifikat: {{ $jaminan['nomor_sertifikat'] ?? 0 }},
                    Nama jaminan: {{ $jaminan['nama_pemilik'] ?? 0 }},
                    Alamat : {{ $jaminan['alamat'] ?? 0 }} Luas: {{ $jaminan['luas'] ?? 0 }} (m²),
                    Nilai Jual Tanah: {{ number_format($jaminan['nilai_jual_tanah'] ?? 0) }},
                @elseif ($jaminan['jenis_jaminan'] == '2')
                    Nomor: {{ $jaminan['nomor'] ?? 0 }},
                    Nama jaminan: {{ $jaminan['jenis_kendaraan'] ?? 0 }},
                    Nopol: {{ $jaminan['nopol'] ?? 0 }},
                    Nilai Jual Kendaraan: {{ number_format($jaminan['nilai_jual_kendaraan'] ?? 0) }},
                @elseif ($jaminan['jenis_jaminan'] == '3')
                    Nomor: {{ $jaminan['nomor'] ?? 0 }},
                    Nama Pegawai: {{ $jaminan['nama_pegawai'] ?? 0 }},
                    Nama Instansi Penerbit: {{ $jaminan['nama_kuitansi_penerbit'] ?? 0 }},
                @elseif ($jaminan['jenis_jaminan'] == '4')
                    Nomor Jaminan: {{ $jaminan['nama_jaminan'] ?? 0 }},
                    Keterangan: {{ $jaminan['keterangan'] ?? 0 }},
                    Nilai Jaminan: {{ number_format($jaminan['nilai_jaminan'] ?? 0) }},
                @else
                    Nomor Sertifikat: {{ $jaminan['nomor_sertifikat'] ?? 0 }},
                    Nama jaminan: {{ $jaminan['nama_pemilik'] ?? 0 }},
                    Alamat : {{ $jaminan['alamat'] ?? 0 }} Luas: {{ $jaminan['luas'] ?? 0 }} (m²),
                    Nilai Jual Tanah: {{ number_format($jaminan['nilai_jual_tanah'] ?? 0) }},
                @endif )
            </td>
        </tr>
        <tr>
            <td width="5"> &nbsp; </td>
            <td> Uang Muka </td>
            <td align="center"> : </td>
            <td>Rp. {{ number_format($pinkel->depe, 2) }}</td>
        </tr>
    </table><br>
    <div class="centered-text">
        Dan dengan surat ini menyatakan sanggup untuk menyelesaikan pembiayaan/kredit sesuai dengan permohonan diatas.
        Apabila di kemudian hari terjadi kemacetan, saya siap di proses sesuai peraturan yang berlaku.</div>
    <div class="centered-text">
        Demikian surat pernyataan dibuat, agar bisa di gunakan sebagaimana mestinya. </div>
    <br>
    <div style="text-align: center;" style="font-size: 10px;">
        <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 10px;" class="p0">
            <tr>
                <td style="padding: 0px !important;"><br>
                    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
                        <tr>
                            <td width="100" align="center"> Mengetahui, <br>
                                {{ $pinkel->anggota->d->sebutan_desa->sebutan_kades }}
                                {{ $pinkel->anggota->d->nama_desa }}
                            </td>
                            <td width="10" align="center"> &nbsp; </td>
                            <td width="100" align="center">
                                {{ $kec->nama_kec }},
                                {{ \Carbon\Carbon::parse($pinkel->tgl_proposal)->locale('id')->translatedFormat('d F Y') }}
                                <br> Pemohon,
                            </td>
                        </tr> <br> <br> <br> <br> <br><br><br><br>
                        <tr>
                            <td width="100" align="center">
                                {{ $pinkel->anggota->d->kades }}
                            </td>
                            <td width="10" align="center"> &nbsp; </td>
                            <td width="100" align="center"> {{ $pinkel->anggota->namadepan }}
                            </td>
                        </tr>
                        <tr>
                            <td width="100" align="center" colspan="3"> Menyetujui, </td>
                        </tr>
                        <tr>
                            <td width="100" align="center"> Direktur, <br>{{ $kec->nama_lembaga_long }}</td>
                            <td width="10" align="center"> &nbsp; </td>
                            <td width="100" align="center"> Manager Unit Pembiayaan <br> {{ $kec->nama_lembaga_long }}
                            </td>
                        </tr> <br> <br> <br> <br> <br><br><br><br>
                        <tr>
                            <td width="100" align="center"> {{ $mgr->namadepan }} {{ $mgr->namabelakang }}</td>
                            <td width="10" align="center"> &nbsp; </td>
                            <td width="100" align="center"> {{ $dir->namadepan }} {{ $dir->namabelakang }}
                            </td>
                        </tr>
                    </table>
                @endsection
