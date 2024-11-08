<?php

namespace App\Policies;

use App\Models\User;

class MenuPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAdminMenu(User $user)
    {
        return $user->hasRole('admin');
    }
}
