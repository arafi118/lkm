<div class="scrollbar-sidebar">
    <div class="app-sidebar__inner"><br>
        <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
            <a href="/dashboard" class="logo" id="nama_lembaga_sort" style="color: rgb(0, 0, 0); font-weight: bold;">
                {{ Session::get('nama_lembaga') }}
            </a>
        </div>

        <br>
        <hr class="horizontal light mt-0">
        <ul class="vertical-nav-menu">
            @include('layouts.menu', ['parent_menu' => Session::get('menu')])
        </ul>
    </div>
</div>
