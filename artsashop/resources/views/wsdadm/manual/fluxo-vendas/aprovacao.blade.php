<section id="fluxo-aprovacao" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">

        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            Fluxo de vendas
        </span>

        <h2 class="mt-2 text-2xl font-bold tracking-tight text-blumine-800">
            Aprovação da clínica
        </h2>

        <p class="mt-4 text-base leading-7 text-slate-600">
            Após a confirmação do pagamento, o pedido é encaminhado para a
            clínica responsável pelo exame. A clínica deve analisar as
            informações do pedido e confirmar se poderá realizar o
            atendimento na data e horário selecionados pelo cliente.
        </p>

        <p class="mt-4 text-base leading-7 text-slate-600">
            Essa etapa é importante porque o pagamento realizado pelo cliente
            não representa a aprovação automática do atendimento pela clínica.
        </p>

    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Como funciona
        </h3>

        <div class="mt-6 grid gap-4 sm:grid-cols-3">

            <div class="rounded-lg bg-slate-50 p-5">

                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blumine-700 text-sm font-semibold text-white">
                    1
                </div>

                <h4 class="mt-4 font-semibold text-blumine-800">
                    Pagamento confirmado
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    O cliente conclui o pagamento do pedido através de uma
                    das formas disponíveis no checkout.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blumine-700 text-sm font-semibold text-white">
                    2
                </div>

                <h4 class="mt-4 font-semibold text-blumine-800">
                    Análise da clínica
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    A clínica recebe a solicitação e verifica os dados do
                    exame, paciente, data e horário agendados.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blumine-700 text-sm font-semibold text-white">
                    3
                </div>

                <h4 class="mt-4 font-semibold text-blumine-800">
                    Aprovação
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Após a análise, a clínica aprova o pedido e o atendimento
                    segue para as próximas etapas do fluxo.
                </p>

            </div>

        </div>

    </div>


    {{-- ANÁLISE DO PEDIDO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Análise do pedido
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Ao receber um novo pedido, a clínica deve verificar se possui
            condições de realizar o atendimento solicitado.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Entre as informações que devem ser consideradas estão os dados
            do paciente, o exame adquirido, a data, o horário e as demais
            informações necessárias para a realização do atendimento.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <p class="text-sm leading-6 text-blumine-700">
                A aprovação é realizada pela clínica porque é ela quem
                possui a responsabilidade de confirmar a disponibilidade
                e as condições necessárias para realizar o exame.
            </p>

        </div>

    </div>


    {{-- APROVAÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Aprovação do atendimento
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Quando a clínica confirma que poderá realizar o atendimento,
            o pedido é aprovado e o sistema atualiza seu status para
            representar essa aprovação.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A partir desse momento, o pedido pode seguir normalmente para
            as próximas etapas do processo de atendimento.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg border border-green-200 bg-green-50 p-5">

                <h4 class="font-semibold text-green-800">
                    Pedido aprovado
                </h4>

                <p class="mt-2 text-sm leading-6 text-green-700">
                    A clínica confirmou o atendimento e o pedido pode
                    prosseguir no fluxo normal do Examex.
                </p>

            </div>


            <div class="rounded-lg border border-red-200 bg-red-50 p-5">

                <h4 class="font-semibold text-red-800">
                    Pedido não aprovado
                </h4>

                <p class="mt-2 text-sm leading-6 text-red-700">
                    Caso a clínica não possa realizar o atendimento,
                    o pedido deve seguir o fluxo correspondente à
                    indisponibilidade ou cancelamento.
                </p>

            </div>

        </div>

    </div>


    {{-- RESPONSABILIDADE --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Responsabilidade da clínica
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A clínica é responsável por analisar as solicitações recebidas
            e confirmar se poderá realizar os atendimentos nos horários
            selecionados pelos clientes.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Por isso, é importante manter a agenda de atendimento atualizada
            e verificar regularmente os novos pedidos recebidos através do
            painel da clínica.
        </p>

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
                    O pagamento do pedido e a aprovação da clínica são
                    etapas diferentes do processo. O pagamento confirma
                    a transação financeira, enquanto a aprovação confirma
                    que a clínica poderá realizar o atendimento solicitado.
                </p>

            </div>

        </div>

    </div>

</section>
