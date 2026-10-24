<div class="row">
    <div class="col-12 table-responsive">
        <h3 class="text-base text-blumine-600">Dados do Preço</h3>
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title text-base">Preços para o <strong>{{$reportPrices['titulo_marketplaces']}}</strong></h5>
            </div>
            <div class="card-body">
                <dl class="divide-y divide-gray-100">
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">FOB</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">$ {{number_format($reportPrices['fob'], 2, '.', '')}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Peso</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{number_format($reportPrices['weight'], 2, '.', '')}} Kg</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">air_cost</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">$ {{number_format($reportPrices['air_cost'], 2, '.', '')}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">air_freight</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">$ {{number_format($reportPrices['air_freight'], 2, '.', '')}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">invoice_freight</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">$ {{number_format($reportPrices['invoice_freight'], 2, '.', '')}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">perc_freight_fob</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{number_format($reportPrices['perc_freight_fob'], 2, '.', '')}} %</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">perc_freight_air</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{number_format($reportPrices['perc_freight_air'], 2, '.', '')}} %</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">perc_frt_fob</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{number_format($reportPrices['perc_frt_fob'], 2, '.', '')}} %</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Total da Invoice</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">$ {{number_format($reportPrices['invoice_total'], 2, '.', '')}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Frete Correios</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">$ {{number_format($reportPrices['correios_freight'], 2, '.', '')}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Taxa de Importação</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">$ {{number_format($reportPrices['tax_import'], 2, '.', '')}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Taxa de ICMS</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">$ {{number_format($reportPrices['tax_icms'], 2, '.', '')}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">TOTAL</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">$ {{number_format($reportPrices['total_product_price'], 2, '.', '')}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Valor de Venda em Dolar</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">$ {{number_format($reportPrices['price_dolar'], 2, '.', '')}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Multiplicador do Marketplace</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{number_format($reportPrices['marketplace_multiplier'], 2, '.', '')}} %</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Comissao Marketplace</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{number_format($reportPrices['marketplace_commision'], 2, '.', '')}} %</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Comissao BrazilBorder</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{number_format($reportPrices['brazilborder_commision'], 2, '.', '')}} %</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Valor do Incremento ou Desconto</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">$ {{number_format($reportPrices['price_increment'], 2, '.', '')}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Tipo de Incremento ou Desconto</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$reportPrices['price_increment_type']}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Valor do Dolar</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">R$ {{number_format($reportPrices['dolar_tax'], 2, '.', '')}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Preço</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">R$ {{number_format($reportPrices['price'], 2, '.', '')}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Preço Venda</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">R$ {{number_format($reportPrices['final_price'], 2, '.', '')}}</dd>
                    </div>
                    <div class="px-4 py-1 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Index da Venda</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{number_format($reportPrices['sales_index'], 2, '.', '')}} %</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
