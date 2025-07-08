<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    use HasFactory;

	protected $fillable = [
		'title',
		'desc',
		'tags',
		'email',
		'link',
		'image',
		'approved',
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function scopeFilter($query, array $filters)
	{
		if ($filters['search'] ?? false) {
			$query->where(function ($q) use ($filters) { //for not reset other filters
				$q->where('title', 'like', '%' . $filters['search'] . '%')
				->orWhere('desc', 'like', '%' . $filters['search'] . '%');
			});
		}
		if ($filters['user_id'] ?? false) {
			$query->where('user_id', $filters['user_id']);
		}
		if ($filters['tag'] ?? false) {
			$query->where('tags', 'like', '%' . $filters['tag'] . '%');
		}
		if ($filters['disapproved'] ?? false) {
			$query->where('approved', false);
		}
	}
}
