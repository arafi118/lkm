@php
    use App\Utils\Tanggal;
@endphp

@extends('perguliran_i.dokumen.layout.base')

@section('content')
    <!-- Judul -->
    <div style="width:100%; font-size:10pt;">
        <div style="text-align:center; font-size:18pt; font-weight:bold; margin-bottom:5px;">
            CHECK LIST
        </div>
        <div style="text-align:center; font-size:16pt; margin-bottom:5px;">
            KELENGKAPAN PROPOSAL {{ strtoupper($pinkel->jpp->nama_jpp) }}
        </div>
    </div>

    <!-- Identitas -->
    <div style="width:100%; font-size:10pt; text-align:justify; margin-bottom:10px;">
        <div style="display:table; width:100%; font-size:10pt; text-align:justify;"></div>
    </div>

    <div style="width:100%; font-size:10pt;">
        <div style="width:40%; margin-left:auto; text-align:center;">
            <div>Diperiksa oleh</div>
            <div style="height:80px;"></div>
            <div><b>{{ $dir->namadepan }}</b></div>
        </div>
    </div>

@endsection
