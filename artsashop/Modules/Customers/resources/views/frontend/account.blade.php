<x-frontend.app-layout layout="2columns-customer">
    <div class="dashboard">
        <div class="dy-card-body p-2 m-1">
            <h2 class="dy-card-title">Minha Conta</h2>
            <div class="welcome-msg">
                <p class="hello"><strong>Olá, {{ Auth::guard('customer')->user()->customer_name }}</strong></p>
                <p>No painel "Minha Conta", você pode visualizar um resumo das suas atividades recentes e atualizar suas informações. Selecione um dos links abaixo para visualizar ou editar as informações.</p>
            </div>
        </div>

        <div class="dy-card-body p-2 m-1">
            <h2 class="dy-card-title">Meus Últimos Pedidos</h2>
            <x-sales::frontend.customer-orders-component customerId="{{ $customer->customer_id }}" limit="2" />
        </div>

    </div>
</x-frontend.app-layout>
