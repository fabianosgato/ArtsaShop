<x-frontend.app-layout layout="2columns-left">
    <div class="brand-view">
        @if($brand['is_salable'])
            <div class="page-title title-buttons">
                <h1>{{ $brand['page_title'] }}</h1>
            </div>
            <div class="content">
                {!! $brand['content'] !!}
            </div>
        @else
            <div class="page-title title-buttons">
                <h1>Produtos da {{ $brand['brand_name'] }}</h1>
            </div>
        @endif

        <div class="category-products">
            <h2 class="brand-product-titles">Veja nossos produtos {{ $brand['brand_name'] }}</h2>

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
