<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\KontrakanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'kontrakan'], function(){
    Route::post('indexlessee', [KontrakanController::class, 'indexLessee']);
    Route::post('indexlessor', [KontrakanController::class, 'indexLessor']);
    Route::post('show', [KontrakanController::class, 'show']);
    Route::post('store', [KontrakanController::class, 'store']);
    Route::post('update', [KontrakanController::class, 'update']);
    Route::post('delete', [KontrakanController::class, 'delete']);
    Route::post('active', [KontrakanController::class, 'showActive']);
    Route::post('notactive', [KontrakanController::class, 'showNotActive']);
    Route::post('setactive', [KontrakanController::class, 'setActive']);
    Route::post('setnotactive', [KontrakanController::class, 'setNotActive']);
});
Route::group(['prefix' => 'transaction'], function(){
    Route::post('lessorpending', [TransaksiController::class, 'lessorPending']);
    Route::post('lessorongoing', [TransaksiController::class, 'lessorOngoing']);
    Route::post('lessorfinished', [TransaksiController::class, 'lessorFinished']);
    Route::post('setapprove', [TransaksiController::class, 'setApprove']);
    Route::post('store', [TransaksiController::class, 'store']);
    Route::post('show', [TransaksiController::class, 'show']);
});
Route::get('province', [CityController::class, 'getProvince']);
Route::post('city', [CityController::class, 'getCity']);

Route::group(['prefix' => 'v1'], function(){
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
    Route::get('logout', [UserController::class, 'logout'])->middleware('auth:api');
});