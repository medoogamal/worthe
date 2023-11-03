<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\Client\OrderController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Order2Controller;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// routes/web.php

Route::group(['prefix' => LaravelLocalization::setLocale()], function()
{
	/** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    Route::prefix('dashboard')->middleware(['auth'])->group(function(){

        Route::get('/index',[DashboardController::class, 'index'])->name('dashboard.index');

        // users route
        Route::resource('users',UserController::class)->except(['show']);

        // categories route
        Route::resource('categories',CategoryController::class)->except(['show']);


        // categories route
        Route::resource('products',ProductController::class)->except(['show']);

        // client route
        Route::resource('clients',ClientController::class)->except(['show']);

        // client route
        Route::resource('users.orders',OrderController::class)->except(['show']);

        // order route
        Route::resource('orders',Order2Controller::class)->except(['show']);
        Route::get('orders/{order}/products',[Order2Controller::class,'products'])->name('orders.products');

    })->name('dashboard.'); //end of dashboard routes
});

/** OTHER PAGES THAT SHOULD NOT BE LOCALIZED **/






Route::resource('/',HomeController::class);
Route::get('/product/{product}',[HomeController::class,'show'])->name('single.product');
Route::get('/products',[HomeController::class,'products'])->name('multi.product');
Route::post('/',[CartController::class,'store'])->middleware("auth")->name('cart.store');
// Route::post('/checkout',[CartController::class,'checkout'])->middleware("auth")->name('cart.checkout');
Route::get('/cart',[CartController::class,'index'])->middleware("auth")->name('cart.index');
Route::post('/cart/{cart}',[CartController::class,'destroy'])->middleware("auth")->name('cart.destroy');


Route::post('/checkout',[CheckoutController::class,'checkout'])->middleware("auth")->name('cart.checkout');
Route::get('/paymob/callback',[CheckoutController::class,'callback'])->middleware("auth")->name('paymob.callback');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';