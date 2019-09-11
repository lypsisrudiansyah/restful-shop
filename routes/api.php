<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('beranda', function(){
	return 'as';
});
/*
	Routing for Buyers
*/
Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);

/*
	Routing for Categories
*/
Route::resource('categories', 'Category\CategoryController', ['only' => ['create', 'edit']]);

/*
	Routing for Products
*/
Route::resource('products', 'Product\ProductController', ['only' => ['index', 'show']]);


/*
	Routing for Sellers
*/
Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);


/*
	Routing for Transactions
*/
Route::resource('transactions', 'Transaction\TransactionController', ['only' => ['index', 'show']]);


/*
	Routing for Users
*/
Route::resource('users', 'User\UserController', ['except' => ['create', 'edit']]);
