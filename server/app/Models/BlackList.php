<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlackList extends Model
{
  use HasFactory;

  protected $fillable = [
    'is_banned',
    'reason',
    'banned_at',
    'user_id',
  ];

  public function user(): HasOne {
    return $this->hasOne(User::class);
  }
}
