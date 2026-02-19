<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::where('parent_id', '0')
                    ->where('aktif', 'Y')
                    ->orderBy('sort')
                    ->with(['child' => function($query) {
                        $query->where('aktif', 'Y')->orderBy('sort');
                    }, 'child.child' => function($query) {
                        $query->where('aktif', 'Y')->orderBy('sort');
                    }])
                    ->get();

        $title = 'Pengaturan Menu';
        return view('admin.menu.index')->with(compact('title', 'menu'));
    }
}
