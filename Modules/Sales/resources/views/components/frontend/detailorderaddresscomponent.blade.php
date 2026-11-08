<address>
    <strong>{{ $address['customer_name'] }}</strong><br>
    {{ $address['customer_phone'] }}<br>
    {{ $address['postcode'] }}<br>
    {{ $address['street'] }} - {{ $address['number'] }}<br>

    @if(!empty($address['complement']))
        {{ $address['complement'] }}<br>
    @endif

    @if(!empty($address['detail']))
        {{ $address['detail'] }}<br>
    @endif

    @if(!empty($address['reference']))
        {{ $address['reference'] }}<br>
    @endif

    {{ $address['neighborhood'] }}, {{ $address['city'] }}<br>
    Celular: {{ $address['customer_phone'] }}<br>

</address>
