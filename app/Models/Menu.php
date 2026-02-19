<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    
    public $timestamps = false;

    protected $fillable = [
        'parent_id',
        'sort',
        'title',
        'ikon',
        'type',
        'link',
        'lokasi',
        'kecuali',
        'aktif'
    ];

    /**
     * Relasi ke child menu (submenu)
     */
    public function child()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')
                    ->where('aktif', 'Y')
                    ->orderBy('sort');
    }

    /**
     * Relasi ke parent menu
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }

    /**
     * Scope untuk menu aktif saja
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', 'Y');
    }

    /**
     * Scope untuk menu utama (parent_id = 0)
     */
    public function scopeMainMenu($query)
    {
        return $query->where('parent_id', '0');
    }
}
