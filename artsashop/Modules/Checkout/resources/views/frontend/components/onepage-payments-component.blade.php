<div class="dy-card bg-base-100 border border-gray-200 shadow-sm lg:p-4 mb-3.5">
    <div class="dy-card-body p-2">
        <h3 class="dy-card-title">Pagamentos</h3>
        <fieldset class="space-y-4">
            <legend class="sr-only">Método de Pagamento</legend>

            @foreach($methods as $method)
                <div class="group">
                    <!-- Card do Método -->
                    <label
                        for="method_{{ $method->code() }}"
                        class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none transition-all hover:border-indigo-200 has-[:checked]:border-indigo-600 has-[:checked]:ring-2 has-[:checked]:ring-indigo-600 has-[:checked]:bg-indigo-50"
                    >
                        <input
                            id="method_{{ $method->code() }}"
                            name="paymentMethod"
                            type="radio"
                            value="{{ $method->code() }}"
                            class="payment-method-radio h-4 w-4 mt-0.5 border-gray-300 text-indigo-600 focus:ring-indigo-600"
                            @checked(($quote['payment_method'] ?? null) === $method->code())
                            x-model="selectedPayment"
                        >
                        <div class="ml-3 flex flex-col">
                            <span class="block text-sm font-semibold text-gray-900">
                                {{ $method->label() }}
                            </span>

                        </div>

                        <!-- Ícone de Check visual (opcional) -->
                        <div class="ml-auto hidden has-[:checked]:block text-indigo-600">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </label>

                    <!-- Conteúdo dinâmico (Formulário do Cartão, QR Code Pix, etc) -->
                    <div
                        class="payment-callout mt-3 overflow-hidden bg-gray-50 p-4 border-l-4 border-indigo-400"
                        data-method="{{ $method->code() }}"
                        style="{{ ($quote['payment_method'] ?? null) === $method->code() ? '' : 'display:none;' }}"
                    >
                        @include($method->view(), $method->viewData([
                            'quote' => $quote,
                            'customer' => auth()->user(),
                        ]))
                    </div>
                </div>
            @endforeach
        </fieldset>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const csrfToken = '{{ csrf_token() }}';
        const discountUrl = '{{ route("checkout.onepage.ajax-discount") }}';

        function formatCurrency(value) {
            return 'R$ ' + value.toFixed(2).replace('.', ',');
        }

        function toggleCallouts(paymentMethod) {
            document.querySelectorAll('.payment-callout').forEach(el => {
                el.style.display = 'none';
            });

            const activeCallout = document.querySelector(
                `.payment-callout[data-method="${paymentMethod}"]`
            );

            if (activeCallout) {
                activeCallout.style.display = '';
            }
        }

        function updateDiscountUI(response) {

            const discountRow = document.getElementById('discount-row');
            const discountLabel = document.getElementById('order-discount-label');
            const discountAmount = document.getElementById('order-discount');
            const grandTotal = document.getElementById('order-grand-total');

            if (!response.success) return;

            if (response.discount.amount > 0) {
                discountLabel.textContent = response.discount.label;
                discountAmount.textContent = '- ' + formatCurrency(response.discount.amount);
                discountRow.classList.remove('hidden');
            } else {
                discountRow.classList.add('hidden');
            }

            grandTotal.textContent = formatCurrency(response.grand_total);
        }

        document.addEventListener('change', function (event) {

            if (!event.target.classList.contains('payment-method-radio')) return;

            const paymentMethod = event.target.value;

            // sincroniza com Alpine
            const checkoutEl = document.querySelector('[x-data="checkout()"]');

            if (checkoutEl && window.Alpine) {
                Alpine.$data(checkoutEl).paymentMethod = paymentMethod;
            }

            toggleCallouts(paymentMethod);

            const discountAmount = document.getElementById('order-discount');
            const grandTotal = document.getElementById('order-grand-total');

            if (discountAmount) discountAmount.textContent = 'Calculando...';
            if (grandTotal) grandTotal.textContent = '...';

            fetch(discountUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    payment_method: paymentMethod
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro na requisição');
                    }
                    return response.json();
                })
                .then(data => updateDiscountUI(data))
                .catch(error => {
                    console.error('Erro ao calcular desconto:', error);
                });

        });

    });
</script>
