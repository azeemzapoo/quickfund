<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\PledgeController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\InvestmentController;


// Home route

Route::get('/', function () {
    return view('pages.home');
});


// Ideas route
// Route::get('/ideas', function () {
//     return view('pages.ideas');
// });

Route::get('/ideas', [IdeaController::class, 'index']);
Route::get('/ideas/create', [IdeaController::class, 'create']);
Route::post('/ideas', [IdeaController::class, 'store']);

Route::get('/ideas/{id}', [IdeaController::class, 'show']);
Route::get('/ideas/{id}/edit', [IdeaController::class, 'edit']);
Route::put('/ideas/{id}', [IdeaController::class, 'update']);
Route::delete('/ideas/{id}', [IdeaController::class, 'destroy']);


// pledge routes

Route::get('/pledges', [PledgeController::class, 'index']);
Route::post('/pledges', [PledgeController::class, 'store']);


// contribution routes

Route::get('/contributions', [ContributionController::class, 'index']);
Route::post('/contributions', [ContributionController::class, 'store']);


// investment routes

Route::get('/investments', [InvestmentController::class, 'index']);
Route::post('/investments', [InvestmentController::class, 'store']);

// Dashboard Routes

Route::get('/dashboard', function () {
    return view('pages.dashboard');
});


