<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * route "/register"
 * @method "POST"
 */
Route::post('/register', Api\RegisterController::class)->name('register');

/**
 * route "/login"
 * @method "POST"
 */
Route::post('/login', Api\LoginController::class)->name('login');

/**
 * route "/user"
 * @method "GET"
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * route "/logout"
 * @method "POST"
 */
Route::post('/logout', Api\LogoutController::class)->name('logout');

// Route::get('/news', Api\NewsController::class)->name('news');
// Route::get('/news', 'api\NewsController@index');

/**
 * route "/news/{token}"
 * @method "GET"
 */
Route::get('/news/{token}', 'Api\NewsController@getDataNews')->middleware('jwt.verify');


/**
 * route "/regulation/{token}"
 * @method "GET"
 */
Route::get('/regulasi/{token}', 'Api\NewsController@getDataRegulation')->middleware('jwt.verify');

