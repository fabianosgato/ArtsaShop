<?php

namespace Database\Factories;

use App\Models\CustomerEntity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<CustomerEntity>
 */
class CustomerFactory extends Factory
{

    /**
     * O nome do model correspondente à factory.
     */
    protected $model = CustomerEntity::class;

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
            'customer_name' => fake()->name(),
            'customer_email' => fake()->unique()->safeEmail(),
            'vat_number' => fake()->unique()->numberBetween(1000, 999999),
            'date_of_birth' => fake()->date(),
            'customer_passwd' => static::$password ??= Hash::make('password'),
        ];
    }
}
