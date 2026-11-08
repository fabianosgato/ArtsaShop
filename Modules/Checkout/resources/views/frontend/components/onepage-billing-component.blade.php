@if($customer == null)
    {{-- ================= (BILLING) ENDEREÇO DE COBRANÇA QUANDO CLIENTE CADASTRA ================= --}}
    <div id="billing-form" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @include('checkout::frontend.components.billing.customer-address-billing')
    </div>

    {{-- ================= (SHIPPING) ENDEREÇO DE ENTREGA QUANDO CLIENTE CADASTRA ================= --}}
    <div id="shipping-address" class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10 {{ empty(old('billing.use_different_shipping')) ? 'hidden' : '' }}">
        @include('checkout::frontend.components.shipping.customer-address-shipping')
    </div>

@else
    {{-- ================= BILLING DO CLIENTE CADASTRADO ================= --}}
    @include('checkout::frontend.components.customer.customer-registered-address')
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {

        function getFields(scope) {
            return {
                street: document.querySelector(`.street[data-scope="${scope}"]`),
                neighborhood: document.querySelector(`.neighborhood[data-scope="${scope}"]`),
                city: document.querySelector(`.city[data-scope="${scope}"]`),
                region: document.querySelector(`.region[data-scope="${scope}"]`),
                number: document.querySelector(`.number[data-scope="${scope}"]`)
            };
        }

        function clear(fields) {
            if (!fields) return;
            fields.street && (fields.street.value = '');
            fields.neighborhood && (fields.neighborhood.value = '');
            fields.city && (fields.city.value = '');
            fields.region && (fields.region.value = '');
        }

        function loading(fields, state) {
            if (!fields) return;

            if (fields.region) fields.region.disabled = state;

            if (state) {
                fields.street && (fields.street.value = '...');
                fields.neighborhood && (fields.neighborhood.value = '...');
                fields.city && (fields.city.value = '...');
            }
        }

        // ===== CEP =====
        document.addEventListener('blur', function (event) {

            if (!event.target.classList.contains('postcode')) return;

            const input = event.target;
            const scope = input.dataset.scope;
            const fields = getFields(scope);
            const cep = input.value.replace(/\D/g, '');

            const addressContainer = document.getElementById(`${scope}-address-fields`);

            // CEP inválido
            if (!/^[0-9]{8}$/.test(cep)) {
                clear(fields);
                addressContainer && addressContainer.classList.add('hidden');
                return;
            }

            // Mostra campos
            addressContainer && addressContainer.classList.remove('hidden');

            loading(fields, true);

            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => response.json())
                .then(data => {

                    if (data.erro) {
                        clear(fields);
                        return;
                    }

                    if (fields.street) fields.street.value = data.logradouro || '';
                    if (fields.neighborhood) fields.neighborhood.value = data.bairro || '';
                    if (fields.city) fields.city.value = data.localidade || '';
                    if (fields.region) fields.region.value = data.uf || '';

                    // FOCO NO NÚMERO
                    setTimeout(() => {
                        const numberField = document.querySelector(`.number[data-scope="${scope}"]`);
                        if (numberField) {
                            numberField.focus();
                        }
                    }, 300);

                })
                .catch(() => {
                    clear(fields);
                })
                .finally(() => {
                    loading(fields, false);
                });

        }, true);

        // ===== TOGGLE SHIPPING =====
        const useDifferentShipping = document.getElementById('use_different_shipping');
        const shippingAddress = document.getElementById('shipping-address');

        if (useDifferentShipping && shippingAddress) {
            useDifferentShipping.addEventListener('change', function () {
                shippingAddress.classList.toggle('hidden', !this.checked);
            });
        }

        document.addEventListener('change', function (event) {

            if (event.target.name !== 'address_option') return;

            const billingForm = document.getElementById('billing-form');

            if (!billingForm) return;

            if (event.target.value === 'new') {
                billingForm.classList.remove('hidden');
            } else {
                billingForm.classList.add('hidden');
            }

        });

        // Identifica se os campos estão preechidos
        const container = document.getElementById('billing-address-fields');
        if (!container) return;
        const fields = [
            'billing[postcode]',
            'billing[street]',
            'billing[number]',
            'billing[city]',
            'billing[region]'
        ];

        const hasData = fields.some(name => {
            const el = document.querySelector(`[name="${name}"]`);
            console.log(el)
            return el && el.value && el.value.trim() !== '';
        });

        console.log(hasData)

        if (hasData) {
            container.classList.remove('hidden');
        }

    });
</script>
