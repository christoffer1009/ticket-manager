<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'requester_id' => User::factory()->create()->id,
            'assignee_id' => User::factory()->create()->id,
            'status_id' => fake()->numberBetween(1, 3),
            'priority_id' => fake()->numberBetween(1, 4),
            'closed_at' => $this->faker->boolean ? Carbon::now() : null,
        ];
    }
}
