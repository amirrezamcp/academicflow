<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SelectionController;

Route::get('/', fn() => redirect()->route('masters.index'));

Route::resource('masters', MasterController::class);
Route::resource('lessons', LessonController::class);
Route::resource('presentations', PresentationController::class);
Route::resource('students', StudentController::class);
Route::resource('selections', SelectionController::class);
