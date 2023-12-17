<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\TeacherAuthController;
use App\Http\Controllers\StudentController;
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
})->name('homepage');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [StudentController::class, 'index'])->name('student.home');

    Route::get('/dashboard/enrolled', [StudentController::class, 'indexenrolled'])->name('student.enrolled');

    Route::get('/dashboard/archived', [StudentController::class, 'indexarchived'])->name('student.archived');

    Route::get('/dashboard/marks/archived/{registration}/{course_code}', [StudentController::class, 'showmarksarchived'])->name('student.marks.showarchived');

    Route::get('/dashboard/marks/{registration}/{course_code}', [StudentController::class, 'showmarks'])->name('student.marks.show');

    Route::post('/dashboard/claims/{mark}', [StudentController::class, 'storeclaim'])->name('student.claims.store');
});

// TEACHER ROUTES
Route::group(['middleware' => ['auth:is_teacher']], function () {

    Route::get('teacher/dashboard', [TeacherController::class, 'index'])->name('teacher.home');

    Route::get('teacher/marks', [TeacherController::class, 'indexmarks'])->name('teacher.marks.index');
    Route::get('teacher/claims', [TeacherController::class, 'indexclaims'])->name('teacher.claims.index');
    Route::get('teacher/marks/create/{code}', [TeacherController::class, 'createmarks'])->name('teacher.marks.create');
    Route::get('teacher/marks/{mark}/edit', [TeacherController::class, 'editmarks'])->name('teacher.marks.edit');
    Route::patch('teacher/marks/update/{mark}', [TeacherController::class, 'updatemarks'])->name('teacher.marks.update');
    Route::post('teacher/marks/{course}', [TeacherController::class, 'storemarks'])->name('teacher.marks.store');
    Route::delete('/student/claims/{claim}', [TeacherController::class, 'deleteclaim'])->name('student.claims.delete');

    Route::post('/teacher/logout', [TeacherAuthController::class, 'logout'])->name('teacher.logout');
});


Route::middleware('guest')->group(function () {

    Route::get('/teacher/login', [TeacherAuthController::class, 'showLoginForm'])->name('teacher.login');
    Route::post('/teacher/login', [TeacherAuthController::class, 'login'])->name('teacher.store');

    Route::get('/auth/token/{token}', [TeacherAuthController::class, 'authenticate'])->name('teacher.auth.confirm');
});

require __DIR__ . '/auth.php';
