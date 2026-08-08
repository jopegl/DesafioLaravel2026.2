<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        $quantity  = $this->faker->numberBetween(1, 5);
        $unitPrice = $this->faker->randomFloat(2, 10, 500);
        $totalPrice = round($quantity * $unitPrice, 2);

        return [
            'product_id'    => Product::factory(),
            'buyer_id'      => User::factory(),
            'seller_id'     => User::factory(),
            'category_id'   => Category::factory(),
            'quantity'      => $quantity,
            'unit_price'    => $unitPrice,
            'total_price'   => $totalPrice,
            'purchase_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }

    public function forProduct(Product $product): static
    {
        return $this->state(function (array $attributes) use ($product) {
            $quantity  = $attributes['quantity'];
            $unitPrice = $product->price ?? $attributes['unit_price'];

            return [
                'product_id'  => $product->id,
                'category_id' => $product->category_id,
                'seller_id'   => $product->user_id ?? $attributes['seller_id'],
                'unit_price'  => $unitPrice,
                'total_price' => round($quantity * $unitPrice, 2),
            ];
        });
    }
}
