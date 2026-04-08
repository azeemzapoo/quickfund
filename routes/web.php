<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\PledgeController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\InvestmentController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('pages.home');
});

/*
|--------------------------------------------------------------------------
| Dashboard (Auth Protected)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes (Auth Protected)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Ideas (CRUD) - Protected
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/ideas', [IdeaController::class, 'index'])->name('ideas.index');
    Route::get('/ideas/create', [IdeaController::class, 'create'])->name('ideas.create');
    Route::post('/ideas', [IdeaController::class, 'store'])->name('ideas.store');

    Route::get('/ideas/{id}', [IdeaController::class, 'show'])->name('ideas.show');
    Route::get('/ideas/{id}/edit', [IdeaController::class, 'edit'])->name('ideas.edit');
    Route::put('/ideas/{id}', [IdeaController::class, 'update'])->name('ideas.update');
    Route::delete('/ideas/{id}', [IdeaController::class, 'destroy'])->name('ideas.destroy');

});

/*
|--------------------------------------------------------------------------
| Pledges
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/pledges', [PledgeController::class, 'index'])->name('pledges.index');
    Route::post('/pledges', [PledgeController::class, 'store'])->name('pledges.store');
});

/*
|--------------------------------------------------------------------------
| Contributions
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/contributions', [ContributionController::class, 'index'])->name('contributions.index');
    Route::post('/contributions', [ContributionController::class, 'store'])->name('contributions.store');
});

/*
|--------------------------------------------------------------------------
| Investments
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/investments', [InvestmentController::class, 'index'])->name('investments.index');
    Route::post('/investments', [InvestmentController::class, 'store'])->name('investments.store');
});