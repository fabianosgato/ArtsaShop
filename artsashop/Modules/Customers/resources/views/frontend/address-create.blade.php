<x-frontend.app-layout layout="2columns-customer">
    <div class="dashboard">

        <form action="{{route('account.addressCreate.post')}}" method="post">
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> Celular
                            </label>
                            <input type="text"
                                   class="mask-telefone w-full border px-3 py-2"
                                   name="cellphone"
                                   value="{{ old('cellphone') }}"
                                   required>
                            <p class="text-xs text-gray-500 mt-1">
                                Informe seu celular para podermos entrar em contato sobre seu pedido confirmando sua compra
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> CEP
                            </label>
                            <input type="text"
                                   class="mask-postcode postcode w-full border px-3 py-2"
                                   name="postcode"
                                   data-scope="billing"
                                   value="{{ old('postcode') }}"
                                   required>
                            <p class="text-xs text-gray-500 mt-1">
                                Informe seu CEP, se seu endereço estiver em nossa base será preechido automaticamente
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> Endereço
                            </label>
                            <input type="text"
                                   class="street w-full border px-3 py-2"
                                   name="street"
                                   data-scope="billing"
                                   value="{{ old('street') }}"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> Número
                            </label>
                            <input type="text"
                                   class="number w-full border px-3 py-2"
                                   name="number"
                                   value="{{ old('number') }}"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Complemento
                            </label>
                            <input type="text"
                                   class="w-full border px-3 py-2"
                                   name="complement"
                                   value="{{ old('complement') }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> Bairro
                            </label>
                            <input type="text"
                                   class="neighborhood w-full border px-3 py-2"
                                   name="neighborhood"
                                   data-scope="billing"
                                   value="{{ old('neighborhood') }}"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                <em>*</em> Cidade
                            </label>
                            <input type="text"
                                   class="city w-full border px-3 py-2"
                                   name="city"
                                   data-scope="billing"
                                   value="{{ old('city') }}"
                                   required>
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

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Telefone (Residencial ou outro celular)
                            </label>
                            <input type="text"
                                   class="mask-telefone w-full border px-3 py-2"
                                   name="phone"
                                   value="{{ old('phone') }}">
                            <p class="text-xs text-gray-500 mt-1">
                                Informe outro número de celular ou telefone para contato caso deseje (opcional)
                            </p>
                        </div>

                        {{-- recipient_name : Nome de quem pode receber o pedido --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Nome de quem pode receber o pedido neste endereço
                            </label>
                            <input type="text"
                                   name="recipient_name"
                                   value="{{ old('recipient_name') ?? $customer['customer_name'] ?? '' }}"
                                   class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100">
                            <p class="text-xs text-gray-500 mt-1">
                                Informe o nome da pessoa que receberá o pedido se for outra pessoa (opcional)
                            </p>
                        </div>

                        <div class="md:col-span-2 space-y-3">

                            <label class="flex items-center gap-2 text-sm">
                                <input type="checkbox"
                                       name="is_default_billing"
                                       value="1"
                                       class="w-4 h-4"
                                       checked
                                    {{ old('is_default_billing') ? 'checked' : '' }}>
                                Definir como endereço padrão de cobrança
                            </label>

                            <label class="flex items-center gap-2 text-sm">
                                <input type="checkbox"
                                       name="is_default_shipping"
                                       value="1"
                                       class="w-4 h-4"
                                       checked
                                    {{ old('is_default_shipping') ? 'checked' : '' }}>
                                Definir como endereço padrão de entrega
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
