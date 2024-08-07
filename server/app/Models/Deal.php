<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
  use HasFactory;

  protected $fillable = [
    'client_id',
    'employee_id',
    'company_id',
    'appartment_id',
    'payment_type_id',
  ];

  public function client(): HasOne {
    return $this->hasOne(User::class);
  }

  public function employee(): HasOne {
    return $this->hasOne(User::class);
  }

  public function company(): HasOne {
    return $this->hasOne(Company::class);
  }

  public function appartment(): HasOne {
    return $this->hasOne(Appartment::class);
  }

  public function paymentType(): HasOne {
    return $this->hasOne(PaymentType::class);
  }
}
