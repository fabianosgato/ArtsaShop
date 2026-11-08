<x-frontend.app-layout layout="2columns-customer">
    <div class="dashboard">
        <div class="dy-card bg-base-100 rounded-md border border-gray-200 shadow-sm mb-6">
            <div class="dy-card-body p-4">

                @if($customerAddresses && $customerAddresses->count())
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="dy-card-title m-0">
                            Meus Endereços
                        </h3>
                        <a href="{{ route('account.addressCreate') }}"
                           class="px-4 py-2 border rounded text-sm text-primary-50 bg-blumine-400 hover:bg-blumine-500 transition">
                            Cadastrar Novo Endereço
                        </a>
                    </div>
                    <div class="space-y-6">
                        @foreach($customerAddresses as $customerAddress)
                            <div class="border rounded-lg shadow-sm p-4 bg-white">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
                                    <h2 class="text-lg font-semibold text-celadon-700">
                                        {{ $customerAddress->recipient_name }}
                                    </h2>
                                    <div class="flex flex-wrap gap-2">

                                        @if($customerAddress->is_default_billing == 1)
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                                Endereço de Cobrança Padrão
                                            </span>
                                        @endif

                                        @if($customerAddress->is_default_shipping == 1)
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                                Endereço de Entrega Padrão
                                            </span>
                                        @endif

                                    </div>

                                </div>

                                {{-- ADDRESS INFO --}}
                                <div class="text-sm text-gray-700 leading-relaxed space-y-1">

                                    <div><strong>CEP:</strong> {{ $customerAddress->postcode }}</div>
                                    <div><strong>Celular:</strong> {{ $customerAddress->cellphone }}</div>

                                    @if(!empty($customerAddress->phone))
                                        <div><strong>Telefone:</strong> {{ $customerAddress->phone }}</div>
                                    @endif

                                    <div><strong>Rua:</strong> {{ $customerAddress->street }}</div>

                                    @if(!empty($customerAddress->number))
                                        <div><strong>Número:</strong> {{ $customerAddress->number }}</div>
                                    @endif

                                    @if(!empty($customerAddress->complement))
                                        <div><strong>Complemento:</strong> {{ $customerAddress->complement }}</div>
                                    @endif

                                    @if(!empty($customerAddress->neighborhood))
                                        <div><strong>Bairro:</strong> {{ $customerAddress->neighborhood }}</div>
                                    @endif

                                    @if(!empty($customerAddress->city))
                                        <div><strong>Cidade:</strong> {{ $customerAddress->city }}</div>
                                    @endif

                                    @if(!empty($customerAddress->region))
                                        <div><strong>Estado:</strong> {{ $customerAddress->region }}</div>
                                    @endif

                                </div>

                                {{-- ACTIONS --}}
                                <div class="mt-4 flex justify-end">
                                    <a href="{{ route('account.addressedit', ['id' => $customerAddress->address_id]) }}"
                                       class="px-4 py-2 border rounded text-sm text-primary-50 bg-blumine-400 hover:bg-blumine-500 transition">
                                        Editar Endereço
                                    </a>
                                </div>

                            </div>

                        @endforeach

                    </div>

                @else
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="dy-card-title m-0">
                            Meus Endereços
                        </h3>
                    </div>
                    <div class="p-6 border rounded bg-gray-50 text-center text-gray-600">
                        Você ainda não possui nenhum endereço cadastrado

                        <div class="mt-4 flex justify-center">
                            <a href="{{ route('account.addressCreate') }}"
                               class="px-4 py-2 border rounded text-sm text-primary-50 bg-blumine-400 hover:bg-blumine-500 transition">
                               Cadastrar Novo Endereço
                            </a>
                        </div>
                    </div>

                @endif

            </div>
        </div>

    </div>
</x-frontend.app-layout>
