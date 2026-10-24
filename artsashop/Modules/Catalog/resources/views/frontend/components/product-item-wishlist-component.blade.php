<li class="col-sm-6 col-md-3 col-sms-6 col-smb-12 item" id="product-item-{{ $product['product_id'] }}">
    <div class="item-inner">
        <a href="{{ url($product['slug_key']) }}" title="{{$product['name']}}" class="product-image"><img src="{{$product['image']}}" alt="{{$product['name']}}"></a>

        <div class="free-shipp">Frete Grátis</div>

        <x-catalog::product-category-component attributeSetId="{{ $product['attribute_set_id'] }}" />
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

        <x-catalog::product-prices-component productId="{{$product['product_id']}}" />

    </div>
</li>
