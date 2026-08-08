<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::pluck('id');
        $categoryIds = Category::pluck('id');

        if ($userIds->isEmpty() || $categoryIds->isEmpty()) {
            $this->command->warn('Nenhum usuário ou categoria encontrado. Rode UserSeeder e CategorySeeder antes.');
            return;
        }

        Product::factory()
            ->count(50)
            ->create([
                'user_id' => fn() => $userIds->random(),
                'category_id' => fn() => $categoryIds->random(),
            ]);

        Product::factory()
            ->count(5)
            ->outOfStock()
            ->create([
                'user_id' => fn() => $userIds->random(),
                'category_id' => fn() => $categoryIds->random(),
            ]);
    }
}
