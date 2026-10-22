<x-frontend.app-layout layout="1column">

    @php
        $errorMessages = [
            401 => [
                'title' => 'Acesso não autorizado',
                'message' => 'Você não tem autorização para acessar este recurso.',
            ],
            403 => [
                'title' => 'Acesso negado',
                'message' => 'Você não tem permissão para acessar este recurso.',
            ],
            404 => [
                'title' => 'Página não encontrada',
                'message' => 'A página que você está procurando não foi encontrada.',
            ],
            419 => [
                'title' => 'Sessão expirada',
                'message' => 'Sua sessão expirou. Atualize a página e tente novamente.',
            ],
            429 => [
                'title' => 'Muitas solicitações',
                'message' => 'Recebemos muitas solicitações em pouco tempo. Aguarde alguns instantes e tente novamente.',
            ],
            500 => [
                'title' => 'Erro interno',
                'message' => 'Ocorreu um erro inesperado. Nossa equipe foi informada e estamos trabalhando para normalizar o serviço.',
            ],
            503 => [
                'title' => 'Serviço temporariamente indisponível',
                'message' => 'A loja está temporariamente indisponível. Tente novamente em alguns instantes.',
            ],
        ];

        $error = $errorMessages[$status] ?? $errorMessages[500];
    @endphp

    <div class="cms-pages py-10">
        <div class="page-title title-buttons">
            <h1>{{ $error['title'] }}</h1>
        </div>

        <div class="space-y-4">
            <p class="text-lg">{{ $error['message'] }}</p>

            @if(app()->environment('local'))
                <div class="mt-6 rounded border border-red-300 bg-red-50 p-4 text-left">
                    <h2 class="mb-3 text-lg font-semibold text-red-800">
                        Detalhes do erro — ambiente local
                    </h2>

                    <dl class="space-y-2 text-sm break-words">
                        <div>
                            <dt class="font-semibold">HTTP Status</dt>
                            <dd>{{ $status }}</dd>
                        </div>

                        <div>
                            <dt class="font-semibold">Exceção</dt>
                            <dd>{{ get_class($exception) }}</dd>
                        </div>

                        <div>
                            <dt class="font-semibold">Mensagem</dt>
                            <dd>{{ $exception->getMessage() ?: 'Sem mensagem.' }}</dd>
                        </div>

                        <div>
                            <dt class="font-semibold">Arquivo</dt>
                            <dd>{{ $exception->getFile() }}</dd>
                        </div>

                        <div>
                            <dt class="font-semibold">Linha</dt>
                            <dd>{{ $exception->getLine() }}</dd>
                        </div>
                    </dl>

                    <details class="mt-4">
                        <summary class="cursor-pointer font-semibold">
                            Stack trace
                        </summary>

                        <pre class="mt-3 max-h-96 overflow-auto whitespace-pre-wrap rounded bg-white p-3 text-xs">{{ $exception->getTraceAsString() }}</pre>
                    </details>
                </div>
            @endif
        </div>
    </div>

</x-frontend.app-layout>
