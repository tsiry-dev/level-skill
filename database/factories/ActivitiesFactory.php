<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activities>
 */
class ActivitiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $users = User::all();
        $title = fake()->sentence(1, true);

        return [
            'created_by' => $users->unique()->random()->id,
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title) . '-' . time(),
            'description' => fake()->sentences(3, true)
        ];
    }
}
