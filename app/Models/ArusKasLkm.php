<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArusKasLkm extends Model
{
    use HasFactory;

    public function getTable()
    {
        $lokasi = session('lokasi');

        $lokasiKop = [1, 351, 352, 353, 354];

        if (in_array($lokasi, $lokasiKop)) {
            return 'arus_kas_kop';
        }

        return 'arus_kas_lkm';
    }

    public function child()
    {
        return $this->hasMany(ArusKasLkm::class, 'parent_id');
    }
}
