<?php

use App\Http\Controllers\Api\StudentApiController;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Route;

// Public reference data (no auth required)
Route::get('/provinces', [StudentApiController::class, 'provinces'])->name('api.provinces');
Route::get('/districts', [StudentApiController::class, 'districts'])->name('api.districts');
Route::get('/communes', [StudentApiController::class, 'communes'])->name('api.communes');
Route::get('/villages', [StudentApiController::class, 'villages'])->name('api.villages');
Route::get('/courses', [StudentApiController::class, 'courses'])->name('api.courses');
Route::get('/levels', [StudentApiController::class, 'levels'])->name('api.levels');
Route::get('/classes', [StudentApiController::class, 'classes'])->name('api.classes');
Route::get('/academic-years', [StudentApiController::class, 'academicYears'])->name('api.academic-years');
Route::get('/shifts', [StudentApiController::class, 'shifts'])->name('api.shifts');

Route::middleware('auth:web')->group(function () {
    Route::get('/students', [StudentApiController::class, 'students'])->middleware('can:students.view')->name('api.students');
    Route::get('/students/{student}', [StudentApiController::class, 'show'])->middleware('can:students.view')->name('api.students.show');
    Route::patch('/students/{student}/status', [StudentApiController::class, 'updateStatus'])->middleware([ValidateCsrfToken::class, 'can:students.edit'])->name('api.students.status');

    Route::get('/genders', [StudentApiController::class, 'genders'])->middleware('can:students.view')->name('api.genders');

    Route::get('/classes/{class}/students', [StudentApiController::class, 'classStudents'])->middleware('can:classes.view')->name('api.classes.students');
    Route::get('/guardians', [StudentApiController::class, 'guardians'])->middleware('can:guardians.view')->name('api.guardians');
});
