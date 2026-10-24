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

        @if($order['payment_method'] = 'pix')
            @if(!empty($payment['additional_information']['pix']))
                <div class="mb-4">
                    <span class="font-bold">Link para Pagamento:</span>
                    <span class="float-right">{{ strip_tags($payment['additional_information']['pix']['link']) }}</span>
                </div>
            @endif
        @endif

        <div class="mb-4">
            <span class="text-2xl text-emerald-500">Total de Frete:</span>
            <span class="text-2xl text-emerald-500 float-right">{{ (new \NumberFormatter('pt_BR', \NumberFormatter::CURRENCY))->formatCurrency(floatval($order['base_shipping_amount']), 'BRL') }}</span>
        </div>
        <div class="mb-4">
            <span class="text-2xl text-emerald-500">Total Pago:</span>
            <span class="text-2xl text-emerald-500 float-right">{{ (new \NumberFormatter('pt_BR', \NumberFormatter::CURRENCY))->formatCurrency(floatval($order['base_grand_total']), 'BRL') }}</span>
        </div>

    </div>

</section>
