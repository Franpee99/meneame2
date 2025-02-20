@props(['comentario'])

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
        <form action="{{ route('comentarios.store', $comentario->comentable) }}" method="POST">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comentario->id }}">
            <textarea name="contenido" class="w-full p-2 text-sm border border-gray-300 rounded-lg" required placeholder="Escribe tu respuesta aquí..."></textarea>
            <button type="submit" class="mt-2 px-3 py-1 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800">
                Enviar respuesta
            </button>
        </form>
    </div>

    <!-- Mostrar respuestas de este comentario -->
    @if ($comentario->comentarios->count())
        <div class="ml-6 border-l-2 border-gray-300 pl-4 mt-4">
            @foreach ($comentario->comentarios as $reply)
                @include('components.respuesta-comentario', ['comentario' => $reply])
            @endforeach
        </div>
    @endif
</div>
