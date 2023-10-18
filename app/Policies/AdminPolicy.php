<?php

namespace App\Policies;

use App\Models\Admin;

class AdminPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function destroy(Admin $user, Admin $admin)
    {
        return $user->id !== $admin->id;
    }
}
