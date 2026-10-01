<section id="marketplace-financeiro" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">

        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            Marketplace
        </span>

        <h1 class="mt-2 text-3xl font-bold tracking-tight text-blumine-800">
            Financeiro
        </h1>

        <p class="mt-4 text-base leading-7 text-slate-600">
            A área Financeiro permite acompanhar os valores dos pedidos que
            devem ser repassados às clínicas participantes do Marketplace.
        </p>

    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Visão geral
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A tela financeira apresenta os pedidos que possuem valores
            destinados às clínicas, permitindo acompanhar o valor total do
            pedido, o percentual de repasse e o valor correspondente ao
            pagamento da clínica.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O módulo foi desenvolvido para oferecer uma visão simples dos
            valores financeiros relacionados aos pedidos realizados no
            Marketplace.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/marketplace/financeiro/listagem.png') }}"
                alt="Tela financeira do Examex"
                class="w-full"
            >

        </div>

    </div>


    {{-- INFORMAÇÕES --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Informações apresentadas
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A listagem apresenta as principais informações necessárias para
            identificar o pedido e verificar o valor destinado à clínica.
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
                        Identificação do pedido relacionado ao repasse.
                    </td>

                </tr>

                <tr>

                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Clínica
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Clínica que receberá o valor correspondente ao
                        percentual definido para o pedido.
                    </td>

                </tr>

                <tr>

                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Cliente
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Cliente responsável pela realização do pedido.
                    </td>

                </tr>

                <tr>

                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Valor do pedido
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Valor total pago pelo cliente no pedido.
                    </td>

                </tr>

                <tr>

                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Porcentagem da clínica
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Percentual definido para a clínica no cadastro
                        financeiro.
                    </td>

                </tr>

                <tr>

                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Total a ser pago
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Valor calculado para repasse à clínica com base
                        no percentual definido.
                    </td>

                </tr>

                <tr>

                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Pagamento
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Forma de pagamento utilizada pelo cliente.
                    </td>

                </tr>

                <tr>

                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Pago
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Indica se o valor destinado à clínica já foi
                        marcado como pago.
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


    {{-- CÁLCULO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Cálculo do repasse
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O valor destinado à clínica é calculado utilizando o valor do
            pedido e o percentual de repasse configurado para a clínica.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <p class="text-sm font-semibold text-blumine-800">
                Exemplo
            </p>

            <div class="mt-4 space-y-2 text-sm text-blumine-700">

                <div class="flex justify-between gap-4">
                    <span>Valor do pedido</span>
                    <strong>R$ 48,00</strong>
                </div>

                <div class="flex justify-between gap-4">
                    <span>Percentual da clínica</span>
                    <strong>75%</strong>
                </div>

                <div class="my-3 border-t border-blumine-200"></div>

                <div class="flex justify-between gap-4 text-base font-semibold">
                    <span>Valor para repasse</span>
                    <strong>R$ 36,00</strong>
                </div>

            </div>

        </div>

    </div>


    {{-- STATUS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Status do pagamento
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A coluna <strong>Pago</strong> permite acompanhar se o valor
            destinado à clínica já foi registrado como pago.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">

                <div class="flex items-center gap-2">

                    <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">
                        Pendente
                    </span>

                </div>

                <p class="mt-3 text-sm leading-6 text-amber-700">
                    O valor está disponível para acompanhamento e ainda não
                    foi registrado como pago para a clínica.
                </p>

            </div>


            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4">

                <div class="flex items-center gap-2">

                    <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                        Pago
                    </span>

                </div>

                <p class="mt-3 text-sm leading-6 text-emerald-700">
                    O pagamento destinado à clínica foi registrado como
                    realizado.
                </p>

            </div>

        </div>

    </div>


    {{-- MARCAR COMO PAGO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Registrar pagamento
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Após realizar o repasse financeiro à clínica, utilize a ação
            disponível no registro correspondente para marcar o valor como
            pago.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Essa informação é utilizada para manter o controle dos valores
            que já foram repassados e daqueles que ainda estão pendentes.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/marketplace/financeiro/marcar-pago.png') }}"
                alt="Registro de pagamento para clínica"
                class="w-full"
            >

        </div>

    </div>


    {{-- FILTROS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Pesquisa e filtros
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A listagem permite utilizar os recursos de pesquisa e filtros para
            localizar pedidos e acompanhar os valores financeiros de forma
            mais rápida.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <h3 class="font-semibold text-blumine-800">
                Filtro por status do pedido
            </h3>

            <p class="mt-2 text-sm leading-6 text-blumine-700">
                Utilize o filtro de status para visualizar somente os pedidos
                que estejam em uma determinada situação dentro do fluxo do
                Marketplace.
            </p>

        </div>

    </div>


    {{-- IMPORTANTE --}}
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
                    O módulo Financeiro apresenta o controle dos valores de
                    repasse, mas a definição das datas e condições efetivas
                    de pagamento às clínicas deve seguir as regras financeiras
                    estabelecidas pela administração do Marketplace.
                </p>

            </div>

        </div>

    </div>

</section>
