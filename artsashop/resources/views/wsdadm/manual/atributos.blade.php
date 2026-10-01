<section id="atributos" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">

        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            Atributos
        </span>

        <h1 class="mt-2 text-3xl font-bold tracking-tight text-blumine-800">
            Grupos de atributos
        </h1>

        <p class="mt-4 text-base leading-7 text-slate-600">
            A área de Atributos permite administrar os grupos e informações
            adicionais utilizados pelos exames cadastrados no Examex.
        </p>

    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Visão geral
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O módulo de Atributos é uma das partes mais importantes do Examex.
            Ele é responsável por definir a estrutura das informações utilizadas
            nos exames e serve como base para a organização do catálogo do
            Marketplace.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Além de controlar as informações específicas dos exames, os atributos
            também são utilizados pelo sistema para construir os filtros
            disponíveis no Marketplace. Dessa forma, a configuração dos atributos
            influencia diretamente a forma como os clientes podem localizar e
            filtrar os exames disponíveis.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As categorias dos exames também são criadas a partir dos Grupos de
            Atributos. Por esse motivo, a estrutura definida nesta área é
            fundamental para o funcionamento correto do catálogo, das categorias
            e das buscas realizadas pelos clientes.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/atributos/listagem.png') }}"
                alt="Lista de grupos de atributos do Examex"
                class="w-full"
            >

        </div>

    </div>

    <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-6">

        <div class="flex gap-3">

            <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.8"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 9v3.75m0 3.75h.008v.008H12V16.5ZM10.29 3.86 2.82 17.25a1.5 1.5 0 0 0 1.31 2.25h15.74a1.5 1.5 0 0 0 1.31-2.25L13.71 3.86a1.95 1.95 0 0 0-3.42 0Z" />

            </svg>

            <div>

                <h3 class="font-semibold text-amber-800">
                    Módulo fundamental para o funcionamento do Marketplace
                </h3>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    A alteração da estrutura dos Grupos de Atributos pode afetar
                    o cadastro dos exames, as categorias e os filtros utilizados
                    nas buscas do Marketplace. Recomenda-se não alterar ou remover
                    estruturas já utilizadas sem orientação técnica.
                </p>

            </div>

        </div>

    </div>


    {{-- GRUPOS DE ATRIBUTOS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Grupos de atributos
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Um grupo de atributos reúne um conjunto de informações que podem
            ser utilizadas em conjunto nos exames.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A utilização de grupos facilita a padronização das informações
            cadastradas e evita a necessidade de configurar individualmente
            a mesma estrutura para diferentes exames.
        </p>

        <div class="mt-6 rounded-lg bg-slate-50 p-5">

            <div class="flex flex-col items-center gap-3 text-sm sm:flex-row sm:justify-center">

                <div class="rounded-lg border border-slate-200 bg-white px-5 py-3 text-center shadow-sm">

                    <p class="font-semibold text-blumine-800">
                        Grupo de atributos
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Conjunto de informações
                    </p>

                </div>

                <svg class="hidden h-5 w-5 text-slate-400 sm:block"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.8"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>

                <div class="rounded-lg border border-slate-200 bg-white px-5 py-3 text-center shadow-sm">

                    <p class="font-semibold text-blumine-800">
                        Atributos
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Informações do exame
                    </p>

                </div>

                <svg class="hidden h-5 w-5 text-slate-400 sm:block"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.8"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>

                <div class="rounded-lg border border-slate-200 bg-white px-5 py-3 text-center shadow-sm">

                    <p class="font-semibold text-blumine-800">
                        Exame
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Produto do catálogo
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- CADASTRO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Cadastro de um grupo
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Para cadastrar um novo Grupo de Atributos, utilize a opção de
            criação disponível na tela de Atributos.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O nome do grupo deve seguir obrigatoriamente o padrão:
        </p>

        <div class="mt-4 rounded-lg border border-blumine-200 bg-blumine-50 p-5">

            <p class="text-center text-lg font-semibold text-blumine-800">
                Exame &gt; {Tipo de Exame} &gt; {Exame Final}
            </p>

        </div>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Por exemplo, para cadastrar uma nova vacina, o grupo deve seguir a
            estrutura:
        </p>

        <div class="mt-4 rounded-lg bg-slate-50 p-4">

            <p class="font-medium text-blumine-800">
                Exame &gt; Vacinas &gt; Vacina Ebola
            </p>

        </div>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os <strong>Tipos de Exame</strong> já utilizados pelo Examex foram
            previamente cadastrados e fazem parte da estrutura de organização
            dos exames e dos filtros disponíveis no Marketplace.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            É permitido criar novos <strong>Exames Finais</strong> dentro de um
            Tipo de Exame existente. Por exemplo, novos exames podem ser
            adicionados dentro de <strong>Exame &gt; Vacinas</strong> sem alterar
            a estrutura do Tipo de Exame.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/atributos/cadastro.png') }}"
                alt="Cadastro de grupo de atributos do Examex"
                class="w-full"
            >

        </div>

    </div>

    <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-6">

        <div class="flex gap-3">

            <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.8"
                 stroke="currentColor">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 9v3.75m0 3.75h.008v.008H12V16.5ZM10.29 3.86 2.82 17.25a1.5 1.5 0 0 0 1.31 2.25h15.74a1.5 1.5 0 0 0 1.31-2.25L13.71 3.86a1.95 1.95 0 0 0-3.42 0Z" />

            </svg>

            <div>

                <h3 class="font-semibold text-amber-800">
                    Não altere os Tipos de Exame
                </h3>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    Os Tipos de Exame existentes fazem parte da estrutura utilizada
                    pelos filtros e pelas buscas do Marketplace. Não altere, remova
                    ou renomeie esses níveis da estrutura sem orientação técnica.
                </p>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    Para adicionar um novo serviço ao catálogo, crie um novo
                    <strong>Exame Final</strong> dentro de um Tipo de Exame
                    existente.
                </p>

            </div>

        </div>

    </div>

    {{-- ATRIBUTOS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Configuração dos atributos
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os atributos são responsáveis por definir as informações adicionais
            que serão utilizadas no cadastro dos exames. Além de armazenar essas
            informações, eles também controlam quais dados podem ser utilizados
            nos filtros, nas pesquisas e na apresentação dos exames no Marketplace.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/atributos/edicao-atributos.png') }}"
                alt="Cadastro de grupo de atributos do Examex"
                class="w-full"
            >

        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            {{-- NOME --}}
            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Nome do atributo
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    É o nome que identifica o atributo e que será apresentado
                    ao usuário nas áreas do sistema em que essa informação for
                    utilizada.
                </p>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Esse nome também é utilizado nas buscas e nos filtros do
                    Marketplace quando o atributo estiver configurado para essas
                    finalidades.
                </p>

            </div>


            {{-- CÓDIGO --}}
            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Código do atributo
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    O código é utilizado internamente pelo sistema para identificar
                    o atributo.
                </p>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Ele é gerado automaticamente a partir do nome do atributo no
                    momento do cadastro, não sendo necessário informar esse valor
                    manualmente.
                </p>

            </div>


            {{-- SISTEMA --}}
            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Atributo de Sistema
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Quando configurado como <strong>Sim</strong>, o atributo passa
                    a ser considerado um atributo de sistema e é disponibilizado
                    automaticamente para todos os Grupos de Atributos.
                </p>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Essa configuração deve ser utilizada somente para informações
                    que realmente precisam estar presentes em todos os grupos.
                </p>

            </div>


            {{-- OBRIGATÓRIO --}}
            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Atributo Requerido
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Define se o preenchimento do atributo será obrigatório durante
                    o cadastro do exame.
                </p>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Quando configurado como <strong>Sim</strong>, o exame não
                    poderá ser salvo sem que esse atributo seja preenchido.
                </p>

            </div>


            {{-- FILTROS --}}
            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Usado nos filtros do site
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Quando configurado como <strong>Sim</strong>, o atributo pode
                    ser utilizado como filtro nas páginas de busca e listagem
                    de exames do Marketplace.
                </p>

                <p class="mt-3 text-sm leading-6 text-slate-600">
                    Nem todos os tipos de campo podem ser utilizados como filtros.
                    Consulte a seção <strong>Tipos de campo</strong> abaixo.
                </p>

            </div>


            {{-- PESQUISA --}}
            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Usado nas pesquisas do site
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Quando configurado como <strong>Sim</strong>, os valores
                    preenchidos nesse atributo também podem ser considerados pela
                    busca aberta do Marketplace.
                </p>

            </div>


            {{-- VISIBILIDADE --}}
            <div class="rounded-lg bg-slate-50 p-4 sm:col-span-2">

                <h3 class="font-semibold text-blumine-800">
                    Visível no site
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Quando configurado como <strong>Sim</strong>, o valor
                    preenchido para o atributo poderá ser apresentado na página
                    do exame no Marketplace, conforme o layout utilizado.
                </p>

            </div>

        </div>

    </div>

    {{-- IMAGEM --}}
    <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

        <img
            src="{{ asset('images/manual/atributos/edicao-atributos-options.png') }}"
            alt="Cadastro de grupo de atributos do Examex"
            class="w-full"
        >

    </div>

    {{-- TIPOS DE CAMPO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Tipos de campo
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Na guia <strong>Opções</strong> do cadastro do atributo é definido
            o tipo de campo que será utilizado para informar seu valor durante
            o cadastro dos exames.
        </p>

        <div class="mt-6 space-y-4">

            {{-- SIM NÃO --}}
            <div class="rounded-lg border border-slate-200 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Sim/Não
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Utilizado para informações que possuem apenas duas
                    possibilidades de resposta: <strong>Sim</strong> ou
                    <strong>Não</strong>.
                </p>

                <div class="mt-3 rounded-lg bg-emerald-50 p-3">

                    <p class="text-sm leading-6 text-emerald-700">
                        <strong>Pode ser utilizado como filtro.</strong>
                    </p>

                </div>

            </div>


            {{-- TEXTO --}}
            <div class="rounded-lg border border-slate-200 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Texto
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Utilizado quando o valor do atributo será informado como
                    texto em um campo de uma única linha.
                </p>

                <div class="mt-3 rounded-lg bg-slate-50 p-3">

                    <p class="text-sm leading-6 text-slate-600">
                        Não é utilizado como filtro de seleção.
                    </p>

                </div>

            </div>


            {{-- ÁREA DE TEXTO --}}
            <div class="rounded-lg border border-slate-200 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Área de Texto
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Utilizado para informações textuais maiores, permitindo o
                    preenchimento de múltiplas linhas.
                </p>

                <div class="mt-3 rounded-lg bg-slate-50 p-3">

                    <p class="text-sm leading-6 text-slate-600">
                        Não é utilizado como filtro de seleção.
                    </p>

                </div>

            </div>


            {{-- SELEÇÃO SIMPLES --}}
            <div class="rounded-lg border border-slate-200 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Seleção simples
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Apresenta uma lista de opções previamente cadastradas,
                    permitindo que apenas uma opção seja selecionada.
                </p>

                <div class="mt-3 rounded-lg bg-emerald-50 p-3">

                    <p class="text-sm leading-6 text-emerald-700">
                        <strong>Pode ser utilizado como filtro.</strong>
                    </p>

                </div>

            </div>


            {{-- SELEÇÃO MÚLTIPLA --}}
            <div class="rounded-lg border border-slate-200 p-5">

                <h3 class="font-semibold text-blumine-800">
                    Seleção múltipla
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Apresenta uma lista de opções previamente cadastradas,
                    permitindo selecionar mais de uma opção para o mesmo exame.
                </p>

                <div class="mt-3 rounded-lg bg-emerald-50 p-3">

                    <p class="text-sm leading-6 text-emerald-700">
                        <strong>Pode ser utilizado como filtro.</strong>
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- FILTROS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Atributos utilizados nos filtros
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Para que um atributo seja utilizado como filtro de seleção no
            Marketplace, ele precisa estar configurado com a opção
            <strong>"Usado nos filtros do site"</strong> igual a
            <strong>Sim</strong>.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Além dessa configuração, somente determinados tipos de campo são
            compatíveis com os filtros de seleção.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-3">

            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-5">

                <h3 class="font-semibold text-emerald-800">
                    Sim/Não
                </h3>

                <p class="mt-2 text-sm leading-6 text-emerald-700">
                    Disponível nos filtros.
                </p>

            </div>


            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-5">

                <h3 class="font-semibold text-emerald-800">
                    Seleção simples
                </h3>

                <p class="mt-2 text-sm leading-6 text-emerald-700">
                    Disponível nos filtros.
                </p>

            </div>


            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-5">

                <h3 class="font-semibold text-emerald-800">
                    Seleção múltipla
                </h3>

                <p class="mt-2 text-sm leading-6 text-emerald-700">
                    Disponível nos filtros.
                </p>

            </div>

        </div>

        <div class="mt-6 rounded-lg border border-slate-200 bg-slate-50 p-5">

            <h3 class="font-semibold text-blumine-800">
                Campos que não aparecem como filtro de seleção
            </h3>

            <p class="mt-2 text-sm leading-6 text-slate-600">
                Os tipos <strong>Texto</strong> e <strong>Área de Texto</strong>
                podem armazenar informações nos exames, mas não são utilizados
                como filtros de seleção no Marketplace.
            </p>

        </div>

    </div>


    {{-- OPÇÕES --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Opções dos atributos
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os tipos <strong>Sim/Não</strong>, <strong>Seleção simples</strong>
            e <strong>Seleção múltipla</strong> utilizam valores ou opções que
            serão apresentados durante o cadastro do exame.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As opções devem representar somente valores que realmente possam ser
            utilizados para aquele atributo. Quando o atributo for utilizado em
            filtros do Marketplace, essas opções também serão utilizadas para
            permitir que o cliente refine os resultados da busca.
        </p>

    </div>


    {{-- ASSOCIAÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Utilização nos exames
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Depois de configurados, os atributos podem fazer parte dos Grupos de
            Atributos utilizados pelos exames do catálogo.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os atributos definidos como <strong>atributos de sistema</strong>
            possuem um comportamento diferente: eles são disponibilizados para
            todos os Grupos de Atributos.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <p class="text-sm leading-6 text-blumine-700">
                A configuração de um atributo influencia diretamente o cadastro
                dos exames e, quando aplicável, os filtros, pesquisas e informações
                apresentadas no Marketplace.
            </p>

        </div>

    </div>


    {{-- EDIÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Alteração dos atributos
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os atributos podem ser consultados e alterados através das opções
            disponíveis na listagem de atributos.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Alterações como o tipo do campo, a utilização em filtros, pesquisas
            ou a visibilidade no site podem modificar o comportamento dos exames
            que utilizam esse atributo.
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
                      d="M12 9v3.75m0 3.75h.008v.008H12V16.5ZM10.29 3.86 2.82 17.25a1.5 1.5 0 0 0 1.31 2.25h15.74a1.5 1.5 0 0 0 1.31-2.25L13.71 3.86a1.95 1.95 0 0 0-3.42 0Z" />

            </svg>

            <div>

                <h3 class="font-semibold text-amber-800">
                    Atenção ao alterar atributos
                </h3>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    Os atributos possuem funções que vão além do cadastro das
                    informações dos exames. Eles também podem controlar filtros,
                    pesquisas e informações apresentadas no Marketplace.
                </p>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    Antes de alterar ou remover um atributo que já esteja sendo
                    utilizado, verifique onde ele está aplicado e quais partes
                    do Marketplace dependem dessa configuração.
                </p>

            </div>

        </div>

    </div>
</section>
