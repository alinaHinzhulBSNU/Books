<?php

use Illuminate\Support\Facades\Route;

//ПРАВИЛЬНИЙ ЧАС(для правильного часу створення замовлення)
date_default_timezone_set('Europe/Kiev');

//Auth
Auth::routes();
Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

//For menu
Route::get('/', [\App\Http\Controllers\BooksController::class, 'index'])->name('books');
Route::get('/about', [\App\Http\Controllers\PagesController::class, 'about'])->name('about')->middleware('auth');

//Books
Route::resource('/books', "\App\Http\Controllers\BooksController");
//Books filters
Route::get('authors/{id}/books', [\App\Http\Controllers\BooksController::class, 'authorFilter']);
Route::get('publishers/{id}/books', [\App\Http\Controllers\BooksController::class, 'publisherFilter']);
Route::get('genres/{id}/books', [\App\Http\Controllers\BooksController::class, 'genreFilter']);
//Book search
Route::get('/search', [\App\Http\Controllers\BooksController::class, 'search']);

//Authors
Route::resource('/authors', "\App\Http\Controllers\AuthorsController");

//Publishers
Route::resource('/publishers', "\App\Http\Controllers\PublishersController");

//Genres
Route::resource('/genres', "\App\Http\Controllers\GenresController");

//Comments
Route::resource('/comments', '\App\Http\Controllers\CommentsController');


//ADMIN
//Orders
Route::resource('/admin/orders', '\App\Http\Controllers\OrderDetailsController');
//Users
Route::resource('/admin/users', '\App\Http\Controllers\UsersController');

//ICONS
//Orders(Profile)
Route::resource('/profile/orders', '\App\Http\Controllers\OrderDetailsController');
//Items(Cart)
Route::resource('/cart/items', '\App\Http\Controllers\ItemsController');
