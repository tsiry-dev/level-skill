<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\ActivitiesController;
use App\Http\Controllers\Admin\ActivityTypeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuestionsController;
use App\Http\Controllers\Admin\ResponseController;
use App\Http\Controllers\Admin\TestController as AdminTestController;
use App\Http\Controllers\CategoryTestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');


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

    //QUESTIONS
    Route::get('test/{activities}/{activityType}', [QuestionsController::class, 'show'])
          ->name('questions.show');

    Route::post('activityTypes/{activityType}', [QuestionsController::class, 'store'])
          ->name('questions.store');

    //RESPONSES
    Route::post('responses/{activityType}', [ResponseController::class, 'store'])
          ->name('responses.store');

    Route::delete('responses/{answer}', [ResponseController::class, 'remove'])
          ->name('responses.remove');

    //CATEGORIESTEST
    Route::get('categories', [CategoryTestController::class, 'index'])
          ->name('categories.index');


});



Route::group(['middleware' => 'user', 'prefix' => 'account', 'as' => 'account.'], function() {
    Route::get('', [AccountController::class, 'index'])->name('index');
    Route::get('/test-list', [TestController::class, 'index'])->name('test');
    Route::get('/test/all', [TestController::class, 'all'])->name('test.all');
});




// Route::get('account', function () {
//     return Inertia::render('account/IndexVue');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
