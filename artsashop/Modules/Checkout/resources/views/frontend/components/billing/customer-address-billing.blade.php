<h5 class="md:col-span-2 text-lg font-semibold">Endereço de Cobrança</h5>
{{-- Celular (PRIORIDADE) --}}
<div>
    <label class="block text-sm font-medium mb-1">
        <em>*</em> Celular
    </label>
    <input type="text"
           class="mask-telefone w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
           name="billing[cellphone]"
           placeholder="(00)0000-0000"
           data-required="true"
           required
           value="{{ old('billing.cellphone', $quote['customer_address_billing']['cellphone'] ?? '') }}">
    <p class="text-xs text-gray-500 mt-1">
        Informe seu celular para podermos entrar em contato sobre seu pedido confirmando sua compra
    </p>
</div>

{{-- CEP (GATILHO) --}}
<div>
    <label class="block text-sm font-medium mb-1">
        <em>*</em> CEP
    </label>
    <input type="text"
           id="billing-postcode"
           class="mask-postcode postcode w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
           name="billing[postcode]"
           data-scope="billing"
           placeholder="00000-000"
           data-required="true"
           required
           value="{{ old('billing.postcode', $quote['customer_address_billing']['postcode'] ?? '') }}">
    <p class="text-xs text-gray-500 mt-1">
        Informe seu CEP, se seu endereço estiver em nossa base será preechido automaticamente
    </p>
</div>

@php
    $hasBilling = !empty($quote['customer_address_billing']['postcode']);
@endphp

<div id="billing-address-fields"
     class="{{ $hasBilling ? '' : 'hidden' }} md:col-span-2 grid grid-cols-2 gap-4">

    <div>
        <label class="block text-sm font-medium mb-1">
            <em>*</em> Endereço
        </label>
        <input type="text"
               class="street w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
               name="billing[street]"
               data-scope="billing"
               data-required="true"
               required
               value="{{ old('billing.street', $quote['customer_address_billing']['street'] ?? '') }}">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">
            <em>*</em> Número
        </label>
        <input type="text"
               class="number w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
               id="billing.number"
               name="billing[number]"
               data-scope="billing"
               data-required="true"
               required
               value="{{ old('billing.number', $quote['customer_address_billing']['number'] ?? '') }}">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">
            Complemento
        </label>
        <input type="text"
               class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
               name="billing[complement]"
               value="{{ old('billing.complement', $quote['customer_address_billing']['complement'] ?? '') }}">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">
            <em>*</em> Bairro
        </label>
        <input type="text"
               class="neighborhood w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
               name="billing[neighborhood]"
               data-scope="billing"
               data-required="true"
               required
               value="{{ old('billing.neighborhood', $quote['customer_address_billing']['neighborhood'] ?? '') }}">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">
            <em>*</em> Cidade
        </label>
        <input type="text"
               class="city w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
               name="billing[city]"
               data-scope="billing"
               data-required="true"
               required
               value="{{ old('billing.city', $quote['customer_address_billing']['city'] ?? '') }}">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">
            <em>*</em> Estado
        </label>
        <select name="billing[region]"
                class="region w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
                data-scope="billing"
                data-required="true"
                required>
            <option value="">Escolha...</option>
            @foreach($regions as $region)
                <option value="{{ $region->uf_initials }}"
                    {{ old('billing.region', $quote['customer_address_billing']['region'] ?? '') == $region->uf_initials ? 'selected' : '' }}>
                    {{ $region->uf_description }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- recipient_name : Nome de quem pode receber o pedido --}}
    <div>
        <label class="block text-sm font-medium mb-1">
            Nome de quem vai receber o pedido
        </label>
        <input type="text"
               name="billing[recipient_name]"
               value="{{ old('billing.recipient_name', $quote['customer_address_billing']['recipient_name'] ?? $quote['customer_name'] ?? '') }}"
               class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100">
        <p class="text-xs text-gray-500 mt-1">
            Informe o nome da pessoa que receberá o pedido se for outra pessoa (opcional)
        </p>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">
            Telefone (Residencial ou outro celular)
        </label>
        <input type="text"
               class="mask-telefone w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
               name="billing[phone]"
               placeholder="(00)0000-0000"
               value="{{ old('billing.phone', $quote['customer_address_billing']['telephone'] ?? '') }}">
        <p class="text-xs text-gray-500 mt-1">
            Informe outro número de celular ou telefone para contato caso deseje (opcional)
        </p>

    </div>

    {{-- CHECKBOX --}}
    <div class="md:col-span-2 space-y-3">
        {{-- Mostra apenas se o cliente estiver se cadastrando --}}
        @if($quote['customer_create_account'])
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="save_address" value="1" checked>
                Salvar este endereço para próximas compras
            </label>
        @endif

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox"
                   id="use_different_shipping"
                   name="billing[use_different_shipping]"
                   value="1">
            Entregar meu pedido em outro endereço
        </label>

    </div>

</div>
