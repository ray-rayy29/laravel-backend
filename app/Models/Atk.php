<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atk extends Model
{
    protected $table = 'atk';
    
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'satuan',
        'stok',
        'keterangan',
        'gambar'
    ];
}