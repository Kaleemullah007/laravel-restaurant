<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\DepositHistoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductionHistoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\VendorController;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/product_price', function () {
    return response()->json([1, 2, 4]);
})->name('product_price');

Route::get('/', function () {

    return to_route('login');
});

Route::get('pos1', function () {

    return view('pages.pos');
});
Route::get('get-csv-sales', [SaleController::class, 'CSV']);
Route::get('localization/{locale}', [LocalizationController::class, 'index'])->name('localization');

// Route::get('get-csv-products',[SaleController::class,'CSV']);
// Route::get('get-csv-purchases',[SaleController::class,'CSV']);
// Route::get('get-csv-expenses',[SaleController::class,'CSV']);
// Route::get('get-csv-productions',[SaleController::class,'CSV']);

Route::group([
    'middleware' => ['avoid-back-history', 'lng'],

], function () {

    Auth::routes(['verify' => true, 'register' => false]);

    Route::middleware('userauth')->group(function () {

        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
        Route::post('get-dashboard', [HomeController::class, 'getDashboard']);

        Route::get('/user-profile-setting', [SettingController::class, 'userProfileSetting'])->name('user-profile-setting');
        Route::post('profile-update', [SettingController::class, 'update'])->name('profile-update');

        Route::get('/setting', [SettingController::class, 'Setting'])->name('setting');
        Route::post('get-products', [ProductController::class, 'getProducts']);
        Route::post('get-pos-products', [ProductController::class, 'getProductsForPos']);
        Route::resource('product', ProductController::class);
        Route::get('/deal/product/{product}', [DealController::class, 'selectedProduct'])->name('deal.product');
        Route::resource('deal', DealController::class);
        Route::get('get-price/{product}', [ProductController::class, 'getPrice']);
        // Customer amount
        Route::get('customer-amount/{customer}', [CustomerController::class, 'customerAmount']);
        // Vendor amount
        Route::get('vendor-amount/{customer}', [CustomerController::class, 'VendorAmount']);

        route::get('add-new-row', [SaleController::class, 'addNewRow']);
        route::get('update-products', [SaleController::class, 'UpdateProducts']);
        route::get('add-new-row-pos', [SaleController::class, 'addNewRowPos']);

        Route::post('get-sales', [SaleController::class, 'getSales']);
        Route::get('generate-pdf/{id}', [SaleController::class, 'generatePDF'])->name('generate-pdf');
        Route::resource('sale', SaleController::class)->middleware('avoid-back-history');
        Route::post('get-purchases', [PurchaseController::class, 'getPurchases']); // Pending
        Route::resource('purchase', PurchaseController::class);
        Route::post('get-expenses', [ExpenseController::class, 'getExpenses']); // Pending
        Route::resource('expense', ExpenseController::class);
        // Route::post('get-productions',[ProductionHistoryController::class,'getProduction']);// Pending
        // Route::resource('production',ProductionHistoryController::class);
        Route::post('get-customers', [CustomerController::class, 'getCustomers']); // Pending
        Route::resource('customer', CustomerController::class);
        Route::resource('vendor', VendorController::class);
        route::get('deposit-html', [DepositHistoryController::class, 'index']);
        route::get('purchase-return', [PurchaseReturnController::class, 'index'])->name('purchase-return.index');
        route::get('purchase-return/{purchaseReturn}/edit', [PurchaseReturnController::class, 'edit'])->name('purchase-return.edit');
        route::put('purchase-return/{purchaseReturn}', [PurchaseReturnController::class, 'update'])->name('purchase-return.update');

        Route::resource('deposit', DepositHistoryController::class);
    });
    route::get('add-new-row-pos', [SaleController::class, 'addNewRowPos']);
    Route::get('slip/{slip}', [SaleController::class, 'slip'])->name('sale.slip')->middleware('avoid-back-history');
    // Route::get('generate-pdf/{id}', [SaleController::class, 'generatePDF'])->name('generate-pdf');
    Route::post('employeepos', [SaleController::class, 'store'])->name('employeepos');
    route::get('pos', [SaleController::class, 'pos'])->name('pos');
    route::get('sale/viewsale/{sale}', [SaleController::class, 'employeeshow'])->name('sale.viewsale');
});

Route::fallback(function () {
    abort(404);
});
