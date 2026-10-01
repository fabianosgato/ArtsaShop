<x-wsdadm.app-layout>
    <section>
        <x-slot name="header">
            @livewire('titles-component')
        </x-slot>
        <div class="mx-auto px-0 space-y-6">
            @livewire($componentName, [
                'data' => $data,
                'params' => $params ?? [],
            ])
        </div>
    </section>
</x-wsdadm.app-layout>

