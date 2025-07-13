<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResepObat extends Model
{
    protected $fillable = ['resep_detail_id', 'obatalkes_id', 'qty'];

    public function resepDetail()
    {
        return $this->belongsTo(ResepDetail::class);
    }

    public function obatalkes()
    {
        return $this->belongsTo(Obatalkes::class, 'obatalkes_id');
    }
}
