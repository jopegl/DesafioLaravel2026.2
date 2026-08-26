<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $images = [];

        for ($i = 1; $i <= 20; $i++) {
            $filename = "products/product-{$i}.jpg";

            if (!Storage::disk('public')->exists($filename)) {
                try {
                    $response = Http::timeout(3)->get("https://picsum.photos/seed/product{$i}/640/480");

                    if ($response->successful()) {
                        Storage::disk('public')->put($filename, $response->body());
                        $images[] = $filename;
                    }
                } catch (\Exception $e) {
                }
            } else {
                $images[] = $filename;
            }
        }

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'name' => fake()->words(3, true),
            'photo' => !empty($images) ? fake()->randomElement($images) : "products/test",
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 20, 3000),
            'quantity' => fake()->numberBetween(0, 50),
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }

    public function outOfStock(): static
    {
        return $this->state(fn(array $attributes) => [
            'quantity' => 0,
        ]);
    }
}
