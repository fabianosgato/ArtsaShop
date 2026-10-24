<x-wsdadm.app-layout>
    <section>
        <x-slot name="header">
            <div class="mx-auto px-8 space-y-6">
                <div class="navbar">
                    <div class="flex-1">
                        <h2 class="text-bold text-lg text-lightblue">
                            Modulos do sistema: Menu de acesso <strong>{{ $moduleName }}</strong>
                        </h2>
                    </div>
                    @if($buttonInsert != false)
                        <div class="flex">
                            <ul class="px-1 mt-4 mb-4 right-0">
                                <li class="right-0">
                                    <a class="btn btn-block btn-primary" href="{{ $actionInsert }}">Inserir</a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </x-slot>
        <div class="mx-auto px-8 space-y-6">
            @include('wsdadm.layouts.flash-messages')
            @livewire('system::grids.sys-module-menus-grid', ['moduleId' => $moduleId])
        </div>
    </section>
</x-wsdadm.app-layout>
