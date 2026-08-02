<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@emporio.com'],
            User::factory()->admin()->raw([
                'name' => 'Administrador',
            ])
        );

        User::factory()->count(10)->create();

        User::factory()->count(5)->createdBy($admin)->create();
    }
}
