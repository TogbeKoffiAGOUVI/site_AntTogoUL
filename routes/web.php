<?php


use App\Http\Controllers\MainController;
use App\Http\Controllers\ResearcherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryBlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\GuestMiddleware;

Route::middleware([GuestMiddleware::class])->group(function () {
    Route::get('/', [MainController::class, 'home'])->name('home');
    Route::get('/login', [MainController::class, 'login'])->name('login');
    Route::get('/registration', [MainController::class, 'registration'])->name('registration');

    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/registration', [AuthController::class, 'registration'])->name('registration');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ROUTE POUR LE FORMULAIRE D'AFFICHAGE ET D'UPLOAD DE PROFIL
    Route::resource('profiles', ProfileController::class);

    Route::resource('formerStudents', StudentController::class)->except(['show']);
    Route::resource('researchers', ResearcherController::class)->except(['show']);
});

Route::get('/formerStudents/{student}', [StudentController::class, 'show'])->name('formerStudents.show');
Route::get('/researchers/{researcher}', [ResearcherController::class, 'show'])->name('researchers.show');

Route::get('/', [MainController::class, 'home'])->name(('home'));

// Route pour mettre en place ma bibliothèque virtuelle
Route::resource('documents', DocumentController::class);
Route::resource('categories', CategoryController::class);

// Route pour mettre en place ma bibliothèque virtuelle
Route::resource('documents', PostController::class);
Route::resource('categories', CategoryBlogController::class);