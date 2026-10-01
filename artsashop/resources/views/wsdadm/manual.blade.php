<x-wsdadm.app-manual>

    <section>

        <x-slot name="header">
            <div class="mx-auto px-8 space-y-6">
                <div class="navbar">

                    <div class="flex-1">
                        <h2 class="text-bold text-lg text-blumine-700">
                            {{ __('Manual de Utilização do Examex') }}
                        </h2>
                    </div>

                </div>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="mx-auto sm:px-12 lg:px-8 space-y-12">
                @include('wsdadm.manual.introducao')
                @include('wsdadm.manual.marketplace-clinicas')
                @include('wsdadm.manual.marketplace-pedidos')
                @include('wsdadm.manual.marketplace-financeiro')
                @include('wsdadm.manual.catalogo-exames')
                @include('wsdadm.manual.catalogo-categorias')
                @include('wsdadm.manual.atributos')
                @include('wsdadm.manual.cms')
                @include('wsdadm.manual.configuracoes-lojas')
                @include('wsdadm.manual.configuracoes-usuarios')
                @include('wsdadm.manual.configuracoes-grupos-usuarios')
                @include('wsdadm.manual.configuracoes-modulos')
                @include('wsdadm.manual.configuracoes-status-produtos')
                @include('wsdadm.manual.configuracoes-seo')
                @include('wsdadm.manual.configuracoes')

                @include('wsdadm.manual.fluxo-vendas')
                @include('wsdadm.manual.regras-sistema')
                @include('wsdadm.manual.informacoes-tecnicas')
            </div>
        </div>

    </section>

</x-wsdadm.app-manual>
