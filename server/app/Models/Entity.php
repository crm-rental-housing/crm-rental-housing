<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;;

class Entity extends Model
{
  use HasFactory;

  protected $fillable = [
    'city',
    'street',
    'house',
    'floors_number',
    'entrances_number',
    'project_id',
    'user_id',
  ];

  public function project(): BelongsTo {
    return $this->belongsTo(Project::class);
  }

  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function appartments(): HasMany {
    return $this->hasMany(Appartment::class);
  }
}
