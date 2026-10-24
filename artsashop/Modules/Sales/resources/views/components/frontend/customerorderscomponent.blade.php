@if(count($orders) > 0)

    <div class="space-y-6">

        @foreach($orders as $order)
            <div class="border rounded-lg shadow-sm bg-white p-4">

                {{-- HEADER --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-4">

                    <h5 class="text-lg font-semibold text-celadon-700">
                        Pedido #{{ $order->increment_code }}
                        <span class="text-sm text-gray-500 font-normal">
                            ({{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }})
                        </span>
                    </h5>

                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                        {{ $order->status_label }}
                    </span>

                </div>

                {{-- ITENS --}}
                <div class="space-y-3 mb-4">
                    <x-sales::frontend.customer-order-itens-component orderId="{{ $order->order_id }}" />
                </div>

                {{-- FOOTER --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pt-4 border-t">

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('sales.order.index', ['id' => $order->order_id]) }}"
                           class="px-4 py-2 border rounded text-sm hover:bg-gray-50 transition">
                            Ver Detalhes
                        </a>

                    </div>

                    <div class="text-right">
                        <div class="text-sm text-gray-500">
                            Total do pedido:
                        </div>
                        <div class="text-xl font-semibold text-celadon-700">
                            R$ {{ number_format($order->payment_amount, 2, ',', '.') }}
                        </div>
                    </div>

                </div>

            </div>

        @endforeach

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

@else

    <div class="p-6 border rounded bg-gray-50 text-center text-gray-600">
        Você não possui nenhum pedido
    </div>

@endif
