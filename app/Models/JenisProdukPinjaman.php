<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisProdukPinjaman extends Model
{
    use HasFactory;

    protected $table = 'jenis_produk_pinjaman';
    public $timestamps = false;

    public function pinjaman_kelompok()
    {
        return $this->hasMany(PinjamanKelompok::class, 'jenis_pp');
    }

    public function pinjaman_anggota()
    {
        return $this->hasMany(PinjamanAnggota::class, 'jenis_pp');
    }

    public function pinjaman_individu()
    {
        return $this->hasMany(PinjamanIndividu::class, 'jenis_pp');
    }

    public function max_pros()
    {
        return $this->hasOne(PinjamanIndividu::class, 'jenis_pp')
            ->where('status', 'A')
            ->orderByRaw('CASE WHEN jangka = 0 THEN 0 ELSE (pros_jasa / jangka) END DESC');
    }

}
