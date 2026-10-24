<x-frontend.app-layout layout="1column">

    <div x-data="checkout()">

        {{-- HEADER --}}
        <div class="page-title title-buttons mb-4">
            <h1 class="text-2xl font-semibold">Finalização da Compra</h1>
        </div>

        {{-- BARRA DE PROGRESSO --}}
        <x-checkout::onepage-progress-bar-component />

        {{-- LAYOUT PRINCIPAL --}}
        <div class="grid md:grid-cols-2 gap-8">

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
                      action="{{ route('checkout.onepage.placeOrder.post') }}"
                      x-ref="checkoutForm"
                      @submit.prevent="submitOrder">

                    @csrf

                    {{-- Campo de CPF/CNPJ --}}
                    @include('checkout::frontend.components.customer.customer-form-taxvat')

                    <x-checkout::onepage-payments-component :quote="$quote" />

                    {{-- BOTÃO --}}
                    <button type="submit"
                            :disabled="isSubmitting"
                            class="w-full bg-black text-white py-3 rounded mt-4 disabled:opacity-50">
                        <span x-show="!isSubmitting">Finalizar compra</span>
                        <span x-show="isSubmitting">Processando...</span>
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
        document.addEventListener('alpine:init', () => {

            Alpine.store('payment', {
                creditCard: null
            });

            // Validações do checkout
            Alpine.data('checkout', () => ({

                isSubmitting: false,
                selectedPayment: 'pix',
                paymentMethod: 'pix',
                errorMessage: '',

                fieldErrors: {},

                // HELPERS UI
                setFieldError(field, message) {
                    this.fieldErrors[field] = message;

                    const el = document.querySelector(`[data-field="${field}"]`);
                    if (el) {
                        el.classList.add('border-red-500');
                        el.classList.remove('border-gray-300');
                    }
                },

                clearFieldError(field) {
                    delete this.fieldErrors[field];

                    const el = document.querySelector(`[data-field="${field}"]`);
                    if (el) {
                        el.classList.remove('border-red-500');
                        el.classList.add('border-gray-300');
                    }
                },

                clearAllErrors() {
                    this.fieldErrors = {};
                    document.querySelectorAll('[data-field]').forEach(el => {
                        el.classList.remove('border-red-500');
                        el.classList.add('border-gray-300');
                    });
                },

                // SCROLL PARA PRIMEIRO ERRO
                scrollToFirstError() {

                    const firstErrorField = Object.keys(this.fieldErrors)[0];
                    if (!firstErrorField) return;

                    const el = document.querySelector(`[data-field="${firstErrorField}"]`);
                    if (!el) return;

                    // Scroll suave centralizado (mobile friendly)
                    el.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    // Pequeno delay para garantir foco após scroll
                    setTimeout(() => {
                        el.focus();
                    }, 400);
                },

                // PAGAMENTO
                validatePayment() {

                    if (this.paymentMethod === 'credit_card') {

                        const cardComponent = Alpine.store('payment').creditCard;

                        if (!cardComponent)
                            return false;

                        return cardComponent.validate();
                    }

                    return true;
                },

                // SUBMIT
                submitOrder() {

                    // BLOQUEIO DUPLO CLICK
                    if (this.isSubmitting) return;

                    this.errorMessage = '';
                    this.clearAllErrors();

                    let valid = true;

                    // CPF / CNPJ
                    const cpfEl = document.querySelector('[name="register[vat_number]"]');

                    if (cpfEl) {

                        const value = cpfEl.value.trim();

                        if (!value) {
                            this.setFieldError('cpf', 'Informe seu CPF ou CNPJ');
                            valid = false;

                        } else if (!window.Validators.cpfCnpj(value)) {
                            this.setFieldError('cpf', 'CPF/CNPJ inválido');
                            valid = false;
                        }
                    }

                    // PAGAMENTO
                    if (!this.validatePayment()) {
                        this.errorMessage = 'Preencha corretamente os dados do Cartão de Crédito';
                        valid = false;
                    }

                    if (!valid) {
                        this.scrollToFirstError();
                        return;
                    }

                    // 🟢 BLOQUEIA SUBMIT
                    this.isSubmitting = true;

                    this.submitForm();
                },

                submitForm() {
                    this.$refs.checkoutForm.submit();
                }

            }));

            // Validações do Cartao de Crédito
            Alpine.data('creditCard', () => ({

                cardHolder: '',
                cardNumber: '',
                brand: '',
                expiry: '',
                cvv: '',

                errors: {},

                init() {
                    Alpine.store('payment').creditCard = this;
                },

                // MAX LENGTH DINÂMICO para AMEX
                get maxLength() {
                    return this.brand === 'amex' ? 17 : 19;
                },

                get cvvMaxLength() {
                    return this.brand === 'amex' ? 4 : 3;
                },

                // FORMATAÇÃO CARTÃO
                formatCardNumber() {

                    let value = this.cardNumber.replace(/\D/g, '');

                    const isAmex = /^3[47]/.test(value);

                    if (isAmex) {

                        value = value.substring(0, 15);

                        value = value.replace(/^(\d{4})(\d{1,6})?(\d{1,5})?/, (m, p1, p2, p3) => {
                            let result = p1;
                            if (p2) result += ' ' + p2;
                            if (p3) result += ' ' + p3;
                            return result;
                        });

                    } else {

                        value = value.substring(0, 16);
                        value = value.replace(/(\d{4})(?=\d)/g, '$1 ');

                    }

                    this.cardNumber = value;

                },

                // FORMATA EXPIRAÇÃO
                formatExpiry() {

                    let value = this.expiry.replace(/\D/g, '').substring(0, 6);

                    // Ajusta mês automaticamente
                    if (value.length >= 2) {

                        let month = parseInt(value.substring(0, 2));

                        if (month > 12) {
                            value = '12' + value.substring(2);
                        } else if (month === 0) {
                            value = '01' + value.substring(2);
                        }

                    }

                    if (value.length > 2) {
                        value = value.replace(/^(\d{2})(\d{1,4})$/, '$1/$2');
                    }

                    this.expiry = value;

                },

                // DETECTA BANDEIRA
                detectBrand() {

                    const number = this.cardNumber.replace(/\D/g, '');

                    const patterns = {
                        visa: /^4/,
                        mastercard: /^(5[1-5]|2[2-7])/,
                        amex: /^3[47]/,
                        elo: /^(4011|4312|4389|4514|4576|5041|5066|509|6277|6363)/,
                        hipercard: /^(606282|3841)/,
                    };

                    for (let brand in patterns) {
                        if (patterns[brand].test(number)) {
                            this.brand = brand;
                            return;
                        }
                    }

                    this.brand = '';
                },

                // LUHN (VALIDAÇÃO CARTÃO)
                isValidCardNumber() {

                    const number = this.cardNumber.replace(/\D/g, '');

                    let sum = 0;
                    let shouldDouble = false;

                    for (let i = number.length - 1; i >= 0; i--) {

                        let digit = parseInt(number[i]);

                        if (shouldDouble) {
                            digit *= 2;
                            if (digit > 9) digit -= 9;
                        }

                        sum += digit;
                        shouldDouble = !shouldDouble;
                    }

                    return sum % 10 === 0;

                },

                // VALIDA DATA
                isValidExpiry() {

                    if (!/^\d{2}\/\d{4}$/.test(this.expiry)) return false;

                    const [month, year] = this.expiry.split('/').map(Number);

                    if (month < 1 || month > 12) return false;

                    const now = new Date();
                    const currentYear = now.getFullYear();
                    const currentMonth = now.getMonth() + 1;

                    if (year < currentYear) return false;

                    if (year === currentYear && month < currentMonth) return false;

                    return true;
                },

                // VALIDA CVV
                isValidCVV() {

                    const cvv = this.cvv.replace(/\D/g, '');

                    if (this.brand === 'amex') {
                        return cvv.length === 4;
                    }

                    return cvv.length === 3;
                },

                // Valida os dados do cartão de crédito
                validate(){

                    this.errors = {};

                    const holder = this.cardHolder;
                    const number = this.cardNumber.replace(/\D/g, '');
                    const cvv = this.cvv.replace(/\D/g, '');

                    // Nome que está no Cartão
                    if (!holder) {
                        this.errors.holder = 'Nome que está no cartão é obrigatório';

                    } else {
                        const clean = holder.trim().replace(/\s+/g, ' ');
                        const parts = clean.split(' ');

                        if (parts.length < 2) {
                            this.errors.holder = 'Informe nome e sobrenome como está no cartão';
                        }
                    }

                    // Número do cartão
                    if (!number) {
                        this.errors.cardNumber = 'Número do cartão é obrigatório';
                    } else if (!this.isValidCardNumber()) {
                        this.errors.cardNumber = 'Número do cartão inválido';
                    }

                    // Data
                    if (!this.expiry) {
                        this.errors.expiry = 'Data de expiração é obrigatória';
                    } else if (!this.isValidExpiry()) {
                        this.errors.expiry = 'Data de expiração inválida';
                    }

                    // CVV
                    if (!cvv) {
                        this.errors.cvv = 'CVV é obrigatório';
                    } else if (!this.isValidCVV()) {
                        this.errors.cvv = 'CVV inválido';
                    }

                    return Object.keys(this.errors).length === 0;

                },

            }));

        })
    </script>

</x-frontend.app-layout>
