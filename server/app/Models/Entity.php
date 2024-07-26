<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
  use HasFactory;

  protected $fillable = [
    'city',
    'street',
    'house',
    'project_id',
    'floors_number',
    'entrances_number'
  ];

  public function project(): HasOne {
    return $this->hasOne(Project::class);
  }

  public function appartments(): BelongsTo {
    return $this->belongsTo(Appartment::class);
  }
}
