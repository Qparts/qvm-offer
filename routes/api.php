<?php
use App\Http\Controllers\Admin\AdvertisementAdminController;
use App\Http\Controllers\Admin\OfferAdminController;
use App\Http\Controllers\Qvm\AdvertisementController;
use App\Http\Controllers\Qvm\ConfigController;
use App\Http\Controllers\Qvm_seller\ConfigSellerController;
use App\Http\Controllers\Qvm\OfferController;
use App\Http\Controllers\Qvm\OrderController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */
Route::middleware(['auth:jwt'])->as('api.')->prefix('v1/qvm')->group(function () {
    Route::controller(AdvertisementController::class)->prefix('advertisements')->as('advertisements.')->group(function () {
        Route::get('advertisements', 'index')->name('advertisements.index');
        Route::get('advertisements_top', 'advertisements_top')->name('advertisements.top');
        Route::get('advertisements_medium', 'advertisements_medium')->name('advertisements.advertisements_medium');
        Route::get('advertisements_bottom', 'advertisements_bottom')->name('advertisements.advertisements_bottom');
    });
    Route::controller(OfferController::class)->prefix('offers')->as('offers.')->group(function () {
        Route::get('special_offers', 'index')->name('special_offers.index');
        Route::get('special_offers/{id}', 'show')->name('special_offers.show');
        Route::post('special_offers/{id}/add_order', 'add_order')->name('special_offers.add_order');
    });
    Route::controller(ConfigController::class)->prefix('config')->as('config.')->group(function () {
        Route::get('offer_types', 'offer_types')->name('offer_types');
    });
    Route::controller(OrderController::class)->prefix('orders')->as('orders.')->group(function () {
        Route::get('add_order', 'add_order');
    });
});

Route::middleware(['auth:jwt'])->as('api.')->prefix('v1/qvm_seller')->group(function () {

    Route::prefix('advertisements')->as('advertisements.')->group(function () {
        Route::apiResource('advertisements', AdvertisementAdminController::class);
    });
    Route::prefix('offers')->as('offers.')->group(function () {
        Route::apiResource('offers', OfferAdminController::class);
    });

    Route::controller(ConfigSellerController::class)->prefix('config')->as('config.')->group(function () {
        Route::get('company_labels', 'company_labels')->name('company_labels');
    });


    // Purchase Order Route
    Route::controller(PurchaseOrderController::class)->prefix('purchase_orders')->as('purchase_orders.')->group(function () {
        Route::post('add_purchase_order', 'store')->name('store');
        Route::get('purchase_orders/{purchase_order_id}/refund', 'refund_purchase_order')->name('refund_purchase_order');
        Route::get('purchase_orders/{purchase_order_id}/change_status', 'change_status')->name('change_status');
        Route::get('my_purchase_orders', 'index')->name('index');
        Route::put('change_status', 'change_status')->name('change_status');
    });
});


Route::middleware(['auth:jwt'])->as('api.')->prefix('v1/qvm_admin')->group(function () {
    Route::prefix('advertisements')->as('advertisements.')->group(function () {
        Route::apiResource('advertisements', AdvertisementAdminController::class);
    });
    Route::prefix('offers')->as('offers.')->group(function () {
        Route::apiResource('offers', OfferAdminController::class);
    });
    // Purchase Order Route
    Route::controller(PurchaseOrderController::class)->prefix('purchase_orders')->as('purchase_orders.')->group(function () {
        Route::post('add_purchase_order', 'store')->name('store');
        Route::get('purchase_orders/{purchase_order_id}/refund', 'refund_purchase_order')->name('refund_purchase_order');
        Route::get('purchase_orders/{purchase_order_id}/change_status', 'change_status')->name('change_status');
        Route::get('my_purchase_orders', 'index')->name('index');
        Route::put('change_status', 'change_status')->name('change_status');
    });
});
