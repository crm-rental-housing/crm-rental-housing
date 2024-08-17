<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
  use HasFactory;

  protected $fillable = [
		'username',
		'first_name',
		'middle_name',
		'last_name',
		'gender',
		'birthdate',
		'phone_number',
		'user_id',
  ];

	public function user(): BelongsTo {
		return $this->belongsTo(User::class);
	}
}
