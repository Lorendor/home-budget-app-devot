<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use Illuminate\Support\Facades\Route;

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Balance
Route::get('/balance', [AuthController::class, 'balance'])->middleware('auth:sanctum');

// Category
Route::apiResource('categories', CategoryController::class);

// Expense
Route::apiResource('expenses', ExpenseController::class)->middleware('auth:sanctum');

// Income
Route::apiResource('incomes', IncomeController::class)->middleware('auth:sanctum');