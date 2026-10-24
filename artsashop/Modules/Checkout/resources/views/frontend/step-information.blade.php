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
                <form method="POST"
                      action="{{ route('checkout.onepage.information.post') }}"
                      @submit="validateForm">
                    @csrf

                    @if(session('checkout.existing_customer'))
                        <div class="mb-4 p-3 rounded bg-blue-50 text-blue-700 text-sm">

                            Já encontramos uma conta com este e-mail.

                            <div class="mt-2">
                                <a href="{{ route('account.login') }}"
                                   class="underline font-medium">
                                    Entrar na minha conta
                                </a>
                                <span class="text-gray-500">ou continue sem entrar.</span>
                            </div>

                        </div>
                    @endif

                    <x-checkout::onepage-customer-form-register-component :quote="$quote" />

                    {{-- BOTÃO --}}
                    <button class="w-full bg-black text-white py-3 rounded mt-4">
                        Continuar para o Endereço
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
        {{-- validacao dos dados do usuario --}}
        document.addEventListener('alpine:init', () => {

            Alpine.data('checkout', () => ({

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

                    el.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    setTimeout(() => el.focus(), 300);
                },

                validateForm(event) {

                    this.clearErrors();

                    let valid = true;

                    // =============================
                    // NOME COMPLETO
                    // =============================
                    const nameEl = document.querySelector('[name="register[customer_name]"]');

                    if (nameEl) {
                        const name = nameEl.value.trim();

                        if (!window.Validators.fullName(name)) {
                            this.setFieldError('customer_name', 'Informe nome e sobrenome');
                            valid = false;
                        }
                    }

                    // =============================
                    // EMAIL
                    // =============================
                    const emailEl = document.querySelector('[name="register[email_address]"]');

                    if (emailEl) {
                        const email = emailEl.value.trim();

                        if (!window.Validators.email(email)) {
                            this.setFieldError('email', 'E-mail inválido');
                            valid = false;
                        }
                    }

                    // =============================
                    // SENHA (SE CHECKBOX ATIVO)
                    // =============================
                    const createAccount = document.getElementById('create_account_checkbox');
                    const passEl = document.getElementById('password');
                    const confirmEl = document.getElementById('password_confirmation');

                    if (createAccount && createAccount.checked) {

                        const pass = passEl?.value || '';
                        const confirm = confirmEl?.value || '';

                        if (!window.Validators.password(pass)) {
                            this.setFieldError('password', 'Mínimo 8 caracteres com letras e números');
                            valid = false;
                        }

                        if (!confirm) {
                            this.setFieldError('password_confirmation', 'Confirme a senha');
                            valid = false;

                        } else if (pass !== confirm) {
                            this.setFieldError('password_confirmation', 'Senhas não conferem');
                            valid = false;
                        }
                    }

                    // =============================
                    // FINAL
                    // =============================
                    if (!valid) {
                        event.preventDefault();
                        this.scrollToError();
                    }

                    return valid;
                }

            }));

        });

        document.addEventListener('DOMContentLoaded', function () {
            // =============================
            // TOGGLE CREATE ACCOUNT
            // =============================
            const checkbox = document.getElementById('create_account_checkbox');
            const passwordFields = document.getElementById('password-fields');
            const password = document.getElementById('password');
            const confirm = document.getElementById('password_confirmation');

            if (checkbox) {
                checkbox.addEventListener('change', function () {

                    if (this.checked) {
                        passwordFields.classList.remove('hidden');

                        password.setAttribute('required', 'required');
                        confirm.setAttribute('required', 'required');

                    } else {
                        passwordFields.classList.add('hidden');

                        password.removeAttribute('required');
                        confirm.removeAttribute('required');

                        password.value = '';
                        confirm.value = '';
                    }
                });
            }

            // =============================
            // TOGGLE SENHA
            // =============================
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
