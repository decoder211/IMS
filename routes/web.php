<?php

// use App\Http\Controllers\ProfileController;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Admincontroller;
// use App\Http\Controllers\CategoryController;
// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\CustomerController;
// use App\Http\Controllers\OrderController;
// use App\Http\Controllers\SaleController;
// use App\Http\Controllers\DashboardController;


// Route::get('/welcome', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', [Admincontroller::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/admin_dashboard', [Admincontroller::class, 'dashboard'])->middleware(['auth', 'verified'])->name('admin.dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
// Category Routes
// Route::resource('categories', CategoryController::class)->middleware(['auth', 'verified']);
// Route::patch('/admin/categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');

//Product Routes
// Route::prefix('products')->name('products.')->group(function () {
//     Route::get('/', [ProductController::class, 'index'])->name('index');
//     Route::get('/create', [ProductController::class, 'create'])->name('create');
//     Route::post('/', [ProductController::class, 'store'])->name('store');
//     Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
//     Route::put('/{product}', [ProductController::class, 'update'])->name('update');
//     Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
//     Route::get('/available-stock', [ProductController::class, 'availableStock'])->name('available-stock');
// });

//Customer Routes
// Route::prefix('customers')->name('customers.')->group(function () {
//     Route::get('/', [CustomerController::class, 'index'])->name('index');
//     Route::get('/create', [CustomerController::class, 'create'])->name('create');
//     Route::post('/', [CustomerController::class, 'store'])->name('store');
//     Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
//     Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
//     Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
// });

//Order Routes
// Route::prefix('orders')->name('orders.')->group(function () {
    // Route::get('/', [OrderController::class, 'index'])->name('index');
    // Route::get('/create', [OrderController::class, 'create'])->name('create');
    // Route::post('/', [OrderController::class, 'store'])->name('store');
    // Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('update-status');
    // Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
    // Route::get('/pending', [OrderController::class, 'pendingOrders'])->name('pending');
    // Route::get('/delivered', [OrderController::class, 'deliveredOrders'])->name('delivered');
    // Route::get('/{order}/download', [OrderController::class, 'downloadOrder'])->name('download-order');
// });
//Sale Routes
// Route::prefix('sales')->name('sales.')->group(function () {
//     Route::get('/', [SaleController::class, 'index'])->name('index');
//     Route::get('/create', [SaleController::class, 'create'])->name('create');
//     Route::post('/', [SaleController::class, 'store'])->name('store');
//     Route::get('/{sale}/download', [SaleController::class, 'downloadInvoice'])->name('download-invoice');
// });
//Route::get('/{sale}/payment-status', [SaleController::class, 'updatePaymentStatus'])->name('update-payment-status');
//


// Route::get('/sales/{sale}/toggle-payment', [SaleController::class, 'togglePayment']);
  // Dashboard Route
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Route::get('/', function () {
//     return redirect()->route('dashboard');
// });
// require __DIR__.'/auth.php';



use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;

// FIX #1: Single root redirect — removed duplicate welcome + redirect routes
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// FIX #2: Single dashboard route — removed duplicate Admincontroller dashboard
// DashboardController handles all dashboard logic now
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile routes (already had auth middleware — unchanged)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// FIX #3: All resource + custom routes now inside auth middleware group
Route::middleware(['auth', 'verified'])->group(function () {

    // Category Routes
    // FIX #4: toggleStatus now protected by auth middleware
    Route::resource('categories', CategoryController::class);
    Route::patch('/admin/categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])
        ->name('categories.toggleStatus');

    // Product Routes
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/available-stock', [ProductController::class, 'availableStock'])->name('available-stock');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Customer Routes
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::post('/', [CustomerController::class, 'store'])->name('store');
        Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
        Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
    });

    // Order Routes
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/pending', [OrderController::class, 'pendingOrders'])->name('pending');
        Route::get('/delivered', [OrderController::class, 'deliveredOrders'])->name('delivered');
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
        Route::get('/{order}/download', [OrderController::class, 'downloadOrder'])->name('download-order');
    });

    // Sale Routes
    // FIX #5: togglePayment changed from GET to PATCH and is now protected by auth
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::get('/', [SaleController::class, 'index'])->name('index');
        Route::get('/create', [SaleController::class, 'create'])->name('create');
        Route::post('/', [SaleController::class, 'store'])->name('store');
        Route::get('/{sale}/download', [SaleController::class, 'downloadInvoice'])->name('download-invoice');
        Route::patch('/{sale}/toggle-payment', [SaleController::class, 'togglePayment'])->name('toggle-payment');
    });
});

require __DIR__.'/auth.php';
