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

            {{-- Coluna esquera --}}
            <div class="hidden md:block bg-gray-50 p-6 rounded-lg border">
                <h2 class="text-xl font-semibold mb-4">
                    Compra 100% segura
                </h2>
                <p class="text-sm text-gray-600 mb-4">
                    Sem taxas ocultas. Tudo transparente para você.
                </p>
                <ul class="space-y-3 text-sm text-gray-700">
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-plane-arrival"></i> Frete grátis para todo o Brasil
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-check-double"></i> Impostos já inclusos no preço
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-box-open"></i> Entrega em até 18 dias
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-lock"></i> Pagamento seguro
                    </li>
                    <li class="flex items-center gap-2">
                        🇧🇷 Suporte técnico no Brasil
                    </li>
                </ul>
            </div>

            {{-- coluna direita --}}
            <div>
                <h1 class="text-2xl font-semibold mb-2">
                    Como você quer continuar?
                </h1>
                <p class="text-sm text-gray-600 mb-6">
                    Informe seu e-mail para continuar a compra
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

                {{-- ALERTA CLIENTE EXISTENTE --}}
                @if(session('existing_customer'))
                    <div class="bg-blue-50 text-blue-700 p-3 rounded mb-4 text-sm">
                        Já encontramos uma conta com esse e-mail. Você poderá entrar na próxima etapa.
                    </div>
                @endif

                {{-- FORM --}}
                <form method="POST"
                      action="{{ route('checkout.onepage.identify.post') }}"
                      @submit="submitHandler">
                    @csrf

                    {{-- EMAIL --}}
                    <div class="mb-4">

                        <label class="block text-sm font-medium mb-1">
                            <em>*</em> E-mail
                        </label>

                        <input type="email"
                               name="customer_email"
                               value="{{ old('email', $email ?? $quote['customer_email']) }}"
                               required
                               autofocus
                               autocomplete="email"
                               placeholder="seu@email.com"
                               class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100">
                        <p class="text-red-500 text-sm mt-1"
                           x-show="errorMessage"
                           x-text="errorMessage"></p>
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">
                            {{ $message }}
                        </p>
                        @enderror

                    </div>

                    {{-- BOTÃO CONTINUAR --}}
                    <button type="submit"
                            class="w-full bg-black text-white py-3 rounded font-semibold hover:bg-gray-800 transition">
                        Continuar
                    </button>

                </form>

                {{-- DIVISOR --}}
                <div class="text-center text-sm text-gray-500 my-5">
                    ou
                </div>

                {{-- SOCIAL LOGIN --}}
                <div class="space-y-3">
                    <a href="{{ route('account.social.redirect', ['provider' => 'google', 'checkout' => 1]) }}"
                       class="w-full flex items-center justify-center gap-3 border px-4 py-2 rounded hover:bg-gray-50 transition">
                        <img src="{{ asset('images/frontend/google.svg') }}" class="w-5 h-5" alt="Login com o Google">
                        <span class="text-sm">Continuar com Google</span>
                    </a>
                </div>

                {{-- TEXTO AUXILIAR --}}
                <p class="text-xs text-gray-500 mt-4 text-center">
                    Você poderá finalizar a compra sem criar conta.
                </p>

            </div>

        </div>

    </div>
    <script>
        document.addEventListener('alpine:init', () => {

            Alpine.data('checkout', () => ({

                errorMessage: '',

                submitHandler(event) {

                    const input = document.querySelector('[name="customer_email"]');
                    const email = input ? input.value.trim() : '';

                    // reset visual
                    this.errorMessage = '';
                    if (input) input.classList.remove('border-red-500');

                    // VALIDAÇÃO EMAIL
                    if (!email || !window.Validators.email(email)) {

                        event.preventDefault();

                        this.errorMessage = 'Por favor, informe um e-mail válido';

                        if (input) {
                            input.classList.add('border-red-500');

                            input.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });

                            setTimeout(() => input.focus(), 300);
                        }

                        return false;
                    }

                    return true;
                }

            }));

        });
    </script>

</x-frontend.app-layout>
