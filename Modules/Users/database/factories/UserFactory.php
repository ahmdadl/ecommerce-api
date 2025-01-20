<?php

namespace Modules\Users\Database\Factories;

use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Users\Enums\UserGender;
use Modules\Users\Enums\UserRole;
use Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Users\Models\User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('123123123'),
            'remember_token' => Str::random(10),
            'role' => UserRole::CUSTOMER,
            'is_active' => true,
            'gender' => null,
            'birth_date' => fake()->date(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model's active state.
     */
    public function unActive(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the model's role is admin.
     *
     * @return static
     */
    public function admin(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => UserRole::ADMIN,
        ]);
    }

    /**
     * Indicate that the model's role is developer.
     *
     * @return static
     */
    public function developer(): static
    {
        return $this->state(fn(array $attributes) => [
            'role' => UserRole::DEVELOPER,
        ]);
    }

    /**
     * Indicate that the model's gender is male.
     *
     * @return static
     */
    public function male(): static
    {
        return $this->state(fn(array $attributes) => [
            'gender' => UserGender::MALE,
        ]);
    }
}
