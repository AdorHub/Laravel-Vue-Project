<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;

class ListingPolicy
{
	public function before(User $user)
	{
		if ($user->isAdmin()) {
			return true;
		}
		return null;
	}

    public function view(?User $user, Listing $listing): bool
    {
        return $listing->user->type !== 'suspended' && $listing->approved;
    }

    public function create(User $user): bool
    {
        return $user->type !== 'suspended';
    }

    public function modify(User $user, Listing $listing): bool
    {
		return $user->id === $listing->user_id && $user->type !== 'suspended';
    }

	public function approve(User $user): bool
	{
		return $user->isAdmin();
	}
}
