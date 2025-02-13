<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear noticia
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('noticias.store') }}" class="max-w-sm mx-auto"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-5">
                    <x-input-label for="titular" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Titular
                    </x-input-label>
                    <x-text-input name="titular" type="text" id="titular" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :value="old('titular')" />
                    <x-input-error :messages="$errors->get('titular')" class="mt-2" />
                </div>
                <div class="mb-5">
                    <x-input-label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Descripción
                    </x-input-label>
                    <textarea name="descripcion" id="descripcion" cols="30" rows="10" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('descripcion') }}</textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>
                <div class="mb-5">
                    <x-input-label for="url" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        URL
                    </x-input-label>
                    <x-text-input name="url" type="text" id="url" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :value="old('url')" />
                    <x-input-error :messages="$errors->get('url')" class="mt-2" />
                </div>
                <div class="mb-5">
                    <x-input-label for="categoria_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Categoría
                    </x-input-label>
                    <select name="categoria_id" id="categoria_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}">
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
                </div>
                <div class="mb-5">
                    <x-input-label for="imagen" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Imagen
                    </x-input-label>
                    <x-text-input name="imagen" type="file" id="imagen" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        :value="old('imagen')" />
                    <x-input-error :messages="$errors->get('imagen')" class="mt-2" />
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Crear
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
