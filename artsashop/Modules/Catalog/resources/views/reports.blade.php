<x-wsdadm.app-layout>
    <section>
        <x-slot name="header">
            <div class="mx-auto px-8 space-y-6">
                <div class="navbar">
                    <div class="flex-1">
                        <h2 class="text-bold text-lg text-blumine-700">Histórico de Preços</h2>
                    </div>
                </div>
            </div>
        </x-slot>
        <div class="mx-auto px-8 space-y-6">
            @livewire('catalog::grids.warehouse-prices-grid', ['productId' => $productId])

            @livewire('catalog::grids.report-prices-grid', ['productId' => $productId])
        </div>
    </section>
</x-wsdadm.app-layout>
