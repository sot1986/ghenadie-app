<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'users' => collect([
            ['id' => 1, 'name' => 'John Doe', 'email' => fake()->email],
            ['id' => 2, 'name' => 'Jane Doe', 'email' => fake()->email],
        ]),
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('posts', \App\Http\Controllers\PostController::class);
    Route::patch('posts/{post}/special', [\App\Http\Controllers\PostController::class, 'special'])->name('posts.special');
    Route::put('posts/{post}/restore', [\App\Http\Controllers\PostController::class, 'restore'])->name('posts.restore');
    Route::delete('posts/{post}/force-delete', [\App\Http\Controllers\PostController::class, 'forceDelete'])->name('posts.force-delete');

    Route::get('comments', function () {
        return Inertia::render('Comments/List', [
            'result' => \App\Models\Comment::query()->with([
                'post',
                'user',
            ])->paginate(10),
        ]);
    })->name('comments.index')
        ->middleware('can:admin');
});

Route::get('/test-connection', function () {
    try {
        DB::connection('mysql2')->getPdo();
        return response()->json(['message' => 'Successfully connected to the database.'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => $e->getMessage()], 500);
    }
});

require __DIR__ . '/auth.php';
