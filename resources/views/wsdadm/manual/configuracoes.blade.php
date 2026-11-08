{{-- configuracoes-sistema --}}
<section id="configuracoes-sistema" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">

        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            Sistema
        </span>

        <h1 class="mt-2 text-3xl font-bold tracking-tight text-blumine-800">
            Configurações
        </h1>

        <p class="mt-4 text-base leading-7 text-slate-600">
            A área de Configurações permite administrar os parâmetros utilizados
            pelo Examex para o funcionamento do Marketplace e dos seus recursos.
        </p>

    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Visão geral
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As configurações centralizam parâmetros que podem ser utilizados
            por diferentes partes do sistema.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A centralização dessas informações permite alterar determinados
            comportamentos do sistema sem a necessidade de modificar
            diretamente o código da aplicação.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/configuracoes/config.png') }}"
                alt="Configurações do Examex"
                class="w-full"
            >

        </div>

    </div>


    {{-- ORGANIZAÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Organização das configurações
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As configurações são organizadas de acordo com sua finalidade,
            facilitando a localização dos parâmetros que precisam ser
            consultados ou alterados.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Configurações do sistema
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Parâmetros relacionados ao funcionamento geral da
                    aplicação.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Configurações do Marketplace
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Parâmetros utilizados pelos recursos relacionados ao
                    Marketplace.
                </p>

            </div>

        </div>

    </div>


    {{-- ALTERAÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Alteração de uma configuração
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Para alterar uma configuração, localize o parâmetro desejado,
            informe o novo valor e salve as alterações.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As configurações devem ser alteradas somente quando houver
            necessidade operacional ou orientação para modificar determinado
            comportamento do sistema.
        </p>

    </div>


    {{-- CUIDADOS --}}
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
                    Atenção
                </h3>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    Algumas configurações podem alterar diretamente o
                    comportamento do Marketplace. Antes de modificar um
                    parâmetro, certifique-se de compreender sua finalidade e
                    o impacto da alteração.
                </p>

            </div>

        </div>

    </div>


    {{-- BOA PRÁTICA --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Boas práticas
        </h2>

        <div class="mt-5 space-y-3">

            <div class="flex items-start gap-3">

                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blumine-100 text-sm font-semibold text-blumine-700">
                    1
                </span>

                <p class="text-sm leading-6 text-slate-600">
                    Altere somente as configurações necessárias para a
                    operação do sistema.
                </p>

            </div>


            <div class="flex items-start gap-3">

                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blumine-100 text-sm font-semibold text-blumine-700">
                    2
                </span>

                <p class="text-sm leading-6 text-slate-600">
                    Confira o valor informado antes de salvar uma alteração.
                </p>

            </div>


            <div class="flex items-start gap-3">

                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blumine-100 text-sm font-semibold text-blumine-700">
                    3
                </span>

                <p class="text-sm leading-6 text-slate-600">
                    Caso tenha dúvidas sobre uma configuração, consulte a
                    documentação do sistema antes de alterá-la.
                </p>

            </div>

        </div>

    </div>


    {{-- OBSERVAÇÃO --}}
    <div class="mt-6 rounded-xl border border-blumine-100 bg-blumine-50 p-6">

        <h2 class="text-lg font-semibold text-blumine-800">
            Observação
        </h2>

        <p class="mt-3 text-sm leading-6 text-blumine-700">
            As configurações disponíveis podem variar de acordo com os
            recursos habilitados no Examex. Utilize somente os parâmetros
            apresentados na sua instalação.
        </p>

    </div>

</section>
