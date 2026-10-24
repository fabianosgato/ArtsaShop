<x-frontend.app-layout layout="2columns-customer">
    <div class="dashboard">

        <form action="{{route('account.addressedit.post')}}" method="post">
            @csrf

            <div class="dy-card bg-base-100 rounded-md border border-gray-200 shadow-sm mb-6">
                <div class="dy-card-body p-4">

                    <h3 class="dy-card-title mb-6">
                        Meu Endereço
                    </h3>

                    @if (session('success'))
                        <div class="mb-6 p-3 rounded bg-green-100 text-green-700 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    <input type="hidden" name="address_id" value="{{$address->address_id}}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> Celular
                            </label>
                            <input type="text"
                                   class="mask-telefone w-full border px-3 py-2"
                                   name="cellphone"
                                   value="{{ $address->cellphone }}"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Telefone
                            </label>
                            <input type="text"
                                   class="mask-telefone w-full border px-3 py-2"
                                   name="phone"
                                   value="{{$address->phone}}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> CEP
                            </label>
                            <input type="text"
                                   class="mask-postcode postcode w-full border px-3 py-2"
                                   name="postcode"
                                   data-scope="billing"
                                   value="{{ $address->postcode }}"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                País
                            </label>
                            <input type="text"
                                   class="w-full border px-3 py-2 bg-gray-100"
                                   value="Brasil"
                                   readonly>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> Estado
                            </label>
                            <select class="region w-full border px-3 py-2"
                                    name="region"
                                    data-scope="billing"
                                    required>
                                <option value="">Escolha...</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->uf_initials }}"
                                        {{ old('region', $address->region ?? '') == $state->uf_initials ? 'selected' : '' }}>
                                        {{ $state->uf_description }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> Endereço
                            </label>
                            <input type="text"
                                   class="street w-full border px-3 py-2"
                                   name="street"
                                   data-scope="billing"
                                   value="{{ $address->street }}"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> Número
                            </label>
                            <input type="text"
                                   class="number w-full border px-3 py-2"
                                   name="number"
                                   value="{{ $address->number }}"
                                   required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1">
                                Complemento
                            </label>
                            <input type="text"
                                   class="w-full border px-3 py-2"
                                   name="complement"
                                   value="{{ $address->complement }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> Cidade
                            </label>
                            <input type="text"
                                   class="city w-full border px-3 py-2"
                                   name="city"
                                   data-scope="billing"
                                   value="{{ $address->city }}"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> Bairro
                            </label>
                            <input type="text"
                                   class="neighborhood w-full border px-3 py-2"
                                   name="neighborhood"
                                   data-scope="billing"
                                   value="{{ $address->neighborhood }}"
                                   required>
                        </div>

                        <div class="md:col-span-2 space-y-3">

                            <label class="flex items-center gap-2 text-sm">
                                <input type="checkbox"
                                       name="is_default_billing"
                                       value="1"
                                       class="w-4 h-4"
                                    {{ $address->is_default_billing ? 'checked' : '' }}>
                                Salvar como padrão para Endereço de Cobrança
                            </label>

                            <label class="flex items-center gap-2 text-sm">
                                <input type="checkbox"
                                       name="is_default_shipping"
                                       value="1"
                                       class="w-4 h-4"
                                    {{ $address->is_default_shipping ? 'checked' : '' }}>
                                Salvar como padrão para Endereço de Entrega
                            </label>
                        </div>
                        <div class="md:col-span-2 pt-4">
                            <button type="submit"
                                    class="px-6 py-2 bg-celadon-700 text-white rounded hover:opacity-90 transition">
                                Salvar Endereço
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-frontend.app-layout>
