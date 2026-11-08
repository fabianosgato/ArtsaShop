<section id="fluxo-pesquisa" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">

        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            Fluxo de vendas
        </span>

        <h2 class="mt-2 text-2xl font-bold tracking-tight text-blumine-800">
            Pesquisa de exames
        </h2>

        <p class="mt-4 text-base leading-7 text-slate-600">
            A pesquisa de exames é o primeiro passo da jornada de compra
            do cliente no Marketplace. Através dela, o cliente pode localizar
            os exames disponíveis e utilizar os filtros para encontrar o
            atendimento que melhor corresponde à sua necessidade.
        </p>

    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Visão geral
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os exames apresentados no Marketplace são organizados de acordo
            com as categorias e atributos configurados no sistema
            administrativo.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O cliente pode pesquisar pelo nome do exame ou utilizar os
            filtros disponíveis para refinar os resultados apresentados.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/fluxo-vendas/pesquisa-exames.png') }}"
                alt="Pesquisa de exames no Marketplace Examex"
                class="w-full"
            >

        </div>

    </div>


    {{-- PESQUISA --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Pesquisa pelo nome do exame
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O cliente pode utilizar o campo de pesquisa para localizar
            diretamente um exame disponível no Marketplace.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os resultados são apresentados de acordo com os exames
            disponíveis no catálogo e suas respectivas informações.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <h4 class="font-semibold text-blumine-800">
                Dica
            </h4>

            <p class="mt-2 text-sm leading-6 text-blumine-700">
                Quanto mais específica for a pesquisa realizada pelo cliente,
                mais fácil será localizar o exame desejado.
            </p>

        </div>

    </div>


    {{-- FILTROS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Filtros de pesquisa
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Além da pesquisa pelo nome, o Marketplace disponibiliza filtros
            que permitem refinar os resultados apresentados ao cliente.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os filtros são definidos a partir dos atributos configurados
            no sistema administrativo. Dessa forma, somente os atributos
            configurados para utilização nos filtros são apresentados nessa
            etapa da pesquisa.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    Filtros de seleção
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Permitem que o cliente selecione valores disponíveis
                    para refinar os resultados encontrados.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    Filtros por atributos
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Utilizam as informações cadastradas nos exames para
                    restringir os resultados de acordo com as características
                    desejadas pelo cliente.
                </p>

            </div>

        </div>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/fluxo-vendas/filtros-exames.png') }}"
                alt="Filtros de exames disponíveis no Marketplace Examex"
                class="w-full"
            >

        </div>

    </div>


    {{-- CATEGORIAS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Navegação por categorias
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os exames também são organizados em categorias, permitindo que
            o cliente navegue pelo catálogo de acordo com o tipo de exame
            que deseja realizar.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A estrutura das categorias é definida através dos grupos de
            atributos cadastrados no WsdAdmin e é utilizada pelo Marketplace
            para organizar e localizar os exames.
        </p>

    </div>


    {{-- RESULTADOS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Resultado da pesquisa
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Após realizar uma pesquisa ou aplicar um filtro, o Marketplace
            apresenta os exames que correspondem aos critérios selecionados.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A partir da listagem de resultados, o cliente pode selecionar
            o exame desejado e prosseguir para a próxima etapa do processo,
            que consiste na escolha da clínica e do horário disponível para
            atendimento.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/fluxo-vendas/resultado-pesquisa.png') }}"
                alt="Resultado da pesquisa de exames no Marketplace Examex"
                class="w-full"
            >

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
                    A disponibilidade dos filtros e a forma como os exames
                    são organizados no Marketplace dependem da configuração
                    dos atributos e categorias no WsdAdmin.
                </p>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    Alterações na estrutura dos atributos utilizados nos
                    filtros podem modificar a forma como os clientes
                    encontram os exames no Marketplace.
                </p>

            </div>

        </div>

    </div>

</section>
