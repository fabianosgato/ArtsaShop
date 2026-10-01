<x-wsdadm.app-layout>
<section>
    <x-slot name="header">
        <div class="mx-auto px-8 space-y-6">
            <div class="navbar">
                <div class="flex-1">
                    <h2 class="text-bold text-lg text-blumine-700">Produtos Cadastrados a serem editados</h2>
                </div>
                @if($totalImporterProducts > 0)
                <div class="flex-none">
                    <ul class="menu menu-horizontal px-1">
                        <li><a class="btn btn-active btn-accent btn-sm" href="{{ route('products.insert') }}">Monitorar Importação de Produtos</a></li>
                    </ul>
                </div>
                @endif

                <div class="flex-none">
                    <ul class="menu menu-horizontal px-1">
                        <li><a class="btn btn-active btn-info btn-sm" href="{{ route('products.new') }}">Cadastrar Manualmente</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </x-slot>
    <div class="mx-auto px-8 space-y-6">
        @include('wsdadm.layouts.flash-messages')
        @livewire($componentName, key($componentName))
    </div>
</section>
</x-wsdadm.app-layout>
