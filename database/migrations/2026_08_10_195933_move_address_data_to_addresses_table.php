<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $users = DB::table('users')->whereNotNull('zip_code')->get();

        foreach ($users as $user) {
            DB::table('addresses')->insert([
                'user_id'      => $user->id,
                'zip_code'     => $user->zip_code,
                'street'       => $user->street,
                'number'       => $user->number,
                'neighborhood' => $user->neighborhood,
                'city'         => $user->city,
                'state'        => $user->state,
                'complement'   => $user->complement,
                'is_default'   => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }

    public function down(): void
    {
        // 
    }
};
