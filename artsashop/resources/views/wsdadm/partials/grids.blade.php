<x-wsdadm.app-layout>
<section>
    <x-slot name="header">
        @livewire('titles-component')
    </x-slot>
    <div class="mx-auto px-8 space-y-6 pb-44">
        @include('wsdadm.layouts.flash-messages')
        @livewire($componentName, key($componentName))
    </div>
</section>
</x-wsdadm.app-layout>
