<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\Reaction;
use App\Models\Note;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
public function run(): void
{
    User::factory()->admin()->create([
        'name' => 'Administrator',
        'email' => 'admin@test.nl',
    ]);

    User::factory(10)->create();

    Category::factory(5)->create();

    Ticket::factory(30)->create();

    Reaction::factory(50)->create();

    Note::factory(30)->create();
}
}
