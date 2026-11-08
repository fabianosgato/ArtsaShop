<div class="row">
    <div class="col-12 table-responsive">
        @include('catalog::wsdadm/products/partials/product-info')

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title text-base">Preços</h5>
            </div>
            <div class="card-body">
                <dl class="divide-y divide-gray-100">
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Preço</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ formatPrice($catalogProduct['final_price']) }}</dd>
                    </div>
                </dl>
                <dl class="divide-y divide-gray-100">
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Preço Final</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{ formatPrice($catalogProduct['final_price']) }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
