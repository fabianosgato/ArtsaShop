<x-frontend.app-layout layout="1column">
    <div class="x-auto px-4 py-10">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">
                Ops! Não conseguimos processar seu pedido.
            </h1>
        </div>

        <div class="bg-white border rounded-lg p-6 shadow-sm">
            <div class="mb-6">
                <div class="block content-center">
                    <h2>Isso pode acontecer por diversas razões — mas não se preocupe, estamos aqui para ajudar!</h2>
                </div>
            </div>
        </div>
        <div class="mt-8 text-center">
            <button
                onclick="window.location='{{ route('index.home') }}'"
                class="bg-gray-900 text-white px-6 py-3 rounded hover:bg-black transition">
                Continuar Comprando
            </button>
        </div>

    </div>

</x-frontend.app-layout>
