<section>
    <div class="bg-white p-6 rounded-lg shadow-lg text-primary-500">
        <h2 class="text-xl font-semibold mb-4 text-blumine-700">Informações do Pedido : {{ $order['increment_code'] }}</h2>
        <div class="mb-4">
            <span class="font-bold">Status:</span> {{ $order['status_label'] }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Data do Pedido:</span> {{ \Carbon\Carbon::parse($order['created_at'] )->format('d/m/Y H:i') }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Data de Atualização:</span> {{ \Carbon\Carbon::parse($order['updated_at'] )->format('d/m/Y H:i') }}
        </div>
    </div>
</section>
