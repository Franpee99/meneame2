<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\ProfileController;
use App\Models\Noticia;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('portada', [
        'noticias' => Noticia::orderBy('created_at',
                    'desc')->paginate(8),
    ]);
})->name('home');

Route::resource('noticias', NoticiaController::class);

// Rutas de comentarios dentro de un noticia
Route::middleware('auth')->group(function () {
    Route::get('/noticias/{noticia}/comentarios/create', [ComentarioController::class, 'create'])
        ->name('comentarios.create');

    Route::post('/noticias/{noticia}/comentarios', [ComentarioController::class, 'store'])
        ->name('comentarios.store');

    Route::delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])
        ->name('comentarios.destroy');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
