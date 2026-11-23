<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\Concerns\UsesVietnameseFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    use UsesVietnameseFaker;
    /** Bộ đếm giúp email luôn duy nhất dù mỗi lần tạo có Faker mới. */
    protected static int $emailCounter = 0;
    
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
        $name = $this->faker->name();

        return [
            'name' => $name,
            'email' => Str::slug($name, '.') . '.' . (++static::$emailCounter) . random_int(10, 99) . '@example.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make(config('planin.seed_password', 'password123')),
            'role' => 'member',
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
