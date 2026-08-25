<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $avatars = [];

        //peguei de 10 a 30 pra variar as imagens
        for ($i = 10; $i <= 30; $i++) {
            $filename = "users/avatar-{$i}.jpg";

            if (!Storage::disk('public')->exists($filename)) {
                try {
                    $response = Http::timeout(3)->get("https://i.pravatar.cc/300?img={$i}");

                    if ($response->successful()) {
                        Storage::disk('public')->put($filename, $response->body());
                        $avatars[] = $filename;
                    }
                } catch (\Exception $e) {
                }
            } else {
                $avatars[] = $filename;
            }
        }

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => false,
            'phone' => fake()->numerify('###########'),
            'birth_date' => fake()->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d'),
            'cpf' => fake('pt_BR')->cpf(false),
            'balance' => fake()->randomFloat(2, 0, 5000),
            'photo' => !empty($avatars) ? fake()->randomElement($avatars) : null,
            'created_by' => null,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_admin' => true,
            'balance' => 0,
        ]);
    }

    public function createdBy(User $user): static
    {
        return $this->state(fn(array $attributes) => [
            'created_by' => $user->id,
        ]);
    }
}
