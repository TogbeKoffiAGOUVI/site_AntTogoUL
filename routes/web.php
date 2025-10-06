<?php


use App\Http\Controllers\MainController;
use App\Http\Controllers\ResearcherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
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
    Route::resource('formerStudents', StudentController::class)->except(['show']); //cette ligne me permet de definir une route contraint par une athentification mais sous reserve de l'authentification d'une exception
    Route::resource('researchers', ResearcherController::class)->except(['show']);
});

Route::get('/formerStudents/{student}', [StudentController::class, 'show'])->name('formerStudents.show');
Route::get('/researchers/{researcher}', [ResearcherController::class, 'show'])->name('researchers.show');

Route::get('/', [MainController::class, 'home'])->name(('home'));
