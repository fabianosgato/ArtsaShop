<section id="marketplace-pedidos" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">

        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            Marketplace
        </span>

        <h1 class="mt-2 text-3xl font-bold tracking-tight text-blumine-800">
            Pedidos
        </h1>

        <p class="mt-4 text-base leading-7 text-slate-600">
            A área de Pedidos permite acompanhar e consultar todas as compras
            realizadas pelos clientes através do Marketplace Examex.
        </p>

    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Visão geral
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A tela de Pedidos concentra as principais informações de uma venda,
            permitindo acompanhar o cliente, a clínica responsável pelo
            atendimento, o valor da compra, o pagamento e o status atual do
            pedido.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A partir dessa tela também é possível acessar os detalhes de um
            pedido específico para consultar todas as informações relacionadas
            à compra.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">
            <img
                src="{{ asset('images/manual/marketplace/pedidos/listagem.png') }}"
                alt="Lista de pedidos do Examex"
                class="w-full"
            >
        </div>

    </div>


    {{-- INFORMAÇÕES DA LISTAGEM --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Informações dos pedidos
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A listagem apresenta as principais informações necessárias para
            identificar e acompanhar cada pedido.
        </p>

        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">
                <tr>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Informação
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Descrição
                    </th>

                </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 bg-white">

                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Pedido #
                    </td>
                    <td class="px-4 py-3 text-sm text-slate-600">
                        Identificação do pedido realizado pelo cliente.
                    </td>
                </tr>

                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Clínica
                    </td>
                    <td class="px-4 py-3 text-sm text-slate-600">
                        Clínica responsável pelo atendimento do pedido.
                    </td>
                </tr>

                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Cliente
                    </td>
                    <td class="px-4 py-3 text-sm text-slate-600">
                        Cliente que realizou a compra.
                    </td>
                </tr>

                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        CPF/CNPJ
                    </td>
                    <td class="px-4 py-3 text-sm text-slate-600">
                        Documento do Cliente que realizou a compra.
                    </td>
                </tr>

                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Valor do pedido
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Valor total da compra realizada pelo cliente.
                    </td>
                </tr>

                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Pagamento
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Forma de pagamento utilizada na compra.
                    </td>
                </tr>

                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Status
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Situação atual do pedido dentro do fluxo do Examex.
                    </td>
                </tr>

                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Data do pedido
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Data em que o pedido foi realizado.
                    </td>
                </tr>

                </tbody>

            </table>

        </div>

    </div>


    {{-- PESQUISA E FILTROS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Pesquisa e filtros
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A tela permite localizar pedidos utilizando os recursos de pesquisa
            e filtragem disponíveis na listagem.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Pesquisa
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Utilize a pesquisa para localizar rapidamente um pedido,
                    cliente ou outra informação disponível para consulta.
                </p>

            </div>

            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Filtros
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Os filtros permitem restringir a listagem de acordo com
                    determinadas condições do pedido.
                </p>

            </div>

        </div>

    </div>


    {{-- DETALHES --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Detalhes do pedido
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Ao acessar os detalhes de um pedido, o sistema apresenta as
            informações completas relacionadas à compra.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Essa consulta permite verificar os dados do cliente, os exames
            adquiridos, a clínica responsável, o agendamento, os valores e as
            informações relacionadas ao pagamento.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">
            <img
                src="{{ asset('images/manual/marketplace/pedidos/detalhes.png') }}"
                alt="Detalhes de um pedido no Examex"
                class="w-full"
            >
        </div>

    </div>


    {{-- STATUS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Status do pedido
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O status indica em qual etapa do processo o pedido se encontra.
            O pedido pode passar por diferentes situações durante seu ciclo
            de vida.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <h3 class="font-semibold text-blumine-800">
                Atenção
            </h3>

            <p class="mt-2 text-sm leading-6 text-blumine-700">
                O status do pedido deve ser utilizado como referência para
                identificar a situação atual da compra e determinar quais ações
                podem ser realizadas.
            </p>

        </div>

    </div>


    {{-- AÇÕES --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Ações disponíveis
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A listagem disponibiliza ações para consultar um pedido e acessar
            informações adicionais relacionadas à compra.
        </p>

        <div class="mt-6 space-y-3">

            <div class="flex items-start gap-3 rounded-lg bg-slate-50 p-4">

                <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blumine-100 text-xs font-semibold text-blumine-700">
                    1
                </span>

                <div>
                    <h3 class="font-semibold text-blumine-800">
                        Detalhes
                    </h3>

                    <p class="mt-1 text-sm leading-6 text-slate-600">
                        Abre a página com as informações completas do pedido.
                    </p>
                </div>

            </div>


            <div class="flex items-start gap-3 rounded-lg bg-slate-50 p-4">

                <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blumine-100 text-xs font-semibold text-blumine-700">
                    2
                </span>

                <div>
                    <h3 class="font-semibold text-blumine-800">
                        Informação rápida
                    </h3>

                    <p class="mt-1 text-sm leading-6 text-slate-600">
                        Exibe uma visão resumida das informações do pedido sem
                        precisar sair da listagem.
                    </p>
                </div>

            </div>

        </div>

    </div>


    {{-- OBSERVAÇÃO --}}
    <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-6">

        <div class="flex gap-3">

            <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.8"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 9v3.75m0 3.75h.008v.008H12V16.5ZM10.29 3.86 2.82 17.25A1.5 1.5 0 0 0 4.13 19.5h15.74a1.5 1.5 0 0 0 1.31-2.25L13.71 3.86a1.95 1.95 0 0 0-3.42 0Z" />
            </svg>

            <div>

                <h3 class="font-semibold text-amber-800">
                    Importante
                </h3>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    O acompanhamento do status do pedido é importante para
                    identificar pedidos que aguardam aprovação da clínica,
                    pedidos aprovados e pedidos que foram cancelados ou
                    reembolsados.
                </p>

            </div>

        </div>

    </div>

</section>
