<x-frontend.app-layout layout="1column">

    @include('errors.error-content', [
        'status' => 401,
        'title' => 'Acesso não autorizado',
        'message' => 'Você não tem autorização para acessar este recurso.',
    ])

</x-frontend.app-layout>
