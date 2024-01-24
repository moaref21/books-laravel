<?php

use App\Http\Controllers\AdminsCcntollers;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublishersController;
use App\Http\Controllers\AuthersController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Srmklive\PayPal\Services\PayPal;

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

// Route::get('/', function () {
//     return view('gallery');
// });

Auth::routes();

Route::get('/', [GalleryController::class, 'index'])->name('/');
Route::get('/search', [GalleryController::class, 'search'])->name('search');


//book
Route::get('/book/{book}',[BooksController::class,'details'])->name('book.details');
//End Book

//Category
Route::get('/category',[CategoriesController::class,'list'])->name('gallery.category.index');
Route::get('/category/search',[CategoriesController::class,'search'])->name('gallery.category.search');
Route::get('/category/{category}',[CategoriesController::class,'result'])->name('gallery.category.show');
//EndCategory

//Publisher
Route::get('/publisher',[PublishersController::class,'list'])->name('gallery.publisher.index');
Route::get('/publisher/search',[PublishersController::class,'search'])->name('gallery.publisher.search');
Route::get('/publisher/{publisher}',[PublishersController::class,'result'])->name('gallery.publisher.show');
//EndPublisher


//Authers
Route::get('/authers',[AuthersController::class,'list'])->name('gallery.authers.list');
Route::get('/authers/search',[AuthersController::class,'search'])->name('gallery.authers.search');
Route::get('/authers/{auther}',[AuthersController::class,'result'])->name('gallery.authers.show');

//EndAuthers
Route::prefix('/admin')->middleware('can:update-books')->group(function(){
    Route::get('/',[AdminsCcntollers::class,'index'])->name('admin.index');

    Route::resource('/books',BooksController::class);
    Route::resource('/categories',CategoriesController::class);
    Route::resource('/publishers',PublishersController::class);
    Route::resource('/authers',AuthersController::class);
    Route::resource('/users',UsersController::class)->middleware('can:update-users');
});
Route::post('/book/{book}/rate', [BooksController::class,'rate'])->name('book.rate');


// Route::get('/admin/book',[BooksController::class,'index'])->name('books.index');
// Route::get('/admin/book/create',[BooksController::class,'create'])->name('books.create');
// Route::post('/admin/book',[BooksController::class,'store'])->name('books.store');
// Route::get('/admin/book/{book}',[BooksController::class,'show'])->name('books.show');
// Route::get('/admin/book/{book}/edit',[BooksController::class,'edit'])->name('books.edit');
// Route::patch('/admin/book/{book}',[BooksController::class,'update'])->name('books.update');
// Route::get('/admin', function () {
//     return view('theme.default');
// });


Route::get('/profile', [ProfileController::class, 'index'])->middleware('auth');
Route::patch('/profile', [ProfileController::class, 'update'])->middleware('auth');

Route::post('/cart',[CartController::class,'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class,'viewCart'])->name('cart.view');
Route::post('/removeOne/{book}', [CartController::class,'removeOne'])->name('cart.remove_one');
Route::post('/removeAll/{book}', [CartController::class,'removeAll'])->name('cart.remove_all');




Route::get('/checkout', [PurchaseController::class, 'creditCheckout'])->name('credit.checkout');
Route::post('/checkout', [PurchaseController::class, 'purchase'])->name('products.purchase');

Route::post('paypal' ,  [PurchaseController::class,'createPayment'])->name('orders');
