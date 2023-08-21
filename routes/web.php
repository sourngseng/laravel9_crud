<?php

use App\Http\Controllers\CompanyAjaxController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\EmployeeController;

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

Route::get('hello',function(){
    echo "Hello, Dara";
});


Route::get('test',[TestingController::class,'index']);
Route::get('get-name',[TestingController::class,'getName']);

Route::get('contact',[TestingController::class,'contact']);

// Company
// Route::resource('companies', CompanyController::class);

// Employee Management
Route::get('/employees', [EmployeeController::class, 'index']);
Route::post('/store', [EmployeeController::class, 'store'])->name('store');
Route::get('/fetchall', [EmployeeController::class, 'fetchAll'])->name('fetchAll');
Route::delete('/delete', [EmployeeController::class, 'delete'])->name('delete');
Route::get('/edit', [EmployeeController::class, 'edit'])->name('edit');
Route::post('/update', [EmployeeController::class, 'update'])->name('update');


// Compney with Ajax
Route::get('/company-ajax', [CompanyAjaxController::class, 'index']);
Route::post('/save_company', [CompanyAjaxController::class, 'save_company'])->name('save_company');
Route::get('/comp_fetchAll', [CompanyAjaxController::class, 'fetchAll'])->name('comp_fetchAll');
Route::delete('/comp_delete', [CompanyAjaxController::class, 'delete'])->name('comp_delete');
Route::get('/comp_edit', [CompanyAjaxController::class, 'edit'])->name('comp_edit');
Route::post('/comp_update', [CompanyAjaxController::class, 'update'])->name('comp_update');

