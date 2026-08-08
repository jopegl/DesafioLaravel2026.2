<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.page');

Route::get('/dashboard/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/dashboard/products', [ProductController::class, 'store'])->name('products.store');
Route::put('/dashboard/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/dashboard/products/{product}', [ProductController::class, 'destroy'])->name('products.delete');

Route::get('/dashboard/sales', [SaleController::class, 'index'])->name('sales.index');
Route::get('/dashboard/sales/pdf', [SaleController::class, 'generatePdf'])->name('sales.pdf');
Route::get('/dashboard/sales/xlsx', [SaleController::class, 'generateXlsx'])->name('sales.xlsx');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/send-email', [EmailController::class, 'index'])->name('admin.email.index');
    Route::post('/send-email', [EmailController::class, 'send'])->name('admin.email.send');
    Route::get('/send-email/search-user', [EmailController::class, 'searchUser'])->name('admin.email.search');
});

require __DIR__ . '/auth.php';
