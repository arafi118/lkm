@php
    use App\Models\TandaTanganLaporan;
    $ttd = TandaTanganLaporan::where([['lokasi', Session::get('lokasi')]])->first();

    $tanggal = false;
    if ($ttd) {
        $str = strpos($ttd->tanda_tangan_pelaporan, '{tanggal}');

        if ($str !== false) {
            $tanggal = true;
        }
    }

    if (!$tanggal) {
        $jumlah += 1;
    }

    $path = explode('/', Request::path());
    $show = ((in_array('perguliran', $path)
                ? true
                : in_array('detail', $path))
            ? true
            : in_array('kelompok', $path))
        ? true
        : false;
    $id_search = 'cariKelompok';
    $label = 'Kelompok';
    if (in_array('jurnal_angsuran_individu', $path)) {
        $id_search = 'cariAnggota';
        $label = 'Individu (NIK/Nama Peminjam)';
    }
@endphp
<div class="app-header header-shadow">
    <div class="app-header__logo">
        <a href="/dashboard" class="logo" id="nama_lembaga_sort" style="color: rgb(0, 0, 0);">
            <b> {{ Session::get('nama_lembaga') }} </b>
        </a>
        <div class="header__pane ms-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>

    <div class="app-header__content">
        <div class="app-header-left">
            <div class="search-wrapper">
                <div class="input-holder">
                    <input type="text" class="search-input" placeholder="Type to search">
                    <button class="search-icon"><span></span></button>
                </div>
                <button class="btn-close"></button>
            </div>
            <ul class="header-menu nav">
                <li class="nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        <i class="nav-link-icon fa-solid fa-bell"> </i>
                        Reminder
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="nav-link-icon fa-solid fa-envelope"></i>
                        TS dan Invoice
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Biaya Perpanjangan Maintenance dan Server</a></li>
                        <li><a class="dropdown-item" href="#">Technical Support</a></li>
                        <li><a class="dropdown-item" href="#">MoU</a></li>
                    </ul>
                </li>
                <li class="dropdown nav-item">
                    <a href="javascript:void(0);" class="nav-link">
                        <i class="nav-link-icon fa-solid fa-arrow-up-right-from-square"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
        <div class="app-header-right">
            <div class="header-btn-lg pe-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left">
                            <div class="btn-group">
                                <a href="/profil" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    class="p-0 btn">
                                    <img width="42"
                                        class="rounded-circle"src="{{ asset('storage/profil/' . Session::get('foto')) }}"
                                        class="avatar" id="profil_avatar">
                                    <i class="fa fa-angle-down ms-2 opacity-8"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true"
                                    class="dropdown-menu dropdown-menu-right">
                                    <button type="button" tabindex="0" class="dropdown-item">Reminder</button>
                                    <li class="nav-item dropdown">
                                        <a class="dropdown-item dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            TS dan Invoice
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Biaya Perpanjangan Maintenance
                                                    dan Server</a></li>
                                            <li><a class="dropdown-item" href="#">Technical Support</a></li>
                                            <li><a class="dropdown-item" href="#">MoU</a></li>
                                        </ul>
                                    </li>
                                    <div tabindex="-1" class="dropdown-divider"></div>
                                    <button type="button" tabindex="0" class="dropdown-item">Logout</button>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content-left  ms-3 header-user-info">
                            <a href="/profil" class="nav-link text-black">
                                <span class="nav-link-text ms-2 ps-1 nama_user">{{ Session::get('nama') }}</span>
                            </a>
                        </div>&nbsp;&nbsp;
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            <i class="fa text-white fa-solid fa-image"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="/pelaporan/preview" method="post" id="FormLaporanSisipan" target="_blank">
    @csrf

    <input type="hidden" name="type" id="type" value="pdf">
    <input type="hidden" name="tahun" id="tahun" value="{{ date('Y') }}">
    <input type="hidden" name="bulan" id="bulan" value="{{ date('m') }}">
    <input type="hidden" name="hari" id="hari" value="{{ date('d') }}">
    <input type="hidden" name="laporan" id="laporan" value="pelunasan">
    <input type="hidden" name="sub_laporan" id="sub_laporan" value="">
</form>


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                    Scan Kartu Angsuran
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="reader"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-info" id="stopScan">Stop</button>
            </div>
        </div>
    </div>
</div>