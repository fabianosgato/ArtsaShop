<section>
    <div class="bg-white p-6 rounded-lg shadow-lg text-primary-500">
        <h2 class="text-xl font-semibold mb-4 text-blumine-700">ID do Pedido : {{ $order['order_id'] }}</h2>
        <div class="mb-4">
            <span class="text-2xl text-amber-600 font-bold">Marketplace:</span>
            <span class="text-2xl text-amber-600 font-bold">{{ $order['titulo_marketplaces'] }}</span>
        </div>
        <div class="mb-4">
            <span class="text-2xl text-amber-600 font-bold">Canal:</span>
            <span class="text-2xl text-amber-600 font-bold">{{ $order['canal'] }}</span>
        </div>
        <div class="mb-4">
            <span class="text-2xl text-amber-600 font-bold">ID DO CANAL:</span>
            <span class="text-2xl text-amber-600 font-bold">{{ $order['canal_remote_id'] }}</span>
        </div>
        <div class="mb-4">
            <span class="font-bold">Status:</span> {{ $order['label'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Data do Pedido:</span> {{ \Carbon\Carbon::parse($order['created'] )->format('d/m/Y H:i') }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Data de Atualização:</span> {{ \Carbon\Carbon::parse($order['updated'] )->format('d/m/Y H:i') }}
        </div>
    </div>
</section>
