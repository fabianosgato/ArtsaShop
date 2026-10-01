<section>
    <div class="bg-white p-6 rounded-lg shadow-lg text-primary-500">
        <h2 class="text-xl font-semibold mb-4 text-blumine-700">Endereço de Cobrança</h2>
        <div class="mb-4">
            <span class="font-bold">Nome:</span> {{ $billing['customer_name'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Telefone:</span> {{ $billing['customer_phone'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Celular:</span> {{ $billing['customer_phone'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">CEP:</span> {{$billing['postcode']}}
        </div>
        <div class="mb-4">
            <span class="font-bold">Endereço:</span> {{ $billing['street'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Número:</span> {{ $billing['number'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Complemento:</span> {{ $billing['complement'] }}
        </div>

        <div class="mb-4">
            <span class="font-bold">Bairro:</span> {{ $billing['neighborhood'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Cidade:</span> {{ $billing['city'] }}/{{ $billing['region'] }}
        </div>
    </div>

</section>
