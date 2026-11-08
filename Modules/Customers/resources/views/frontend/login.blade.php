<x-frontend.app-layout layout="1column">

    <div class="max-w-6xl mx-auto px-4 py-6" x-data="register()">

        <h1 class="text-xl font-semibold mb-6 mt-6 text-center">
            Crie sua conta para continuar com segurança
        </h1>

        <div class="grid md:grid-cols-2 gap-8 items-start">


            {{-- COLUNA ESQUERDA (CONFIANÇA) --}}
            <div class="md:block bg-gray-50 p-6 rounded-lg border">

                <h2 class="text-xl font-semibold mb-4">
                    Compre com praticidade e segurança
                </h2>

                <p class="text-sm text-gray-600 mb-4">
                    Acesse sua conta ArtsaShop para acompanhar seus pedidos e manter seus dados de compra organizados. Se ainda não possui uma conta, não se preocupe: você poderá criá-la rapidamente durante o processo.
                </p>

                <p class="text-sm text-gray-600 mb-4">
                    Suas informações são utilizadas para identificação da conta e processamento dos pedidos
                </p>

            </div>

            {{-- COLUNA DIREITA --}}
            <div class="w-full max-w-md mx-auto">

                {{-- ALERTAS --}}
                @if ($errors->any())
                    <div class="mb-4 p-3 rounded bg-red-100 text-red-700 text-sm">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM --}}
                <form method="POST" action="{{ route('account.loginPost') }}">
                    @csrf

                    {{-- STEP 1 - EMAIL --}}
                    <div id="step-email" class="border p-5 shadow-sm bg-white">

                        {{-- GOOGLE --}}
                        <div class="space-y-3">
                            <a href="{{ route('account.social.redirect', 'google') }}"
                               class="w-full flex items-center justify-center gap-3 border px-4 py-2 rounded hover:bg-gray-50">
                                <img src="{{ asset('images/frontend/google.svg') }}" class="w-5 h-5">
                                <span class="text-sm">Continuar com Google</span>
                            </a>
                        </div>

                        <div class="flex items-center my-4">
                            <div class="flex-1 border-t"></div>
                            <span class="px-3 text-xs text-gray-500">ou</span>
                            <div class="flex-1 border-t"></div>
                        </div>

                        <label class="block text-sm font-medium mb-2">
                            E-mail
                        </label>

                        <input type="email"
                               id="email"
                               name="customer_email"
                               required
                               placeholder="seu@email.com"
                               class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100">
                        <p class="text-red-500 text-sm mt-1"
                           x-show="fieldErrors.email"
                           x-text="fieldErrors.email"></p>

                        <p class="text-xs text-gray-500 mt-2">
                            Usaremos seu e-mail para enviar informações do pedido.
                        </p>

                        <button type="button"
                                id="btn-check-email"
                                class="mt-4 w-full px-6 py-2 bg-black text-white rounded">
                            Continuar
                        </button>

                    </div>

                    {{-- STEP LOGIN --}}
                    <div id="step-login" class="hidden border p-5 shadow-sm mt-4 bg-white">

                        <h2 class="text-lg font-semibold mb-4">
                            Já encontramos sua conta
                        </h2>

                        <div class="mb-4 text-sm text-gray-600" id="login-email-display"></div>

                        <input type="password"
                               name="password"
                               placeholder="Digite sua senha"
                               class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
                               required>

                        <button type="submit"
                                class="mt-4 w-full px-6 py-2 bg-black text-white rounded">
                            Entrar
                        </button>

                    </div>

                    {{-- STEP REGISTER --}}
                    <div id="step-register" class="hidden border p-5 shadow-sm mt-4 bg-white">

                        <h2 class="text-lg font-semibold mb-4">
                            Complete seu cadastro
                        </h2>

                        <div class="space-y-4">

                            <input type="text"
                                   name="customer_name"
                                   placeholder="Nome completo"
                                   class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
                                   required>

                            <p class="text-red-500 text-sm"
                               x-show="fieldErrors.customer_name"
                               x-text="fieldErrors.customer_name"></p>


                            <input type="text"
                                   name="vat_number"
                                   id="vat_number"
                                   placeholder="CPF/CNPJ"
                                   class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
                                   required>
                            <p class="text-red-500 text-sm"
                               x-show="fieldErrors.vat_number"
                               x-text="fieldErrors.vat_number"></p>

                            <p class="text-xs text-gray-500">
                                Necessário para emissão da nota fiscal.
                            </p>

                            <div class="relative mt-3">
                                <input type="password"
                                       name="password"
                                       id="password"
                                       data-field="password"
                                       placeholder="Senha"
                                       class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100">

                                <button type="button" class="toggle-password absolute right-3 top-1/2 -translate-y-1/2">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>

                            <p class="text-red-500 text-sm"
                               x-show="fieldErrors.password"
                               x-text="fieldErrors.password"></p>

                            <div class="relative mt-3">
                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       data-field="password_confirmation"
                                       placeholder="Confirmar senha"
                                       class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100 pr-10">

                                <button type="button" class="toggle-password absolute right-3 top-1/2 -translate-y-1/2">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>

                            <p class="text-red-500 text-sm"
                               x-show="fieldErrors.password_confirmation"
                               x-text="fieldErrors.password_confirmation"></p>

                        </div>

                        <button type="submit"
                                formaction="{{ route('account.createpost') }}"
                                @click="validateForm"
                                class="mt-4 w-full bg-black text-white py-2">
                            Criar conta e continuar
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>
        {{-- Validacao do form de login --}}
        document.addEventListener('alpine:init', () => {

            Alpine.data('register', () => ({

                fieldErrors: {},

                setFieldError(field, message) {
                    this.fieldErrors[field] = message;
                    const el = document.querySelector(`[data-field="${field}"]`);
                    if (el) el.classList.add('border-red-500');
                },

                clearErrors() {
                    this.fieldErrors = {};
                    document.querySelectorAll('[data-field]').forEach(el => {
                        el.classList.remove('border-red-500');
                    });
                },

                scrollToError() {
                    const first = Object.keys(this.fieldErrors)[0];
                    if (!first) return;

                    const el = document.querySelector(`[data-field="${first}"]`);
                    if (!el) return;

                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => el.focus(), 300);
                },

                validateEmail(email) {
                    return window.Validators.email(email);
                },

                validateForm(event) {

                    this.clearErrors();
                    let valid = true;

                    // EMAIL
                    const email = document.querySelector('[name="customer_email"]')?.value.trim();

                    if (!email || !this.validateEmail(email)) {
                        this.setFieldError('email', 'Informe seu e-mail corretamente');
                        valid = false;
                    }

                    // NOME
                    const name = document.querySelector('[name="customer_name"]')?.value.trim();

                    if (!window.Validators.fullName(name)) {
                        this.setFieldError('customer_name', 'Informe nome e sobrenome');
                        valid = false;
                    }

                    // CPF / CNPJ
                    const cpfEl = document.querySelector('[name="vat_number"]');

                    if (cpfEl) {

                        const value = cpfEl.value.trim();

                        if (!value) {
                            this.setFieldError('vat_number', 'Informe seu CPF ou CNPJ');
                            valid = false;

                        } else if (!window.Validators.cpfCnpj(value)) {
                            this.setFieldError('vat_number', 'CPF/CNPJ inválido');
                            valid = false;
                        }
                    }

                    // SENHA
                    const pass = document.getElementById('password')?.value;
                    const confirm = document.getElementById('password_confirmation')?.value;

                    if (!window.Validators.password(pass)) {
                        this.setFieldError('password', 'Mínimo 8 caracteres com letras e números');
                        valid = false;
                    }

                    if (pass !== confirm) {
                        this.setFieldError('password_confirmation', 'Senhas não conferem');
                        valid = false;
                    }

                    // FINAL
                    if (!valid) {
                        event?.preventDefault();
                        this.scrollToError();
                    }

                    return valid;
                }

            }));

        });

        {{-- Steps do cadastro --}}
        document.addEventListener('DOMContentLoaded', function () {

            const btn = document.getElementById('btn-check-email');
            const form = document.querySelector('form');

            const stepEmail = document.getElementById('step-email');
            const stepLogin = document.getElementById('step-login');
            const stepRegister = document.getElementById('step-register');

            const emailInput = document.getElementById('email');
            const loginEmailDisplay = document.getElementById('login-email-display');

            if (!btn || !form) return;

            function toggleStep(stepToShow) {

                const steps = {
                    'step-login': stepLogin,
                    'step-register': stepRegister
                };

                Object.keys(steps).forEach(step => {

                    const el = steps[step];
                    const inputs = el.querySelectorAll('input');

                    if (step === stepToShow) {
                        el.classList.remove('hidden');
                        inputs.forEach(i => i.disabled = false);
                    } else {
                        el.classList.add('hidden');
                        inputs.forEach(i => i.disabled = true);
                    }

                });

                // mantém contexto visual (não remove completamente)
                stepEmail.classList.add('opacity-50');
            }

            btn.addEventListener('click', async function () {

                const email = emailInput.value;

                if (!email) return;

                try {

                    const response = await fetch('{{ route('account.checkEmail') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ email })
                    });

                    const data = await response.json();

                    loginEmailDisplay.innerText = email;

                    if (data.exists) {
                        toggleStep('step-login');
                    } else {
                        toggleStep('step-register');
                    }

                } catch (error) {
                    console.error(error);
                }

            });

            form.addEventListener('submit', function () {

                const email = emailInput.value;

                form.querySelectorAll('input[name="customer_email"]').forEach(el => el.remove());

                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'customer_email';
                input.value = email;

                form.appendChild(input);
            });

            // TOGGLE SENHA
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function () {

                    const input = this.closest('.relative').querySelector('input');
                    const icon = this.querySelector('i');

                    const isPassword = input.type === 'password';

                    input.type = isPassword ? 'text' : 'password';

                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            });

        });
    </script>

</x-frontend.app-layout>
