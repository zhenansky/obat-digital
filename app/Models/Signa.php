<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signa extends Model
{
    protected $table = 'signa_m';
    protected $primaryKey = 'signa_id';

    protected $fillable = [
        'signa_nama',
        'is_active',
        'is_deleted',
    ];

    public function resepDetails()
    {
        return $this->hasMany(ResepDetail::class, 'signa_id', 'signa_id');
    }
}