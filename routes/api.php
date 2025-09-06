<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InterviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Admin
Route::get('/admin', [UserController::class, 'getAdmin'])->name('admin.get');

// Categories
Route::get('/categories', [CategoryController::class, 'getCategories'])->name('categories.list');

// Interviews
Route::get('/interview', [InterviewController::class, 'getAllOrPagination'])->name('interview.list');
Route::post('/add-interview', [InterviewController::class, 'addInterview'])->name('interview.add');
Route::post('/edit-interview', [InterviewController::class, 'editInterview'])->name('interview.edit');
Route::get('/delete-interview/{id}', [InterviewController::class, 'deleteInterview'])->name('interview.delete');
