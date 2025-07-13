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

    // RELASI BARU: Relasi ke racikan details
    public function racikanDetails()
    {
        return $this->hasMany(RacikanDetail::class);
    }

    // HELPER METHOD: Mendapatkan detail racikan dengan format yang rapi
    public function getRacikanDetailsFormatted()
    {
        if (!$this->is_racikan) {
            return null;
        }

        return $this->racikanDetails()
            ->with('obatalkes')
            ->get()
            ->map(function ($detail) {
                return [
                    'nama_obat' => $detail->obatalkes->obatalkes_nama ?? 'Obat tidak ditemukan',
                    'kode_obat' => $detail->obatalkes->obatalkes_kode ?? '-',
                    'qty' => $detail->qty,
                    'satuan' => $detail->satuan,
                    'keterangan' => $detail->keterangan,
                    'stok_tersedia' => $detail->obatalkes->stok ?? 0
                ];
            });
    }

    // HELPER METHOD: Menghitung total obat dalam racikan
    public function getTotalObatRacikan()
    {
        if (!$this->is_racikan) {
            return 0;
        }

        return $this->racikanDetails()->count();
    }
}