<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComentarioRequest;
use App\Http\Requests\UpdateComentarioRequest;
use App\Models\Comentario;
use App\Models\Noticia;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller implements HasMiddleware
{

    public static function middleware() // Para implementar que debe estar logeado
    {
        return [
            new Middleware('auth', only: ['create', 'store']), // Para que te rediriga a iniciar sesion
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Noticia $noticia)
    {
        return view('comentarios.create', compact('noticia'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComentarioRequest $request, Noticia $noticia)
    {
        //Validacion del contenido en el request

        $validated = $request->validated();

        $comentario = new Comentario();
        $comentario->noticia_id = $noticia->id;
        $comentario->user_id = Auth::id();
        $comentario->contenido = $validated['contenido'];
        $comentario->parent_id = $validated['parent_id'] ?? null;

        if ($comentario->parent_id) {
            $comentario->comentable_type = Comentario::class;
            $comentario->comentable_id = $comentario->parent_id;
        } else {
            $comentario->comentable_type = Noticia::class;
            $comentario->comentable_id = $noticia->id;
        }

        $comentario->save();


        return redirect()->route('home')->with('success', 'Comentario agregado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comentario $comentario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comentario $comentario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComentarioRequest $request, Comentario $comentario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comentario $comentario)
    {
        $comentario->delete();
        return redirect()->route('home');
    }
}
