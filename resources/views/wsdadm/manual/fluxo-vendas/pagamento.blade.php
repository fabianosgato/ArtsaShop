<section id="fluxo-pagamento" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">

        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            Fluxo de vendas
        </span>

        <h2 class="mt-2 text-2xl font-bold tracking-tight text-blumine-800">
            Pagamento
        </h2>

        <p class="mt-4 text-base leading-7 text-slate-600">
            O pagamento é realizado durante o checkout, após a seleção do
            exame, da clínica e do horário desejado pelo cliente.
        </p>

        <p class="mt-4 text-base leading-7 text-slate-600">
            Atualmente, o Examex disponibiliza duas formas de pagamento:
            <strong>PIX</strong> e <strong>cartão de crédito</strong>.
        </p>

    </div>


    {{-- FORMAS DE PAGAMENTO --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Formas de pagamento
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As formas de pagamento disponíveis são apresentadas diretamente
            no checkout e o cliente deve selecionar uma delas para concluir
            a compra.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            {{-- PIX --}}
            <div class="rounded-lg border border-slate-200 bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    PIX
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    O pagamento por PIX permite a confirmação do pagamento
                    de forma rápida e é uma das formas de pagamento
                    disponíveis para a conclusão do pedido.
                </p>

                <div class="mt-4 rounded-lg border border-blumine-100 bg-blumine-50 p-4">

                    <p class="text-sm leading-6 text-blumine-700">
                        O PIX pode possuir desconto aplicado automaticamente
                        conforme as regras configuradas para o pagamento.
                    </p>

                </div>

            </div>


            {{-- CARTÃO --}}
            <div class="rounded-lg border border-slate-200 bg-slate-50 p-5">

                <h4 class="font-semibold text-blumine-800">
                    Cartão de crédito
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    O cliente pode realizar o pagamento utilizando cartão
                    de crédito através da integração de pagamento do
                    Examex.
                </p>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    O pagamento pode passar por uma etapa adicional de
                    autenticação, quando exigida pelo emissor do cartão.
                </p>

            </div>

        </div>

    </div>


    {{-- PIX --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Pagamento via PIX
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Ao selecionar o PIX no checkout, o sistema apresenta as
            informações necessárias para que o cliente realize o pagamento.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Após a realização do pagamento, o sistema acompanha a situação
            da transação para identificar a confirmação do pagamento.
        </p>

        <div class="mt-6 rounded-lg border border-blue-200 bg-blue-50 p-5">

            <h4 class="font-semibold text-blue-800">
                Atenção
            </h4>

            <p class="mt-2 text-sm leading-6 text-blue-700">
                O cliente deve realizar o pagamento utilizando uma conta
                bancária de sua titularidade, conforme as orientações
                apresentadas no checkout.
            </p>

        </div>

    </div>


    {{-- CARTÃO DE CRÉDITO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Pagamento com cartão de crédito
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O pagamento com cartão de crédito é processado através do
            gateway de pagamento integrado ao Examex.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Dependendo da análise de segurança da transação, o cliente
            poderá ser direcionado para uma etapa de autenticação adicional
            antes da conclusão do pagamento.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-3">

            <div class="rounded-lg bg-slate-50 p-4">

                <h4 class="font-semibold text-blumine-800">
                    Pagamento aprovado
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    A transação é aprovada e o pedido segue para as próximas
                    etapas do fluxo.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h4 class="font-semibold text-blumine-800">
                    Autenticação
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Quando necessário, o cliente realiza a autenticação
                    adicional solicitada pelo emissor do cartão.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h4 class="font-semibold text-blumine-800">
                    Pagamento recusado
                </h4>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Quando a transação não é aprovada, o cliente deve
                    utilizar outra forma de pagamento ou tentar novamente,
                    conforme as opções disponibilizadas pelo checkout.
                </p>

            </div>

        </div>

    </div>


    {{-- BOLETO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Boleto bancário
        </h3>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O pagamento via boleto bancário não está disponível no Examex.
        </p>

        <div class="mt-6 rounded-lg border border-amber-200 bg-amber-50 p-5">

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

                    <h4 class="font-semibold text-amber-800">
                        Por que o boleto não está disponível?
                    </h4>

                    <p class="mt-2 text-sm leading-6 text-amber-700">
                        A decisão está relacionada ao funcionamento do
                        agendamento de exames, e não a uma limitação técnica
                        do sistema.
                    </p>

                    <p class="mt-2 text-sm leading-6 text-amber-700">
                        Como o cliente pode realizar uma compra para uma
                        data próxima, o prazo necessário para pagamento e
                        compensação de um boleto pode não ser compatível
                        com a data do exame agendado.
                    </p>

                    <p class="mt-2 text-sm leading-6 text-amber-700">
                        Por esse motivo, o fluxo do Examex foi definido para
                        utilizar formas de pagamento com confirmação mais
                        adequada à dinâmica dos agendamentos.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- FLUXO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h3 class="text-xl font-semibold text-blumine-800">
            Fluxo do pagamento
        </h3>

        <div class="mt-6 space-y-4">

            <div class="flex gap-4">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blumine-700 text-sm font-semibold text-white">
                    1
                </div>

                <div>

                    <h4 class="font-semibold text-blumine-800">
                        Seleção da forma de pagamento
                    </h4>

                    <p class="mt-1 text-sm leading-6 text-slate-600">
                        O cliente escolhe PIX ou cartão de crédito no
                        checkout.
                    </p>

                </div>

            </div>


            <div class="flex gap-4">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blumine-700 text-sm font-semibold text-white">
                    2
                </div>

                <div>

                    <h4 class="font-semibold text-blumine-800">
                        Processamento
                    </h4>

                    <p class="mt-1 text-sm leading-6 text-slate-600">
                        O pagamento é enviado para processamento através
                        do gateway integrado ao Examex.
                    </p>

                </div>

            </div>


            <div class="flex gap-4">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blumine-700 text-sm font-semibold text-white">
                    3
                </div>

                <div>

                    <h4 class="font-semibold text-blumine-800">
                        Confirmação
                    </h4>

                    <p class="mt-1 text-sm leading-6 text-slate-600">
                        Após a confirmação do pagamento, o pedido segue
                        para as próximas etapas do fluxo de vendas.
                    </p>

                </div>

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
                    A confirmação do pagamento não representa, por si só,
                    a aprovação do exame pela clínica. Após o pagamento,
                    o pedido segue o fluxo definido pelo Examex até a
                    conclusão do atendimento.
                </p>

            </div>

        </div>

    </div>

</section>
