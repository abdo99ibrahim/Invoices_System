<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SectionsController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('invoices', InvoicesController::class);
Route::resource('sections', SectionsController::class);
Route::resource('InvoiceAttachments', InvoicesAttachmentsController::class);
Route::resource('products', ProductsController::class);
Route::get('/section/{id}',[InvoicesController::class,'getProducts']);
Route::get('/invoicesDetails/{id}',[InvoicesDetailsController::class,'edit']);
Route::get('/View_file/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'open_file']);
Route::get('/download/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'get_file']);
Route::post('/delete_file',[InvoicesDetailsController::class,'destroy'])->name('delete_file');

Route::get('/edit_invoice/{id}',[InvoicesController::class,'edit']);
Route::get('status_show/{id}',[InvoicesController::class,'show'])->name('status_show');
Route::post('status_update/{id}',[InvoicesController::class,'status_update'])->name('status_update');

Route::get('/paid_invoices',[InvoicesController::class,'paid_invoices']);
Route::get('/partial_paid_invoices',[InvoicesController::class,'partial_paid_invoices']);
Route::get('/unpaid_invoices',[InvoicesController::class,'unpaid_invoices']);


Route::resource('Archive',InvoiceArchiveController::class);

Route::get('Print_invoice/{id}',[InvoicesController::class,'Print_invoice'])->name('status_show');

Route::get('/{page}', [AdminController::class, 'index']);

