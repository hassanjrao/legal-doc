<?php

use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminContactUsUserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminDocumentController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes([
    'verify' => false,
    'reset' => false,
]);


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('blogs',BlogController::class);

Route::middleware(["auth"])->group(function () {

Route::prefix("admin")->name("admin.")->group(function () {
    Route::get("", [AdminDashboardController::class, "index"])->name("dashboard.index");

    Route::get('documents/{id}/fill', [AdminDocumentController::class, 'showFillForm'])->name('documents.showFillForm');

    Route::post('documents/fill', [AdminDocumentController::class, 'fill'])->name('documents.fill');


    Route::get('documents/{id}/download', [AdminDocumentController::class, 'download'])->name('documents.download');

    Route::get('documents/{id}/download/user', [AdminDocumentController::class, 'downloadUserDocument'])->name('documents.download.user');


    Route::resource('documents', AdminDocumentController::class);

    Route::resource('blogs', AdminBlogController::class)->middleware('role:admin');

    Route::resource('users', AdminUserController::class)->middleware('role:admin');

    Route::resource('contact-us-users', AdminContactUsUserController::class)->middleware('role:admin');
});

});
