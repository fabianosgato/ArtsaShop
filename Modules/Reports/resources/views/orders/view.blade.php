<x-wsdadm.app-layout>
    <x-slot name="header">
        <div class="mx-auto px-8 space-y-6">
            <div class="navbar">
                <div class="flex-1">
                    <h2 class="text-bold text-lg text-blumine-700">Pedido ID {{ $order['order_id'] }}</h2>
                </div>
            </div>
        </div>

    </x-slot>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @include('reports::orders.partials.canal')
                @include('reports::orders.partials.customer')
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @include('reports::orders.partials.billing')
                @include('reports::orders.partials.shipping')
            </div>

            <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @include('reports::orders.partials.itens')
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @include('sales::orders.partials.historic')
                @include('reports::orders.partials.payments')
            </div>

        </div>
    </div>
</x-wsdadm.app-layout>
