<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RacikanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'resep_detail_id',
        'obatalkes_id',
        'qty',
        'satuan',
        'keterangan'
    ];

    protected $casts = [
        'qty' => 'decimal:2',
        'obatalkes_id' => 'integer'
    ];

    // Relasi ke ResepDetail
    public function resepDetail()
    {
        return $this->belongsTo(ResepDetail::class);
    }

    // Relasi ke Obatalkes - sesuaikan dengan nama tabel dan foreign key yang benar
    public function obatalkes()
    {
        return $this->belongsTo(Obatalkes::class, 'obatalkes_id', 'obatalkes_id');
    }
}