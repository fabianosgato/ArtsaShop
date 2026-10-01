<div class="tab-custom-content">
    <blockquote>
        <h5>Dados Warerouse</h5>
        <ul class="list-unstyled">
            <li><small>Título: <cite title="Source Title">{{ $catalogProduct['title'] }}</cite></small></li>
            <li><small>ASIN: <cite title="Source Title">{{ $catalogProduct['asin'] }}</cite></small></li>
            <li><small>Status: <cite title="Source Title">{{ $catalogProduct['availability_status'] }}</cite></small></li>
            <li><small>URL: <cite title="Source Title"><a href="{{ $catalogProduct['product_url'] }}" target="_blank">{{ $catalogProduct['product_url'] }}</a></cite></small></li>
        </ul>
    </blockquote>
</div>
