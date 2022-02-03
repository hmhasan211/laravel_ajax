<?php

use App\Http\Controllers\ajaxCrudController;
use App\Http\Controllers\ajaxDataController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\DataCollector\AjaxDataCollector;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('get/alldata',[ajaxDataController::class,'allData']);
Route::post('/save/data/',[ajaxDataController::class,'store']);
Route::get('/edit/data/{id}',[ajaxDataController::class,'edit']);
Route::post('/update/data/{id}',[ajaxDataController::class,'update']);
Route::get('/delete/data/{id}',[ajaxDataController::class,'destroy']);

