<section>
    <div class="bg-white p-6 rounded-lg shadow-lg text-primary-500">
        <h2 class="text-xl font-semibold mb-4 text-blumine-700">Pagamento e Totais</h2>
        <div class="mb-4">
            <span class="font-bold">Metodo de Pagamento:</span>
            <span class="float-right">{{ $order['payment_method'] }}</span>
        </div>
        <div class="mb-4">
            <span class="font-bold">Descrição:</span>
            <span class="float-right">{{ strip_tags($order['payment_description']) }}</span>
        </div>
        <div class="mb-4">
            <span class="text-2xl text-emerald-500">Total de Frete:</span>
            <span class="text-2xl text-emerald-500 float-right">{{ (new \NumberFormatter('pt_BR', \NumberFormatter::CURRENCY))->formatCurrency(floatval($order['shipping_cost']), 'BRL') }}</span>
        </div>
        <div class="mb-4">
            <span class="text-2xl text-emerald-500">Total Pago:</span>
            <span class="text-2xl text-emerald-500 float-right">{{ (new \NumberFormatter('pt_BR', \NumberFormatter::CURRENCY))->formatCurrency(floatval($order['order_price']), 'BRL') }}</span>
        </div>
    </div>
</section>
