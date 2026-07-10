<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
public function definition(): array
{
    return [
        'note' => fake()->paragraph(),
        'ticket_id' => Ticket::query()->inRandomOrder()->value('id'),
        'user_id' => User::query()->inRandomOrder()->value('id'),
    ];
}
}