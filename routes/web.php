<?php

use App\Http\Controllers\Admin\categoriesController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\pickupController as AdminpickupController;
use App\Http\Controllers\Admin\reviewsController as AdminreviewsController;
use App\Http\Controllers\Admin\usersController as AdminusersController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Farmer\DashboardController as FarmerDashboardController;
use App\Http\Controllers\Admin\marketController as AdminmarketController;
use App\Http\Controllers\Admin\FarmerController as AdminFarmerController;
use App\Http\Controllers\Farmer\productController as FarmerProductsController;
use App\Http\Controllers\Farmer\OrdersController as FarmerOrdersController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\landing\MarketController;
use App\Http\Controllers\Farmer\profileController;
use App\Http\Controllers\AI\ChatController;
use App\Http\Controllers\landing\HomepageController;
use App\Http\Controllers\landing\CartController;
use App\Http\Controllers\Customer\FeedbackController;
use App\Http\Controllers\landing\SmartBasketController;
use App\Http\Controllers\landing\PriceCompareController;
use App\Http\Controllers\landing\BasketCompareController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomepageController::class, 'index'])
    ->name('homepage');

Route::get('/markets', [HomepageController::class, 'markets'])
    ->name('markets');

Route::get('/products', [MarketController::class, 'freshPicks'])
    ->name('products');


/*
|--------------------------------------------------------------------------
| Cart Routes
|--------------------------------------------------------------------------
*/

// Cart page
Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

// Add product to cart
Route::post('/cart/add', [CartController::class, 'addToCart'])
    ->name('cart.add');

// Increase / decrease quantity
Route::post('/cart/update', [CartController::class, 'updateQuantity'])
    ->name('cart.update');

// Remove product
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])
    ->name('cart.remove');

// Checkout page
Route::get('/cart/checkout', [CartController::class, 'checkout'])
    ->name('cart.checkout');

// Place order
Route::post('/cart/place-order', [CartController::class, 'placeOrder'])
    ->middleware('auth')
    ->name('cart.placeOrder');

// Cancel / reject order
Route::post('/orders/{id}/cancel', [CartController::class, 'cancelOrRejectOrder'])
    ->name('orders.cancel');

// Order success
Route::get('/order-success', function () {
    return view('order-success');
})->name('order.success');


/*
|--------------------------------------------------------------------------
| Market Details
|--------------------------------------------------------------------------
*/

Route::get('/markets/{id}', [MarketController::class, 'marketDetails'])
    ->name('market.details');


/*
|--------------------------------------------------------------------------
| Customer Order Routes
|--------------------------------------------------------------------------
*/

// Customer orders
Route::get('/customer/orders', [CartController::class, 'customerOrders'])
    ->middleware('auth')
    ->name('customer.orders');

// Customer cancel order
Route::post('/customer/orders/{order}/cancel', [CartController::class, 'cancelCustomerOrder'])
    ->middleware('auth')
    ->name('customer.orders.cancel');
/// oder history
Route::get('/history', [CustomerDashboardController::class, 'history'])
    ->middleware('auth')
    ->name('history');
// feedback
Route::post(
    '/history/{order}/feedback',
    [FeedbackController::class, 'store']
)->name('history.feedback');
//// API
Route::post('/ai/chat', [ChatController::class, 'chat'])
    ->name('ai.chat');
//// Samrt backit routes
Route::get('/smart-basket', [SmartBasketController::class, 'index'])
    ->name('smart-basket.index');

Route::post('/smart-basket/generate', [SmartBasketController::class, 'generate'])
    ->name('smart-basket.generate');

Route::post('/smart-basket/update', [SmartBasketController::class, 'update'])
    ->name('smart-basket.update');

Route::post('/smart-basket/add-to-cart', [SmartBasketController::class, 'addToCart'])
    ->name('smart-basket.add-to-cart');

Route::post('/smart-basket/clear', [SmartBasketController::class, 'clear'])
    ->name('smart-basket.clear');

//////  proce compaire 
Route::get('/price-compare', [PriceCompareController::class, 'index'])
    ->name('price-compare.index');

Route::post('/price-compare', [PriceCompareController::class, 'compare'])
    ->name('price-compare.compare');

/////////////////////////
/// market Compair price
/////////////////////////
Route::get('/compare-shopping', [BasketCompareController::class, 'index'])
    ->name('compare-shopping.index');

Route::post('/compare-shopping/products', [BasketCompareController::class, 'productsByCategory'])
    ->name('compare-shopping.products');

Route::post('/compare-shopping/compare', [BasketCompareController::class, 'compare'])
    ->name('compare-shopping.compare');

Route::post('/compare-shopping/select-market', [BasketCompareController::class, 'selectMarket'])
    ->name('compare-shopping.select-market');


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Admin Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Admin Markets
        |--------------------------------------------------------------------------
        */

        Route::get('/markets', [AdminmarketController::class, 'markets'])
            ->name('markets');

        Route::post('/markets', [AdminmarketController::class, 'store'])
            ->name('markets.store');

        Route::put('/markets/{id}', [AdminmarketController::class, 'update'])
            ->name('markets.update');

        Route::delete('/markets/{id}', [AdminmarketController::class, 'destroy'])
            ->name('markets.destroy');


        /*
        |--------------------------------------------------------------------------
        | Admin Categories
        |--------------------------------------------------------------------------
        */

        Route::get('/categories', [categoriesController::class, 'index'])
            ->name('categories');

        Route::post('/categories/save', [categoriesController::class, 'store'])
            ->name('categories.save');

        Route::delete('/categories/{id}', [categoriesController::class, 'destroy'])
            ->name('categories.destroy');


        /*
        |--------------------------------------------------------------------------
        | Admin Farmers
        |--------------------------------------------------------------------------
        */

        Route::get('/farmers', [AdminFarmerController::class, 'index'])
            ->name('farmers');
        Route::get('/farmers/{id}', [AdminFarmerController::class, 'show'])
            ->name('farmers.show');
        Route::patch('/farmers/{id}/toggle-status', [AdminFarmerController::class, 'toggleStatus'])
            ->name('farmers.toggle-status');

        /// pickup orders routes 
        Route::get('/pickup', [AdminpickupController::class, 'pickup'])
            ->name('pickup');
        Route::get('/pickup/{id}', [AdminpickupController::class, 'pickupShow'])
            ->name('pickup.show');
        /// histry routes 
        Route::get('/history', [AdminpickupController::class, 'history'])
            ->name('history');

        Route::get('/history/{id}', [AdminpickupController::class, 'historyShow'])
            ->name('history.show');

        // feedbacks
        Route::get('/reviews', [AdminreviewsController::class, 'reviews'])
            ->name('reviews');

        // users 
        Route::get('/users', [AdminusersController::class, 'users'])
            ->name('users');


        Route::get('/products/requests', [AdminProductController::class, 'requests'])
            ->name('products.requests');

        Route::post('/products/{product}/approve', [AdminProductController::class, 'approve'])
            ->name('products.approve');

        Route::post('/products/{product}/reject', [AdminProductController::class, 'reject'])
            ->name('products.reject');

        Route::get('/products', [AdminProductController::class, 'index'])
            ->name('products.index');

        Route::post('/products/{product}/not-available', [AdminProductController::class, 'makeNotAvailable'])
            ->name('products.not_available');

        Route::post('/products/{product}/make-available', [AdminProductController::class, 'makeAvailable'])
            ->name('products.make_available');

        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])
            ->name('products.destroy');
    });


/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {

        // Customer Dashboard
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
            ->name('dashboard');
    });


/*
|--------------------------------------------------------------------------
| Farmer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:farmer'])
    ->prefix('farmer')
    ->name('farmer.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Farmer Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [FarmerDashboardController::class, 'index'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Farmer Profile
        |--------------------------------------------------------------------------
        */

        Route::get('/profile', [profileController::class, 'index'])
            ->name('profile');

        Route::post('/profile', [profileController::class, 'store'])
            ->name('profile.store');


        /*
        |--------------------------------------------------------------------------
        | Farmer Products
        |--------------------------------------------------------------------------
        */

        Route::resource('products', FarmerProductsController::class);


        /*
        |--------------------------------------------------------------------------
        | Pending Orders
        |--------------------------------------------------------------------------
        */

        Route::get('/orders', [FarmerOrdersController::class, 'index'])
            ->name('orders');

        Route::post('/orders/{id}/confirm', [FarmerOrdersController::class, 'confirm'])
            ->name('orders.confirm');

        Route::post('/orders/{id}/cancel', [FarmerOrdersController::class, 'cancel'])
            ->name('orders.cancel');


        /*
        |--------------------------------------------------------------------------
        | Pickup / Ready Orders
        |--------------------------------------------------------------------------
        */

        Route::get('/pickup', [FarmerOrdersController::class, 'pickupOrders'])
            ->name('pickup');


        /*
        |--------------------------------------------------------------------------
        | Single Order Details
        |--------------------------------------------------------------------------
        */

        Route::get('/orders/{id}', [FarmerOrdersController::class, 'show'])
            ->name('orders.show');


        /*
        |--------------------------------------------------------------------------
        | Mark Order as Picked Up
        |--------------------------------------------------------------------------
        */

        Route::post('/orders/{id}/picked-up', [FarmerOrdersController::class, 'pickedUp'])
            ->name('orders.pickedup');

        Route::get('/history', [FarmerOrdersController::class, 'history'])
            ->name('history');

        // feedbacks
        Route::get('/feedbacks', [FarmerDashboardController::class, 'feedbacks'])
            ->name('feedbacks');
    });


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/



require __DIR__ . '/auth.php';
