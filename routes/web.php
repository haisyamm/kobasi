<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; //Mendaftarkan controller yang akan digunakan
use App\Http\Controllers\PositionController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RABController;

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


Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'register_action'])->name('register.action');    
Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'login_action'])->name('login.action');

Route::middleware('auth')->group(
    function () {
        Route::get('/', function () {
            return view('home', ['title' => 'Beranda']);
        })->name('home');
        Route::get('password', [UserController::class, 'password'])->name('password');
        Route::post('password', [UserController::class, 'password_action'])->name('password.action');
        Route::get('logout', [UserController::class, 'logout'])->name('logout');

        //route position
        Route::resource('positions', PositionController::class);
        
        Route::resource('departements', DepartementController::class);
        Route::get('departement/export-pdf', [DepartementController::class, 'exportPdf'])->name('departements.exportPdf');
        Route::get('position/export-excel', 
        [PositionController::class, 'exportExcel'])
        ->name('positions.exportExcel');
        Route::resource('rabs', RABController::class);
        Route::get('home', [RABController::class, 'chartLine']);
        Route::get('chart-line-ajax', [RABController::class, 'chartLineAjax'])->name('rabs.chartLineAjax');
        Route::get('search/product', [ProductController::class, 'autocomplete'])->name('search.product');
        Route::resource('products', ProductController::class);
    });