<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $buyers   = User::where('is_admin', false)->get();

        if ($products->isEmpty() || $buyers->isEmpty()) {
            $this->command->warn('Rode ProductsSeeder e UsersSeeder antes de SalesSeeder.');
            return;
        }

        $products->each(function (Product $product) use ($buyers) {
            Sale::factory()
                ->count(rand(1, 4))
                ->forProduct($product)
                ->create([
                    'buyer_id' => fn() => $buyers->random()->id,
                ]);
        });
    }
}
