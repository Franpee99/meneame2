<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4 pb-4 pl-4 pr-4">
                    @foreach ($noticias as $noticia)
                        <x-noticia :noticia="$noticia" />
                    @endforeach
                </div>
            </div>
            <div class="mt-2">
                {{ $noticias->links() }}  <!--Para el paginado-->
            </div>
        </div>
    </div>
</x-app-layout>
