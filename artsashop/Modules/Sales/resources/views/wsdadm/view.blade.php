<x-wsdadm.app-layout>
    <x-slot name="header">
        <div class="mx-auto px-8 space-y-6">
            <div class="navbar">
                <div class="flex-1">
                    <h2 class="text-bold text-lg text-blumine-700">Pedido N° {{ $order['increment_code'] }}</h2>
                </div>
            </div>
        </div>

    </x-slot>
    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @include('sales::wsdadm.partials.canal')
                @include('sales::wsdadm.partials.customer')
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @include('sales::wsdadm.partials.billing')
                @include('sales::wsdadm.partials.shipping')
            </div>

            <div class="p-4 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @include('sales::wsdadm.partials.itens')
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
{{--                @include('sales::wsdadm.partials.tracking')--}}
                @include('sales::wsdadm.partials.payments')
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-12">
{{--                @include('sales::wsdadm.partials.historic')--}}
            </div>

        </div>
    </div>
</x-wsdadm.app-layout>
