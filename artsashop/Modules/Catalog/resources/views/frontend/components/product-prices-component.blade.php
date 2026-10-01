<div class="price-box">
    @if(isset($productPrices['price_discount']))
    <p class="old-price">
        <span class="price" id="old-price-{{$productPrices['price_id']}}"><span class="currencySymbol">R$</span>{{ number_format($productPrices['price'], 2, ',', '.') }}</span>
    </p>
    <p class="special-price">
        <span class="price"><span class="currencySymbol">R$</span>{{ number_format($productPrices['price_discount'], 2, ',', '.') }} <span class="discount">no PIX</span></span>
    </p>
    @elseif($productPrices['final_price'] >= $productPrices['price'])
        <span class="regular-price" id="product-price-{{$productPrices['price_id']}}">
            <span class="price"><span class="currencySymbol">R$</span>{{ number_format($productPrices['price'], 2, ',', '.') }}</span>
        </span>
    @else
        <p class="old-price">
            <span class="price" id="old-price-{{$productPrices['price_id']}}"><span class="currencySymbol">R$</span>{{ number_format($productPrices['final_price'], 2, ',', '.') }}</span>
        </p>
        <p class="special-price">
            <span class="price"><span class="currencySymbol">R$</span>{{ number_format($productPrices['final_price'], 2, ',', '.') }}</span>
        </p>
    @endif
</div>
