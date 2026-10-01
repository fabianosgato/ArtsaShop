<div class="callout callout-info">
    <h5 class="text-blumine-600"><i class="fas fa-info"></i> Titulo cadastrado no sistema:</h5>
    <span class="text-primary-500 text-xs">{{$catalogProduct['name']}}</span>
</div>
<div class="callout callout-info">
    <h5 class="text-blumine-600"><i class="fas fa-info"></i> Categoria/Grupo de Atributos:</h5>
    <p class="text-primary-500 text-xs">{{ $catalogProduct['attribute_set_name']}}</p>
</div>
<div class="card card-primary card-outline">
    <div class="card-header">
        <h5 class="card-title text-base">Informações do Produto</h5>
        <a target="_blank" style="float: right" class="btn btn-active btn-accent btn-sm" href="{{ route('products.edit', $catalogProduct['product_id']) }}">Editar</a>
    </div>
    <div class="card-body">
        <div class="@if ($catalogProduct['is_excluded']) alert alert-danger alert-dismissible @else alert alert-success alert-dismissible @endif ">
            @if ($catalogProduct['is_excluded']) Produto Excluido @else Produto Ativo @endif
        </div>
        <dl class="divide-y divide-gray-100">
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">ASIN</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                    <strong>{{$catalogProduct['asin']}}</strong><br />
                    <a target="_blank" class="card-link" href="{{env('PROVIDER_URL')}}html/{{ substr($catalogProduct['asin'], 0, 4) }}/{{$catalogProduct['asin']}}.html">Ver Pagina Capturada</a>
                </dd>
            </div>
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">SKU</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><strong>{{ $catalogProduct['sku']}}</strong></dd>
            </div>
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">EAN</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><strong>{{ $catalogProduct['ean']}}</strong></dd>
            </div>
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Peso do item</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $catalogProduct['weight']}}</dd>
            </div>
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Data de atualização Warehouse</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ \Carbon\Carbon::parse($catalogProduct['updated'])->format('d/m/Y H:i')}}</dd>
            </div>
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Quantidade</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $catalogProduct['qty']}}</dd>
            </div>
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Status</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $catalogProduct['status_product']}}</dd>
            </div>
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Status Warehouse</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $catalogProduct['availability_status']}}</dd>
            </div>
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Link do Produto:</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><a href="{{ $catalogProduct['product_url'] }}" target="_blank" class="card-link">Clique Aqui</a></dd>
            </div>
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">

            </div>
        </dl>
    </div>
</div>
