<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\CepController;
use App\Http\Controllers\Api\MercadoPagoController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.page');
Route::get('/cep/{zipCode}', [CepController::class, 'search'])->name('cep.search');
Route::post('/webhook', [MercadoPagoController::class, 'webhook'])->name('webhook');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/dashboard/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/dashboard/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/dashboard/products/{product}', [ProductController::class, 'delete'])->name('products.delete');

    Route::get('/dashboard/sales', [SaleController::class, 'indexSalesHistory'])->name('sales.index');
    Route::get('/dashboard/sales/pdf', [SaleController::class, 'generatePdf'])->name('sales.pdf');
    Route::get('/dashboard/sales/xlsx', [SaleController::class, 'generateXlsx'])->name('sales.xlsx');

    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');

    Route::prefix('mercadopago')->name('mercadopago.')->group(function () {
        Route::post('/checkout', [MercadoPagoController::class, 'process'])->name('process');
        Route::get('/sucesso', [MercadoPagoController::class, 'success'])->name('success');
        Route::get('/pendente', [MercadoPagoController::class, 'pending'])->name('pending');
        Route::get('/falha', [MercadoPagoController::class, 'failure'])->name('failure');
    });
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/send-email', [EmailController::class, 'index'])->name('admin.email.index');
    Route::post('/send-email', [EmailController::class, 'send'])->name('admin.email.send');
    Route::get('/send-email/search-user', [EmailController::class, 'searchUser'])->name('admin.email.search');

    Route::resource('admins', AdminController::class)->except(['show', 'create', 'edit']);
    Route::resource('users', UserController::class)->except(['show', 'create', 'edit']);
});



require __DIR__ . '/auth.php';
