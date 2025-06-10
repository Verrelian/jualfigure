<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;

    protected $table = 'specification';

    protected $primaryKey = 'spec_id';      // 👈 penting
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'scale',
        'material',
        'manufacture',
        'release_date',
        'series',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'product_id', 'product_id');
    }
}
