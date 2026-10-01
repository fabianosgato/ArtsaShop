<section id="catalogo-exames" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">
        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            Catálogo
        </span>
        <h1 class="mt-2 text-3xl font-bold tracking-tight text-blumine-800">
            Exames
        </h1>
        <p class="mt-4 text-base leading-7 text-slate-600">
            A área de Exames permite administrar os exames disponibilizados
            no Marketplace Examex.
        </p>
    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Visão geral
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Cada exame cadastrado no catálogo representa um serviço que pode
            ser disponibilizado pelas clínicas no Marketplace.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O exame cadastrado nesta área representa o exame padrão do Marketplace. Ele funciona como uma referência comum para as clínicas, de forma semelhante ao funcionamento de marketplaces como Amazon e Mercado Livre, onde existe um produto padrão ao qual os vendedores podem associar suas próprias ofertas.

            No Examex, a clínica utiliza esse exame padrão como base para cadastrar seu próprio exame, definindo as informações específicas da oferta, como valores, disponibilidade e horários de atendimento. Dessa forma, o exame padrão organiza o catálogo do Marketplace, enquanto cada clínica possui sua própria oferta vinculada a ele.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/catalogo/exames/listagem.png') }}"
                alt="Lista de exames do Examex"
                class="w-full"
            >

        </div>

    </div>


    {{-- LISTAGEM --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Lista de exames
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A tela apresenta os exames cadastrados no sistema e permite
            localizar rapidamente um exame específico através dos recursos
            disponíveis na listagem.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A partir da listagem também é possível acessar o cadastro do
            exame para consultar ou alterar suas informações.
        </p>

    </div>


    {{-- INFORMAÇÕES DO EXAME --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Informações do exame
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O cadastro do exame reúne as informações necessárias para sua
            utilização no Marketplace.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Nome
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Nome utilizado para identificar o exame no catálogo e no
                    Marketplace.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Categoria
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Categoria utilizada para organizar o exame dentro do
                    catálogo.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Descrição
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Informações apresentadas ao cliente sobre o exame.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Status
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Define se o exame está disponível para utilização no
                    sistema.
                </p>

            </div>

        </div>

    </div>


    {{-- CADASTRO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Cadastro de um exame
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Para cadastrar um novo exame, utilize a opção de criação
            disponível na tela de Exames.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Durante o cadastro devem ser preenchidas as informações necessárias
            para que o exame possa ser utilizado pelas clínicas e apresentado
            aos clientes.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/catalogo/exames/cadastro.png') }}"
                alt="Cadastro de exame no Examex"
                class="w-full"
            >

        </div>

    </div>


    {{-- CLÍNICAS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Disponibilidade nas clínicas
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O exame cadastrado no catálogo representa o serviço que poderá ser
            oferecido pelas clínicas participantes do Marketplace.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A disponibilidade de um exame, seus valores e seus horários de
            atendimento são definidos de acordo com a configuração realizada
            para cada clínica.
        </p>

    </div>


    {{-- CATEGORIAS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Categorias
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Os exames podem ser organizados em categorias para facilitar a
            navegação e a localização dos serviços disponíveis no Marketplace.
        </p>

        <div class="mt-5 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <p class="text-sm leading-6 text-blumine-700">
                O cadastro das categorias é realizado na área
                <strong>Catálogo → Categorias</strong>.
            </p>

        </div>

    </div>


    {{-- PESQUISA --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Pesquisa e filtros
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Utilize os recursos de pesquisa e filtragem disponíveis na listagem
            para localizar um exame específico.
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
                    Alterações realizadas no cadastro de um exame podem
                    refletir diretamente na forma como o serviço é apresentado
                    no Marketplace.
                </p>

            </div>

        </div>

    </div>

</section>
