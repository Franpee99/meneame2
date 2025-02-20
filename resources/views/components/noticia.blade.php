@props(['noticia'])

<div class="w-full p-6 mt-2 mb-2 bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
    <!-- Contenido principal del noticia -->
    <div class="flex flex-col md:flex-row justify-between">
        <!-- Texto y acciones -->
        <div class="md:w-3/4">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white ">
                <a class="hover:text-blue-500 hover:underline" href="{{ $noticia->url }}">{{ $noticia->titular }}</a>

                @can('update', $noticia)
                    <a href="{{ route('noticias.edit', $noticia) }}">
                        <button type="button" class="px-2 py-1 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                            Editar
                        </button>
                    </a>
                @endcan

                @can('delete', $noticia)
                    <form class="inline" method="POST" action="{{ route('noticias.destroy', $noticia) }}">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="px-2 py-1 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800">
                            Borrar
                        </button>
                    </form>
                @endcan
            </h5>
            <p class="text-xs text-gray-500 pb-5">{{ $noticia->created_at->format('d M Y') }} | {{ $noticia->categoria->nombre }}</p>
            <p class="font-normal text-gray-700 dark:text-gray-400">{{ $noticia->descripcion }}</p>
        </div>

        <!-- Imagen -->
        <div class="md:w-1/4 flex justify-end">
            <img src="{{ $noticia->getRutaImagen() }}" class="w-40 h-40 object-cover rounded-lg shadow-lg">
        </div>
    </div>

    <!-- Sección de comentarios -->
    <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Comentarios ({{ $noticia->comentarios->count() }})</h3>

        <!-- Formulario para agregar un nuevo comentario -->
        <form action="{{ route('comentarios.store', $noticia) }}" method="POST" class="mb-4">
            @csrf
            <textarea name="contenido" class="w-full p-2 text-sm border border-gray-300 rounded-lg" required placeholder="Escribe tu comentario aquí..."></textarea>
            <button type="submit" class="mt-2 px-3 py-1 text-sm font-medium text-white bg-green-700 rounded-lg hover:bg-green-800">
                Comentar
            </button>
        </form>

        @if ($noticia->comentarios->isEmpty())
            <p class="text-sm text-gray-500 mt-2">Aún no hay comentarios. Sé el primero en comentar.</p>
        @else
            <div class="space-y-4 mt-4">
                @foreach ($noticia->comentarios->where('parent_id', null) as $comentario)
                    @include('components.respuesta-comentario', ['comentario' => $comentario])
                @endforeach
            </div>
        @endif
    </div>
</div>
