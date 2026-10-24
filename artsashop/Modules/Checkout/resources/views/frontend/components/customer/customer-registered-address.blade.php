@if($defaultAddress)
    <div class="dy-card bg-base-100 mb-3.5">
        <div class="dy-card-body p-2 m-1">
            <h3 class="dy-card-title">Endereço cadastrado</h3>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="radio"
                    name="address_option"
                    id="use_saved_address"
                    value="saved"
                    {{ old('address_option', 'saved') === 'saved' ? 'checked' : '' }}
                >
                <label class="form-check-label" for="use_saved_address">
                    Entregar neste endereço
                </label>
            </div>

            <div class="border rounded p-3 mt-2">
                <strong>{{ $defaultAddress->recipient_name }}</strong><br>
                {{ $defaultAddress->street }}<br>
                {{ $defaultAddress->neighborhood }} - {{ $defaultAddress->city }}/{{ $defaultAddress->region }}<br>
                CEP {{ $defaultAddress->postcode }}
                <input type="hidden" name="saved_address_id" value="{{$defaultAddress->address_id}}">
            </div>

            <div class="form-check mt-3">
                <input
                    class="form-check-input"
                    type="radio"
                    name="address_option"
                    id="new_address"
                    value="new"
                    {{ old('address_option') === 'new' ? 'checked' : '' }}
                >
                <label class="form-check-label" for="new_address">
                    Cadastrar novo endereço
                </label>
            </div>
        </div>
    </div>

    {{-- ================= BILLING ENDEREÇO ================= --}}
    <div id="billing-form"
         class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-3.5 p-2
     {{ old('address_option', 'saved') === 'new' ? '' : 'hidden' }}">
        @include('checkout::frontend.components.billing.customer-address-billing')
    </div>

    {{-- ================= SHIPPING ================= --}}
    <div id="shipping-address" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-3.5 mt-10 p-2 hidden">
        @include('checkout::frontend.components.shipping.customer-address-shipping')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const savedRadio = document.getElementById('use_saved_address');
            const newRadio = document.getElementById('new_address');
            const billingForm = document.getElementById('billing-form');

            const shippingCheckbox = document.getElementById('use_different_shipping');
            const shippingAddress = document.getElementById('shipping-address');

            function toggleBillingFields(disabled) {
                const fields = document.querySelectorAll('#billing-form input, #billing-form select');

                fields.forEach(field => {

                    if (disabled) {
                        field.setAttribute('disabled', 'disabled');
                        field.removeAttribute('required');
                    } else {
                        field.removeAttribute('disabled');

                        // só reativa required se originalmente tinha
                        if (field.dataset.required === "true") {
                            field.setAttribute('required', 'required');
                        }
                    }
                });
            }

            // ===== BILLING TOGGLE =====
            function updateBillingVisibility() {
                if (!billingForm) return;

                if (newRadio && newRadio.checked) {
                    billingForm.classList.remove('hidden');
                    toggleBillingFields(false);
                } else {
                    billingForm.classList.add('hidden');
                    toggleBillingFields(true);
                }
            }

            if (savedRadio) {
                savedRadio.addEventListener('change', updateBillingVisibility);
            }

            if (newRadio) {
                newRadio.addEventListener('change', updateBillingVisibility);
            }

            updateBillingVisibility();

            // ===== SHIPPING TOGGLE =====
            function updateShippingVisibility() {
                if (!shippingAddress || !shippingCheckbox) return;

                if (shippingCheckbox.checked) {
                    shippingAddress.classList.remove('hidden');
                } else {
                    shippingAddress.classList.add('hidden');
                }
            }

            if (shippingCheckbox) {
                shippingCheckbox.addEventListener('change', updateShippingVisibility);
            }

            updateShippingVisibility();

        });
    </script>
@else
    {{-- ================= BILLING ENDEREÇO ================= --}}
    <div id="billing-form" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @include('checkout::frontend.components.billing.customer-address-billing')
    </div>

    {{-- ================= SHIPPING ================= --}}
    <div id="shipping-address" class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10 hidden">
        @include('checkout::frontend.components.shipping.customer-address-shipping')
    </div>

@endif
