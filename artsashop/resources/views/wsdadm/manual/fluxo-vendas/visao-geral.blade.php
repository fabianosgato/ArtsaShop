<section id="fluxo-vendas-principal" class="scroll-mt-24">

    {{-- APROVAÇÃO --}}
    <div class="mt-6 rounded-xl border border-emerald-200 bg-white p-6 shadow-sm">

        <div class="flex items-start gap-4">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-100 font-semibold text-emerald-700">
                ✓
            </div>

            <div>

                <h2 class="text-xl font-semibold text-emerald-800">
                    Clínica aprova o pedido
                </h2>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Quando a clínica aprova o pedido, o atendimento é
                    confirmado e o pedido segue seu fluxo normal de
                    processamento.
                </p>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    O cliente recebe a comunicação correspondente à aprovação
                    do pedido.
                </p>

            </div>

        </div>

    </div>


    {{-- RECUSA --}}
    <div class="mt-6 rounded-xl border border-red-200 bg-white p-6 shadow-sm">

        <div class="flex items-start gap-4">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100 font-semibold text-red-700">
                ×
            </div>

            <div>

                <h2 class="text-xl font-semibold text-red-800">
                    Clínica recusa o pedido
                </h2>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Caso a clínica não possa realizar o atendimento, o pedido
                    é recusado.
                </p>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Quando o pagamento já foi realizado, o sistema realiza o
                    cancelamento do pagamento junto ao meio de pagamento
                    utilizado.
                </p>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    O cliente também recebe uma comunicação informando que o
                    pedido foi recusado pela clínica.
                </p>

            </div>

        </div>

    </div>


    {{-- PAGAMENTO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Fluxo do pagamento
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O pagamento é processado antes da aprovação da clínica. Dessa
            forma, quando a clínica recebe o pedido, o pagamento já possui
            sua situação registrada no sistema.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-5">

                <h3 class="font-semibold text-emerald-800">
                    Pagamento aprovado
                </h3>

                <p class="mt-2 text-sm leading-6 text-emerald-700">
                    O pedido pode seguir para análise e aprovação da clínica.
                </p>

            </div>


            <div class="rounded-lg border border-red-200 bg-red-50 p-5">

                <h3 class="font-semibold text-red-800">
                    Pagamento não aprovado
                </h3>

                <p class="mt-2 text-sm leading-6 text-red-700">
                    O pedido não prossegue para a etapa de aprovação da
                    clínica enquanto o pagamento não for confirmado.
                </p>

            </div>

        </div>

    </div>


    {{-- ESTORNO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Cancelamento e reembolso
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Quando um pedido é recusado pela clínica depois que o pagamento
            já foi confirmado, o sistema realiza o cancelamento do pagamento
            através do meio de pagamento utilizado.
        </p>

        <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-5">

            <h3 class="font-semibold text-red-800">
                Recusa pela clínica
            </h3>

            <p class="mt-2 text-sm leading-6 text-red-700">
                O pedido é marcado como cancelado pela clínica e o valor
                pago pelo cliente é encaminhado para reembolso através do
                meio de pagamento correspondente.
            </p>

        </div>

    </div>


    {{-- COMUNICAÇÕES --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Comunicação por e-mail
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O sistema envia mensagens por e-mail em momentos importantes do
            fluxo do pedido.
        </p>

        <div class="mt-6 space-y-3">

            <div class="flex items-start gap-3 rounded-lg bg-slate-50 p-4">

                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blumine-100 text-sm font-semibold text-blumine-700">
                    1
                </span>

                <div>

                    <h3 class="font-semibold text-blumine-800">
                        Pedido aprovado
                    </h3>

                    <p class="mt-1 text-sm leading-6 text-slate-600">
                        O cliente recebe a confirmação da aprovação do pedido
                        pela clínica.
                    </p>

                </div>

            </div>


            <div class="flex items-start gap-3 rounded-lg bg-slate-50 p-4">

                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blumine-100 text-sm font-semibold text-blumine-700">
                    2
                </span>

                <div>

                    <h3 class="font-semibold text-blumine-800">
                        Novo pedido para a clínica
                    </h3>

                    <p class="mt-1 text-sm leading-6 text-slate-600">
                        A clínica é comunicada quando possui um novo pedido
                        aguardando aprovação.
                    </p>

                </div>

            </div>


            <div class="flex items-start gap-3 rounded-lg bg-slate-50 p-4">

                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blumine-100 text-sm font-semibold text-blumine-700">
                    3
                </span>

                <div>

                    <h3 class="font-semibold text-blumine-800">
                        Pedido recusado
                    </h3>

                    <p class="mt-1 text-sm leading-6 text-slate-600">
                        O cliente recebe a comunicação correspondente à
                        recusa do pedido pela clínica.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- RESUMO --}}
    <div class="mt-6 rounded-xl border border-blumine-200 bg-blumine-50 p-6">

        <h2 class="text-xl font-semibold text-blumine-800">
            Resumo do fluxo
        </h2>

        <div class="mt-6 flex flex-col items-center gap-3 text-center">

            <div class="w-full max-w-md rounded-lg border border-blumine-200 bg-white p-4 shadow-sm">

                <p class="font-semibold text-blumine-800">
                    Cliente realiza a compra
                </p>

            </div>

            <div class="text-blumine-500">
                ↓
            </div>

            <div class="w-full max-w-md rounded-lg border border-blumine-200 bg-white p-4 shadow-sm">

                <p class="font-semibold text-blumine-800">
                    Pagamento confirmado
                </p>

            </div>

            <div class="text-blumine-500">
                ↓
            </div>

            <div class="w-full max-w-md rounded-lg border border-amber-200 bg-amber-50 p-4 shadow-sm">

                <p class="font-semibold text-amber-800">
                    Aguardando aprovação da clínica
                </p>

            </div>

            <div class="flex w-full max-w-md flex-col items-center gap-3 sm:flex-row">

                <div class="flex-1">

                    <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4">

                        <p class="font-semibold text-emerald-800">
                            Aprovado
                        </p>

                        <p class="mt-1 text-xs text-emerald-700">
                            Pedido segue para atendimento
                        </p>

                    </div>

                </div>

                <div class="text-slate-400">
                    ou
                </div>

                <div class="flex-1">

                    <div class="rounded-lg border border-red-200 bg-red-50 p-4">

                        <p class="font-semibold text-red-800">
                            Recusado
                        </p>

                        <p class="mt-1 text-xs text-red-700">
                            Pedido cancelado e pagamento reembolsado
                        </p>

                    </div>

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
                    A aprovação da clínica é uma etapa importante do processo.
                    O pagamento confirmado não significa que o atendimento
                    já tenha sido aprovado pela clínica.
                </p>

            </div>

        </div>

    </div>

</section>
