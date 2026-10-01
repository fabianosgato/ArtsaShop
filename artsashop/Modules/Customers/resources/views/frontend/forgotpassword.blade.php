<x-frontend.app-layout layout="1column">
    <div class="max-w-2xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-semibold mb-8">Esqueci minha senha</h1>
        <form action="{{ route('account.forgotpassword.post') }}" method="post" autocomplete="off">
            @csrf
            @if ($errors->any())
                <div class="mb-6 p-4 rounded bg-red-100 text-red-700 text-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 p-4 rounded bg-green-100 text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="dy-card bg-base-100 rounded-md border border-gray-200 shadow-sm">
                <div class="dy-card-body p-6 space-y-6">
                    <h3 class="text-lg font-semibold">Digite seu e-mail para recuperar sua senha</h3>
                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">
                            <em>*</em> Endereço de E-mail
                        </label>
                        <input type="email"
                               name="email_address"
                               value="{{ old('email_address') }}"
                               required
                               class="w-full border border-gray-300 px-2 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blumine-500 focus:border-blumine-500 transition">
                        <p class="text-xs text-gray-500 mt-1">
                            Nunca compartilharemos seu e-mail com ninguém.
                        </p>
                    </div>

                </div>

                <div class="border-t p-6 flex justify-between items-center">

                    <span class="text-sm text-gray-500">
                        * Campos obrigatórios
                    </span>

                    <button type="submit"
                            class="px-6 py-2 bg-celadon-700 text-white rounded hover:opacity-90 transition">
                        Enviar
                    </button>

                </div>
            </div>

        </form>

    </div>
</x-frontend.app-layout>
