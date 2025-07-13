<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepDetail extends Model
{
    protected $fillable = [
        'resep_id',
        'obatalkes_id',
        'signa_id',
        'qty',
        'is_racikan',
        'nama_racikan',
    ];

    protected $casts = [
        'is_racikan' => 'boolean',
    ];

    public function resep()
    {
        return $this->belongsTo(Resep::class);
    }

    public function obatalkes()
    {
        return $this->belongsTo(Obatalkes::class, 'obatalkes_id', 'obatalkes_id');
    }

    public function signa()
    {
        return $this->belongsTo(Signa::class, 'signa_id', 'signa_id');
    }
}
