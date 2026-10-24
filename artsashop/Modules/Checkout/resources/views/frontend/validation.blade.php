<x-frontend.app-layout layout="1column">
    <div class="x-auto px-4 py-10">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">
                Estamos processando sua compra, em breve iramos redirecioná-lo
            </h1>
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
