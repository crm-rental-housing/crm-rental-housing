<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'description',
    'deadline',
    'payment_type_id',
    'company_id',
    'user_id',
  ];

  public function paymentType(): HasOne {
    return $this->hasOne(PaymentType::class);
  }

  public function company(): HasOne {
    return $this->hasOne(Company::class);
  }
  
  public function user(): HasOne {
    return $this->hasOne(User::class);
  }

  public function images(): BelongsTo {
    return $this->belongsTo(ProjectImage::class);
  }

  public function entities(): BelongsTo {
    return $this->belongsTo(Entity::class);
  }
}
