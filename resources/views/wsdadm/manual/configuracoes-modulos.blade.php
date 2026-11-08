<section id="configuracoes-modulos" class="scroll-mt-24">

    {{-- TÍTULO --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-2xl font-semibold text-blumine-800">
            Configurações → Módulos do Sistema
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os módulos do sistema são utilizados para organizar as
            funcionalidades do WsdAdmin e controlar sua disponibilidade
            nas permissões dos grupos de usuários.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Essa tela permite consultar os módulos existentes, sua ordem
            de apresentação e seu status de funcionamento.
        </p>

    </div>


    {{-- LISTAGEM --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Módulos disponíveis
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A listagem apresenta os módulos atualmente configurados no
            sistema, como <strong>Marketplace</strong>,
            <strong>Catálogo</strong>, <strong>Atributos</strong>,
            <strong>CMS</strong> e <strong>Configurações</strong>.
        </p>

        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/configuracoes/configuracoes-modulos.png') }}"
                alt="Módulos do sistema no WsdAdmin"
                class="w-full"
            >

        </div>

    </div>


    {{-- CAMPOS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Informações do módulo
        </h2>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Módulo
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Identifica a área funcional do sistema à qual as
                    permissões estão relacionadas.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Ordenação
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Define a ordem utilizada para organizar os módulos
                    dentro do sistema.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Ativo
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Indica se o módulo está habilitado no sistema.
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
                    Os módulos disponíveis nesta tela fazem parte da
                    estrutura interna do WsdAdmin e são utilizados
                    principalmente para organização e controle das
                    permissões dos grupos de usuários.
                </p>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    A inclusão de um novo módulo nesta tela
                    <strong>não cria uma nova funcionalidade no sistema</strong>.
                    Novas funcionalidades dependem de desenvolvimento
                    específico e da implementação correspondente no sistema.
                </p>

            </div>

        </div>

    </div>

</section>
