<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\CardController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('boards')->group(function () {
        Route::get('/', [BoardController::class, 'index'])->name('board.index');
        Route::post('/', [BoardController::class, 'store'])->name('board.store');
        Route::get('/{id}', [BoardController::class, 'show'])->name('board.show');
        Route::get('/{id}/edit', [BoardController::class, 'edit'])->name('board.edit');
        Route::put('/{id}', [BoardController::class, 'update'])->name('board.update');
        Route::delete('/{id}', [BoardController::class, 'destroy'])->name('board.destroy');
        Route::get('/{id}/users', [BoardController::class, 'getBoardUsers'])->name('board.users');

        // REMOVE MEMBER FROM BOARD
        Route::delete('/{id}/users/{userId}', [BoardController::class, 'removeUserFromBoard'])->name('board.removeUser');

        // ADD MEMBER TO BOARD
        Route::post('/addUser', [BoardController::class, 'addUserToBoard'])->name('board.addUser');
    });

    Route::prefix('columns')->group(function () {
        Route::get('/{boardId}', [ColumnController::class, 'index'])->name('column.index');
        Route::post('/', [ColumnController::class, 'store'])->name('column.store');
        Route::delete('/{id}', [ColumnController::class, 'destroy'])->name('column.destroy');
        Route::put('/{id}', [ColumnController::class, 'update'])->name('column.update');
        Route::put('/{id}/move', [ColumnController::class, 'move'])->name('column.move');
    });

    Route::prefix('cards')->group(function () {
        Route::post('/', [CardController::class, 'store'])->name('card.store');
        Route::delete('/{id}', [CardController::class, 'destroy'])->name('card.destroy');
        Route::get('/{id}', [CardController::class, 'get'])->name('card.get');
        Route::put('/{id}', [CardController::class, 'update'])->name('card.update');
        Route::put('/{id}/move', [CardController::class, 'move'])->name('card.move');
        Route::get('/', [CardController::class, 'myCards'])->name('card.myCards');
        Route::put('/cardNext/{id}', [CardController::class, 'cardNext'])->name('card.cardNext');
    });
    
});

require __DIR__ . '/auth.php';