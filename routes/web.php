<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\SimplePageController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\VacanciesController;
use App\Http\Controllers\PartnersController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ThanksController;
use App\Http\Controllers\SportSchoolController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\PricesController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\DisplaySettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/page/{slug}', [SimplePageController::class, 'page'])->name('simple.page');

Route::get('/team', [EmployeesController::class, 'trainers'])->name('team');
Route::get('/management', [EmployeesController::class, 'management'])->name('management');
Route::get('/documents', [DocumentsController::class, 'index'])->name('documents');
Route::get('/partners', [PartnersController::class, 'index'])->name('partners');
Route::get('/thanks', [ThanksController::class, 'index'])->name('thanks');
Route::get('/sport_school/{slug}', [SportSchoolController::class, 'page'])->name('sport_school.page');
Route::get('/services', [ServicesController::class, 'index'])->name('services');
Route::get('/prices', [PricesController::class, 'index'])->name('prices');
Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule');

Route::get('/vacancies', [VacanciesController::class, 'index'])->name('vacancies');
Route::get('/vacancies/{slug}', [VacanciesController::class, 'page'])->name('vacancies.page');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/gallery/{slug}', [GalleryController::class, 'page'])->name('gallery.page');

Route::get('/news', [NewsController::class, 'index'])->name('news');
Route::get('/news/{slug}', [NewsController::class, 'page'])->name('news.page');

Route::get('/contacts', function () {
    return view('contacts');
})->name('contacts');

Route::get('/search', function () {
    return view('search.index');
})->name('search');

Route::post('/special', [DisplaySettingsController::class, 'setSpecialSettings'])->name('special.post');
Route::get('/special_classes', [DisplaySettingsController::class, 'getSpecialClasses'])->name('special.get');

Route::post('/review', [ReviewController::class, 'post'])->name('review.post');
Route::post('/feedback', [FeedbackController::class, 'post'])->name('feedback.post');