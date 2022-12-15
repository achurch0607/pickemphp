<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::get('/schedule', [App\Http\Controllers\scheduleController::class, 'show'])
                ->middleware('auth')
                ->name('schedule');

//Route::get('/teams', function () {
//    return view('teams');
//})->middleware(['auth'])->name('teams');
Route::get('/teams', [App\Http\Controllers\TeamsController::class, 'index'])
                ->middleware('auth')
                ->name('teams');

Route::post('/schedule', [App\Http\Controllers\ScheduleController::class, 'show'])->middleware('auth')->name('showWeek');
Route::post('/insertPicks', [App\Http\Controllers\PicksController::class, 'update'])->middleware('auth')->name('insertPicks');
require __DIR__.'/auth.php';
