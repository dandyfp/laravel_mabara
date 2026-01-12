<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameSessionController;
use App\Http\Controllers\TransactionController;

Route::post('/game-sessions', [GameSessionController::class, 'store']);
Route::post('/transactions', [TransactionController::class, 'store']);
