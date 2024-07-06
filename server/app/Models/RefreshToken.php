<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'refresh_token',
        'expires_in',
        'user_id'
    ];

    public function user(): HasOne {
        return $this->hasOne(User::class);
    }
}