<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;

    protected $table = 'specification'; // ganti sesuai nama tabel spesifikasimu

    protected $fillable = [
        'product_id',    // FK ke produk
        'scale',
        'material',
        'manufacture',
        'release_date',
        'series',
    ];

    // Relasi kebalikannya ke Produk (banyak Spesifikasi milik satu Produk)
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'product_id', 'id');
    }
    public $timestamps = false;
}
