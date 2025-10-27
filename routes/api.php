<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/balance', [AuthController::class, 'balance'])->middleware('auth:sanctum');

// Category
Route::apiResource('categories', CategoryController::class);

// Expense
Route::apiResource('expenses', ExpenseController::class)->middleware('auth:sanctum');

// Income
Route::apiResource('incomes', IncomeController::class)->middleware('auth:sanctum');

// Reports
Route::prefix('reports')->middleware('auth:sanctum')->group(function () {
    Route::get('/overview', [ReportController::class, 'overview']);
    Route::get('/monthly', [ReportController::class, 'monthly']);
    Route::get('/quarterly', [ReportController::class, 'quarterly']);
    Route::get('/yearly', [ReportController::class, 'yearly']);
});
