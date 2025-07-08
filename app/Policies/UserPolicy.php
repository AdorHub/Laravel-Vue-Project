<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function modifyType(User $user)
	{
		return $user->isAdmin();
	}
}
