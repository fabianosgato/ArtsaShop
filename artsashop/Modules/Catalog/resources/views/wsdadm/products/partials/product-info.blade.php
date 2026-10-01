<div class="callout callout-info">
    <h5 class="text-blumine-600"><i class="fas fa-info"></i> Produto:</h5>
    <span class="text-primary-500 text-xs">{{$catalogProduct['name']}}</span>
</div>
<div class="callout callout-info">
    <h5 class="text-blumine-600"><i class="fas fa-info"></i> Grupo de Atributos:</h5>
    <p class="text-primary-500 text-xs">{{ $catalogProduct['attribute_set_name']}}</p>
</div>
<div class="card card-primary card-outline">
    <div class="card-header">
        <h5 class="card-title text-base">Informações do Produto</h5>
        <a target="_blank" style="float: right" class="btn btn-forms btn-accent btn-sm" href="{{ route('wsdadm.catalog.products.edit', $catalogProduct['product_id']) }}">Editar</a>
    </div>
    <div class="card-body">
        <dl class="divide-y divide-gray-100">
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">SKU</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><strong>{{ $catalogProduct['sku']}}</strong></dd>
            </div>
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">EAN</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><strong>{{ $catalogProduct['ean']}}</strong></dd>
            </div>
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Marca</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $catalogProduct['brand_name']}}</dd>
            </div>
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Peso do item</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $catalogProduct['weight']}}</dd>
            </div>
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Quantidade</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $catalogProduct['qty']}}</dd>
            </div>
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Status</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $catalogProduct['status']}}</dd>
            </div>
            <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Página do Produto:</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><a href="{{ url($catalogProduct['slug_key']) }}" target="_blank" class="card-link">Clique Aqui</a></dd>
            </div>
        </dl>
    </div>
</div>
