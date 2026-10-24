<div class="row">
    <div class="col-12 table-responsive">
        <h3 class="py-6 text-lg text-blumine-600">PEDIDO # {{$order['increment_id']}}</h3>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title text-base">Informações do Pedido</h5>
            </div>
            <div class="card-body">
                <dl class="divide-y divide-gray-100">
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Canal</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$order['canal']}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">ID DO CANAL:</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$order['canal_remote_id']}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Status:</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$order['status_label']}}</dd>
                    </div>
                </dl>
            </div>
        </div>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title">Informações de Cobrança do Cliente</h5>
            </div>
            <div class="card-body">
                <dl class="divide-y divide-gray-100">
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Nome Cliente:</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$order['customer_name']}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Email:</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$order['customer_email']}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Telefone:</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$billing['customer_phone']}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Rua:</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$billing['street']}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Numero:</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$billing['number']}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Complemento:</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$billing['complement']}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Bairro:</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$billing['neighborhood']}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Cidade
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$billing['city']}}</dd>
                    </div>
                </dl>
            </div>
        </div>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title">Endereço de entrega</h5>
            </div>
            <div class="card-body">
                <div class="row invoice-info">
                    <div class="col-sm-6 invoice-col">
                        <address class="text-blumine-700">
                            {{$shipping['street']}}, {{$shipping['number']}}<br>
                            Complemento: {{$shipping['complement']}}<br>
                            Bairro: {{$shipping['neighborhood']}}<br>
                            Cidade: {{$shipping['city']}}
                        </address>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title">Itens</h5>
            </div>
            <div class="card-body overflow-x-auto">
                <table class="dy-table dy-table-xs">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Sku</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td class="text-blumine-700">{{$product['product_name']}}</td>
                        <td class="text-blumine-700">{{$product['product_sku']}}</td>
                        <td class="text-blumine-700">{{$product['qty_ordered']}}</td>
                    </tr>
                @empty
                    <tr>
                        <td style="text-align:center" colspan="3">Nao existem Produtos para este pedido</td>
                    </tr>
                @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
