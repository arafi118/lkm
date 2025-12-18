@extends('layouts.base')

@section('title', 'Kartu Anggota')

@section('content')
<style>
    .kartu-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    .kartu {
        /* CR80 / ID-1 : 85.60mm x 53.98mm */
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

    .bg-primary-soft {
        background-color: #e7f1ff;
    }

    .text-primary {
        color: #0d6efd;
    }

    .text-info {
        color: #0dcaf0;
    }
    }
    .kartu-header {
        text-align: center;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .kartu-body {
        display: flex;
        gap: 10px;
    }
    .kartu-foto {
        width: 100px;
        height: 120px;
        border: 1px solid #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .kartu-foto img {
        width: 100%;
        height: auto;
    }
    .kartu-data {
        font-size: 12px;
        line-height: 1.4;
    }
    .kartu-data table {
        width: 100%;
    }
    .kartu-data td {
        vertical-align: top;
        padding: 2px 0;
    }
    .kartu-footer {
        margin-top: 10px;
        font-size: 11px;
        text-align: right;
    }
    .kartu::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 260px;
        height: 260px;
        background-image: url('{{ $logo ?? '' }}');
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
        opacity: 0.08;
        transform: translate(-50%, -50%);
        z-index: 0;
    }
    .kartu * {
        position: relative;
        z-index: 1;
    }
</style>

<div class="kartu-wrapper">
    <div class="kartu">
        <div class="kartu-header text-primary" style="font-size:12px;">
            KARTU ANGGOTA
        </div>

        <div class="kartu-body bg-primary-soft" style="padding:4px; border-radius:4px;">
            <div class="kartu-foto">
                @if($anggota->foto)
                    <img src="{{ asset('storage/'.$anggota->foto) }}" alt="Foto Anggota">
                @else
                    <span>Foto</span>
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
                        <td>: {{ $anggota->tempat_lahir }}, {{$anggota->tgl_lahir }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>: {{ $anggota->alamat }}</td>
                    </tr>
                    <tr>
                        <td><strong>Desa</strong></td>
                        <td>: {{ optional($anggota->desaRelasi)->nama_desa }}</td>
                    </tr>
                    <tr>
                        <td><strong>No. HP</strong></td>
                        <td>: {{ $anggota->hp }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>: {{ $anggota->status }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="kartu-footer">
            Terdaftar: {{$anggota->terdaftar }}<br>
            Petugas: {{ $anggota->petugas }}
        </div>
    </div>
</div>

<div style="text-align:center; margin-top:15px;">
    <button onclick="window.print()" class="btn btn-primary">
        🖨 Cetak Kartu
    </button>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .kartu, .kartu * {
        visibility: visible;
    }
    .kartu {
        position: absolute;
        left: 0;
        top: 0;
    }
    button {
        display: none;
    }
}
</style>
@endsection
