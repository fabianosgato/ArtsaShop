@if(count($orderItens) > 0)
    <div class="space-y-4">
        @foreach($orderItens as $orderItem)
            <div class="flex items-center gap-4 border-b pb-4">

                {{-- IMAGEM --}}
                <div class="w-20 h-20 flex-shrink-0">
                    <img src="{{ $orderItem->image }}"
                         alt="{{ $orderItem->product_name }}"
                         class="w-full h-full object-cover rounded">
                </div>

                {{-- NOME --}}
                <div class="flex-1 text-sm font-medium text-gray-800">
                    <span>{{ $orderItem->product_name }}</span>
                    <span>
                        <a href="{{ url($orderItem->slug_key) }}">
                            {{ $orderItem->product_sku }}
                        </a>
                    </span>

                    {{-- BOTÃO RECOMPRA --}}
                    <div class="mt-2">
                        <button
                            type="button"
                            class="btn-rebuy-item inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded bg-celadon-600 text-white hover:bg-celadon-700 transition"
                            data-product-id="{{ $orderItem->product_id }}"
                            data-qty="{{ intval($orderItem->qty_ordered) }}"
                        >
                            Comprar novamente
                        </button>
                    </div>

                </div>

                {{-- QUANTIDADE E PREÇO --}}
                <div class="text-sm text-right font-semibold text-gray-700">
                    {{ intval($orderItem->qty_ordered) }}x
                    <span class="block md:inline">R$ {{ number_format($orderItem->sales_price, 2, ',', '.') }}</span>
                </div>

            </div>
        @endforeach
    </div>
@endif
