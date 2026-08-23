<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                'email' => 'admin@emporio.com',
                'password' => Hash::make('12345678'),
            ])
        );

        User::factory()->count(10)->create();

        User::factory()->count(5)->createdBy($admin)->create();
    }
}
