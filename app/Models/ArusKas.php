<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class ArusKas extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $lokasi = Session::get('lokasi');
        $tableName = 'arus_kas_' . $lokasi;

        $this->table = Schema::hasTable($tableName) ? $tableName : 'arus_kas';
    }

    public function child()
    {
        return $this->hasMany(ArusKas::class, 'sub', 'id')->orderBy('id', 'ASC');
    }
}
