<section>
    <div class="bg-white p-6 rounded-lg shadow-lg text-primary-500">
        <h2 class="text-xl font-semibold mb-4 text-blumine-700">Endereço de Entrega</h2>
        <div class="mb-4">
            <span class="font-bold">Nome:</span> {{ $shipping['customer_name'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Telefone:</span> {{ $shipping['customer_phone'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Celular:</span> {{ $shipping['customer_phone'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">CEP:</span> {{$shipping['postcode']}}
        </div>
        <div class="mb-4">
            <span class="font-bold">Endereço:</span> {{ $shipping['street'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Número:</span> {{ $shipping['number'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Complemento:</span> {{ $shipping['complement'] }}
        </div>

        <div class="mb-4">
            <span class="font-bold">Bairro:</span> {{ $shipping['neighborhood'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Cidade:</span> {{ $shipping['city'] }}/{{ $shipping['region'] }}
        </div>
    </div>

</section>
