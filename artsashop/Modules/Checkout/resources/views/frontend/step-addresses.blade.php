<x-frontend.app-layout layout="1column">

    <div class="onepage-checkout" x-data="checkout()">

        {{-- HEADER --}}
        <div class="page-title title-buttons mb-4">
            <h1 class="text-2xl font-semibold">Finalização da Compra</h1>
        </div>

        {{-- BARRA DE PROGRESSO --}}
        <x-checkout::onepage-progress-bar-component />

        {{-- LAYOUT PRINCIPAL --}}
        <div class="grid md:grid-cols-2 gap-8 fieldset">

            {{-- FORM --}}
            <div>
                <h1 class="text-2xl font-semibold mb-2">
                    Quase lá!
                </h1>
                <p class="text-sm text-gray-600 mb-6">
                    Só precisamos de alguns dados
                </p>
                {{-- ERROS --}}
                @if ($errors->any())
                    <div class="mb-4 p-3 rounded bg-red-100 text-red-700 text-sm">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('checkout.onepage.addresses.post') }}">
                    @csrf

                    <x-checkout::onepage-billing-component :quote="$quote" />

                    {{-- BOTÃO --}}
                    <button class="w-full bg-black text-white py-3 rounded mt-4">
                        Continuar para o Pagamento
                    </button>

                </form>

            </div>

            {{-- RESUMO DO PEDIDO --}}
            <div class="bg-gray-50 p-6 rounded border h-fit">
                {{-- RESUMO --}}
                <x-checkout::onepage-review-component :quote="$quote" />
            </div>

        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            Alpine.data('checkout', () => ({


            }));

        });
    </script>


</x-frontend.app-layout>
