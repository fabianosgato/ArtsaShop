<x-frontend.app-layout layout="2columns-customer">
    <div class="dashboard">

        <form action="{{ route('account.editpost') }}" method="post" autocomplete="off">
            @csrf

            <div class="dy-card bg-base-100 rounded-md border border-gray-200 shadow-sm mb-6">
                <div class="dy-card-body p-4">

                    <h3 class="dy-card-title mb-6">
                        Meus Dados Pessoais
                    </h3>

                    <input type="hidden" name="customer_id" value="{{ $customer->customer_id }}">

                    @if (session('success'))
                        <div class="mb-6 p-3 rounded bg-green-100 text-green-700 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 p-3 rounded bg-red-100 text-red-700 text-sm">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-6">

                        {{-- EMAIL --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> Endereço de E-mail
                            </label>
                            <input type="email"
                                   name="email_address"
                                   value="{{ $customer->customer_email }}"
                                   readonly
                                   class="w-full border px-3 py-2 bg-gray-100">
                            <p class="text-xs text-gray-500 mt-1">
                                Sua conta de e-mail não pode ser alterada.
                            </p>
                        </div>

                        {{-- NOME --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> Nome Completo
                            </label>
                            <input type="text"
                                   name="customer_name"
                                   value="{{ $customer->customer_name }}"
                                   class="w-full border px-3 py-2">
                        </div>

                        {{-- CPF/CNPJ --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> CPF/CNPJ
                            </label>
                            <input type="text"
                                   name="vat_number"
                                   id="vat_number"
                                   value="{{ $customer->vat_number }}"
                                   class="mask-cpf-cnpj w-full border px-3 py-2">
                        </div>

                        {{-- DATA NASCIMENTO --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Data de Nascimento
                            </label>
                            <input type="text"
                                   name="date_of_birth"
                                   id="date_of_birth"
                                   value="{{ $customer->date_of_birth }}"
                                   class="w-full border px-3 py-2">
                        </div>

                        {{-- TROCAR SENHA --}}
                        <div class="pt-4 border-t">

                            <label class="flex items-center gap-2 text-sm cursor-pointer">
                                <input type="checkbox"
                                       id="change_password"
                                       name="change_password"
                                       value="1"
                                       class="w-4 h-4">
                                Quero alterar minha senha
                            </label>

                            {{-- CAMPOS DE SENHA --}}
                            <div id="password-fields" class="hidden mt-4 space-y-4">

                                <div class="relative">
                                    <label class="block text-sm font-medium mb-1">
                                        Nova Senha
                                    </label>
                                    <input type="password"
                                           name="password"
                                           class="password-field w-full border px-3 py-2 pr-10">
                                    <button type="button"
                                            class="toggle-password absolute right-3 top-9 text-sm text-gray-500">
                                        👁
                                    </button>
                                </div>

                                <div class="relative">
                                    <label class="block text-sm font-medium mb-1">
                                        Confirmar Nova Senha
                                    </label>
                                    <input type="password"
                                           name="password_confirmation"
                                           class="password-field w-full border px-3 py-2 pr-10">
                                    <button type="button"
                                            class="toggle-password absolute right-3 top-9 text-sm text-gray-500">
                                        👁
                                    </button>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="border-t p-4 flex justify-between items-center">

                    <span class="text-sm text-gray-500">
                        * Campos Obrigatórios
                    </span>

                    <button type="submit"
                            class="px-6 py-2 bg-celadon-700 text-white rounded hover:opacity-90 transition">
                        Atualizar Meus Dados
                    </button>

                </div>

            </div>

        </form>

    </div>

    {{-- JS TOGGLE PASSWORD --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const checkbox = document.getElementById('change_password');
            const passwordFields = document.getElementById('password-fields');

            checkbox.addEventListener('change', function () {
                passwordFields.classList.toggle('hidden', !this.checked);
            });

        });
    </script>

</x-frontend.app-layout>
