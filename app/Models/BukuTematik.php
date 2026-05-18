<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BukuTematik extends Model
{
    protected $table = 'buku_tematik';

    public $timestamps = false;

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'nomor_rak',
        'judul',
        'penerbit',
        'kelas',
        'semester',
        'kurikulum',
        'stok',
        'gambar'
    ];
}
