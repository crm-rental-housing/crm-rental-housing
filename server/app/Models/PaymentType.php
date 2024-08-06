<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'description'
  ];

  public function projects(): BelongsTo
  {
    return $this->belongsTo(Project::class);
  }
}
