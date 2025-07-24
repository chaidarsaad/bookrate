<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index'])->name('home');
Route::get('/top-books', [BookController::class, 'topAuthorsView'])->name('top.books');

Route::get('/book-list', [BookController::class, 'bookList']);
Route::get('/top', [BookController::class, 'topAuthors']);

Route::get('/rate', [RatingController::class, 'create'])->name('create.rating');
Route::post('/rate', [RatingController::class, 'store'])->name('store.rating');
Route::get('/search-authors', action: [RatingController::class, 'searchAuthors']);
Route::get('/search-books/{author}', [RatingController::class, 'searchBooks']);

Route::get('/authors.json', [RatingController::class, 'searchAuthors']);
