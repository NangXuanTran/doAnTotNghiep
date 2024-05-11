<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HomeworkController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/sign-in', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('sign-in');

Route::post('/sign-in', [LoginController::class, 'store'])
    ->middleware('guest');

Route::middleware(['auth', 'manager'])->group(function () {
    Route::get('/my-info/{id}', [AuthController::class, 'myInfo'])->name('auth.my-info');
    Route::PUT('/change-info/{id}', [AuthController::class, 'changeMyInfo'])->name('auth.change-info');

    Route::get('/password/{id}', [AuthController::class, 'password'])->name('auth.password');
    Route::PUT('/change-password/{id}', [AuthController::class, 'changeMyPassword'])->name('auth.change-my-password');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::resource('user', UserController::class);
        Route::resource('teacher', TeacherController::class);
        Route::resource('room', RoomController::class);
        Route::resource('document', DocumentController::class);
        Route::post('/document/upload', [DocumentController::class, 'uploadFile'])->name('document.upload');
        Route::get('/document/download/{id}', [DocumentController::class, 'downloadFile'])->name('document.download');
        Route::resource('question', QuestionController::class);
        Route::resource('homework', HomeworkController::class);
    });

    Route::post('/logout', [LoginController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');
});

// Route::middleware('teacher')->group(function () {
//     Route::resource('document', DocumentController::class);
//     Route::post('/document/upload', [DocumentController::class, 'uploadFile'])->name('document.upload');
//     Route::get('/document/download/{id}', [DocumentController::class, 'downloadFile'])->name('document.download');
//     Route::resource('question', QuestionController::class);
//     Route::resource('homework', HomeworkController::class);
//     Route::resource('attendance', HomeworkController::class);
//     Route::get('/schedule', [DocumentController::class, 'schedule'])->name('teacher.schedule');
// });
