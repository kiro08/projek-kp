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
Route::get('/logout', [usercontroller::class, 'logout'])->name('logout');
//Excel Controller
Route::post('/Excel/store', [ExcelController::class, 'store'])->name('store');
Route::get('/admin/export/{tableName}', [ExcelController::class, 'exportExcel'])->name('export');

//Admin Controller
Route::get('/admin/dashboard', [AdminController::class, 'Dashboard'])->name('dashboard');
Route::get('/admin/view/{tablename}', [AdminController::class, 'view'])->name('view');
Route::get('/admin/index', [AdminController::class, 'index'])->name('index');
Route::put('/admin/view/{tablename}', [AdminController::class, 'update'])->name('update');
Route::post('/admin/search/{tablename}', [AdminController::class, 'search'])->name('search');
Route::get('/admin/search/{tableName}', [AdminController::class, 'search'])->name('search');
Route::delete('/admin/delete/{tableName}', [AdminController::class, 'delete'])->name('table.delete');

