<?php

use App\Http\Controllers\Api\AlatApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\ReservasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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

Route::post('/login', [AuthApiController::class,'authenticate']);
Route::post('/register', [AuthApiController::class,'register']);

Route::post('/reservasi', [ReservasiController::class,'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthApiController::class, 'logout']);
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('/alat')->group(function () {
        Route::get('/', [AlatApiController::class, 'showAllAlat']);
        Route::get('/{id}',[AlatApiController::class, 'detail']);
});

Route::prefix('/category')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
});

Route::get('/kalender-alat', function() {
    $order = DB::table('orders')
    ->join('alats', 'alats.id','=','orders.alat_id')
    ->join('payments','payments.id','=','orders.payment_id')
    ->where('orders.status', 2)
    ->where('payments.status', 3)
    ->get(['nama_alat AS title','starts AS start','ends AS end']);
    return json_encode($order);
});

Route::get('/kalender-alat/{id}', function($id) {
    $order = DB::table('orders')
    ->join('alats', 'alats.id','=','orders.alat_id')
    ->join('payments','payments.id','=','orders.payment_id')
    ->where('alats.id', $id)
    ->where('orders.status', 2)
    ->where('payments.status', 3)
    ->get(['nama_alat AS title','starts AS start','ends AS end']);

    return json_encode($order);
});

Route::post('/register', [RegisterController::class, 'store']);

