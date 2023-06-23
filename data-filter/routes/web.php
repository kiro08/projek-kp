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

Route::get('/Excel/index', [ExcelController::class, 'index'])->name('index');
Route::post('/Excel/store', [ExcelController::class, 'store'])->name('store');
Route::get('/Excel/tables', [ExcelController::class, 'listTables'])->name('listTables');
Route::get('/Excel/tables/{tableName}', [ExcelController::class, 'showTable'])->name('showTable');

// controller admin
Route::get('/admin/dashboard', [AdminController::class, 'Dashboard']);