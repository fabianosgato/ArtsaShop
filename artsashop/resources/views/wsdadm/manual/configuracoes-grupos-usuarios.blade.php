{{-- configuracoes de grupos de usuarios --}}
<section id="configuracoes-grupos-usuarios" class="scroll-mt-24">

    {{-- TÍTULO --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-2xl font-semibold text-blumine-800">
            Configurações → Grupos de Usuários
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os grupos de usuários são utilizados para definir quais
            funcionalidades do WsdAdmin estarão disponíveis para cada
            usuário do sistema.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Em vez de configurar as permissões individualmente para cada
            usuário, o sistema permite criar grupos com diferentes níveis
            de acesso e posteriormente associar os usuários ao grupo
            correspondente.
        </p>

    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Visão geral
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A tela de Grupos de Usuários apresenta os grupos cadastrados
            no sistema e permite consultar, alterar ou administrar suas
            configurações.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Grupo
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Nome utilizado para identificar o conjunto de
                    permissões. O nome deve representar a finalidade
                    daquele grupo dentro do sistema.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Ativo
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Indica se o grupo está habilitado para utilização
                    no sistema.
                </p>

            </div>

        </div>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/configuracoes/configuracoes-grupos-usuarios.png') }}"
                alt="Listagem de grupos de usuários do WsdAdmin"
                class="w-full"
            >

        </div>

    </div>


    {{-- CADASTRO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Cadastro de um grupo
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Para criar um novo grupo, utilize a opção
            <strong>Inserir</strong> disponível na parte superior da
            tela de Grupos de Usuários.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Após informar os dados básicos do grupo, devem ser definidas
            as permissões que estarão disponíveis para os usuários
            associados a ele.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <p class="text-sm leading-6 text-blumine-700">
                Recomenda-se criar grupos de acordo com as funções
                desempenhadas pelos usuários. Dessa forma, cada grupo
                recebe somente as permissões necessárias para executar
                suas atividades.
            </p>

        </div>

    </div>


    {{-- PERMISSÕES --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Permissões do grupo
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A guia <strong>Permissões do Grupo</strong> permite definir
            exatamente quais recursos do WsdAdmin poderão ser acessados
            pelos usuários pertencentes ao grupo.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As permissões são organizadas por módulo. Dentro de cada
            módulo são apresentados os recursos disponíveis e as ações
            que podem ser autorizadas.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/configuracoes/configuracoes-grupos-usuarios-permissions.png') }}"
                alt="Permissões dos grupos de usuários do WsdAdmin"
                class="w-full"
            >

        </div>

    </div>


    {{-- TIPOS DE PERMISSÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Tipos de permissão
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Cada recurso pode possuir diferentes níveis de permissão.
            As opções disponíveis na tela são:
        </p>

        <div class="mt-6 space-y-4">

            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Visualizar
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Permite que o usuário acesse e visualize o recurso
                    correspondente dentro do WsdAdmin.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Informações
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Permite acessar as informações ou detalhes
                    disponibilizados pelo recurso.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Alterar
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Permite modificar informações existentes no recurso.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Excluir
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Permite excluir registros relacionados ao recurso,
                    quando essa operação estiver disponível.
                </p>

            </div>

        </div>

    </div>


    {{-- MARCAR TODOS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Marcar todos
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A opção <strong>Marcar Todos</strong> permite selecionar
            rapidamente todas as permissões disponíveis para determinado
            recurso ou módulo.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Essa opção deve ser utilizada com atenção, principalmente
            em grupos que não possuem função administrativa, pois pode
            conceder permissões além das necessárias para a atividade
            do usuário.
        </p>

    </div>


    {{-- ORGANIZAÇÃO DOS MÓDULOS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Organização das permissões
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As permissões são agrupadas conforme os módulos do WsdAdmin.
            Na configuração apresentada, por exemplo, existem módulos
            relacionados a <strong>Configurações</strong>,
            <strong>Catálogo</strong> e <strong>Marketplace</strong>.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Cada módulo possui seus próprios recursos. Dessa forma, é
            possível permitir que um grupo tenha acesso a determinadas
            áreas do sistema sem necessariamente conceder acesso a todas
            as funcionalidades administrativas.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-3">

            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Configurações
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Reúne recursos administrativos relacionados à
                    configuração e gerenciamento do sistema.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Catálogo
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Reúne os recursos relacionados ao gerenciamento
                    dos exames e categorias.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Marketplace
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Reúne os recursos relacionados às clínicas,
                    pedidos e demais operações do Marketplace.
                </p>

            </div>

        </div>

    </div>


    {{-- UTILIZAÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Utilização dos grupos
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Depois de configurado, o grupo pode ser associado aos usuários
            do sistema. Todos os usuários associados ao grupo passarão a
            utilizar as permissões definidas para ele.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Isso permite criar diferentes perfis de acesso, por exemplo,
            separando usuários responsáveis pelo cadastro, usuários
            responsáveis pelas vendas e usuários com acesso administrativo.
        </p>

    </div>


    {{-- ALTERAÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Alteração das permissões
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As permissões de um grupo podem ser alteradas sempre que
            houver necessidade de modificar o nível de acesso dos
            usuários associados a ele.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Ao salvar uma alteração nas permissões, os usuários
            pertencentes ao grupo passam a utilizar a configuração
            atualizada.
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
                    As permissões determinam o que cada usuário poderá
                    acessar, alterar ou excluir dentro do WsdAdmin.
                    Recomenda-se conceder somente as permissões necessárias
                    para a função desempenhada pelo usuário.
                </p>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    Permissões de <strong>Alterar</strong> e principalmente
                    <strong>Excluir</strong> devem ser concedidas com
                    atenção, pois permitem modificar ou remover dados
                    existentes no sistema.
                </p>

            </div>

        </div>

    </div>

</section>
