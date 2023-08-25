<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    //middleware auth
    Route::group(['middleware' => ['auth']], function () {
        //route dashboard
        Route::get('/dashboard', App\Http\Controllers\Admin\DashboardController::class)->name('admin.dashboard');
        //route resource lessons
        Route::resource('/lessons', \App\Http\Controllers\Admin\LessonController::class, ['as' => 'admin']);
        // route resource classrooms
        Route::resource('/classrooms', \App\Http\Controllers\Admin\ClassroomController::class, ['as' => 'admin']);
        //route student import
        Route::get('/students/import', [\App\Http\Controllers\Admin\StudentController::class, 'import'])->name('admin.students.import');
        //route student store import
        Route::post('/students/import', [\App\Http\Controllers\Admin\StudentController::class, 'storeImport'])->name('admin.students.storeImport');
        // route resource students
        Route::resource('/students', \App\Http\Controllers\Admin\StudentController::class, ['as' => 'admin']);
        // route resource exams
        Route::resource('/exams', \App\Http\Controllers\Admin\ExamController::class, ['as' => 'admin']);
        //custom route for create question exam
        Route::get('/exams/{exam}/questions/create', [\App\Http\Controllers\Admin\ExamController::class, 'createQuestion'])->name('admin.exams.createQuestion');
        //custom route for store question exam
        Route::post('/exams/{exam}/questions/store', [\App\Http\Controllers\Admin\ExamController::class, 'storeQuestion'])->name('admin.exams.storeQuestion');
        //custom route for edit question exam
        Route::get('/exams/{exam}/questions/{question}/edit', [\App\Http\Controllers\Admin\ExamController::class, 'editQuestion'])->name('admin.exams.editQuestion');
        //custom route for update question exam
        Route::put('/exams/{exam}/questions/{question}/update', [\App\Http\Controllers\Admin\ExamController::class, 'updateQuestion'])->name('admin.exams.updateQuestion');
        //custom route for destroy question exam
        Route::delete('/exams/{exam}/questions/{question}/destroy', [\App\Http\Controllers\Admin\ExamController::class, 'destroyQuestion'])->name('admin.exams.destroyQuestion');
        //route questions import
        Route::get('/exams/{exam}/questions/import', [\App\Http\Controllers\Admin\ExamController::class, 'import'])->name('admin.exam.questionImport');
        //route questions import
        Route::post('/exams/{exam}/questions/import', [\App\Http\Controllers\Admin\ExamController::class, 'storeImport'])->name('admin.exam.questionStoreImport');
    });
});
