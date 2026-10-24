<div class="dy-card bg-base-100 border border-gray-200 shadow-sm mb-3.5">
    <div class="dy-card-body p-2 m-1">
        <h3 class="dy-card-title">Itens do pedido</h3>
        @foreach($cart['items'] as $item)
            <div class="flex gap-4 max-sm:flex-col">
                <div class="w-24 h-24 shrink-0 bg-white p-2">
                    <a href="{{ url($item['product']['slug_key']) }}" title="{{$item['product']['name']}}">
                        <img src="{{$item['product']['thumbnail']}}" alt="{{$item['product']['name']}}"
                             class="w-full h-full object-contain"/>
                    </a>
                </div>
                <div class="w-full flex justify-between gap-4">
                    <div>
                        <h3 class="text-[15px] font-medium text-slate-900">{{$item['product']['name']}}</h3>
                        <h6 class="text-[15px] text-slate-900 font-semibold cursor-pointer mt-4">
                            R$ {{ Number::format($item['subtotal'], 2, locale: 'pt_BR') }}</h6>
                        <span class="text-[15px]">Qtd: {{$item['qty']}} Unidade(s)</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="dy-card bg-base-100 border border-gray-200 shadow-sm">
    <div class="dy-card-body p-2 m-1">
        <h3 class="dy-card-title">Revisar os dados do pedido</h3>

        <ul class="text-slate-500 font-medium mt-6 space-y-4">

            <li class="flex flex-wrap gap-4 text-sm">
                Subtotal
                <span class="ml-auto font-semibold text-slate-900">
                    <span class="price">
                        R$ {{ Number::format($cart['subtotal'], 2, locale: 'pt_BR') }}
                    </span>
                </span>
            </li>

            <li class="flex flex-wrap gap-4 text-sm">
                Envio e manuseio <br/>
                (Courier Brazil Border - Frete Grátis - 20 dias úteis)
                <span class="ml-auto font-semibold text-slate-900">Grátis</span>
            </li>

            <li class="flex flex-wrap gap-4 text-sm">
                Taxas de Importação
                <span class="ml-auto font-semibold text-slate-900">Grátis</span>
            </li>

            {{-- DESCONTO --}}
            @if(count($quote['discount_data']))
                <li id="discount-row" class="flex flex-wrap gap-4 text-sm">

                    <span id="order-discount-label">
                        {{ $quote['discount_data']['label'] ?? 'Desconto' }}
                    </span>

                    <span id="order-discount" class="ml-auto font-semibold text-slate-900">
                       - R$ {{ Number::format($quote['discount_amount'] ?? 0, 2, locale: 'pt_BR') }}
                    </span>

                </li>
            @else
                <li id="discount-row" class="flex flex-wrap gap-4 text-sm hidden">
                    <span id="order-discount-label">
                        {{ $quote['discount_label'] ?? 'Desconto' }}
                    </span>
                    <span id="order-discount" class="ml-auto font-semibold text-slate-900">
                        -
                    </span>
                </li>
            @endif

            <hr class="border-gray-300">

            {{-- TOTAL --}}
            <li class="flex flex-wrap gap-4 text-2xl text-celadon-700">
                Total
                <span id="order-grand-total"
                      class="ml-auto font-semibold">
            R$ {{ Number::format($quote['grand_total'] ?? 0, 2, locale: 'pt_BR') }}
        </span>
            </li>

        </ul>

    </div>
</div>
