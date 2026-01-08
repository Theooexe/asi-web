<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),

            'authentication_token' => null,
            'authentication_token_generated_at' => null,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn () => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * State: utilisateur avec token + date générée récente (token encore valide)
     */
    public function withValidToken(?string $token=null): static
    {
        return $this->state(fn () => [
            'authentication_token' => $token??Str::random(20),
            // généré il y a 1h => valide si règle = 24h
            'authentication_token_generated_at' => now()->subHour(),
        ]);
    }

    /**
     * State: utilisateur avec token + date trop ancienne (token expiré)
     */
    public function withExpiredToken(?string $token=null): static
    {
        return $this->state(fn () => [
            'authentication_token' => $token??Str::random(20),
            // généré il y a 25h => expiré si règle = 24h
            'authentication_token_generated_at' => now()->subHours(25),
        ]);
    }
}
