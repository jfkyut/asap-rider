<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });


Route::middleware(['auth'])->group(function () {

    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // pasuyo routes
    Route::get('/pasuyo/create', [App\Http\Controllers\PasuyoController::class, 'create'])->name('pasuyo.create');
    Route::post('/pasuyo/store', [App\Http\Controllers\PasuyoController::class, 'store'])->name('pasuyo.store');

    // pick and drop routes
    Route::get('/pick-and-drop/create', [App\Http\Controllers\PickAndDropController::class, 'create'])->name('pick-and-drop.create');
    Route::post('/pick-and-drop/store', [App\Http\Controllers\PickAndDropController::class, 'store'])->name('pick-and-drop.store');

    // user transactions routes
    Route::get('/transactions', [App\Http\Controllers\UserTransactionController::class, 'index'])->name('transaction.index');

    // status routes
    Route::get('/status', [App\Http\Controllers\StatusController::class, 'index'])->name('status.index');

    // inbox routes
    Route::get('/inbox', [App\Http\Controllers\InboxController::class, 'index'])->name('inbox.index');

    Route::put('/inbox/mark-as-read/{message}', [App\Http\Controllers\InboxController::class, 'markAsRead'])->name('inbox.mark-as-read');
});

require __DIR__.'/auth.php';
