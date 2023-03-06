<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ThanksController;
use App\Http\Controllers\VacanciesController;
use App\Http\Controllers\Api\SearchController;

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

Route::get('/employees/', [EmployeesController::class, 'ajax']);
Route::get('/gallery/filter/', [GalleryController::class, 'ajax']);
Route::get('/events/filter/', [NewsController::class, 'ajax']);
Route::get('/thanks/', [ThanksController::class, 'ajax']);
Route::get('/vacancy/', [VacanciesController::class, 'ajax']);

Route::get('/search/', [SearchController::class, 'getSearchResult']);