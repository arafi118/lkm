@foreach ($parent_menu as $menu)
    @if (count($menu->child) > 0)
        @php
            $link = [];
            $path = '/' . Request::path();
            $links = $menu->child->pluck('link');
            $links->each(function ($menu_link) use (&$link) {
                $link[] = $menu_link;
            });
            
            // Cek juga apakah ada grandchild yang aktif
            foreach ($menu->child as $child) {
                if (count($child->child ?? []) > 0) {
                    $child->child->pluck('link')->each(function ($menu_link) use (&$link) {
                        $link[] = $menu_link;
                    });
                }
            }
            
            $active = '';
            if (in_array($path, $link)) {
                $active = 'mm-active';
            }
            if (in_array(str_replace('#', '', $menu->link), explode('/', $path))) {
                $active = 'mm-active';
            }
        @endphp
        <li class="{{ isset($depth) ? 'depth-' . $depth : 'depth-0' }}">
            <a href="#menu_{{ str_replace('#', '', $menu->link) }}" class="{{ $active }}"
                aria-controls="menu_{{ str_replace('#', '', $menu->link) }}" role="button" aria-expanded="false">
                @if ($menu->type == 'material')
                    <i class="metismenu-icon pe-7s-{{ $menu->ikon }}"></i>
                @endif
                {{ $menu->title }}
                <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
            </a>
            <ul>
                @include('layouts.menu', ['parent_menu' => $menu->child, 'depth' => (isset($depth) ? $depth + 1 : 1)])
            </ul>
        </li>
    @else
        @if ($menu->link == '' && $menu->type == '' && $menu->ikon == '')
            <hr class="horizontal light mt-0">
            <li>
                <h6 class="text-uppercase">{{ $menu->title }}</h6>
            </li>
        @else
            @php
                $path = '/' . Request::path();

                $arr_path = explode('/', $path);
                $arr_menu = explode('/', $menu->link);

                $end_page = end($arr_path);
                $end_menu_link = end($arr_menu);

                $active = '';
                if ($path == $menu->link || $end_page == $end_menu_link) {
                    $active = 'mm-active';
                }

                if (
                    (in_array('detail', $arr_path) || in_array('lunas', $arr_path)) &&
                    ($menu->link == '/perguliran' || $menu->link == '/perguliran_i')
                ) {
                    $active = 'mm-active';
                }
            @endphp
            <li class="{{ isset($depth) ? 'depth-' . $depth : 'depth-0' }}">
                <a href="{{ $menu->link }}" class="{{ $active }}">
                    @if ($menu->type == 'material')
                        <i class="metismenu-icon pe-7s-{{ $menu->ikon }}"></i>
                    @endif
                    {{ $menu->title }}
                </a>
            </li>
        @endif
    @endif
@endforeach
