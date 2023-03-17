<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Feature\ProjectController;
use App\Http\Controllers\Feature\TaskController;
use App\Http\Controllers\DashboardController;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/cek_input_user', function () {
        return view('cek_2_free_input');
    })->name('cek_input_user');
});

Route::group(['middleware' => [
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
], 'prefix' => 'feature', 'as' => 'feature.',], function () {
    Route::resource('project', ProjectController::class);
    Route::put('/change-stat-project/{project}/{status}', [ProjectController::class, 'changeStateProject'])->name('project.changestate');

    Route::resource('task', TaskController::class);
    Route::get('/task/create/{projectUuid}', [TaskController::class, 'create'])->name('task.create');
    Route::put('/change-stat-task/{task}/{status}', [TaskController::class, 'changeStateTask'])->name('task.changestate');
});
