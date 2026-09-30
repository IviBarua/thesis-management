<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password = null;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'birth' => fake()->date(),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'department' => fake()->randomElement([
                'CSE',
                'EEE',
                'Math',
                'ECO',
            ]),
            'degree' => fake()->randomElement([
                'bsc',
                'msc',
                'phd',
            ]),
            'batch' => fake()->numberBetween(2018, 2026),
            'session' => fake()->randomElement([
                'spring',
                'summer',
                'fall',
            ]),
            'designation' => fake()->jobTitle(),
            'teacher_id' => fake()->unique()->numerify('T####'),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'teacher',
            'remember_token' => Str::random(10),
        ];
    }
}