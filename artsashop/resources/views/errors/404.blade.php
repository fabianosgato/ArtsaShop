<x-frontend.app-layout layout="1column">

    @include('errors.error-content', [
        'status' => 404,
        'title' => 'Página não encontrada',
        'message' => 'A página que você está procurando não foi encontrada.',
    ])

</x-frontend.app-layout>
