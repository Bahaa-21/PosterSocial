<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Post\PostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/test-mongo', function () {
    try {
        $connection = DB::connection('mongodb');
        $connection->command(['ping' => 1]);
        return ['message' => 'Connected to MongoDB Atlas successfully!'];
    } catch (\Exception $e) {
        return ['message' => 'Connection failed: ' . $e->getMessage()];
    }
});