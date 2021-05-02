<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;

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

Route::get('login', [AuthController::class, 'loginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');
Route::get('/register', [RegistrationController::class, 'index'])->name('registration.index');
Route::post('/register', [RegistrationController::class, 'register'])->name('registration.create');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');
Route::get('/profile/{id}', [ProfileController::class, 'view'])->name('profile.view');

Route::get('/about', function() {
    return view('about');
})->name('about');

Route::get('posts', [PostController::class, 'index'])->name('post.index');
Route::get('/', [PostController::class, 'index'])->name('post.index');
Route::post('/search', [PostController::class, 'search'])->name('post.search');
Route::get('posts/{id}', [PostController::class, 'show'])->name('post.show');
Route::post('posts/store', [PostController::class, 'store'])->name('post.store')->middleware('auth');
Route::get('posts/edit/{id}', [PostController::class, 'edit'])->name('post.edit')->middleware('auth');
Route::post('posts/update/{id}', [PostController::class, 'update'])->name('post.update')->middleware('auth');
Route::post('posts/togglebookmark/{id}', [PostController::class, 'togglebookmark'])->name('post.togglebookmark')->middleware('auth');
Route::get('/create', [PostController::class, 'create'])->name('post.create')->middleware('auth');
Route::get('bookmarks', [PostController::class, 'bookmark'])->name('post.bookmark')->middleware('auth');
Route::post('posts/delete/{id}', [PostController::class, 'delete'])->name('post.delete')->middleware('auth');

if (env('APP_ENV') !== 'local') {
    URL::forceScheme('https');
}