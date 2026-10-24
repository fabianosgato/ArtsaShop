<x-frontend.app-layout layout="2columns-left">
        <div class="page-title title-buttons">
            <h1>Você buscou por: <strong>{{ $term }}</strong></h1>
        </div>

        <div class="category-products">
            <h2 class="brand-product-titles">Você buscou o termo {{ $term }} com {{$products->total()}} resultados encontrados</h2>

            <div class="products-grid grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products->items() as $product)
                    <x-catalog::frontend.product-item-component :catalogProduct="$product" />
                @endforeach
            </div>
            <div class="toolbar-bottom">
                <div class="toolbar">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-frontend.app-layout>
