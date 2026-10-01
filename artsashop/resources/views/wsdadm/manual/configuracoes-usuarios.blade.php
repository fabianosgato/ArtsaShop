{{-- Configuração:Usuarios --}}
<section id="configuracoes-usuarios" class="scroll-mt-24">

    {{-- TÍTULO --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-2xl font-semibold text-blumine-800">
            Configurações → Usuários
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A área de Usuários permite administrar as pessoas que possuem
            acesso ao painel administrativo do Examex.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Cada usuário possui suas próprias credenciais de acesso e está
            associado a um grupo de usuários, que determina quais recursos
            e funcionalidades estarão disponíveis no WsdAdmin.
        </p>

    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Visão geral
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A listagem de usuários apresenta as contas cadastradas no
            sistema e permite consultar rapidamente as principais
            informações de cada acesso.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Nome do usuário
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Identifica a pessoa ou conta responsável pelo acesso
                    ao painel administrativo.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Grupo
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Indica o grupo de usuários ao qual a conta está
                    associada. O grupo determina as permissões disponíveis
                    para aquele usuário.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    E-mail do usuário
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Endereço de e-mail utilizado como identificação do
                    usuário para acesso ao sistema.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Ativo
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Indica se o usuário está habilitado para acessar o
                    WsdAdmin.
                </p>

            </div>

        </div>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/configuracoes/configuracoes-usuarios.png') }}"
                alt="Listagem de usuários do WsdAdmin"
                class="w-full"
            >

        </div>

    </div>


    {{-- CADASTRO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Cadastro de usuários
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Para cadastrar um novo usuário, utilize a opção
            <strong>Inserir</strong> disponível na parte superior da
            listagem.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Durante o cadastro, o usuário deve ser associado a um grupo
            de usuários. Essa associação é importante porque as permissões
            de acesso são determinadas pelo grupo ao qual o usuário
            pertence.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <p class="text-sm leading-6 text-blumine-700">
                Antes de criar um usuário, verifique qual grupo de usuários
                deverá ser associado à conta. Evite conceder permissões
                administrativas quando elas não forem necessárias para a
                atividade do usuário.
            </p>

        </div>

    </div>


    {{-- GRUPO DE USUÁRIOS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Grupos de usuários
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os grupos de usuários são utilizados para organizar as
            permissões de acesso do WsdAdmin.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Dessa forma, as permissões não precisam ser configuradas
            individualmente para cada usuário. O usuário recebe as
            permissões definidas para o grupo ao qual está associado.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Para alterar o nível de acesso de um usuário, normalmente é
            suficiente alterar o grupo ao qual ele pertence ou ajustar as
            permissões desse grupo.
        </p>

    </div>


    {{-- ATIVAÇÃO E DESATIVAÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Ativação e desativação
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O usuário pode ser habilitado ou desabilitado de acordo com a
            necessidade de acesso ao sistema.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Quando um usuário está desabilitado, sua conta permanece
            cadastrada no sistema, mas o acesso ao WsdAdmin fica
            indisponível.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Essa opção é recomendada quando o acesso de uma pessoa precisa
            ser temporariamente ou permanentemente interrompido sem a
            necessidade de remover o cadastro.
        </p>

    </div>


    {{-- EDIÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Alteração de usuários
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os usuários cadastrados podem ser consultados e alterados
            através das ações disponíveis na listagem.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Ao alterar o grupo de um usuário, suas permissões de acesso
            podem ser modificadas de acordo com as permissões configuradas
            para o novo grupo.
        </p>

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
                    O acesso ao WsdAdmin deve ser concedido somente às
                    pessoas que realmente necessitam utilizar o painel
                    administrativo.
                </p>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    A associação do usuário a um grupo determina seu nível
                    de acesso. Por isso, recomenda-se verificar as permissões
                    do grupo antes de associá-lo a um novo usuário.
                </p>

            </div>

        </div>

    </div>

</section>
