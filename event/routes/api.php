<?php

use App\Http\Controllers\pricelist\PricelistController;
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

// pricelist
Route::prefix('/pricelist')->group(function () {
  // import endpoint
  Route::post('/import-pricelist', [PricelistController::class, 'importPricelist'])->name('import-pricelist');
});
