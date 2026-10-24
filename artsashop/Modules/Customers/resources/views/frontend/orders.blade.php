<x-frontend.app-layout layout="2columns-customer">
    <div class="dashboard">
        <div class="card card-primary">
            <div class="card-header">
                <h2>Meus Pedidos</h2>
            </div>
            <div class="card-body">
                <x-sales::frontend.customer-orders-component customerId="{{ $customer->customer_id }}" />
            </div>
        </div>
    </div>
</x-frontend.app-layout>
