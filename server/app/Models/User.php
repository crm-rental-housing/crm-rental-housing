<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'role_id',
        'company_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function info(): BelongsTo 
    {
      return $this->belongsTo(UserInfo::class);
    }

    public function role(): BelongsTo
    {
      return $this->belongsTo(Role::class);
    }

    public function refreshToken(): BelongsTo
    {
      return $this->belongsTo(RefreshToken::class);
    }

    public function company(): BelongsTo
    {
      return $this->belongsTo(Company::class);
    }

    public function projects(): BelongsTo
    {
      return $this->belongsTo(Project::class);
    }

    public function entities(): BelongsTo
    {
      return $this->belongsTo(Entity::class);
    }

    public function appartments(): BelongsTo
    {
      return $this->belongsTo(Appartment::class);
    }

    public function ban(): BelongsTo
    {
      return $this->belongsTo(BlackList::class);
    }
}
