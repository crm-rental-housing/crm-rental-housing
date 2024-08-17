<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


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

    public function projects(): HasMany
    {
      return $this->hasMany(Project::class);
    }
    
    public function deals(): HasMany
    {
    return $this->HasMany(Deal::class);
    }
}
