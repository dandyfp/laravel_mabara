<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameSessionController;

Route::post('/game-sessions', [GameSessionController::class, 'store']);
