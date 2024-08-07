<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'email',
        'phone_number',
    ];

    public function user(): HasMany {
        return $this->hasOne(User::class);
    }

    public function projects(): BelongsTo
    {
      return $this->belongsTo(Project::class);
    }
    
    public function deals(): BelongsTo
    {
    return $this->belongsTo(Deal::class);
    }
}
