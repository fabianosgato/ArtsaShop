<x-frontend.app-layout layout="1column">

    <div class="min-h-[60vh] flex items-center justify-center px-4">

        <div class="w-full max-w-md border p-6 bg-white shadow-sm">

            <h1 class="text-lg font-semibold mb-4 text-center">
                Complete seu cadastro
            </h1>

            <p class="text-sm text-gray-600 mb-4 text-center">
                Precisamos de algumas informações para finalizar seu cadastro.
            </p>

            <form method="POST" action="{{ route('account.completeProfile.post') }}">
                @csrf

                <input type="text"
                       name="vat_number"
                       id="vat_number"
                       placeholder="CPF/CNPJ"
                       class="mask-cpf-cnpj w-full border px-3 py-2 text-sm mb-4"
                       required>

                <button type="submit"
                        class="w-full bg-celadon-700 text-white py-2 rounded">
                    Continuar
                </button>

            </form>

        </div>

    </div>

</x-frontend.app-layout>
