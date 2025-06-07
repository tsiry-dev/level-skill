<?php

use App\Http\Controllers\Admin\ActivitiesController;
use App\Http\Controllers\Admin\ActivityTypeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FormateurController;
use App\Http\Controllers\Admin\QuestionsController;
use App\Http\Controllers\Admin\ResponseController;
use App\Http\Controllers\Admin\SecurityController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TestController as AdminTestController;
use App\Http\Controllers\CategoryTestController;
use App\Http\Controllers\NiveauController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::get('', [DashboardController::class, 'index'])
          ->name('dashboard');

    //TEST
    Route::get('test', [AdminTestController::class, 'index'])
          ->name('tests.all');

    Route::get('test/create', [AdminTestController::class, 'create'])
          ->name('tests.create');

    Route::post('test/create', [AdminTestController::class, 'store'])
          ->name('tests.store');

    Route::get('test/{activity}', [ActivitiesController::class, 'show'])
          ->name('activities.show');

    //ACTIVITY
    Route::delete('activity/{activity}', [ActivitiesController::class, 'remove'])
          ->name('activities.remove');

    Route::patch('activity/{activity}', [ActivitiesController::class, 'update'])
          ->name('activities.update');


    //ACTIVITYTYPE
    Route::post('activity/{activity}', [ActivityTypeController::class, 'store'])
          ->name('activityTypes.store');

    Route::post('test/{activity}/{activityType}', [ActivityTypeController::class, 'showActivityType'])
          ->name('activityTypes.show');

    Route::delete('test/{activity}/{activityType}', [ActivityTypeController::class, 'destroy'])
          ->name('activityTypes.destroy');

    Route::patch('test/{activity}/{activityType}', [ActivityTypeController::class, 'update'])
          ->name('activityTypes.update');

    Route::patch('test/{activityType}', [ActivityTypeController::class, 'updateStatus'])
          ->name('activityTypes.updateStatus');

    //QUESTIONS
    Route::get('test/{activities}/{activityType}', [QuestionsController::class, 'show'])
          ->name('questions.show');

    Route::post('activityTypes/{activityType}', [QuestionsController::class, 'store'])
          ->name('questions.store');

    Route::patch('questions/{activityType}', [QuestionsController::class, 'updateCount'])
          ->name('questions.updateCount');

    //RESPONSES
    Route::post('responses/{activityType}', [ResponseController::class, 'store'])
          ->name('responses.store');

    Route::delete('responses/{answer}', [ResponseController::class, 'remove'])
          ->name('responses.remove');

    //CATEGORIES
    Route::get('categories', [CategoryTestController::class, 'index'])
          ->name('categories.index');

    Route::get('categories/{categoryTest}', [CategoryTestController::class, 'show'])
          ->name('categories.show');

    Route::post('/categories', [CategoryTestController::class, 'store'])
         ->name('categories.store');

    Route::put('/categories/{categoryTest}', [CategoryTestController::class, 'update'])
         ->name('categories.update');

    Route::delete('/categories/{categoryTest}', [CategoryTestController::class, 'destroy'])
         ->name('categories.destroy');

    //STUDENT
    Route::get('students', [StudentController::class, 'index'])
          ->name('students');

    Route::get('students/{user}', [StudentController::class, 'show'])
          ->name('students.show');

    //FORMATEURS
    Route::get('formateurs', [FormateurController::class, 'index'])
        ->name('formateurs.index');

    Route::post('formateurs', [FormateurController::class, 'store'])
        ->name('formateurs.store');

    Route::put('formateurs/{formateur}', [FormateurController::class, 'update'])
        ->name('formateurs.update');

    Route::delete('formateurs/{formateur}', [FormateurController::class, 'destroy'])
        ->name('formateurs.destroy');

    //NIVEAUX
    Route::get('niveaux', [\App\Http\Controllers\Admin\NiveauController::class, 'index'])
        ->name('niveaux.index');

    Route::post('niveaux', [\App\Http\Controllers\Admin\NiveauController::class, 'store'])
        ->name('niveaux.store');

    Route::put('niveaux/{niveau}', [\App\Http\Controllers\Admin\NiveauController::class, 'update'])
        ->name('niveaux.update');

    Route::delete('niveaux/{niveau}', [\App\Http\Controllers\Admin\NiveauController::class, 'destroy'])
        ->name('niveaux.destroy');

    //SECURITY
    Route::get('security', [SecurityController::class, 'index'])
        ->name('security.index');

    Route::post('security', [SecurityController::class, 'update'])
        ->name('security.update');


});
