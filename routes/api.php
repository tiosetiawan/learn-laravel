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

/**
 * route "/learning/{token}"
 * @method "GET"
 */
Route::get('/learning/{token}', 'Api\NewsController@getDataLearning')->middleware('jwt.verify');

/**
 * route "/perusahaan/{token}"
 * @method "GET"
 */
Route::get('/perusahaan/{token}', 'Api\NewsController@getDataPerusahaan')->middleware('jwt.verify');

/**
 * route "/validate/{token}"
 * @method "GET"
 */
Route::get('/validate/{token}', 'Api\ValidateController@getValidateData')->middleware('jwt.verify');

/**
 * route "/validate/{token}"
 * @method "GET"
 */
// Route::post('/validatetoken/{token}', 'Api\ValidateController@getValidateData')->middleware('token.verify');


Route::group(['middleware' => ['token.verify']], function () {
        Route::post('/news', 'Api\ValidateController@getValidateData');
});
