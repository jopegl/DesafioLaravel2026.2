<?php

namespace App\Policies;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SalePolicy
{
    public function exportXlsx(User $user): bool
    {
        return $user->is_admin();
    }
}
