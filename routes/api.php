<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Category_Controller;
use App\Http\Controllers\Menu_items_Controller;
use App\Http\Controllers\Clouds_users_Controller;
use App\Http\Controllers\Check_Auth_Controller;
use App\Http\Controllers\Order_Controller;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('category_api',[Category_Controller::class, 'index']);
Route::post('category_api/add ',[Category_Controller::class, 'store']);
Route::post('category_api/edit',[Category_Controller::class, 'update']);
Route::delete('category_api/delete',[Category_Controller::class, 'destroy']); 

Route::get('menu_items_api', [Menu_items_Controller::class, 'index']);
Route::post('menu_items_api/add ',[Menu_items_Controller::class, 'store']);
Route::put('menu_items_api/edit ',[Menu_items_Controller::class, 'update']);
Route::delete('menu_items_api/delete',[Menu_items_Controller::class, 'destroy']);

Route::post('register', [Clouds_users_Controller::class, 'register']);
Route::post('login', [Clouds_users_Controller::class, 'login']);

Route::middleware('web')->group(function () {
    Route::get('set-role', [Check_Auth_Controller::class, 'setRole']);
    Route::get('session-data', [Check_Auth_Controller::class, 'getSessionData']);
    Route::get('check-admin-role', [Check_Auth_Controller::class, 'checkAdminRole']);
});

Route::get('orders', [Order_Controller::class, 'index']);
Route::post('orders/add', [Order_Controller::class, 'store']);

