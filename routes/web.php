<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TestController as AdminTestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::group(['middleware' => 'admin', 'prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::get('', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('test-all', [AdminTestController::class, 'index'])->name('test.all');

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
