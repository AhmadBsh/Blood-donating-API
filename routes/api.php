<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonateSchedualController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->middleware('auth')->group(function() {
        Route::post('register','register');
        Route::post('login','login');
        Route::get('users','index');
        Route::put('user/{user_id}','update');
        Route::delete('donate/{user_id}','destroy');
 

});
// Route::apiResource('donate', DonateSchedualController::class)->middleware('auth');
Route::controller(DonateSchedualController::class)->middleware('auth')->group(function() {
        Route::get('donate','index');
        Route::post('donate','store');
        Route::get('donate/{user_id}','show');
        Route::put('donate/{user_id}','update');
        Route::delete('donate/{user_id}','destroy');


});




