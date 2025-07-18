<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArusKasLkm extends Model
{
    use HasFactory;
    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = 'arus_kas_lkm';
    }

    public function child()
    {
        return $this->hasMany(ArusKasLkm::class, 'parent_id');
    }
}
