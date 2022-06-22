<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentMarkController;
use App\Models\StudentMark;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/student');
});

Route::get('/student', [StudentController::class, 'index']);
Route::get('/student/{id}', [StudentController::class, 'get'])->name('student.get');
Route::delete('/student/{id}', [StudentController::class, 'delete'])->name('student.delete');
Route::post('/student/submit', [StudentController::class, 'save'])->name('student.save');

Route::get('/marks', [StudentMarkController::class, 'index']);
Route::get('/marks/{student_id}/{term}', [StudentMarkController::class, 'get'])->name('marks.get');
Route::delete('/marks/{student_id}/{term}', [StudentMarkController::class, 'delete'])->name('marks.delete');
Route::post('/marks/submit', [StudentMarkController::class, 'save'])->name('marks.save');
Route::patch('/marks/submit', [StudentMarkController::class, 'update'])->name('marks.save');
