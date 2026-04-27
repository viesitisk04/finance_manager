<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 5, 2500),
            'type' => $this->faker->randomElement(['income', 'expense']),
            'category' => $this->faker->randomElement(['Salary', 'Food', 'Transport', 'Utilities', 'Freelance']),
            'description' => $this->faker->optional()->sentence(),
            'date' => $this->faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
        ];
    }
}
