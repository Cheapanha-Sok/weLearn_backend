<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExamDateController;
use App\Http\Controllers\PdfController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/flights', function () {
    // Only authenticated users may access this route...
})->middleware('auth');
Route::apiResource('category', CategoryController::class);
Route::apiResource('examDate', ExamDateController::class);
Route::apiResource('pdf', PdfController::class);
Route::get('pdf/{examdate_id}/{category_id}/{type}' , [PdfController::class,'show']);