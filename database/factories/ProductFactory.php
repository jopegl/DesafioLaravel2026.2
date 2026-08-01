<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'nome' => fake()->words(3, true),
            'foto' => fake()->imageUrl(640, 480, 'products', true),
            'descricao' => fake()->paragraph(),
            'preco' => fake()->randomFloat(2, 20, 3000),
            'quantidade' => fake()->numberBetween(0, 50),
        ];
    }

    public function semEstoque(): static
    {
        return $this->state(fn(array $attributes) => [
            'quantidade' => 0,
        ]);
    }
}
