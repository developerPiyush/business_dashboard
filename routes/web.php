<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class,'indexWelcome']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Ensure that only authenticated users can access the 'business' routes
Route::middleware(['auth'])->group(function () {
    Route::resource('business', BusinessController::class);
    Route::resource('branch', BranchController::class);
    Route::get('/branch/show-timings/{id}', [BranchController::class,'showTimings'])->name('branch.showTimings');
    Route::get('/branch/{branchId}/working-hours/{date}', [BranchController::class,'getWorkingHours']);


});
