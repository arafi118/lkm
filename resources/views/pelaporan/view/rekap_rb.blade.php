@extends('pelaporan.layout.base')

@section('content')
    @php
        $saldo1 = 0;
        $saldo_bln_lalu1 = 0;

        $saldo2 = 0;
        $saldo_bln_lalu2 = 0;
    @endphp

    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
        <tr>
            <td colspan="4" align="center">
                <div style="font-size: 18px;">
                    <b>LAPORAN LABA RUGI</b>
                </div>
                <div style="font-size: 16px;">
                    <b>{{ strtoupper($sub_judul) }}</b>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4" height="5"></td>
        </tr>
        <tr style="background: rgb(232, 232, 232); font-weight: bold; font-size: 12px;">
            <td align="center" width="55%" height="16">Rekening</td>
            <td align="center" width="15%">s.d. {{ $header_lalu }}</td>
            <td align="center" width="15%">{{ $header_sekarang }}</td>
            <td align="center" width="15%">s.d. {{ $header_sekarang }}</td>
        </tr>
        @php
            $kelompok_judul = [
                '4.1' => '4. Pendapatan',
                '5.1' => '5. Beban',
                '5.2' => '5. Beban',
                '4.2' => '4. Pendapatan Non Operasional',
                '4.3' => '4. Pendapatan Non Operasional',
                '5.3' => '5. Beban Non Operasional',
            ];

            $kelompok_urutan = [
                '4.1' => '4. Pendapatan',
                '5.1' => '5. Beban',
                '4.2' => '4. Pendapatan Non Operasional',
                '5.3' => '5. Beban Non Operasional',
            ];

            $sudah_tampil = []; // untuk memastikan judul kelompok tidak muncul 2x
        @endphp

        @foreach ($rekap as $kode => $p)
            @php
                $judul = $kelompok_judul[$kode] ?? '';
            @endphp
            @if ($judul && !in_array($judul, $sudah_tampil))
                <tr style="background: rgb(200, 200, 200); font-weight: bold; text-transform: uppercase;">
                    <td colspan="4" height="14">{{ $judul }}</td>
                </tr>
                @php
                    $sudah_tampil[] = $judul;
                @endphp
            @endif
            <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                <td colspan="4" height="14">{{$kode}}. {{ $p['nama'] }}</td>
            </tr>
            @php
                $jum_bulan_lalu = 0;
                $jum_saldo = 0;
            @endphp
                
                @foreach ($p['akun3'] as $kode1 => $p1)
                    @php
                        $a = 1;
                    @endphp
                    @foreach ($p1['rekap'] as $kode2 => $p2)
                @php
                    $a+=1;
                    $bg = 'rgb(230, 230, 230)';
                    if ($a % 2 == 0) {
                        $bg = 'rgb(255, 255, 255)';
                    }
                @endphp
                        <tr style="background: rgb(200, 200, 200); font-weight: bold;">
                            <td colspan="4" height="14">{{$kode2}}. {{ $p2['nama'] }}</td>
                        </tr>
                            @foreach ($p2['lokasi'] as $p3)
                                <tr style="background: {{$bg}}); font-weight: bold;">
                                    <td height="14"> &nbsp; &nbsp; &nbsp; {{ $p2['nama'] }} di {{$p3['nama_kec']}}</td>
                                    <td align="right">{{ number_format($p3['saldo_bln_lalu'], 2) }}</td>
                                    <td align="right">{{ number_format($p3['saldo']-$p3['saldo_bln_lalu'], 2) }}</td>
                                    <td align="right">{{ number_format($p3['saldo'], 2) }}</td>
                                </tr>
                            @endforeach 
                    @endforeach 
                @endforeach
                    
            <tr style="background: rgb(150, 150, 150); font-weight: bold;">
                <td align="left" height="14">Jumlah {{ $kode }}. {{ $p['nama'] }}</td>
                <td align="right">{{ number_format(0, 2) }}</td>
                <td align="right">{{ number_format(0, 2) }}</td>
                <td align="right">{{ number_format(0, 2) }}</td>
            </tr>

        @endforeach

@endsection
