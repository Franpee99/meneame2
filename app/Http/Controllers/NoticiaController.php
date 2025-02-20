<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoticiaRequest;
use App\Http\Requests\UpdateNoticiaRequest;
use App\Models\Categoria;
use App\Models\Noticia;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class NoticiaController extends Controller implements HasMiddleware
{

    public static function middleware() // Para implementar que debe estar logeado
    {
        return [
            new Middleware('auth', only: ['create', 'store']), // Para que te rediriga a iniciar sesion
        ];
    }

    public function index(){
        return redirect()->route('home');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('noticias.create', [
        'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoticiaRequest $request)
    {
        //En vez de poner aqui la validacion, se pone en el StoreNoticiaRequest

        $archivo = $request->file('imagen');

        $noticia = new Noticia($request->input());
        $noticia->user_id = Auth::id();
        $noticia->save();

        $nombre = $noticia->id . '.jpg';
        if ($request->hasFile('imagen')) {

            $archivo = $request->file('imagen');

            $archivo->storeAs('imagenes', $nombre, 'public');

            $noticia->imagen = asset("storage/imagenes/$nombre");
        }
        $noticia->save();

        return redirect()->route('home');


    }

    /**
     * Display the specified resource.
     */
    public function show(Noticia $noticia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Noticia $noticia)
    {
        Gate::authorize('update', $noticia); //En el NoticiaPolicy ponemos quien quien puede editarlo (autorizacion)

        return view('noticias.edit', [
            'noticia' => $noticia,
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoticiaRequest $request, Noticia $noticia)
    {
        //En vez de poner aqui la validacion, se pone en el UpdateNoticiaRequest

       // Autorizar la edición
        Gate::authorize('update', $noticia);

        // Actualizar los datos del formulario
        $noticia->fill($request->only(['titular', 'url', 'descripcion', 'categoria_id']));

        // Si el usuario sube una nueva imagen, la reemplazamos
        if ($request->hasFile('imagen')) {
            $archivo = $request->file('imagen');
            $nombre = $noticia->id . '.jpg'; // Mantiene el mismo nombre de archivo que en store()

            // Eliminar la imagen anterior si existe
            if ($noticia->imagen) {
                $rutaAnterior = str_replace(asset('storage/'), '', $noticia->imagen);
                if (Storage::disk('public')->exists($rutaAnterior)) {
                    Storage::disk('public')->delete($rutaAnterior);
                }
            }

            // Guardar la nueva imagen en "storage/app/public/imagenes"
            $archivo->storeAs('imagenes', $nombre, 'public');

            // Actualizar la ruta de la imagen en la base de datos
            $noticia->imagen = asset("storage/imagenes/$nombre");
        }

        $noticia->save();

        return redirect()->route('home');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Noticia $noticia)
    {
        $noticia->delete();
        return redirect()->route('home');
    }
}
