<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pesanan_detail()
    {
        return $this->hasMany(PesananDetail::class, 'pesanan_id');
    }
    public function scopeFilter($query, $filters)
    {
        if (isset($filters['status']) && $filters['status'] !== '') {
            return $query->where('status', $filters['status']);
        }
        return $query;
    }
}
