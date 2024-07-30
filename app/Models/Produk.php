<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function produkkategori()
    {
        return $this->belongsTo(ProdukKategori::class, 'kategori_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['kategori'] ?? false, function ($query, $kategori) {
            $query->whereHas('produkkategori', function ($query) use ($kategori) {
                $query->where('slug', $kategori);
            });
        });
    
        $query->when($filters['search'] ?? false, function($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        });
    }
}
