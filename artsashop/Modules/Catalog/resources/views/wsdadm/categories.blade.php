<x-wsdadm.app-layout>
    <section>
        <x-slot name="header">
            <div class="mx-auto px-8 space-y-6">
                <div class="navbar">
                    <div class="flex-1">
                        <h2 class="text-bold text-lg text-blumine-700">{{ __('Inserir/Editar Categorias') }}</h2>
                    </div>
                </div>
            </div>
        </x-slot>
        <div class="mx-auto sm:px-12 lg:px-8 space-y-12">
            <div class="category-table">
                @include('wsdadm.layouts.flash-messages')
                @livewire($componentName, key($componentName))
            </div>
        </div>
    </section>
</x-wsdadm.app-layout>
