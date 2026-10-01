<x-frontend.app-layout layout="1column">
    <div class="page-title title-buttons">
        <h1>Nossos produtos</h1>
    </div>

    <div class="category-products">

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
</x-frontend.app-layout>
