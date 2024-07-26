<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appartment extends Model
{
  use HasFactory;

  protected $fillable = [
    'price',
    'entrance_number',
    'floor_number',
    'appartment_number',
    'rooms_number',
    'total_area',
    'kitchen_area',
    'repair_type',
    'type_id',
    'entity_id',
  ];

  public function entity(): HasOne {
    return $this->hasOne(Entity::class);
  }

  public function type(): HasOne {
    return $this->hasOne(AppartmentType::class);
  }
}
