<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="/dashboard">
        <img src="{{ $logo }}" width="26px" height="26px" class="navbar-brand-img h-100" alt="main_logo"
          onerror="this.onerror=null; this.src='/assets/img/logo.jpeg';">
        <span class="ms-1 font-weight-bold">{{ Session::get('nama_lembaga') }}</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">

    <div class="sidenav-scroll-wrapper">
        @include('layouts.menu', ['parent_menu' => Session::get('menu')])
    </div>

    {{-- Tombol TUTUP sidebar — tampil di dalam sidebar saat sidebar terbuka --}}
    <div class="sidenav-footer px-3 pb-3 pt-2 border-top">
        <a href="javascript:;" class="nav-link p-0 d-flex align-items-center gap-2 text-secondary" id="iconNavbarSidenav" title="Tutup Sidebar">
            <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
            </div>
            <span class="text-xs font-weight-bold">Tutup Sidebar</span>
        </a>
    </div>

</aside>

{{-- Tombol BUKA sidebar — mengambang di kiri layar, hanya tampil saat sidebar tertutup --}}
<button id="btnOpenSidenav" class="btn-open-sidenav" title="Buka Sidebar">
    <i class="fas fa-bars"></i>
</button>

<style>
    /* ===== Tombol floating buka sidebar ===== */
    .btn-open-sidenav {
        position: fixed;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        z-index: 999;
        background: #5e72e4;
        color: white;
        border: none;
        border-radius: 0 8px 8px 0;
        width: 28px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 2px 2px 8px rgba(0,0,0,0.25);
        transition: opacity 0.3s ease, width 0.3s ease;
        opacity: 0.85;
        padding: 0;
        font-size: 13px;
    }

    .btn-open-sidenav:hover {
        opacity: 1;
        width: 34px;
    }

    /* Sembunyikan tombol buka saat sidebar sedang terbuka/pinned */
    .g-sidenav-pinned .btn-open-sidenav {
        opacity: 0;
        pointer-events: none;
    }

    /* Sembunyikan juga saat sidebar tampil penuh di desktop (xl ke atas) */
    @media (min-width: 1200px) {
        .btn-open-sidenav {
            display: none;
        }
    }

    /* ===== Sidebar footer toggler ===== */
    .sidenav-footer {
        margin-top: auto;
    }

    .sidenav-footer .sidenav-toggler-line {
        background-color: #344767;
    }
</style>

<script>
    // Tombol floating klik → trigger toggle yang sama dengan Argon
    document.getElementById('btnOpenSidenav').addEventListener('click', function () {
        document.getElementById('iconNavbarSidenav').click();
    });
</script>
