@props(['noticia'])

<div class="flex justify-between w-full p-6 mt-2 mb-2 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
    <div>
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white ">
            <a class="hover:text-blue-500 hover:underline" href="{{ $noticia->url }}">{{ $noticia->titular }}</a>
            {{-- @can es para las autorizaciones/permisos del "NoticiaPolicy.php" --}}
            @can('update', $noticia)
                <a href="{{ route('noticias.edit', $noticia) }}">
                    <button type="button" class="px-2 py-1 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Editar
                    </button>
                </a>
                @endcan

                @can('delete', $noticia)
                <form class="inline" method="POST" action="{{ route('noticias.destroy', $noticia) }}">
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="px-2 py-1 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                        Borrar
                    </button>
                </form>
            @endcan
        </h5>
        <p class="text-xs text-gray-500 pb-5">{{ $noticia->created_at }} {{ $noticia->categoria->nombre}}</p>
        <p class="font-normal text-gray-700 dark:text-gray-400">{{ $noticia->descripcion }}</p>
    </div>
    <div>
        <img src="{{ $noticia->getRutaImagen() }}" />
    </div>
</div>
