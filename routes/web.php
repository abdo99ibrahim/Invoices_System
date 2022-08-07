<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Auth::routesc();
Auth::routes([
    'register' => false
]);
Route::get('/', function () {
    return view('auth.login');
});
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(['auth']);

Route::resource('invoices', InvoicesController::class)->middleware('auth');
Route::resource('sections', SectionsController::class)->middleware('auth');
Route::resource('InvoiceAttachments', InvoicesAttachmentsController::class)->middleware('auth');
Route::resource('products', ProductsController::class)->middleware('auth');
Route::get('/section/{id}',[InvoicesController::class,'getProducts'])->middleware('auth');
Route::get('/invoicesDetails/{id}',[InvoicesDetailsController::class,'edit'])->middleware('auth');
Route::get('/View_file/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'open_file'])->middleware('auth');
Route::get('/download/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'get_file'])->middleware('auth');
Route::post('/delete_file',[InvoicesDetailsController::class,'destroy'])->name('delete_file')->middleware('auth');

Route::get('/edit_invoice/{id}',[InvoicesController::class,'edit'])->middleware('auth');
Route::get('status_show/{id}',[InvoicesController::class,'show'])->name('status_show')->middleware('auth');
Route::post('status_update/{id}',[InvoicesController::class,'status_update'])->name('status_update')->middleware('auth');

Route::get('/paid_invoices',[InvoicesController::class,'paid_invoices'])->middleware('auth');
Route::get('/partial_paid_invoices',[InvoicesController::class,'partial_paid_invoices'])->middleware('auth');
Route::get('/unpaid_invoices',[InvoicesController::class,'unpaid_invoices'])->middleware('auth');


Route::resource('Archive',InvoiceArchiveController::class)->middleware('auth');

Route::get('Print_invoice/{id}',[InvoicesController::class,'Print_invoice'])->name('Print_invoice')->middleware('auth');

Route::get('/invoices_export', [InvoicesController::class, 'export'])->middleware('auth');






Route::get('/{page}', [AdminController::class, 'index']);



