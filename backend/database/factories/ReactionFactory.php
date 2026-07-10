<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReactionFactory extends Factory
{
public function definition(): array
{
    return [
        'message' => fake()->paragraph(),
        'ticket_id' => Ticket::query()->inRandomOrder()->value('id'),
        'user_id' => User::query()->inRandomOrder()->value('id'),
    ];
}
}
