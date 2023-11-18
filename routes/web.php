<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\TeacherAuthController;
use App\Http\Controllers\TeacherController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// TEACHER ROUTES
Route::group(['middleware' => ['auth:is_teacher']], function () {

    Route::get('teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.home');

    Route::get('teacher/marks', [TeacherController::class, 'indexmarks'])->name('teacher.marks.index');
    Route::post('teacher/marks', [TeacherController::class, 'storemarks'])->name('teacher.marks.store');
    Route::get('teacher/marks/create/{code}', [TeacherController::class, 'createmarks'])->name('teacher.marks.create');

    Route::post('/teacher/logout', [TeacherAuthController::class, 'logout'])->name('teacher.logout');
});
Route::middleware('guest')->group(function () {

    Route::get('/teacher/login', [TeacherAuthController::class, 'showLoginForm'])->name('teacher.login');
    Route::post('/teacher/login', [TeacherAuthController::class, 'login'])->name('teacher.store');

    Route::get('/auth/token/{token}', [TeacherAuthController::class, 'authenticate'])->name('teacher.auth.confirm');
});

require __DIR__ . '/auth.php';
