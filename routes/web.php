<?php


use App\Http\Controllers\MainController;
use App\Http\Controllers\ResearcherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiblioCategoryController;
use App\Http\Controllers\CategoryBlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LikeController;
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

// // Route pour mettre en place ma bibliothèque virtuelle
// Route::resource('documents', DocumentController::class);
// Route::resource('categories', CategoryController::class);




//Gestion du Blog

Route::resource('blog/categories', CategoryBlogController::class)->names([
    'index' => 'blog.categories.index',
    'create' => 'blog.categories.create',
    'store' => 'blog.categories.store',
    'show' => 'blog.categories.show',
    'edit' => 'blog.categories.edit',
    'update' => 'blog.categories.update',
    'destroy' => 'blog.categories.destroy',
]);
Route::resource('blog/posts', PostController::class)->names([
    'index' => 'blog.posts.index',
    'create' => 'blog.posts.create',
    'store' => 'blog.posts.store',
    'show' => 'blog.posts.show',
    'edit' => 'blog.posts.edit',
    'update' => 'blog.posts.update',
    'destroy' => 'blog.posts.destroy',
]);

//gestions des likes et commentaires
Route::prefix('posts/{post}')->group(function () {
    Route::post('/like/toggle', [LikeController::class, 'toggle'])->name('blog.posts.like.toggle');
    Route::post('/comments', [CommentController::class, 'store'])->name('blog.posts.comments.store');
});

// Route pour la bibliothèque virtuelle
Route::resource('biblio/categories', BiblioCategoryController::class)->names([
    'index' => 'biblio.categories.index',
    'create' => 'biblio.categories.create',
    'store' => 'biblio.categories.store',
    'show' => 'biblio.categories.show',
    'edit' => 'biblio.categories.edit',
    'update' => 'biblio.categories.update',
    'destroy' => 'biblio.categories.destroy',
]);
Route::resource('biblio/documents', DocumentController::class)->names([
    'index' => 'biblio.documents.index',
    'create' => 'biblio.documents.create',
    'store' => 'biblio.documents.store',
    'show' => 'biblio.documents.show',
    'edit' => 'biblio.documents.edit',
    'update' => 'biblio.documents.update',
    'destroy' => 'biblio.documents.destroy',
]);
