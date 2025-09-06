<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InterviewController;

// Get authenticated user
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Admin
Route::get('/admin', [UserController::class, 'getAdmin'])->name('admin.get');

// Categories
Route::get('/categories', [CategoryController::class, 'getCategories'])->name('categories.index');

// Interviews
Route::get('/interview', [InterviewController::class, 'getAllOrPagination'])->name('interview.index');
Route::post('/add-interview', [InterviewController::class, 'addInterview'])->name('interview.store');
Route::get('/delete-interview/{id}', [InterviewController::class, 'deleteInterview'])->name('interview.delete');
Route::post('/edit-interview', [InterviewController::class, 'editInterview'])->name('interview.update');
