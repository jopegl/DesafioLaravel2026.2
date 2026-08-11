<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function accessUsersList(User $user): bool
    {
        return $user->is_admin;
    }

    public function accessAdminsList(User $user): bool
    {
        return $user->is_admin;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, User $model): bool
    {
        if ($model->is_admin) {
            return false;
        }
        return $user->is_admin;
    }

    public function delete(User $user, User $model): bool
    {
        if ($model->is_admin) {
            return false;
        }
        return $user->is_admin && $user->id !== $model->id;
    }

    public function manageAdmins(User $user, User $model): bool
    {
        if (!$model->is_admin) {
            return false;
        }

        return $user->id === $model->id || $model->created_by === $user->id;
    }
}
