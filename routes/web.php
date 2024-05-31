<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use  App\Http\Controllers\Auth\AuthController;

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

// Route::get('/admin/dashboard/', function () {
//     return view('welcome');
// });

Route::get('login',[AuthController::class,'login'])->name('login');
Route::post('login',[AuthController::class,'userLogin']);
Route::get('admin/login',[AuthController::class,'login']);
Route::post('admin/login',[AuthController::class,'adminLogin']);

Route::group(['middleware' => ['auth.admin']], function () {
    route::get('/admin/dashboard/rooms',[RoomController::class,'index'])->name('admin.rooms');
    route::post('/admin/dashboard/rooms',[RoomController::class,'store'])->name('admin.room.store');
    route::post('/admin/dashboard/room/upload',[RoomController::class,'upload'])->name('admin.room.uplodate');
    route::post('/admin/dashboard/room/upload_request',[RoomController::class,'uploadRequest'])->name('admin.room.uplodate.request');
    route::get('/admin/dashboard/rooms/{id}/delete',[RoomController::class,'destory'])->name('admin.room.delete');
    route::get('/admin/dashboard/rooms/requests',[RoomController::class,'requests'])->name('admin.rooms.requests');
});



Route::group(['middleware' => ['auth']], function () {
    route::get('/user/dashboard/rooms',[RoomController::class,'index'])->name('rooms');
    route::post('/user/dashboard/rooms',[RoomController::class,'store'])->name('room.store');
    route::post('/user/dashboard/room/upload',[RoomController::class,'upload'])->name('room.uplodate');
    route::post('/user/dashboard/room/upload_request',[RoomController::class,'uploadRequest'])->name('room.uplodate.request');
    route::get('/user/dashboard/rooms/{id}/delete',[RoomController::class,'destory'])->name('room.delete');
    route::get('/user/dashboard/rooms/requests',[RoomController::class,'requests'])->name('rooms.requests');

});


Route::get('logout',function(){
    auth()->logout();
    return redirect()->route('login');
})->name('logout');

