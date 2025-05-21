<?php

namespace Database\Seeders;

use App\Models\Activities;
use App\Models\ActivityType;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

         User::factory()->create([
             'name' => 'admin',
             'email' => 'admin@gmail.com',
             'role' => 'admin'
         ]);

         DB::table('activities')->insert(Activities::ACTIVITIES);


        // Récupère toutes les activités insérées
        $activities = Activities::all();

        foreach ($activities as $activity) {
            // Crée entre 2 et 4 ActivityTypes pour chaque activité
            ActivityType::factory(mt_rand(2, 4))->create([
                'activity_id' => $activity->id,
            ])->each(function ($activityType) {
                    Question::factory(mt_rand(8, 12))->create([
                        'activity_type_id' => $activityType->id,
                    ])->each(function ($question) {
                        $numAnswers = mt_rand(4, 6);
                        $correctIndex = rand(0, $numAnswers - 1); // indice de la réponse correcte

                        for ($i = 0; $i < $numAnswers; $i++) {
                            Answer::factory()->create([
                                'question_id' => $question->id,
                                'is_correct' => $i === $correctIndex,  // true pour une seule réponse, false sinon
                            ]);
                        }
                    });

            });
        }


    }
}
