<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\CepController;
use App\Http\Controllers\Api\MercadoPagoController;
use App\Http\Controllers\Api\PagBankController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('home');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.page');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


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

    Route::get('/contact-us', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');
});

Route::middleware(['auth', 'user.only'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])
        ->name('cart.index');
    Route::post('/cart-items', [CartController::class, 'store'])
        ->name('cart-items.store');
    Route::put('/cart-items/{cartItem}', [CartController::class, 'update'])
        ->name('cart-items.update');
    Route::delete('/cart-items/{cartItem}', [CartController::class, 'destroy'])
        ->name('cart-items.destroy');

    Route::get('/dashboard/purchases', [PurchaseController::class, 'indexPurchaseHistory'])->name('purchases.index');
    Route::get('/dashboard/purchases/pdf', [PurchaseController::class, 'generatePdfPurchases'])->name('purchases.pdf');

    Route::prefix('mercadopago')->name('mercadopago.')->group(function () {
        Route::post('/checkout', [MercadoPagoController::class, 'process'])->name('process');
        Route::get('/success', [MercadoPagoController::class, 'success'])->name('success');
        Route::get('/pendent', [MercadoPagoController::class, 'pending'])->name('pending');
        Route::get('/failure', [MercadoPagoController::class, 'failure'])->name('failure');
    });

    Route::prefix('pagbank')->name('pagbank.')->group(function () {
        Route::post('/checkout', [PagBankController::class, 'process'])
            ->name('process');
        Route::get('/callback', [PagBankController::class, 'callback'])
            ->name('callback');
    });

    Route::post('/mercadopago/webhook', [MercadoPagoController::class, 'webhook'])->name('mercadopago.webhook');
    Route::post('/pagbank/webhook', [PagBankController::class, 'webhook'])->name('pagbank.webhook');
});




Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/send-email', [EmailController::class, 'index'])->name('admin.email.index');
    Route::post('/send-email', [EmailController::class, 'send'])->name('admin.email.send');
    Route::get('/send-email/search-user', [EmailController::class, 'searchUser'])->name('admin.email.search');

    Route::resource('admins', AdminController::class)->except(['show', 'create', 'edit']);
    Route::resource('users', UserController::class)->except(['show', 'create', 'edit']);

    Route::get('/contacts', [ContactController::class, 'indexAllMessages'])->name('contacts.index');
    Route::post('/contacts/{contact}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
});



require __DIR__ . '/auth.php';
