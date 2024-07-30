<?php

use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminContactUsUserController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminDocumentCategoryController;
use App\Http\Controllers\AdminDocumentController;
use App\Http\Controllers\AdminDonorController;
use App\Http\Controllers\AdminFeedbackQuestionController;
use App\Http\Controllers\AdminLawAreaController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\AdminTestimonialController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminUserFeedbackController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DocumentController;
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

Auth::routes(['verify' => true]);


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('documents/{id}/download', [HomeController::class, 'download'])->name('documents.download');
Route::post('contact-us', [HomeController::class, 'contactSubmit'])->name('home.contact-us');

Route::resource('documents', DocumentController::class);

Route::resource('blogs', BlogController::class);

Route::get('privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('terms-and-conditions', function () {
    return view('terms-conditions');
})->name('terms-conditions');

Route::get('symlink', function () {


    symlink('/home/j8ajiqs84w0i/laravel/storage/app/public', '/home/j8ajiqs84w0i/public_html/storage');

    return 'Symlink process successfully completed';
});

Route::middleware(["auth",'verified'])->group(function () {

    Route::post('feedback-submit', [HomeController::class, 'feedbackSubmit'])->name('home.feedback-submit');

    Route::prefix("admin")->name("admin.")->group(function () {
        Route::get("", [AdminDashboardController::class, "index"])->name("dashboard.index");

        Route::get('documents/{id}/fill', [AdminDocumentController::class, 'showFillForm'])->name('documents.showFillForm');

        Route::post('documents/fill', [AdminDocumentController::class, 'fill'])->name('documents.fill');


        Route::get('documents/{id}/download', [AdminDocumentController::class, 'download'])->name('documents.download');

        Route::get('documents/{id}/download/user', [AdminDocumentController::class, 'downloadUserDocument'])->name('documents.download.user');


        Route::resource('documents', AdminDocumentController::class);

        Route::resource('blogs', AdminBlogController::class);

        Route::resource('users', AdminUserController::class)->middleware('role:admin');

        Route::resource('contact-us-users', AdminContactUsUserController::class)->middleware('role:admin');

        Route::resource('document-categories', AdminDocumentCategoryController::class)->middleware('role:admin');

        Route::resource('law-areas', AdminLawAreaController::class)->middleware('role:admin');


        // Route::resource('donors', AdminDonorController::class)->middleware('role:admin');

        Route::resource('testimonials', AdminTestimonialController::class)->middleware('role:admin');




        Route::resource('feedback-questions', AdminFeedbackQuestionController::class)->middleware('role:admin');


        Route::resource('user-feedbacks', AdminUserFeedbackController::class)->middleware('role:admin');


        Route::resource('profile', AdminProfileController::class)->only(['index', 'update']);
    });
});
