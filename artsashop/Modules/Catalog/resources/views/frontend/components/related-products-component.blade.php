<div class="block-related">
    <div class="block-title">
        <h2>Produtos Relacionados</h2>
    </div>
    <div class="category-products">
        <ul class="products-grid grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <x-catalog::frontend.product-item-component :catalogProduct="$product" />
            @endforeach
        </ul>
    </div>
</div>
