<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ClientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('register', [ClientController::class, 'register']);
Route::post('login', [ClientController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/rooms/{type}',[ClientController::class, 'rooms']);
    Route::post('/request_room',[ClientController::class, 'requestRoom']);
    Route::get('/request_room/{client}/',[ClientController::class, 'myRequests']);

});
