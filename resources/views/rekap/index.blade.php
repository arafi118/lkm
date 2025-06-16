@extends('rekap.layout.base')

@section('content')
    <form action="" method="post" id="defaultForm">
        @csrf

        <input type="hidden" name="tgl" id="tgl" value="{{ date('d/m/Y') }}">
    </form>
    <!-- Trigger Button (Hidden) //unpaid -->
    @if (1 > 0)
        <button type="button" id="triggerPopup" class="d-none" data-bs-toggle="modal"
            data-bs-target="#notificationPopup"></button>
    @endif

    <style>
        .text-justify {
            text-align: justify;
        }
    </style>
    <div class="app-main__inner">

        <div class="app-page-title">
            <div class="row">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content">
                        <div class="widget-content-outer p-3">
                            <div class="widget-content-wrapper" id="btnAktif">
                                <div class="widget-content-left">
                                    <div class="widget-heading"
                                        style="display: flex; justify-content: space-between; align-items: right; font-size: 11px;">
                                        <span>
                                            <h6><b>Simpanan</b></h6>
                                        </span>
                                        <div class="dropdown text-end">
                                            <span class="text-xs text-secondary">&nbsp;&nbsp; {{ date('d/m/y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-right">
                                    <!-- foreach --><b>
                                    <div class="widget-numbers text-github" style="font-size: 17px;">
                                        1233 Total Simpanan
                                    </div>
                                    <div class="widget-numbers text-warning" style="font-size: 17px;">
                                        1213 Calon Anggota
                                    </div>
                                    <div class="widget-numbers text-success" style="font-size: 17px;">
                                        23 Anggota
                                    </div>
                                    <!-- endforeach --></b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content">
                        <div class="widget-content-outer p-3">
                            <div class="widget-content-wrapper" id="btnAktif">
                                <div class="widget-content-left">
                                    <div class="widget-heading"
                                        style="display: flex; justify-content: space-between; align-items: right; font-size: 11px;">
                                        <span>
                                            <h6><b>Pinjaman</b></h6>
                                        </span>
                                        <div class="dropdown text-end">
                                            <span class="text-xs text-secondary">&nbsp;&nbsp; {{ date('d/m/y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-right">
                                    <!-- foreach --><b>
                                    <div class="widget-numbers text-github" style="font-size: 17px;">
                                        34 Proposal
                                    </div>
                                    <div class="widget-numbers text-warning" style="font-size: 17px;">
                                        6 Verifikasi
                                    </div>
                                    <div class="widget-numbers text-success" style="font-size: 17px;">
                                        3434 Aktif
                                    </div>
                                    <!-- endforeach --></b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-3 widget-content">
                        <div class="widget-content-outer p-3">
                            <div class="widget-content-wrapper" id="btnWaktu">
                                <div class="widget-content-left">
                                    <div class="widget-heading"
                                        style="display: flex; justify-content: space-between; align-items: right; font-size: 11px;">
                                        <div class="dropdown text-end">
                                            <!-- Empty for alignment -->
                                        </div>
                                    </div>
                                    <div class="widget-subheading pt-2">
                                        <span class="text-sm text-end text-primary font-weight-bolder mt-auto mb-0">
                                            <i class="fas fa-calendar-day me-1"></i>
                                            <span id="current-date">Senin, 17 Juni 2024</span>
                                        </span>
                                    </div>
                                    <div class="widget-subheading pt-2">
                                        <span class="text-sm text-end text-info font-weight-bolder mt-auto mb-0">
                                            <i class="fas fa-clock me-1"></i>
                                            <span id="current-time">14:30:45</span>
                                        </span>
                                    </div>
                                    <div class="widget-subheading pt-2">
                                        <span class="text-sm text-end text-success font-weight-bolder mt-auto mb-0">
                                            <i class="fas fa-calendar-week me-1"></i>
                                            Minggu ke-25
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    // Function to update time and date
                    function updateDateTime() {
                        const now = new Date();
        
                        // Format date: Monday, 17 June 2024
                        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', options);
        
                        // Format time: 14:30:45
                        const time = now.toLocaleTimeString('id-ID');
                        document.getElementById('current-time').textContent = time;
        
                        // Calculate week number
                        const firstDayOfYear = new Date(now.getFullYear(), 0, 1);
                        const pastDaysOfYear = (now - firstDayOfYear) / 86400000;
                        const weekNumber = Math.ceil((pastDaysOfYear + firstDayOfYear.getDay() + 1) / 7);
        
                        // Update week number in the DOM if needed
                        document.querySelector('.widget-subheading:last-child span').innerHTML = 
                            `<i class="fas fa-calendar-week me-1"></i> Minggu ke-${weekNumber}`;
                    }

                    // Update immediately and then every second
                    updateDateTime();
                    setInterval(updateDateTime, 1000);
                </script>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-4">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Angsuran Hari Ini</h5>
                        <div class="card-body pb-0 p-3 pt-0 mt-4">
                            <canvas id="myChart" width="200" height="200"></canvas>
                        </div>
                        <div class="card-footer pt-0 pb-2 p-3 d-flex align-items-center justify-content-between">
                            <div class="w-60">
                                <div class="text-sm">
                                    Total Ang.Pokok: <b>Rp. <span id="total_angsur_pokok"></span></b>
                                </div>
                            </div>
                            <div class="w-60">
                                <div class="text-sm">
                                    Total Ang.Jasa: <b>Rp. <span id="total_angsur_jasa"></span></b>
                                </div>
                            </div>
                            {{-- <div class="w-40 d-flex justify-content-end">
                                        <button type="button" id="btnDetailAngsuran" class="btn btn-outline-secondary">Detail</button>
                                    </div> --}}
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-8">
                <div class="card">
                    <div class="card-header pb-0 p-3">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">Realisasi Pendapatan dan Beban</h5>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-md badge-dot me-4">
                                <i class="bg-success"></i>
                                <span class="text-dark text-xs">Pendapatan</span>
                            </span>
                            <span class="badge badge-md badge-dot me-4">
                                <i class="bg-warning"></i>
                                <span class="text-dark text-xs">Beban</span>
                            </span>
                            <span class="badge badge-md badge-dot me-4">
                                <i class="bg-info"></i>
                                <span class="text-dark text-xs">Laba</span>
                            </span>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="chart">
                            <canvas id="chart-line" class="chart-canvas" height="400"
                                style="display: block; box-sizing: border-box; height: 210px; width: 844.4px;"
                                width="1688"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $p = [
            '1' => 12500000,
            '2' => 9800000,
            '3' => 15300000,
            '4' => 7200000,
            '5' => 18500000,
            '6' => 11200000,
            '7' => 14300000,
            '8' => 6700000,
            '9' => 9200000,
            '10' => 16400000,
            '11' => 13800000,
            '12' => 20500000
        ];
        // Monthly balance data (in millions)
        $b = [
            '1' => 125,   // 125 juta
            '2' => 98,    // 98 juta
            '3' => 153,   // 153 juta
            '4' => 72,    // 72 juta
            '5' => 185,   // 185 juta
            '6' => 112,   // 112 juta
            '7' => 143,   // 143 juta
            '8' => 67,    // 67 juta
            '9' => 92,    // 92 juta
            '10' => 164,  // 164 juta
            '11' => 138,  // 138 juta
            '12' => 205   // 205 juta
        ];

        // Surplus data (in millions)
        $surplus = [
            '1' => 15,    // 15 juta surplus
            '2' => -5,    // 5 juta defisit
            '3' => 23,    // 23 juta surplus
            '4' => -12,   // 12 juta defisit
            '5' => 35,    // 35 juta surplus
            '6' => 8,     // 8 juta surplus
            '7' => 19,    // 19 juta surplus
            '8' => -8,    // 8 juta defisit
            '9' => 4,     // 4 juta surplus
            '10' => 28,   // 28 juta surplus
            '11' => 13,   // 13 juta surplus
            '12' => 42    // 42 juta surplus
        ];
    @endphp
    <textarea name="msgInvoice" id="msgInvoice" class="d-none">{{ Session::get('msg') }}</textarea>
    <form action="/pelaporan/preview" method="post" id="FormLaporanDashboard" target="_blank">
        @csrf

        <input type="hidden" name="type" id="type" value="pdf">
        <input type="hidden" name="tahun" id="tahun" value="{{ date('Y') }}">
        <input type="hidden" name="bulan" id="bulan" value="{{ date('m') }}">
        <input type="hidden" name="hari" id="hari" value="{{ date('d') }}">
        <input type="hidden" name="laporan" id="laporan" value="">
        <input type="hidden" name="sub_laporan" id="sub_laporan" value="">
    </form>
@endsection

@section('modal')
    <!-- Popup Modal -->
    <div class="modal fade" id="notificationPopup" tabindex="-1" aria-labelledby="notificationPopupLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationPopupLabel">Notification</h5>
                </div>
                <div class="modal-body text-justify">
                    LKM <strong>aaa </strong> saat ini memiliki tagihan invoice sebesar
                    <strong>Rp. {{ number_format(123123, 2) }}</strong> untuk perpanjangan lisensi.
                    Mohon
                    segera lakukan pembayaran untuk menghindari kemungkinan pemblokiran dari sistem.
                    <br>Pembayaran Transfer Via : <br>
                    - Bank Mandiri Nomor Rekening : <b> 185-000-417-4733 an. Santoso,</b> <br>
                    - Bank BRI Nomor Rekening : <b>0048-01-057317-505 an.Santoso</b><br>
                    Cek info selengkapnya pada menu <strong> Biaya Perpanjangan </strong> di menu pengaturan ->invoice.
                </div>
                <div class="modal-footer">
                    <button type="button" tabindex="0" class="btn btn-primary"  id="logout">OK</button>
                </div>
                
                <form action="/logout" method="post" id="formLogout">
                    @csrf
                </form>

            </div>
        </div>
    </div>

    {{-- Modal Jatuh Dempo --}}
    <div class="modal fade" id="jatuhTempo" aria-labelledby="jatuhTempoLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="jatuhTempoLabel">Jatuh Tempo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="nav-wrapper position-relative end-0">
                        <div class="d-flex justify-content-between p-1" role="tablist">
                            <button class="btn btn-outline-danger flex-fill me-1 active" data-bs-toggle="tab"
                                data-bs-target="#tagihan_hari_ini" role="tab" aria-controls="tagihan_hari_ini"
                                aria-selected="true">
                                Hari ini
                            </button>
                            <button class="btn btn-outline-warning flex-fill me-1" data-bs-toggle="tab"
                                data-bs-target="#menunggak" role="tab" aria-controls="menunggak"
                                aria-selected="false">
                                Menunggak
                            </button>
                            <button class="btn btn-outline-info flex-fill" data-bs-toggle="tab" data-bs-target="#tagihan"
                                role="tab" aria-controls="tagihan" aria-selected="false">
                                Tagihan
                            </button>
                        </div>

                        <div class="tab-content mt-2">
                            <div class="tab-pane fade show active" id="tagihan_hari_ini" role="tabpanel"
                                aria-labelledby="tagihan_hari_ini">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped midle" width="100%">
                                                <thead>
                                                    <tr>
                                                        <td align="center">No</td>
                                                        <td align="center">Load ID</td>
                                                        <td align="center">Nama Pemohon</td>
                                                        <td align="center">Tanggal Cair</td>
                                                        <td align="center">Tunggakan Pokok</td>
                                                        <td align="center">Tunggakan Jasa</td>
                                                        <td align="center">Jumlah</td>
                                                        <td align="center">Keterangan</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="TbHariIni"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="menunggak" role="tabpanel" aria-labelledby="menunggak">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped midle" width="100%">
                                                <thead>
                                                    <tr>
                                                        <td align="center">No</td>
                                                        <td align="center">Load ID</td>
                                                        <td align="center">Tanggal Cair</td>
                                                        <td align="center">Nama Pemohon</td>
                                                        <td align="center">Desa</td>
                                                        <td align="center">Alokasi</td>
                                                        <td align="center">Tunggakan Pokok</td>
                                                        <td align="center">Tunggakan Jasa</td>
                                                        <td align="center">Jumlah</td>
                                                        <td align="center">Keterangan</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="TbMenunggak"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tagihan" role="tabpanel" aria-labelledby="tagihan">
                                <div class="card">
                                    <div class="card-body p-3">
                                        <form action="/dashboard/tagihan" method="post" id="formTagihan">
                                            @csrf

                                            <div class="alert alert-info text-black">
                                                Kirim Whatsapp Tagihan berdasarkan tanggal jatuh tempo. Pastikan nomor HP
                                                Nasabah dapat menerima pesan Whatsapp.
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-static mb-3">
                                                        <label for="tgl_tagihan">Tgl Jatuh Tempo</label>
                                                        <input autocomplete="off" type="text" name="tgl_tagihan"
                                                            id="tgl_tagihan" class="form-control date pesan"
                                                            value="{{ date('d/m/Y') }}">
                                                        <small class="text-danger" id="msg_tgl_tagihan"></small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group input-group-static mb-3">
                                                        <label for="tgl_pembayaran">Tgl Pembayaran</label>
                                                        <input autocomplete="off" type="text" name="tgl_pembayaran"
                                                            id="tgl_pembayaran" class="form-control date pesan"
                                                            value="{{ date('d/m/Y') }}">
                                                        <small class="text-danger" id="msg_tgl_pembayaran"></small>
                                                    </div>
                                                </div>
                                            </div>

                                            <textarea class="form-control d-none" name="pesan_whatsapp" id="pesan_whatsapp"></textarea>
                                        </form>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" id="CekTagihan" class="btn btn-secondary"
                                                >Preview</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-sm me-2 btn-pelaporan">
                        Print
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Pinjaman --}}
    <div class="modal fade" id="pinjaman" aria-labelledby="pinjamanLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="pinjamanLabel">Pinjaman</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="nav-wrapper position-relative end-0">
                        <div class="d-flex justify-content-between p-1" role="tablist">
                            <button class="btn btn-outline-info flex-fill me-1 active" data-bs-toggle="tab"
                                data-bs-target="#proposal" role="tab" aria-controls="proposal" aria-selected="true">
                                Proposal
                            </button>
                            <button class="btn btn-outline-danger flex-fill me-1" data-bs-toggle="tab"
                                data-bs-target="#verifikasi" role="tab" aria-controls="verifikasi"
                                aria-selected="false">
                                Verifikasi
                            </button>
                            <button class="btn btn-outline-warning flex-fill" data-bs-toggle="tab"
                                data-bs-target="#waiting" role="tab" aria-controls="waiting" aria-selected="false">
                                Waiting
                            </button>
                        </div>

                        <div class="tab-content mt-2">
                            <div class="tab-pane fade show active" id="proposal" role="tabpanel"
                                aria-labelledby="proposal">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped midle" width="100%">
                                                <thead>
                                                    <tr>
                                                        <td align="center">No</td>
                                                        <td align="center">Load id</td>
                                                        <td align="center">Tanggal Proposal</td>
                                                        <td align="center">Nama Pemohon P</td>
                                                        <td align="center">Jenis</td>
                                                        <td align="center">Alokasi</td>
                                                        <td align="center">Nama Barang</td>
                                                        <td align="center">Keterangan</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbProposal"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="verifikasi" role="tabpanel" aria-labelledby="verifikasi">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped midle" width="100%">
                                                <thead>
                                                    <tr>
                                                        <td align="center">No</td>
                                                        <td align="center">Load id</td>
                                                        <td align="center">Tanggal Verifikasi</td>
                                                        <td align="center">Nama Pemohon V</td>
                                                        <td align="center">Jenis</td>
                                                        <td align="center">Alokasi</td>
                                                        <td align="center">Nama Barang</td>
                                                        <td align="center">Keterangan</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbVerifikasi"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="waiting" role="tabpanel" aria-labelledby="waiting">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped midle" width="100%">
                                                <thead>
                                                    <tr>
                                                        <td align="center">No</td>
                                                        <td align="center">Load id</td>
                                                        <td align="center">Tanggal Tunggu</td>
                                                        <td align="center">Nama Pemohon W</td>
                                                        <td align="center">Jenis</td>
                                                        <td align="center">Alokasi</td>
                                                        <td align="center">Nama Barang</td>
                                                        <td align="center">Keterangan</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbWaiting"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-sm me-2 btn-pelaporan">
                        Print
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Kelompok Aktif --}}
    <div class="modal fade" id="aktif" aria-controls="individu_aktif" aria-labelledby="aktifLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="aktifLabel">Pinjaman Aktif</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="nav-wrapper position-relative end-0">
                        <div class="tab-content mt-2">
                            <div class="" id="anggota" role="" aria-labelledby="anggota">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped midle" width="100%">
                                                <thead>
                                                    <tr>
                                                        <td align="center">No</td>
                                                        <td align="center">Nik </td>
                                                        <td align="center">Nama Nasabah</td>
                                                        <td align="center">Alamat</td>
                                                        <td align="center">T/S</td>
                                                        <td align="center">Tanggal Cair</td>
                                                        <td align="center">Alokasi</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbAnggota"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-sm me-2 btn-pelaporan">
                        Print
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail Angsuran --}}
    <div class="modal fade" id="detailAngsuran" aria-labelledby="detailAngsuranLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailAngsuranLabel">Pinjaman detailAngsuran</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tagihan --}}
    <div class="modal fade" id="tagihanPinjaman" aria-labelledby="tagihanPinjamanLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tagihanPinjamanLabel">Tagihan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="TbTagihan"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-sm" id="KirimPesan">Kirim Pesan</button>
                    <button type="button" class="btn btn-danger btn-sm" id="closeTagihan">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const triggerButton = document.getElementById('triggerPopup');
            if (triggerButton) {
                triggerButton.click();
            }
            // Ensure modal can be interacted with correctly
            const modalElement = document.getElementById('notificationPopup');
            modalElement.addEventListener('hidden.bs.modal', function() {
                // Ensure the backdrop is removed when modal is closed
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            });
        });
    </script>

    <script>
        $.ajax({
            type: 'post',
            url: '/dashboard/jatuh_tempo',
            data: $('#defaultForm').serialize(),
            success: function(result) {
                if (result.success) {
                    $('#jatuh_tempo').html(result.jatuh_tempo)

                    if (result.jatuh_tempo != '00') {
                        $('#TbHariIni').html(result.hari_ini)
                    }
                }
            }
        })

        $.ajax({
            type: 'post',
            url: '/dashboard/nunggak',
            data: $('#defaultForm').serialize(),
            success: function(result) {
                if (result.success) {
                    $('#nunggak').html(result.nunggak)

                    if (result.nunggak != '00') {
                        $('#TbMenunggak').html(result.table)
                    }
                }
            }
        })

        function tagihan() {
            var tgl_tagihan = $('#tgl_tagihan').val()

            $.ajax({
                url: '/dashboard/tagihan',
                type: 'post',
                data: $('#formTagihan').serialize(),
                success: function(result) {
                    if (result.success) {
                        $('#TbTagihan').html(result.tagihan)
                        $('#tagihanPinjaman').modal('show')
                    }
                }
            })
        }

        $(document).on('click', '#CekTagihan', function(e) {
            e.preventDefault()

            tagihan()
        })

        $(document).on('click', '#closeTagihan', function() {
            $('#tagihanPinjaman').modal('hide')
            $('#jatuhTempo').modal('show')
        })

        $.get('/dashboard/pinjaman?status=P', function(result) {
            if (result.success) {
                $('#tbProposal').html(result.table)
            }
        })

        $.get('/dashboard/pinjaman?status=V', function(result) {
            if (result.success) {
                $('#tbVerifikasi').html(result.table)
            }
        })

        $.get('/dashboard/pinjaman?status=W', function(result) {
            if (result.success) {
                $('#tbWaiting').html(result.table)
            }
        })

        $.get('/dashboard/pemanfaat?status=A', function(result) {
            if (result.success) {
                $('#tbAnggota').html(result.table)
            }
        })

        $(document).on('click', '#KirimPesan', function(e) {
            e.preventDefault()

            var form = $('#FormPemberitahuan')
            var values = $('[data-input=checked]:checked').map(function(i) {
                setTimeout(() => {
                    var pesan = this.value
                    var number = pesan.split('||')[0]
                    var anggota = pesan.split('||')[1]
                    var msg = pesan.split('||')[2]

                    sendMsg(number, anggota, msg)
                }, i * 1500);
            }).get();
        })

        function sendMsg(number, nama, msg, repeat = 0) {
            $.ajax({
                type: 'post',
                url: '/send-text',
                timeout: 0,
                headers: {
                    "Content-Type": "application/json"
                },
                xhrFields: {
                    withCredentials: true
                },
                data: JSON.stringify({
                    token: "",
                    number: number,
                    text: msg
                }),
                success: function(result) {
                    if (result.status) {
                        MultiToast('success', 'Pesan untuk anggota ' + nama + ' berhasil dikirim')
                    } else {
                        if (repeat < 1) {
                            setTimeout(function() {
                                sendMsg(number, nama, msg, repeat + 1)
                            }, 1000)
                        } else {
                            MultiToast('error', 'Pesan untuk anggota ' + nama + ' gagal dikirim')
                        }
                    }
                },
                error: function(result) {
                    if (repeat < 1) {
                        setTimeout(function() {
                            sendMsg(number, nama, msg, repeat + 1)
                        }, 1000)
                    } else {
                        MultiToast('error', 'Pesan untuk anggota ' + nama + ' gagal dikirim')
                    }
                }
            })
        }

        $(document).on('click', '#btnjatuhTempo', function(e) {
            e.preventDefault()

            $('#jatuhTempo').modal('show')


            let tab = $('#jatuhTempo').find('div.nav-wrapper div.d-flex button.active')
            if (tab.length > 0) {
                if (tab.attr('aria-controls') != 'tagihan') {
                    $('.btn-pelaporan').show()
                    setLaporan('5', tab.attr('aria-controls'))
                } else {
                    $('.btn-pelaporan').hide()
                }
            }
        })

        $(document).on('click', '#btnpinjaman', function(e) {
            e.preventDefault()

            $('#pinjaman').modal('show')
            $('.btn-pelaporan').show()

            let tab = $('#pinjaman').find('div.nav-wrapper div.d-flex button.active')
            if (tab.length > 0) {
                setLaporan('5', tab.attr('aria-controls'))
            }
        })

        $(document).on('click', '#btnAktif', function(e) {
            e.preventDefault()

            $('#aktif').modal('show')
            $('.btn-pelaporan').show()

            setLaporan('5', $('#aktif').attr('aria-controls'))
        })

        $(document).on('click', 'div.nav-wrapper div.d-flex button', function() {
            var a = $(this)

            if (a.attr('aria-controls') == 'tagihan') {
                $('.btn-pelaporan').hide()
            } else {
                $('.btn-pelaporan').show()
            }
            setLaporan('5', a.attr('aria-controls'))
        })

        $(document).on('click', '.btn-pelaporan', function(e) {
            $('#FormLaporanDashboard').submit()
        })

        function setLaporan(laporan, subLaporan = null) {
            $('#FormLaporanDashboard #laporan').val(laporan);
            $('#FormLaporanDashboard #sub_laporan').val(subLaporan);
        }
    </script>

    @if (Session::get('invoice'))
        <script>
            function msgInvoice(number, msg, repeat = 0) {
                $.ajax({
                    type: 'post',
                    url: '{{ $api }}/send-text',
                    timeout: 0,
                    headers: {
                        "Content-Type": "application/json"
                    },
                    xhrFields: {
                        withCredentials: true
                    },
                    data: JSON.stringify({
                        token: "33081920220815",
                        number: number,
                        text: msg
                    }),
                    success: function(result) {
                        if (!result.status) {
                            setTimeout(function() {
                                msgInvoice(number, msg, repeat + 1)
                            }, 1000)
                        }
                    },
                    error: function(result) {
                        if (repeat < 1) {
                            setTimeout(function() {
                                msgInvoice(number, msg, repeat + 1)
                            }, 1000)
                        }
                    }
                })
            }

            msgInvoice("{{ Session::get('hp_dir') }}", $('#msgInvoice').val())
            setTimeout(() => {
                msgInvoice('0882006644656', $('#msgInvoice').val())
            }, 1000);
        </script>
    @endif
    <script>
        var formatter = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        })

        var ctx1 = document.getElementById("chart-line").getContext("2d");
        var ctx2 = document.getElementById("myChart").getContext("2d");

        // Line chart
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "Mei",
                    "Jun",
                    "Jul",
                    "Agu",
                    "Sep",
                    "Okt",
                    "Nov",
                    "Des",
                ],
                datasets: [{
                        label: "Pendapatan",
                        tension: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "#4CAF50",
                        pointBorderColor: "transparent",
                        borderColor: "#4CAF50",
                        borderWidth: 2,
                        backgroundColor: "transparent",
                        fill: true,
                        data: [
                            "{{ $p['1'] }}",
                            "{{ $p['2'] }}",
                            "{{ $p['3'] }}",
                            "{{ $p['4'] }}",
                            "{{ $p['5'] }}",
                            "{{ $p['6'] }}",
                            "{{ $p['7'] }}",
                            "{{ $p['8'] }}",
                            "{{ $p['9'] }}",
                            "{{ $p['10'] }}",
                            "{{ $p['11'] }}",
                            "{{ $p['12'] }}"
                        ],
                        maxBarThickness: 6
                    },
                    {
                        label: "Beban",
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "#fb8c00",
                        pointBorderColor: "transparent",
                        borderColor: "#fb8c00",
                        borderWidth: 2,
                        backgroundColor: "transparent",
                        fill: true,
                        data: [
                            "{{ $b['1'] }}",
                            "{{ $b['2'] }}",
                            "{{ $b['3'] }}",
                            "{{ $b['4'] }}",
                            "{{ $b['5'] }}",
                            "{{ $b['6'] }}",
                            "{{ $b['7'] }}",
                            "{{ $b['8'] }}",
                            "{{ $b['9'] }}",
                            "{{ $b['10'] }}",
                            "{{ $b['11'] }}",
                            "{{ $b['12'] }}"
                        ],
                        maxBarThickness: 6
                    },
                    {
                        label: "Laba",
                        tension: 0,
                        borderWidth: 0,
                        pointRadius: 5,
                        pointBackgroundColor: "#1A73E8",
                        pointBorderColor: "transparent",
                        borderColor: "#1A73E8",
                        borderWidth: 2,
                        backgroundColor: "transparent",
                        fill: true,
                        data: [
                            "{{ $surplus['1'] }}",
                            "{{ $surplus['2'] }}",
                            "{{ $surplus['3'] }}",
                            "{{ $surplus['4'] }}",
                            "{{ $surplus['5'] }}",
                            "{{ $surplus['6'] }}",
                            "{{ $surplus['7'] }}",
                            "{{ $surplus['8'] }}",
                            "{{ $surplus['9'] }}",
                            "{{ $surplus['10'] }}",
                            "{{ $surplus['11'] }}",
                            "{{ $surplus['12'] }}"
                        ],
                        maxBarThickness: 6
                    }
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: '#c1c4ce5c'
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#9ca2b7',
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: true,
                            borderDash: [5, 5],
                            color: '#c1c4ce5c'
                        },
                        ticks: {
                            display: true,
                            color: '#9ca2b7',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

        // Pie chart
        var myChart = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: [
                    'Umum',
                    'Kendaraan',
                    'Elektronik',
                    'PRT',
                    'Lain-lain',
                ],
                datasets: [{
                    label: 'Projects',
                    backgroundColor: [
                        '#1a73e8',
                        '#4caf50',
                        '#344767',
                        '#7b809a',
                        '#f44335',
                        '#1a73e8',
                        '#4caf50',
                        '#344767',
                        '#7b809a',
                        '#f44335',
                    ],
                    borderWidth: 1,
                    data: [
                        "{{ 2134 }}",
                        "{{ 234 }}",
                        "{{ 123 }}",
                        "{{ 4356 }}",
                        "{{ 67 }}",
                        "{{ 346 }}",
                        "{{ 457 }}",
                        "{{ 568 }}",
                        "{{ 346 }}",
                        "{{ 2345 }}",
                    ],
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                }
            }
        });

        var total_angsur_pokok =
            "23452"

        $('#total_angsur_pokok').html(formatter.format(total_angsur_pokok))

        var total_angsur_jasa =
            "3425"

        $('#total_angsur_jasa').html(formatter.format(total_angsur_jasa))

        let childWindow, loading;
        $(document).on('click', '#simpanSaldo', function(e) {
            var link = $(this).attr('data-href')

            loading = Swal.fire({
                title: "Mohon Menunggu..",
                html: "Menyimpan Saldo Januari sampai Desember Th. {{ date('Y') }}",
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            })

            childWindow = window.open(link, '_blank');
        })

        window.addEventListener('message', function(event) {
            if (event.data === 'closed') {
                loading.close()
                window.location.reload()
            }
        })
        

    </script>
@endsection
