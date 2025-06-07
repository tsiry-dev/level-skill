<?php

use App\Http\Controllers\AccountController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::group(['middleware' => 'user', 'prefix' => 'account', 'as' => 'account.'], function() {
    Route::get('', [AccountController::class, 'index'])->name('index');
    Route::get('/test-list', [TestController::class, 'index'])->name('test');
    Route::get('/test/all', [TestController::class, 'all'])->name('test.all');

    ///USER ACCOUNT TEST
    Route::get('test/{activity}', [TestController::class, 'show'])
          ->name('test.show');

    Route::get('test/{activities}/{activityType}', [TestController::class, 'showActivityType'])
          ->name('activityType.show');

    Route::post('/test/storeStory/{activityType}', [TestController::class, 'storeTestStory'])
          ->name('test.storeTestStory');

    Route::post('/test/submission/{activityType}', [TestController::class, 'submission'])
         ->name('test.submission');

});


Route::get('account/dashboard', function () {
    return Inertia::render('pages/account/IndexVue');
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/admin.php';
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
