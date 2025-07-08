<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
		'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

	public function listings(): HasMany
	{
		return $this->hasMany(Listing::class);
	}

	public function isAdmin(): bool
	{
		return $this->type === 'admin';
	}

	public function scopeFilter($query, array $filters)
	{
		if ($filters['search'] ?? false) {
			$query->where(function ($q) use ($filters) {
				$q->where('name', 'like', '%' . $filters['search'] . '%')
				->orWhere('email', 'like', '%' . $filters['search'] . '%');
			});
		}
		if ($filters['user_type'] ?? false) {
			$query->where('type', $filters['user_type']);
		}
	}
}
