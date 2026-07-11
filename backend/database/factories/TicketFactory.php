<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),

            'description' => fake()->paragraph(),

            'status' => fake()->randomElement([
                'Open',
                'In behandeling',
                'Gesloten'
            ]),

            'priority' => fake()->randomElement([
                'Laag',
                'Normaal',
                'Hoog'
            ]),

            'user_id' => User::inRandomOrder()->value('id'),

            'category_id' => Category::inRandomOrder()->value('id'),

            'assigned_to' => null,
        ];
    }
}