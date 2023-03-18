<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Feature\DashboardController;
use App\Http\Controllers\Feature\ProjectController;
use App\Http\Controllers\Feature\TaskController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([
    'auth'
])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

    Route::get('/cek_input_user', function () {
        return view('feature/cek_2_free_input');
    })->name('cek_input_user');
});

Route::group(['middleware' => [
    'auth'
], 'prefix' => 'feature', 'as' => 'feature.',], function () {
    Route::resource('project', ProjectController::class);
    Route::put('/change-stat-project/{project}/{status}', [ProjectController::class, 'changeStateProject'])->name('project.changestate');

    Route::resource('task', TaskController::class);
    Route::get('/task/create/{projectUuid}', [TaskController::class, 'create'])->name('task.create');
    Route::put('/change-stat-task/{task}/{status}', [TaskController::class, 'changeStateTask'])->name('task.changestate');
});

require __DIR__.'/auth.php';
