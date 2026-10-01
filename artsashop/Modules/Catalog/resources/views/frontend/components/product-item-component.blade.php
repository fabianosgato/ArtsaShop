<div class="item">
    <div class="item-inner">
        <a href="{{ url($product['slug_key']) }}" title="{{$product['name']}}" class="product-image">
            <img src="{{ $product['image'] }}" alt="{{$product['name']}}" width="255" height="255">
        </a>

        <div class="free-shipp">
            <div class="discount-badge">-10% de desconto no PIX</div>
            Frete Grátis
        </div>

        <x-catalog::product-category-component :product="$product" />
        <h2 class="product-name"><a href="{{ url($product['slug_key']) }}" title="{{$product['name']}}">{{$product['name']}}</a></h2>
        @if($product['status_key'] == 'in-stock')
            <div class="actions">
                <ul class="add-to-links">
                    <li class="add-to-cart"><button type="button" class="button btn-cart-page" data-original-title="Adicionar ao carrinho" rel="tooltip" data-product-id="{{ $product['product_id'] }}"><span><span>Adicionar ao carrinho</span></span></button></li>
                    <li class="add-to-favorites">
                        <x-catalog::product-wishlist-component productId="{{$product['product_id']}}" />
                    </li>
                </ul>
            </div>
        @else
            <div class="availability out-of-stock">
                <span>Sem estoque</span>
            </div>
        @endif

        <div class="brand-name"><a href="{{ url($product['brand_key']) }}">{{ $product['brand_name'] }}</a></div>
        <x-catalog::product-prices-component :product="$product" />

    </div>
</div>
