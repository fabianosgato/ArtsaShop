<section id="configuracoes-status-produtos" class="scroll-mt-24">

    {{-- TÍTULO --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-2xl font-semibold text-blumine-800">
            Configurações → Status de Produtos
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os status de produtos identificam a situação de um exame dentro
            do sistema e permitem que diferentes etapas do processamento
            sejam representadas de forma padronizada.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os status são utilizados internamente pelo sistema para controlar
            a disponibilidade e o processamento dos exames.
        </p>

    </div>


    {{-- LISTAGEM --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Status cadastrados
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A tela apresenta os status disponíveis no sistema, juntamente
            com suas respectivas chaves de identificação.
        </p>

        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/configuracoes/configuracoes-status-produtos.png') }}"
                alt="Status de produtos do WsdAdmin"
                class="w-full"
            >

        </div>

    </div>


    {{-- CAMPOS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Informações do status
        </h2>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Nome do status
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Nome apresentado no WsdAdmin para identificar a situação
                    do exame ou produto.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Key Status
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Chave utilizada internamente pelo sistema para identificar
                    o status nas regras e processos da aplicação.
                </p>

            </div>

        </div>

    </div>


    {{-- IMPORTANTE --}}
    <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-6">

        <div class="flex gap-3">

            <svg
                class="mt-0.5 h-5 w-5 shrink-0 text-amber-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 9v3.75m0 3.75h.008v.008H12V16.5ZM10.29 3.86 2.82 17.25A1.5 1.5 0 0 0 4.13 19.5h15.74a1.5 1.5 0 0 0 1.31-2.25L13.71 3.86a1.95 1.95 0 0 0-3.42 0Z"
                />
            </svg>

            <div>

                <h3 class="font-semibold text-amber-800">
                    Importante
                </h3>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    Os status e suas respectivas chaves são utilizados pelos
                    processos internos do sistema. Recomenda-se não alterar
                    ou excluir status que já estejam sendo utilizados pela
                    aplicação.
                </p>

            </div>

        </div>

    </div>

</section>
