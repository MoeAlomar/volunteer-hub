<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OpportunityController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

// ---------- Public site ----------
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/opportunities', [PublicController::class, 'opportunities'])->name('opportunities.index');
Route::get('/opportunities/{opportunity}', [PublicController::class, 'show'])->name('opportunities.show');
Route::get('/details', [PublicController::class, 'details'])->name('details');
Route::get('/about', [PublicController::class, 'about'])->name('about');

Route::post('/register', [RegistrationController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('register');

// ---------- Admin ----------
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::redirect('/', '/admin/dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('opportunities', OpportunityController::class)
            ->except(['index', 'show'])
            ->whereNumber('opportunity');

        Route::delete('registrations/{registration}', [AdminRegistrationController::class, 'destroy'])
            ->whereNumber('registration')
            ->name('registrations.destroy');
    });
});
