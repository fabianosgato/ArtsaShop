<section id="fluxo-vendas-geral" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">

            <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
                Operação
            </span>

        <h1 class="mt-2 text-3xl font-bold tracking-tight text-blumine-800">
            Fluxo de vendas
        </h1>

        <p class="mt-4 text-base leading-7 text-slate-600">
            O fluxo de vendas apresenta as principais etapas realizadas
            desde a escolha de um exame pelo cliente até a conclusão do
            pedido.
        </p>

    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Visão geral do processo
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O Examex utiliza um fluxo no qual o cliente realiza a compra
            através do Marketplace e, após a confirmação do pagamento, o
            pedido é encaminhado para a clínica responsável pelo atendimento.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A clínica então analisa o pedido e pode aprová-lo ou recusá-lo.
            Essa decisão determina o próximo passo do pedido.
        </p>

    </div>


    {{-- FLUXO PRINCIPAL --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Fluxo principal
        </h2>

        <div class="mt-8 space-y-4">

            {{-- 1 --}}
            <div class="flex items-start gap-4">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blumine-100 font-semibold text-blumine-700">
                    1
                </div>

                <div class="flex-1 rounded-lg bg-slate-50 p-5">

                    <h3 class="font-semibold text-blumine-800">
                        Cliente escolhe o exame
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        O cliente acessa o Marketplace, escolhe o exame
                        desejado e seleciona uma clínica e um horário
                        disponível para atendimento.
                    </p>

                </div>

            </div>


            {{-- SETA --}}
            <div class="ml-5 h-4 border-l-2 border-slate-200"></div>


            {{-- 2 --}}
            <div class="flex items-start gap-4">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blumine-100 font-semibold text-blumine-700">
                    2
                </div>

                <div class="flex-1 rounded-lg bg-slate-50 p-5">

                    <h3 class="font-semibold text-blumine-800">
                        Cliente realiza o pagamento
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        O cliente informa os dados necessários e realiza o
                        pagamento através de uma das formas de pagamento
                        disponíveis.
                    </p>

                </div>

            </div>


            {{-- SETA --}}
            <div class="ml-5 h-4 border-l-2 border-slate-200"></div>


            {{-- 3 --}}
            <div class="flex items-start gap-4">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blumine-100 font-semibold text-blumine-700">
                    3
                </div>

                <div class="flex-1 rounded-lg bg-slate-50 p-5">

                    <h3 class="font-semibold text-blumine-800">
                        Pagamento aprovado
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Após a confirmação do pagamento, o pedido é registrado
                        no sistema e fica disponível para análise da clínica
                        responsável.
                    </p>

                </div>

            </div>


            {{-- SETA --}}
            <div class="ml-5 h-4 border-l-2 border-slate-200"></div>


            {{-- 4 --}}
            <div class="flex items-start gap-4">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-100 font-semibold text-amber-700">
                    4
                </div>

                <div class="flex-1 rounded-lg bg-amber-50 p-5">

                    <h3 class="font-semibold text-amber-800">
                        Aguardando aprovação da clínica
                    </h3>

                    <p class="mt-2 text-sm leading-6 text-amber-700">
                        A clínica recebe a informação do novo pedido e deve
                        analisar se poderá realizar o atendimento solicitado
                        pelo cliente.
                    </p>

                </div>

            </div>

        </div>

    </div>
</section>
