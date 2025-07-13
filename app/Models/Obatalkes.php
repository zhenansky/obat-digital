<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obatalkes extends Model
{
    protected $table = 'obatalkes_m';
    protected $primaryKey = 'obatalkes_id';

    protected $fillable = [
        'obatalkes_nama',
        'stok',
        'is_active',
        'is_deleted',
    ];

    public function resepDetails()
    {
        return $this->hasMany(ResepDetail::class, 'obatalkes_id', 'obatalkes_id');
    }
}