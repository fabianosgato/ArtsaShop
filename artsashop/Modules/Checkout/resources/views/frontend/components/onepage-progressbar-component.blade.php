{{-- BARRA DE PROGRESSO --}}
<div class="max-w-5xl mx-auto mb-6 mt-6">

    <div class="flex justify-between text-xl">
        <div class="{{ request()->routeIs('checkout.onepage.index') ? 'font-bold' : '' }}">
            1. Identificação
        </div>
        <div class="{{ request()->routeIs('checkout.onepage.information') ? 'font-bold' : '' }}">
            2. Dados
        </div>
        <div class="{{ request()->routeIs('checkout.onepage.addresses') ? 'font-bold' : '' }}">
            3. Endereços
        </div>
        <div class="{{ request()->routeIs('checkout.onepage.payment') ? 'font-bold' : '' }}">
            4. Pagamento
        </div>
        <div class="{{ request()->routeIs('checkout.onepage.confirm') ? 'font-bold' : '' }}">
            5. Confirmação
        </div>
    </div>

</div>
