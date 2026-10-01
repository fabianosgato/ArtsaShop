<section id="informacoes-tecnicas" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">

        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            Sistema
        </span>

        <h1 class="mt-2 text-3xl font-bold tracking-tight text-blumine-800">
            Informações técnicas
        </h1>

        <p class="mt-4 text-base leading-7 text-slate-600">
            Esta seção apresenta as principais tecnologias e componentes
            utilizados na construção do Examex.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-500">
            Essas informações são destinadas principalmente à manutenção,
            evolução e suporte técnico do sistema.
        </p>

    </div>


    {{-- APLICAÇÃO --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Aplicação
        </h2>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Framework
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Laravel 13
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Linguagem
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    PHP
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Banco de dados
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    MySQL
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Interface administrativa
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    FilamentPHP 5
                </p>

            </div>

        </div>

    </div>


    {{-- ARQUITETURA --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Arquitetura
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O projeto utiliza uma arquitetura modular, permitindo organizar
            as funcionalidades do sistema em módulos independentes.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <h3 class="font-semibold text-blumine-800">
                Modularização
            </h3>

            <p class="mt-2 text-sm leading-6 text-blumine-700">
                A aplicação utiliza o
                <strong>nwidart/laravel-modules</strong>
                para organização dos módulos do sistema.
            </p>

        </div>

    </div>


    {{-- COMPONENTES --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Principais componentes
        </h2>

        <div class="mt-6 space-y-4">

            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    WsdAdmin
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Interface administrativa utilizada para gerenciamento
                    do catálogo, clínicas, pedidos, configurações,
                    usuários e demais recursos administrativos do Examex.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Marketplace
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Interface destinada aos clientes para pesquisa de
                    exames, escolha de clínicas e horários, carrinho,
                    checkout e realização dos pagamentos.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Painel da clínica
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Área utilizada pelas clínicas para gerenciamento de
                    sua operação, incluindo agenda e aprovação dos pedidos
                    recebidos.
                </p>

            </div>

        </div>

    </div>


    {{-- PAGAMENTOS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Integração de pagamentos
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O Examex utiliza o Pagar.me como gateway para processamento
            dos pagamentos realizados no Marketplace.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    PIX
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Forma de pagamento disponibilizada no checkout,
                    sujeita às configurações e disponibilidade do gateway.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Cartão de crédito
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Forma de pagamento disponibilizada no checkout através
                    da integração com o gateway.
                </p>

            </div>

        </div>

    </div>


    {{-- FRONTEND --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Interface e frontend
        </h2>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Tailwind CSS
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Utilizado na construção das interfaces do sistema,
                    incluindo o WsdAdmin e componentes do frontend.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Vite
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Utilizado no processo de compilação e gerenciamento
                    dos recursos frontend da aplicação.
                </p>

            </div>

        </div>

    </div>


    {{-- AMBIENTE --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Ambiente de execução
        </h2>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Sistema operacional
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Ubuntu Server
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Servidor web
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Apache
                </p>

            </div>

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
                    Informações técnicas
                </h3>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    Alterações na infraestrutura, nas versões dos
                    componentes ou nas integrações externas devem ser
                    realizadas por profissionais com conhecimento técnico
                    do projeto.
                </p>

            </div>

        </div>

    </div>

</section>
