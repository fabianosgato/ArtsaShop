<section id="configuracoes-lojas" class="scroll-mt-24">

    {{-- TÍTULO --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-2xl font-semibold text-blumine-800">
            Configurações → Lojas
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A área de Lojas reúne as configurações responsáveis por
            identificar e definir o funcionamento da loja utilizada pelo
            Examex.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Essas informações são utilizadas pelo sistema para identificar
            corretamente o Marketplace, seus pedidos e o endereço de acesso
            à aplicação.
        </p>

    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Visão geral
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A configuração da loja é composta por informações utilizadas
            internamente pelo Examex para determinar qual loja está sendo
            acessada e como seus pedidos devem ser identificados.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            No projeto Examex existe uma loja principal, responsável pelo
            funcionamento do Marketplace.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/configuracoes/configuracao-lojas.png') }}"
                alt="Configuração de lojas do Examex"
                class="w-full"
            >

        </div>

    </div>


    {{-- IDENTIFICAÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Identificação da loja
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os primeiros campos da configuração são utilizados para
            identificar a loja dentro do sistema.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Nome da Loja
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Nome utilizado para identificar a loja dentro do
                    painel administrativo.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Código da Loja
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Código único utilizado internamente pelo sistema para
                    identificar a loja.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Código da Loja para os Pedidos
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Código utilizado na identificação dos pedidos realizados
                    através da loja.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    URL Host da Loja
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Endereço utilizado pelo sistema para identificar a loja
                    que está sendo acessada.
                </p>

            </div>

        </div>

    </div>


    {{-- LAYOUT E RECURSO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Layout e recurso
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A configuração também define informações utilizadas pelo
            sistema para determinar o layout e a origem dos produtos
            apresentados na loja.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Layout
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Define o layout utilizado pela loja. Essa configuração
                    determina a estrutura visual utilizada pelo Marketplace.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Tipo de Recurso
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Define o tipo de recurso utilizado pelo sistema para
                    determinar quais produtos pertencem à loja.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4 sm:col-span-2">

                <h3 class="font-semibold text-blumine-800">
                    ID do Recurso
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Identifica o recurso associado à loja de acordo com o
                    tipo de recurso selecionado.
                </p>

            </div>

        </div>

    </div>


    {{-- LOJA PADRÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Loja padrão
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A opção <strong>Loja Padrão</strong> determina qual loja será
            considerada a principal pelo sistema.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Quando uma loja é definida como padrão, ela passa a ser
            considerada a loja principal da aplicação. O sistema permite
            apenas uma loja padrão.
        </p>

    </div>


    {{-- IMPORTANTE --}}
    <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-6">

        <div class="flex gap-3">

            <svg
                class="mt-0.5 h-5 w-5 shrink-0 text-amber-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 9v3.75m0 3.75h.008v.008H12V16.5ZM10.29 3.86 2.82 17.25A1.5 1.5 0 0 0 4.13 19.5h15.74a1.5 1.5 0 0 0 1.31-2.25L13.71 3.86a1.95 1.95 0 0 0-3.42 0Z"
                />
            </svg>

            <div>

                <h3 class="font-semibold text-amber-800">
                    Importante
                </h3>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    As configurações de Loja possuem relação direta com o
                    funcionamento do Marketplace e com a identificação dos
                    pedidos. Por isso, alterações nessas informações devem
                    ser realizadas somente quando houver necessidade e com
                    conhecimento de seu impacto no sistema.
                </p>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    A loja utilizada pelo Examex já está configurada para o
                    funcionamento do projeto e, durante a operação normal do
                    sistema, não é necessário alterar essas informações.
                </p>

            </div>

        </div>

    </div>

</section>
