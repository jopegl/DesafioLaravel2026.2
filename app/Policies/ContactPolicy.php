<?php

namespace App\Policies;

use App\Models\User;

class ContactPolicy
{
    public function indexAllMessages(User $user)
    {
        return $user->is_admin;
    }

    public function reply(User $user)
    {
        return $user->is_admin;
    }
}
