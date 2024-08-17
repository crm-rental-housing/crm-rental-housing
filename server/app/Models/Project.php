<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;;

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

  public function paymentType(): BelongsTo {
    return $this->belongsTo(PaymentType::class);
  }

  public function company(): BelongsTo {
    return $this->belongsTo(Company::class);
  }
  
  public function user(): BelongsTo {
    return $this->belongsTo(User::class);
  }

  public function images(): HasMany {
    return $this->hasMany(ProjectImage::class);
  }

  public function entities(): HasMany {
    return $this->hasMany(Entity::class);
  }
}
