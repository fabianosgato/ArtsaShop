<section id="fluxo-agendamento" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">

        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            Fluxo de vendas
        </span>

        <h2 class="mt-2 text-2xl font-bold tracking-tight text-blumine-800">
            Agendamento
        </h2>

        <p class="mt-4 text-base leading-7 text-slate-600">
            Após localizar o exame desejado, o cliente deve escolher uma
            clínica e um horário disponível para realizar o atendimento.
            Essa etapa define o local e o horário associados ao exame
            que será adquirido.
        </p>

    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Visão geral
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A disponibilidade apresentada no Marketplace é baseada nos
            horários cadastrados pelas clínicas participantes do Examex.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Para cada exame, o cliente pode visualizar as clínicas que
            oferecem aquele atendimento e selecionar um dos horários
            disponibilizados para agendamento.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/fluxo-vendas/agendamento.png') }}"
                alt="Agendamento de exame no Marketplace Examex"
                class="w-full"
            >

        </div>

    </div>


    {{-- ESCOLHA DA CLÍNICA --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Escolha da clínica
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O cliente deve selecionar a clínica onde deseja realizar o
            exame. A listagem apresenta as clínicas que disponibilizam
            aquele atendimento no Marketplace.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A disponibilidade de cada clínica depende dos exames
            cadastrados e dos horários disponibilizados em sua agenda.
        </p>

    </div>


    {{-- ESCOLHA DO HORÁRIO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Escolha do horário
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Após selecionar a clínica, o cliente poderá escolher entre os
            horários disponíveis para aquele exame.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Cada horário disponível representa um <strong>slot</strong> da
            agenda da clínica. O slot selecionado fica associado ao exame
            escolhido pelo cliente e será utilizado posteriormente no
            pedido.
        </p>
    </div>


    {{-- RESERVA DO SLOT --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Reserva temporária do horário
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Ao selecionar um horário, o slot é reservado temporariamente
            para o cliente enquanto ele conclui o processo de compra.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <h4 class="font-semibold text-blumine-800">
                Prazo da reserva
            </h4>

            <p class="mt-2 text-sm leading-6 text-blumine-700">
                O slot permanece reservado por até
                <strong>10 minutos</strong>.
                Caso o cliente não conclua a compra dentro desse período,
                o sistema libera o horário automaticamente para que ele
                possa ser novamente disponibilizado.
            </p>

        </div>

    </div>


    {{-- BLOQUEIO DE DUPLICIDADE --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Controle de disponibilidade
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O sistema controla a disponibilidade dos slots para evitar que
            o mesmo horário seja vendido para mais de um cliente.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Quando um slot já estiver reservado ou associado a um pedido,
            ele não poderá ser selecionado novamente por outro cliente.
        </p>

        <div class="mt-6 rounded-lg border border-emerald-200 bg-emerald-50 p-5">

            <h4 class="font-semibold text-emerald-800">
                Segurança do agendamento
            </h4>

            <p class="mt-2 text-sm leading-6 text-emerald-700">
                O controle de disponibilidade garante que um mesmo horário
                não seja utilizado em dois pedidos diferentes.
            </p>

        </div>

    </div>


    {{-- CONTINUAÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Continuação da compra
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Depois de selecionar o exame, a clínica e o horário, o cliente
            pode adicionar o atendimento ao carrinho e continuar para a
            próxima etapa do processo de compra.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O próximo passo é a conferência dos itens selecionados no
            <strong>carrinho</strong>.
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
                    A disponibilidade dos horários depende da agenda
                    configurada pelas clínicas. Caso não existam horários
                    disponíveis, o cliente deverá selecionar outra clínica
                    ou outra data.
                </p>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    O prazo de 10 minutos corresponde à reserva temporária
                    do slot durante o processo de compra e não representa
                    o prazo para realização do exame.
                </p>

            </div>

        </div>

    </div>

</section>
