<x-frontend.app-layout layout="2columns-customer">
    <div class="dashboard">
        <div class="dy-card bg-base-100 rounded-md border border-gray-200 shadow-sm mb-6">
            <div class="dy-card-body p-4">

                <h3 class="dy-card-title mb-4">
                    Dados do Pedido
                </h3>

                <div class="space-y-8">
                    {{-- HEADER --}}
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-4">

                        <h5 class="text-lg font-semibold text-celadon-700">
                            Pedido #{{ $order->increment_code }}
                            <span class="text-sm text-gray-500 font-normal">
                                ({{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }})
                            </span>
                            <p class="text-sm text-gray-500">
                                Data do Pedido:
                                {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}
                            </p>
                        </h5>

                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                            {{ $order->status_label }}
                        </span>

                    </div>

                    {{-- ENDEREÇOS + INFO --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <h4 class="font-semibold mb-2">
                                Endereço de Cobrança
                            </h4>
                            <div class="text-sm text-gray-700 leading-relaxed">
                                <x-sales::frontend.detail-order-address-component
                                    orderId="{{ $order->order_id }}"
                                    addressType="billing"/>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-2">
                                Endereço de Entrega
                            </h4>
                            <div class="text-sm text-gray-700 leading-relaxed">
                                <x-sales::frontend.detail-order-address-component
                                    orderId="{{ $order->order_id }}"
                                    addressType="shipping"/>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold mb-2">
                                Informações Gerais
                            </h4>
                            <div class="text-sm text-gray-700 space-y-1">
                                <div>
                                    <strong>ID do Pedido:</strong>
                                    {{ $order->increment_code }}
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- ITENS --}}
                    <div>
                        <h4 class="font-semibold mb-4">
                            Itens do seu pedido
                        </h4>

                        <div class="space-y-4">
                            <x-sales::frontend.customer-order-itens-component
                                orderId="{{ $order->order_id }}"/>
                        </div>
                    </div>

                    @if($tracking)

                        <div>
                            <h4 class="font-semibold mb-4">
                                Detalhes do envio
                            </h4>

                            <div class="space-y-4">
                                <div class="flex-1 text-sm font-medium text-gray-800">
                                    Transportadora: {{$tracking->carrier}}
                                </div>
                                <div class="flex-1 text-sm font-medium text-gray-800">
                                    Código de Rastreio: {{$tracking->tracking_code}}
                                </div>

                                <div class="flex-1 text-sm font-medium text-gray-800">
                                    <a href="{{$tracking->url}}"
                                       target="_blank"
                                       class="px-4 py-2 bg-celadon-700 text-white text-sm rounded hover:opacity-90 transition">
                                        Rastrear
                                    </a>
                                </div>
                            </div>
                        </div>

                    @endif

                    {{-- PAGAMENTO + TOTAIS --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t pt-6">

                        <div>
                            <h4 class="font-semibold mb-2">
                                Método de Pagamento
                            </h4>
                            <div class="text-sm text-gray-700">
                                {{ $order->payment_description }}
                            </div>

                            @if(($order->status == 'pending_payment') && ($order->payment_method == 'pix'))
                                <div class="text-sm text-gray-700">
                                    <a href="{{ route('payments.pay', ['orderId' => $order->order_id]) }}">Realizar Pagamento</a>
                                </div>
                            @endif

                        </div>

                        <div class="md:text-right">
                            <div class="space-y-2 text-sm text-gray-700">
                                <div class="flex justify-between md:justify-end md:gap-10">
                                    <span>Subtotal:</span>
                                    <span>R$ {{ number_format($order->base_subtotal, 2, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between md:justify-end md:gap-10">
                                    <span>Frete:</span>
                                    <span>R$ {{ number_format($order->base_shipping_amount, 2, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between md:justify-end md:gap-10">
                                    <span>Desconto:</span>
                                    <span>R$ {{ number_format($order->base_discount_amount, 2, ',', '.') }}</span>
                                </div>
                                <div
                                    class="flex justify-between md:justify-end md:gap-10 text-lg font-semibold text-celadon-700 pt-2 border-t">
                                    <span>Total:</span>
                                    <span>
                                        R$ {{ number_format($order->payment_amount, 2, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
        <script>
            document.addEventListener('click', async function (event) {

                const button = event.target.closest('.btn-rebuy-item');
                if (!button) return;

                event.preventDefault();

                const productId = button.dataset.productId;
                const qty = parseInt(button.dataset.qty || 1);

                const csrf = document.querySelector('meta[name="csrf-token"]').content;

                // Estado loading
                const originalText = button.innerHTML;

                button.disabled = true;
                button.innerHTML = 'Adicionando...';

                try {

                    const response = await fetch('/checkout/cart/add-to-cart-ajax', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            qty: qty
                        })
                    });

                    const data = await response.json();

                    if (data.success) {

                        button.innerHTML = '✓ Adicionado';

                        // Pequeno delay para feedback visual
                        setTimeout(() => {
                            window.location.href = '/checkout/cart';
                        }, 500);

                    } else {

                        button.innerHTML = 'Erro';

                    }

                } catch (error) {

                    console.error('Erro ao recomprar produto', error);
                    button.innerHTML = 'Erro';

                } finally {

                    setTimeout(() => {
                        button.disabled = false;
                        button.innerHTML = originalText;
                    }, 2000);

                }

            });
        </script>
    </div>
</x-frontend.app-layout>
