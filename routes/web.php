<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ThreadController;
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

Route::get('/', [ThreadController::class, 'index'])->name('threads.index');

Route::middleware('auth')->group(function () {
    Route::get('/threads/create', [ThreadController::class, 'create'])->name('threads.create');
    Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
    Route::post('/threads/{thread}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::post('/comments/{comment}', [CommentController::class, 'upvote'])->name('comments.upvote');
});

Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');

require __DIR__.'/auth.php';
