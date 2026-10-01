@props([
    'title',
    'products',
    'link' => null,
    'carousel' => false
])

<section class="product-block">
    <div class="page-title title-buttons category">
        <h2>{{ $title }}</h2>
        @if($link)
            <a href="{{ $link }}" class="product-block__more">
                Ver todos
            </a>
        @endif
    </div>

    <div class="category-products">

        @if($carousel)
            <div class="product-swiper swiper">
                <div class="products-grid swiper-wrapper">
                    @foreach($products as $product)
                        <div class="swiper-slide">
                            <x-catalog::frontend.product-item-component :catalogProduct="$product" />
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="products-grid grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                @foreach($products as $product)
                    <x-catalog::frontend.product-item-component :catalogProduct="$product" />
                @endforeach
            </div>
        @endif

    </div>
</section>
