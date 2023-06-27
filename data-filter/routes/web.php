<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usercontroller; 
use App\Http\Controllers\ExcelController; 
use App\Http\Controllers\AdminController; 
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

Route::get('/', [usercontroller::class, 'open'])->name('open');
Route::post('/ceklogin', [usercontroller::class, 'ceklogin'])->name('ceklogin');

//Excel Controller
Route::post('/Excel/store', [ExcelController::class, 'store'])->name('store');

//Admin Controller
Route::get('/admin/dashboard', [AdminController::class, 'Dashboard'])->name('dashboard');
Route::get('/admin/view/{tablename}', [AdminController::class, 'view'])->name('view');
Route::get('/admin/index', [AdminController::class, 'index'])->name('index');
Route::put('/admin/view/{tablename}', [AdminController::class, 'update'])->name('update');
