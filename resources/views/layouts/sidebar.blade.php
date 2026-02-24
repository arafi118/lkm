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

  </aside>
