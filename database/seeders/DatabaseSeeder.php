<?php

namespace Database\Seeders;

use App\Models\Activities;
use App\Models\ActivityType;
use App\Models\Answer;
use App\Models\CategoryTest;
use App\Models\Formateur;
use App\Models\Niveau;
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


       foreach(Formateur::FORMATEURS as $formateur)
       {
           Formateur::create([
               'name' => $formateur['name'],
               'slug' => $formateur['slug'],
               'profile' => $formateur['profile'],
           ]);
       }

       foreach(Niveau::NIVAUX as $niveau)
       {
           Niveau::create([
              'title' => $niveau['title'],
              'slug' => $niveau['slug'],
           ]);
       }

        User::factory(80)->create();

         User::factory()->create([
             'name' => 'admin',
             'email' => 'admin@gmail.com',
             'role' => 'admin',
             'niveau_id' => null,
             'formateur_id' => null,
         ]);

         User::factory()->create([
             'name' => 'user',
             'email' => 'user@gmail.com',
             'role' => 'user',
             'niveau_id' => 1,
             'formateur_id' => 2,
         ]);



         $categoryTests = CategoryTest::CATEGORYTEST;

         foreach ($categoryTests as $categoryTest) {
             CategoryTest::create([
                 'name' => $categoryTest['name'],
                 'slug' => $categoryTest['slug'],
             ]);
         }

        DB::table('activities')->insert(Activities::ACTIVITIES);

        // Récupère toutes les activités insérées
        $activities = Activities::all();

        $activities->each(function ($activity) {
            // Associe chaque activité à une catégorie de test aléatoire
            $activity->categoryTest()->associate(CategoryTest::all()->random());
            $activity->save();
        });

        foreach ($activities as $activity) {

            // Crée entre 2 et 4 ActivityTypes pour chaque activité
            ActivityType::factory(mt_rand(2, 4))->create([
                'activity_id' => $activity->id,
            ])->each(function ($activityType) {
                    Question::factory(mt_rand(50, 300))->create([
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
