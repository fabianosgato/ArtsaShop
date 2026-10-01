<section id="regras-sistema" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">

        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            Sistema
        </span>

        <h1 class="mt-2 text-3xl font-bold tracking-tight text-blumine-800">
            Regras do sistema
        </h1>

        <p class="mt-4 text-base leading-7 text-slate-600">
            Esta seção apresenta as principais regras e comportamentos do
            Examex que devem ser considerados durante a utilização do sistema.
        </p>

    </div>


    {{-- PEDIDOS --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Pedidos
        </h2>

        <div class="mt-6 space-y-4">

            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Aprovação da clínica
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Após a confirmação do pagamento, o pedido fica aguardando
                    a análise e aprovação da clínica responsável pelo
                    atendimento.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Recusa da clínica
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    A clínica pode recusar um pedido que esteja aguardando
                    aprovação. Quando isso ocorre, o pedido é cancelado pela
                    clínica e o pagamento é encaminhado para reembolso.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Comunicação
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    O sistema envia comunicações por e-mail em determinadas
                    etapas do fluxo do pedido, incluindo a confirmação da
                    aprovação e a recusa pela clínica.
                </p>

            </div>

        </div>

    </div>


    {{-- AGENDAMENTO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Agendamento e horários
        </h2>

        <div class="mt-6 space-y-4">

            <div class="rounded-lg border border-blumine-100 bg-blumine-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Reserva do horário
                </h3>

                <p class="mt-2 text-sm leading-6 text-blumine-700">
                    Quando um cliente seleciona um horário disponível durante
                    o processo de compra, o horário é reservado para evitar
                    que outro cliente realize a mesma compra simultaneamente.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Tempo de reserva
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    O horário permanece reservado por um período limitado
                    enquanto o cliente conclui a compra.
                </p>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Atualmente, o período de reserva do carrinho é de
                    <strong>10 minutos</strong>.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Expiração do carrinho
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Caso o cliente não conclua a compra dentro do período
                    definido, a reserva é removida e o horário volta a ficar
                    disponível para utilização.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Horários vencidos
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Horários que já passaram e não foram utilizados deixam de
                    ficar disponíveis para novas reservas.
                </p>

            </div>

        </div>

    </div>


    {{-- SLOT --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Exclusividade do horário
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Um mesmo horário de atendimento não pode ser utilizado para
            múltiplas compras quando já estiver reservado ou ocupado.
        </p>

        <div class="mt-6 rounded-lg border border-emerald-200 bg-emerald-50 p-5">

            <h3 class="font-semibold text-emerald-800">
                Regra de segurança
            </h3>

            <p class="mt-2 text-sm leading-6 text-emerald-700">
                O sistema valida a disponibilidade do horário durante o
                processo de compra para evitar a venda duplicada de um mesmo
                horário.
            </p>

        </div>

    </div>


    {{-- PAGAMENTO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Pagamentos
        </h2>

        <div class="mt-6 space-y-4">

            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Confirmação do pagamento
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    O pedido somente segue para a etapa de aprovação da
                    clínica após o pagamento ser confirmado pelo meio de
                    pagamento utilizado.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Recusa do pedido após pagamento
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Se a clínica recusar um pedido que já tenha sido pago,
                    o sistema realiza o procedimento de cancelamento do
                    pagamento e registra o pedido como cancelado pela clínica.
                </p>

            </div>

        </div>

    </div>


    {{-- CARTÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Cartão de crédito
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O pagamento com cartão de crédito é processado através do
            gateway de pagamento configurado para o Examex.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <h3 class="font-semibold text-blumine-800">
                Aprovação
            </h3>

            <p class="mt-2 text-sm leading-6 text-blumine-700">
                Quando a transação é aprovada pelo gateway, o pagamento é
                registrado no pedido e o fluxo pode prosseguir para a
                aprovação da clínica.
            </p>

        </div>

    </div>


    {{-- REEMBOLSO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Cancelamento e reembolso
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Quando um pedido já pago é recusado pela clínica, o sistema
            registra o cancelamento do pedido e inicia o fluxo de
            reembolso junto ao gateway de pagamento.
        </p>

        <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-5">

            <h3 class="font-semibold text-red-800">
                Pedido recusado pela clínica
            </h3>

            <p class="mt-2 text-sm leading-6 text-red-700">
                O pedido passa para o status de cancelamento pela clínica e
                o pagamento é encaminhado para reembolso conforme as regras
                do meio de pagamento utilizado.
            </p>

        </div>

    </div>


    {{-- CLÍNICAS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Clínicas
        </h2>

        <div class="mt-6 space-y-4">

            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Aprovação dos pedidos
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    A clínica é responsável por analisar os pedidos recebidos
                    e informar se poderá realizar o atendimento.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Dados financeiros
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Cada clínica possui informações financeiras utilizadas
                    para determinar o percentual correspondente ao repasse
                    dos pedidos.
                </p>

            </div>

        </div>

    </div>


    {{-- FINANCEIRO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Repasse financeiro
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O sistema calcula o valor destinado à clínica utilizando o
            percentual de repasse configurado para ela.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <h3 class="font-semibold text-blumine-800">
                Exemplo
            </h3>

            <div class="mt-3 space-y-2 text-sm text-blumine-700">

                <div class="flex justify-between gap-4">
                    <span>Valor do pedido</span>
                    <strong>R$ 48,00</strong>
                </div>

                <div class="flex justify-between gap-4">
                    <span>Percentual da clínica</span>
                    <strong>75%</strong>
                </div>

                <div class="border-t border-blumine-200 pt-2">

                    <div class="flex justify-between gap-4 font-semibold">
                        <span>Valor calculado para a clínica</span>
                        <strong>R$ 36,00</strong>
                    </div>

                </div>

            </div>

        </div>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O controle financeiro permite registrar quando o valor foi
            efetivamente repassado à clínica.
        </p>

    </div>


    {{-- CARRINHO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Carrinho de compras
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O carrinho é utilizado somente durante o processo de compra e não
            funciona como uma lista permanente de produtos salvos pelo cliente.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <h3 class="font-semibold text-blumine-800">
                Expiração
            </h3>

            <p class="mt-2 text-sm leading-6 text-blumine-700">
                Após 10 minutos sem conclusão da compra, a reserva dos
                horários é liberada e a quote correspondente é removida.
            </p>

        </div>

    </div>


    {{-- PRODUTOS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Exames e catálogo
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os exames disponíveis no Marketplace são administrados através
            do catálogo do sistema e podem ser relacionados às clínicas que
            oferecem o respectivo serviço.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As informações cadastradas no catálogo são utilizadas para
            apresentar os serviços aos clientes durante a navegação e o
            processo de compra.
        </p>

    </div>


    {{-- ROTINAS AUTOMÁTICAS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Rotinas automáticas
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Algumas tarefas do sistema são executadas automaticamente para
            manter os dados e os horários atualizados.
        </p>

        <div class="mt-6 space-y-4">

            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Expiração de carrinhos
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Quotes que permanecem inativas por mais de 10 minutos são
                    removidas e os horários reservados são liberados.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Encerramento de horários vencidos
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Horários de atendimento que já passaram são encerrados
                    automaticamente para impedir novas reservas.
                </p>

            </div>

        </div>

    </div>


    {{-- RESUMO --}}
    <div class="mt-6 rounded-xl border border-blumine-200 bg-blumine-50 p-6">

        <h2 class="text-xl font-semibold text-blumine-800">
            Principais regras
        </h2>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-white p-4 shadow-sm">

                <p class="text-2xl font-bold text-blumine-700">
                    10 min
                </p>

                <p class="mt-1 text-sm text-slate-600">
                    Tempo de reserva do horário no carrinho.
                </p>

            </div>


            <div class="rounded-lg bg-white p-4 shadow-sm">

                <p class="text-sm font-semibold text-blumine-800">
                    1 horário
                </p>

                <p class="mt-1 text-sm text-slate-600">
                    Um horário ocupado não pode ser vendido novamente.
                </p>

            </div>


            <div class="rounded-lg bg-white p-4 shadow-sm">

                <p class="text-sm font-semibold text-blumine-800">
                    Aprovação da clínica
                </p>

                <p class="mt-1 text-sm text-slate-600">
                    O pagamento aprovado não substitui a aprovação da clínica.
                </p>

            </div>


            <div class="rounded-lg bg-white p-4 shadow-sm">

                <p class="text-sm font-semibold text-blumine-800">
                    Recusa
                </p>

                <p class="mt-1 text-sm text-slate-600">
                    Pedido recusado pela clínica segue para cancelamento e
                    reembolso do pagamento.
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
                    Importante
                </h3>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    As regras apresentadas nesta seção representam o
                    funcionamento definido para a versão atual do Examex.
                    Alterações futuras nas regras de negócio podem modificar
                    esse comportamento.
                </p>

            </div>

        </div>

    </div>

</section>
