@props(['noticia'])

<div class="w-full p-6 mt-2 mb-2 bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
    <!-- Contenido principal del noticia -->
    <div class="flex flex-col md:flex-row justify-between">
        <!-- Texto y acciones -->
        <div class="md:w-3/4">
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

                <a href="{{ route('comentarios.create', $noticia) }}">
                    <button type="button" class="px-3 py-2 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800">
                        Comentar
                    </button>
                </a>
            </h5>
            <p class="text-xs text-gray-500 pb-5">{{ $noticia->created_at->format('d M Y') }} | {{ $noticia->categoria->nombre }}</p>
        </div>

        <!-- Imagen -->
        <div class="md:w-1/4 flex justify-end">
            <img src="{{ $noticia->getRutaImagen() }}" class="w-40 h-40 object-cover rounded-lg shadow-lg">
        </div>
    </div>

    <!-- Sección de comentarios -->
    <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Comentarios ({{ $noticia->comentarios->count() }})</h3>

        @if ($noticia->comentarios->isEmpty())
            <p class="text-sm text-gray-500 mt-2">Aún no hay comentarios. Sé el primero en comentar.</p>
        @else
            <div class="space-y-4 mt-4">
                @foreach ($noticia->comentarios as $comentario)
                    <div class="p-4 bg-white dark:bg-gray-800 border border-gray-200 rounded-lg shadow">
                        <p class="text-sm font-medium">
                            {{ $comentario->user->name }}
                            <span class="text-xs text-gray-500">· {{ $comentario->created_at->diffForHumans() }}</span>
                        </p>
                        <p class="text-sm text-gray-800 dark:text-gray-200">{{ $comentario->contenido }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
