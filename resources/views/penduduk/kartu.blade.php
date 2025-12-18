@extends('layouts.base')

@section('content')

<style>
/* =======================
   WRAPPER
======================= */
.kartu-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

/* =======================
   KARTU (CR80)
======================= */
.kartu {
    width: 85.6mm;
    height: 53.98mm;
    border: 2px solid #0d6efd;
    border-radius: 6px;
    padding: 8px;
    font-family: Arial, sans-serif;
    background: #ffffff;
    position: relative;
    overflow: hidden;
}

/* =======================
   WATERMARK LOGO
======================= */
.kartu::before {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    height: 90%;
    aspect-ratio: 1 / 1;
    background-image: url('{{ $logo ?? '' }}');
    background-repeat: no-repeat;
    background-position: center;
    background-size: auto 100%;
    opacity: 0.08;
    transform: translate(-50%, -50%);
    z-index: 0;
}

/* Pastikan konten di atas watermark */
.kartu * {
    position: relative;
    z-index: 1;
}

/* =======================
   TEXT COLOR
======================= */
.text-primary {
    color: #0d6efd;
}

.text-info {
    color: #0dcaf0;
}

/* =======================
   HEADER
======================= */
.kartu-header {
    text-align: center;
    font-weight: bold;
    font-size: 12px;
    margin-bottom: 6px;
}

/* =======================
   BODY
======================= */
.kartu-body {
    display: flex;
    gap: 8px;
}

/* FOTO */
.kartu-foto {
    width: 90px;
    height: 110px;
    border: 1px solid #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    font-size: 11px;
}

.kartu-foto img {
    width: 100%;
    height: auto;
}

/* DATA */
.kartu-data {
    font-size: 11px;
    line-height: 1.4;
    width: 100%;
}

.kartu-data table {
    width: 100%;
}

.kartu-data td {
    vertical-align: top;
    padding: 1px 0;
}

/* =======================
   FOOTER
======================= */
.kartu-footer {
    margin-top: 6px;
    font-size: 10px;
    text-align: right;
}

/* =======================
   PRINT SETTING
======================= */
@media print {
    body * {
        visibility: hidden;
    }

    .kartu,
    .kartu * {
        visibility: visible;
    }

    .kartu {
        position: absolute;
        left: 0;
        top: 0;
    }

    .kartu::before {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }

    button {
        display: none;
    }
}
</style>

<div class="kartu-wrapper">
    <div class="kartu">

        <div class="kartu-header text-primary">
            KARTU ANGGOTA
        </div>

        <div class="kartu-body">

            <div class="kartu-foto">
                @if ($anggota->foto)
                    <img src="{{ asset('storage/' . $anggota->foto) }}" alt="Foto">
                @else
                    FOTO
                @endif
            </div>

            <div class="kartu-data">
                <table>
                    <tr>
                        <td><strong>NIK</strong></td>
                        <td>: {{ $anggota->nik }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td>: {{ $anggota->namadepan }}</td>
                    </tr>
                    <tr>
                        <td><strong>JK</strong></td>
                        <td>: {{ $anggota->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td><strong>TTL</strong></td>
                        <td>: {{ $anggota->tempat_lahir }}, {{ $anggota->terdaftar }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>: {{ $anggota->alamat }} <b>{{ $anggota->d->nama_desa }}</b></td>
                    </tr>
                    <tr>
                        <td><strong>No. HP</strong></td>
                        <td>: {{ $anggota->hp }}</td>
                    </tr>
                </table>
            </div>

        </div>

        <div class="kartu-footer">
            Terdaftar: {{ $anggota->terdaftar }}<br>
            Petugas: {{ $user->namadepan ?? '__________'}} {{ $user->namabelakang ?? ''}}
        </div>

    </div>
</div>

<div style="text-align:center; margin-top:15px;">
    <button onclick="window.print()" class="btn btn-primary">
        🖨 Cetak Kartu
    </button>
</div>

@endsection
