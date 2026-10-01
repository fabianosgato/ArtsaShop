<section id="fluxo-carrinho" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">

        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            Fluxo de vendas
        </span>

        <h2 class="mt-2 text-2xl font-bold tracking-tight text-blumine-800">
            Carrinho de compras
        </h2>

        <p class="mt-4 text-base leading-7 text-slate-600">
            O carrinho reúne os exames selecionados pelo cliente antes da
            finalização da compra. Nesta etapa, o cliente pode conferir os
            exames, clínicas, horários e valores antes de prosseguir para
            o checkout.
        </p>

    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Visão geral
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Após selecionar um exame e um horário disponível, o item é
            adicionado ao carrinho. O cliente pode então revisar os dados
            da compra antes de iniciar a etapa de finalização.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Cada item apresenta o exame selecionado, a clínica responsável
            pelo atendimento, o horário escolhido e o respectivo valor.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/fluxo-vendas/carrinho.png') }}"
                alt="Carrinho de compras do Marketplace Examex"
                class="w-full"
            >

        </div>

    </div>


    {{-- ITENS DO CARRINHO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Exames selecionados
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A área de exames selecionados apresenta os itens adicionados
            pelo cliente ao carrinho.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-3">

            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    Exame
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Identifica o exame que será realizado pelo cliente.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    Clínica
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Apresenta a clínica escolhida para realizar o
                    atendimento.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    Horário
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Apresenta a data e o horário selecionados durante o
                    agendamento.
                </p>

            </div>

        </div>

    </div>


    {{-- RESUMO DA COMPRA --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Resumo da compra
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O resumo da compra apresenta os valores relacionados aos exames
            selecionados e permite que o cliente confira o total antes de
            prosseguir.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    Subtotal
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Corresponde à soma dos valores dos exames adicionados
                    ao carrinho.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    Descontos
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Quando aplicável, o sistema apresenta o desconto
                    correspondente à forma de pagamento selecionada.
                </p>

            </div>

        </div>

    </div>


    {{-- DESCONTO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Desconto no PIX
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O Examex pode aplicar uma regra de desconto específica para
            pagamentos realizados via PIX.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Quando essa condição estiver disponível, o desconto é
            apresentado no resumo da compra e o valor total é atualizado
            antes da finalização.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <h4 class="font-semibold text-blumine-800">
                Exemplo
            </h4>

            <p class="mt-2 text-sm leading-6 text-blumine-700">
                No exemplo apresentado na tela, o valor dos exames é de
                R$ 48,00 e o desconto de 10% no PIX reduz o total da compra
                para R$ 43,20.
            </p>

        </div>

    </div>

    {{-- AÇÕES --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Ações disponíveis
        </h3>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    Continuar comprando
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Retorna à navegação do Marketplace para que o cliente
                    possa adicionar outros exames ao carrinho.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    Finalizar compra
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Direciona o cliente para o checkout, onde serão
                    preenchidos os dados necessários para concluir a compra
                    e selecionar a forma de pagamento.
                </p>

            </div>

        </div>

    </div>


    {{-- REMOÇÃO DE ITEM --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Remoção de um exame
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O cliente pode remover um exame do carrinho utilizando a opção
            disponível junto ao item.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Ao remover o item, o horário associado deixa de fazer parte
            daquela compra e pode voltar a ficar disponível de acordo com
            as regras de disponibilidade do sistema.
        </p>

    </div>


    {{-- PRAZO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Prazo para finalizar a compra
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os horários selecionados são mantidos temporariamente enquanto
            o cliente conclui o processo de compra.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <h4 class="font-semibold text-blumine-800">
                Prazo da reserva
            </h4>

            <p class="mt-2 text-sm leading-6 text-blumine-700">
                O slot permanece reservado por até
                <strong>10 minutos</strong>.
                Caso a compra não seja concluída nesse período, o sistema
                libera o horário automaticamente.
            </p>

        </div>

    </div>


    {{-- CONTINUAÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Próxima etapa
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Depois de conferir os exames e os valores apresentados no
            carrinho, o cliente pode selecionar
            <strong>Finalizar compra</strong> para acessar o checkout.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            No checkout serão informados os dados do cliente e selecionada
            a forma de pagamento para concluir o pedido.
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
                    O carrinho não representa uma compra concluída.
                    O pedido somente é criado após o cliente avançar pelo
                    checkout e concluir o processo de pagamento.
                </p>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    Os horários selecionados possuem uma reserva temporária
                    de 10 minutos. Esse mecanismo evita que um mesmo horário
                    fique indisponível indefinidamente enquanto o cliente
                    não conclui a compra.
                </p>

            </div>

        </div>

    </div>

</section>
