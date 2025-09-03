<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InterviewController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login',[AuthController::class,'login'])->name('login');

Route::get('/admin', [UserController::class,'getAdmin'])->name('getAdmin');

Route::get('/categories',[CategoryController::class,'getCategories'])->name('categories');

Route::get('/interview',[InterviewController::class,'getAllOrPagination'])->name('interview');

Route::post('/add-interview',[InterviewController::class,'addInterview'])->name('interview');

Route::delete('/interview/{id}',[InterviewController::class,'deleteInterview'])->name('deleteInterview');

Route::patch('/interview',[InterviewController::class,'editInterview'])->name('editInterview');