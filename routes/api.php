<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameSessionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminUtilityController;


Route::get('/game-sessions/{id}/summary', [GameSessionController::class, 'summary']);
Route::post('/game-sessions', [GameSessionController::class, 'store']);
Route::post('/transactions', [TransactionController::class, 'store']);
Route::get('reports/daily',[ReportController::class,'daily']);
Route::patch('transactions/{id}/mark-paid', [TransactionController::class, 'markPaid']);
Route::get('/manual-promote', [AdminUtilityController::class, 'promoteToAdmin']);