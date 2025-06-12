<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Specification;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'description',
        'type',
        'price',
        'stock',
        'sold',
        'rating_total',
        'image' // ← pastikan ini sesuai dengan nama kolom di database
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function specification()
    {
        return $this->hasOne(Specification::class, 'product_id', 'product_id');
    }

    // Perbaiki accessor ini
    public function getFormattedHargaAttribute()
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }

    // PERBAIKI: gunakan kolom yang benar
    public function getGambarUrlAttribute()
    {
        return $this->image ? 'images/' . $this->image : null;
        // ↑ gunakan 'image' bukan 'images'
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}