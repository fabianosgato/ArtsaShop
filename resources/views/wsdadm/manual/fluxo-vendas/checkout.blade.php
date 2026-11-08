<section id="fluxo-checkout" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">

        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            Fluxo de vendas
        </span>

        <h2 class="mt-2 text-2xl font-bold tracking-tight text-blumine-800">
            Checkout
        </h2>

        <p class="mt-4 text-base leading-7 text-slate-600">
            O checkout é a etapa em que o cliente confirma os dados da
            compra, informa seus dados pessoais, seleciona a forma de
            pagamento e aceita os termos necessários para concluir o pedido.
        </p>

    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Visão geral
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Ao acessar o checkout, o cliente encontra um resumo do exame
            selecionado, da clínica e do horário escolhido, além dos dados
            necessários para concluir a compra.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O checkout também apresenta o valor da compra e os descontos
            aplicáveis à forma de pagamento selecionada.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/fluxo-vendas/checkout.png') }}"
                alt="Checkout do Marketplace Examex"
                class="w-full"
            >

        </div>

    </div>


    {{-- AGENDA --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Agenda reservada
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            No início do checkout, o cliente pode visualizar os dados do
            agendamento realizado, incluindo a clínica, o horário e o exame
            selecionado.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O sistema mantém o horário reservado temporariamente enquanto
            o cliente conclui a compra.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <h4 class="font-semibold text-blumine-800">
                Prazo da reserva
            </h4>

            <p class="mt-2 text-sm leading-6 text-blumine-700">
                A agenda permanece reservada por até
                <strong>10 minutos</strong>.
                O cliente deve concluir o processo dentro desse período
                para manter o horário selecionado.
            </p>

        </div>

    </div>


    {{-- DADOS DO PACIENTE --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Dados do paciente
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O cliente deve informar os dados necessários para identificação
            e comunicação relacionados à compra.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    Nome completo
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Nome completo do paciente responsável pela compra.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    CPF
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Documento utilizado para identificação do responsável
                    pela compra.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    WhatsApp
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Número utilizado para comunicação com o cliente,
                    quando necessário.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    E-mail
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Endereço utilizado para comunicação e envio das
                    informações relacionadas ao pedido.
                </p>

            </div>

        </div>

    </div>


    {{-- RESUMO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Resumo da compra
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O resumo apresenta as principais informações financeiras da
            compra antes da confirmação do pedido.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    Valor do exame
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Apresenta o valor correspondente ao exame selecionado.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    Total da compra
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Apresenta o valor final que será utilizado para a
                    conclusão do pagamento.
                </p>

            </div>

        </div>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <h4 class="font-semibold text-blumine-800">
                Descontos
            </h4>

            <p class="mt-2 text-sm leading-6 text-blumine-700">
                Quando uma regra de desconto estiver disponível para a forma
                de pagamento escolhida, o valor do desconto é apresentado
                no resumo e aplicado ao total da compra.
            </p>

        </div>

    </div>


    {{-- PAGAMENTO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Escolha da forma de pagamento
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O cliente deve selecionar uma das formas de pagamento
            disponibilizadas pelo Marketplace.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    PIX
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Permite realizar o pagamento através de PIX e pode
                    oferecer desconto conforme as regras configuradas
                    no sistema.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    Cartão de crédito
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Permite realizar o pagamento utilizando cartão de
                    crédito através do gateway de pagamento integrado
                    ao Marketplace.
                </p>

            </div>

        </div>

    </div>


    {{-- INFORMAÇÕES DO PIX --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Informações importantes sobre o PIX
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Ao selecionar o PIX, o checkout apresenta as orientações
            necessárias para que o cliente realize o pagamento corretamente.
        </p>

        <div class="mt-6 rounded-lg border border-blue-200 bg-blue-50 p-5">

            <h4 class="font-semibold text-blue-800">
                Orientações para pagamento
            </h4>

            <ul class="mt-3 list-disc space-y-2 pl-5 text-sm leading-6 text-blue-700">

                <li>
                    O pagamento deve ser realizado por uma conta bancária
                    de titularidade do cliente.
                </li>

                <li>
                    O CPF informado no checkout será utilizado como
                    responsável legal pela compra.
                </li>

            </ul>

        </div>

    </div>


    {{-- TERMOS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Aceite dos termos
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Antes de realizar o pagamento, o cliente deve confirmar que
            está de acordo com os termos relacionados à compra,
            cancelamento e compartilhamento dos dados necessários com a
            clínica.
        </p>

        <div class="mt-6 rounded-lg border border-slate-200 bg-slate-50 p-5">

            <p class="text-sm leading-6 text-slate-600">
                O pagamento somente pode ser confirmado após o aceite
                dos termos apresentados no checkout.
            </p>

        </div>

    </div>


    {{-- FINALIZAÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Pagamento e confirmação
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Após preencher os dados, selecionar a forma de pagamento e
            aceitar os termos, o cliente pode utilizar a opção
            <strong>Pagar e confirmar</strong> para iniciar a conclusão
            da compra.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A partir desse momento, o sistema inicia o processamento do
            pagamento e o pedido passa para as próximas etapas do fluxo
            de vendas.
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
                    O horário selecionado permanece reservado por apenas
                    10 minutos durante o processo de compra. Caso o cliente
                    não conclua a compra dentro desse período, o sistema
                    poderá liberar o horário novamente.
                </p>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    A conclusão do checkout inicia o processamento do
                    pagamento. A confirmação definitiva do pedido depende
                    do resultado desse processamento e das etapas seguintes
                    do fluxo de vendas.
                </p>

            </div>

        </div>

    </div>

</section>
