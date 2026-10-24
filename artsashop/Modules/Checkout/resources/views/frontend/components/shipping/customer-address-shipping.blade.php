<h5 class="md:col-span-2 text-lg font-semibold">Endereço de Entrega</h5>
<div>
    <label class="block text-sm font-medium mb-1">
        <em>*</em> CEP
    </label>
    <input type="text"
           class="mask-postcode postcode w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
           name="shipping[postcode]"
           data-scope="shipping"
           placeholder="00000-000"
           value="{{ old('shipping.postcode') }}">
</div>

<div>
    <label class="block text-sm font-medium mb-1">
        <em>*</em> Endereço
    </label>
    <input type="text"
           class="street w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
           name="shipping[street]"
           data-scope="shipping"
           value="{{ old('shipping.street') }}">
</div>

<div>
    <label class="block text-sm font-medium mb-1">
        <em>*</em> Número
    </label>
    <input type="text"
           class="number w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
           name="shipping[number]"
           data-scope="shipping"
           value="{{ old('shipping.number') }}">
</div>

<div>
    <label class="block text-sm font-medium mb-1">
        Complemento
    </label>
    <input type="text"
           class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
           name="shipping[complement]"
           data-scope="shipping"
           value="{{ old('shipping.complement') }}">
</div>

<div>
    <label class="block text-sm font-medium mb-1">
        <em>*</em> Cidade
    </label>
    <input type="text"
           class="city w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
           name="shipping[city]"
           data-scope="shipping"
           value="{{ old('shipping.city') }}">
</div>

<div>
    <label class="block text-sm font-medium mb-1">
        <em>*</em> Bairro
    </label>
    <input type="text"
           class="neighborhood w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
           name="shipping[neighborhood]"
           data-scope="shipping"
           value="{{ old('shipping.neighborhood') }}">
</div>

<div>
    <label class="block text-sm font-medium mb-1">
        <em>*</em> Estado
    </label>
    <select name="shipping[region]"
            class="region w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100"
            data-scope="shipping">
        <option value="">Escolha...</option>
        @foreach($regions as $region)
            <option value="{{ $region->uf_initials }}"
                {{ old('shipping.region') == $region->uf_initials ? 'selected' : '' }}>
                {{ $region->uf_description }}
            </option>
        @endforeach
    </select>
</div>
