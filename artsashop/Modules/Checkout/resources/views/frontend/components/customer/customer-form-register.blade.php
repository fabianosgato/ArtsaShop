{{-- ================= DADOS PESSOAIS DO CLIENTE ================= --}}
<div id="billing-address" class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <h5 class="md:col-span-2 text-lg font-semibold">
        Seus Dados Pessoais
    </h5>

    {{-- NOME --}}
    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">
            <em>*</em> Nome Completo
        </label>

        <input type="text"
               name="register[customer_name]"
               value="{{ old('register.customer_name') ?? ($quote['customer_name'] ?? '') }}"
               data-field="customer_name"
               required
               class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100">

        <p class="text-sm text-gray-500 mt-1">
            Informe seu nome e sobrenome.
        </p>

        <p class="text-red-500 text-sm mt-1"
           x-show="fieldErrors.customer_name"
           x-text="fieldErrors.customer_name"></p>
    </div>

    {{-- EMAIL --}}
    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">
            <em>*</em> Endereço de E-mail
        </label>

        <input type="email"
               name="register[email_address]"
               data-field="email"
               value="{{ $quote['customer_email'] }}"
               autocomplete="new-email"
               readonly
               class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100">

        <p class="text-sm text-gray-500 mt-1">
            Seu e-mail será usado apenas para enviar informações do pedido.
        </p>

        <p class="text-red-500 text-sm mt-1"
           x-show="fieldErrors.email"
           x-text="fieldErrors.email"></p>
    </div>


    @if(!session('checkout.existing_customer'))
    {{-- CHECKBOX CRIAR CONTA --}}
    <div class="md:col-span-2 space-y-3">

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox"
                   id="create_account_checkbox"
                   name="register[customer_create_account]"
                   value="1">

            Criar senha para facilitar suas próximas compras (opcional)
        </label>

    </div>

    {{-- CAMPOS DE SENHA (INICIALMENTE ESCONDIDOS) --}}
    <div id="password-fields" class="hidden md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- SENHA --}}
        <div>
            <label class="block text-sm font-medium mb-1">
                <em>*</em> Crie uma senha
            </label>

            <div class="relative">
                <input type="password"
                       name="register[password]"
                       id="password"
                       data-field="password"
                       autocomplete="new-password"
                       class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100 password-field">

                <button type="button" class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>

            <p class="text-sm text-gray-500 mt-1">
                Use no mínimo 8 caracteres com letras e números.
            </p>

            <p class="text-red-500 text-sm mt-1"
               x-show="fieldErrors.password"
               x-text="fieldErrors.password"></p>
        </div>

        {{-- CONFIRMAÇÃO --}}
        <div>
            <label class="block text-sm font-medium mb-1">
                <em>*</em> Confirme sua senha
            </label>

            <div class="relative">
                <input type="password"
                       name="register[password_confirmation]"
                       id="password_confirmation"
                       data-field="password_confirmation"
                       class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100 password-field">

                <button type="button" class="toggle-password absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>

            <p class="text-red-500 text-sm mt-1"
               x-show="fieldErrors.password_confirmation"
               x-text="fieldErrors.password_confirmation"></p>
        </div>

    </div>
    @endif

</div>

