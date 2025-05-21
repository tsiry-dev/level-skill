<?php

namespace Database\Factories;

use App\Models\Activities;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityType>
 */
class ActivityTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $activities = Activities::all();
        $name = fake()->sentence(2, true);
        return [
            'activity_id' => $activities->unique()->random()->id,
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
        ];
    }
}
