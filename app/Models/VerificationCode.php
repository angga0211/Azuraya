<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function isExpired()
    {
        $expirationTime = now()->subMinutes(5);
        return $this->updated_at->lt($expirationTime);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
