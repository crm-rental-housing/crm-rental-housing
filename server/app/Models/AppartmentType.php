<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppartmentType extends Model
{
  use HasFactory;

  protected $fillable = [
    'value',
    'description'
  ];

  public function appartments(): BelongsTo {
    return $this->belongsTo(Appartment::class);
  }
}
