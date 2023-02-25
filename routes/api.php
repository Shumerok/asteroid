<?php

use App\Http\Controllers\api\v1\AsteroidController;
use App\Http\Controllers\api\v1\IndexController;
use App\Http\Middleware\ApiMiddleware;
use App\Http\Middleware\NoRequestMiddleware;
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

Route::get('/v1/', IndexController::class)->middleware(NoRequestMiddleware::class);
Route::get('/v1/neo', [AsteroidController::class, 'getData'])->middleware(NoRequestMiddleware::class);
Route::get('/v1/neo/fastest', [AsteroidController::class, 'fastest'])->middleware(ApiMiddleware::class);
Route::get('/v1/neo/hazardous', [AsteroidController::class, 'hazardous'])->middleware(NoRequestMiddleware::class);
