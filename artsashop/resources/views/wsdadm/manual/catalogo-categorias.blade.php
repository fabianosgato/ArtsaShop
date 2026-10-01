<section id="catalogo-categorias" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">

        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            Catálogo
        </span>

        <h1 class="mt-2 text-3xl font-bold tracking-tight text-blumine-800">
            Categorias
        </h1>

        <p class="mt-4 text-base leading-7 text-slate-600">
            A área de Categorias permite organizar os exames disponíveis no
            catálogo do Examex, facilitando sua apresentação e localização
            no Marketplace.
        </p>

    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Visão geral
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As categorias são utilizadas para organizar os exames em grupos
            relacionados. Essa organização facilita a navegação do cliente
            pelo Marketplace e permite encontrar os serviços de forma mais
            simples.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Uma categoria pode conter diversos exames e pode ser organizada
            de acordo com a estrutura definida para o catálogo do Examex.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/catalogo/categorias/listagem.png') }}"
                alt="Lista de categorias do Examex"
                class="w-full"
            >

        </div>

    </div>


    {{-- LISTAGEM --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Lista de categorias
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A tela apresenta as categorias cadastradas no sistema e permite
            consultar e administrar a estrutura utilizada pelo catálogo.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Utilize os recursos de pesquisa disponíveis na listagem para
            localizar uma categoria específica.
        </p>

    </div>


    {{-- CADASTRO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Cadastro de categoria
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As categorias são criadas automaticamente a partir dos Grupos de Atributos.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Para criar uma nova categoria, acesse o cadastro de um Grupo de Atributos e utilize a opção "Criar Categoria". Ao salvar o grupo, o sistema cria a categoria correspondente.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Essa estrutura é utilizada porque os exames do Examex pertencem a um Grupo de Atributos. Dessa forma, o Grupo de Atributos define a estrutura do exame e a Categoria é utilizada para organizá-lo dentro do catálogo.
        </p>
    </div>


    {{-- ESTRUTURA --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Organização das categorias
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As categorias podem ser utilizadas para criar uma estrutura
            organizada para os exames disponibilizados no Marketplace.
        </p>

        <div class="mt-6 rounded-lg bg-slate-50 p-5">

            <div class="space-y-3 text-sm">

                <div class="flex items-center gap-3">

                    <span class="flex h-7 w-7 items-center justify-center rounded-md bg-blumine-100 font-semibold text-blumine-700">
                        1
                    </span>

                    <span class="text-slate-700">
                        Categoria
                    </span>

                </div>

                <div class="ml-8 border-l-2 border-slate-200 pl-6">

                    <div class="flex items-center gap-3">

                        <span class="flex h-7 w-7 items-center justify-center rounded-md bg-slate-200 font-semibold text-slate-600">
                            2
                        </span>

                        <span class="text-slate-700">
                            Exames relacionados
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- RELAÇÃO COM EXAMES --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Relação com os exames
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As categorias são utilizadas para organizar os exames cadastrados
            no catálogo.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Ao configurar um exame, sua categoria determina em qual grupo o
            serviço será apresentado dentro da estrutura do catálogo.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <p class="text-sm leading-6 text-blumine-700">
                Antes de cadastrar os exames, recomenda-se organizar as
                categorias que serão utilizadas pelo catálogo.
            </p>

        </div>

    </div>


    {{-- EDIÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-xl font-semibold text-blumine-800">
            Alteração de uma categoria
        </h2>
        <p class="mt-4 text-sm leading-6 text-slate-600">
            Para alterar uma categoria existente, localize o registro na
            listagem e acesse a opção de edição disponibilizada pelo sistema.
        </p>
        <p class="mt-4 text-sm leading-6 text-slate-600">
            Após realizar as alterações necessárias, salve o cadastro para
            atualizar as informações.
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
                    Observação Importante
                </h3>
                <p class="mt-2 text-sm leading-6 text-amber-700">
                    As categorias necessárias para o funcionamento do Examex já foram
                    previamente criadas e configuradas no sistema. Elas são utilizadas
                    diretamente na organização e nas buscas dos exames no Marketplace.
                    Por esse motivo, recomenda-se não alterar ou remover essas categorias
                    sem orientação técnica.
                </p>
            </div>
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
                      d="M12 9v3.75m0 3.75h.008v.008H12V16.5ZM10.29 3.86 2.82 17.25A1.5 1.5 0 0 0 4.13 19.5h15.74a1.5 1.5 0 0 0 1.31-2.25L13.71 3.86a1.95 1.95 0 0 0-3.42 0Z" />

            </svg>
            <div>
                <h3 class="font-semibold text-amber-800">
                    Importante
                </h3>
                <p class="mt-2 text-sm leading-6 text-amber-700">
                    Alterações na organização das categorias podem modificar
                    a forma como os exames são apresentados e localizados no
                    Marketplace.
                </p>
            </div>

        </div>

    </div>

</section>
