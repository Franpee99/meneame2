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
                    <div class="p-4 bg-white dark:bg-gray-800 border border-gray-200 rounded-lg shadow">
                        <p class="text-sm font-medium">
                            {{ $comentario->user->name }}
                            <span class="text-xs text-gray-500">· {{ $comentario->created_at->diffForHumans() }}</span>
                        </p>
                        <p class="text-sm text-gray-800 dark:text-gray-200">{{ $comentario->contenido }}</p>

                        <div class="flex justify-end space-x-2">
                            <!-- Botón para mostrar el formulario de respuesta -->
                            <button onclick="document.getElementById('reply-form-{{ $comentario->id }}').classList.toggle('hidden')"
                                class="px-2 py-1 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                                Responder
                            </button>

                            @can('delete', $comentario)
                                <form class="inline" method="POST" action="{{ route('comentarios.destroy', $comentario) }}">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="px-2 py-1 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800">
                                        Borrar
                                    </button>
                                </form>
                            @endcan
                        </div>

                        <!-- Formulario oculto para responder un comentario -->
                        <div id="reply-form-{{ $comentario->id }}" class="hidden mt-4">
                            <form action="{{ route('comentarios.store', $noticia) }}" method="POST">
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ $comentario->id }}">
                                <textarea name="contenido" class="w-full p-2 text-sm border border-gray-300 rounded-lg" required placeholder="Escribe tu respuesta aquí..."></textarea>
                                <button type="submit" class="mt-2 px-3 py-1 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800">
                                    Enviar respuesta
                                </button>
                            </form>
                        </div>

                        <!-- Mostrar respuestas de este comentario -->
                        @if ($comentario->replies->count())
                            <div class="ml-6 border-l-2 border-gray-300 pl-4 mt-4">
                                @foreach ($comentario->replies as $reply)
                                    <div class="p-3 bg-gray-200 dark:bg-gray-900 rounded-lg mt-2">
                                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">
                                            {{ $reply->user->name }}
                                            <span class="text-xs text-gray-500">· {{ $reply->created_at->diffForHumans() }}</span>
                                        </p>
                                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $reply->contenido }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach

            </div>
        @endif
    </div>
</div>
