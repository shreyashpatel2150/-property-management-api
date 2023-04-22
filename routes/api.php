<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// include controllers
use App\Http\Controllers\Api\PropertyController;

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

Route::controller(PropertyController::class)
    ->prefix('property')
    ->group( function () {
        Route::post('/create', 'create');
        Route::get('/list', 'list');
        Route::delete('/{id}', 'destroy');
        Route::get('/{id}', 'edit');
        Route::put('/{id}/update', 'update');
    });
