<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\EmailController;


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

Route::post('register', 'Api\AuthController@register');

Route::post('login', 'Api\AuthController@login');

Route::get('/email/verify/{id}/{hash}', [EmailController::class, '__invoke'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verify/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');

Route::get('/email/verify/success', function () {
    return view('mail');
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::group(['middleware'=> 'auth:api'], function()
{
    Route::get('pengirimen', 'Api\PengirimanController@index');
    Route::get('pengirimen/{id}', 'Api\PengirimanController@show');
    Route::post('pengirimen', 'Api\PengirimanController@store');
    Route::put('pengirimen/{id}', 'Api\PengirimanController@update');
    Route::delete('pengirimen/{id}', 'Api\PengirimanController@destroy');

    Route::get('kontakkami', 'Api\KontakKamiController@index');
    Route::get('kontakkami/{id}', 'Api\KontakKamiController@show');
    Route::post('kontakkami', 'Api\KontakKamiController@store');
    Route::put('kontakkami/{id}', 'Api\KontakKamiController@update');
    Route::delete('kontakkami/{id}', 'Api\KontakKamiController@destroy');

    Route::get('konfirmasiPengiriman', 'Api\KonfirmasiPengirimanController@index');
    Route::get('konfirmasiPengiriman/{id}', 'Api\KonfirmasiPengirimanController@show');
    Route::post('konfirmasiPengiriman', 'Api\KonfirmasiPengirimanController@store');
    Route::put('konfirmasiPengiriman/{id}', 'Api\KonfirmasiPengirimanController@update');
    Route::delete('konfirmasiPengiriman/{id}', 'Api\KonfirmasiPengirimanController@destroy');

    Route::post('logout', 'Api\AuthController@logout');


    Route::get('user', 'Api\UserController@index');
    Route::get('user/{id}', 'Api\UserController@show');
    Route::put('user/{id}', 'Api\UserController@update');
    Route::delete('user/{id}', 'Api\UserController@destroy');
});
