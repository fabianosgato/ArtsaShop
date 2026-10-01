<section id="cms" class="scroll-mt-24">

    {{-- CABEÇALHO --}}
    <div class="max-w-5xl">

        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            CMS
        </span>

        <h1 class="mt-2 text-3xl font-bold tracking-tight text-blumine-800">
            Gerenciamento de conteúdo
        </h1>

        <p class="mt-4 text-base leading-7 text-slate-600">
            A área de CMS permite administrar as páginas de conteúdo
            disponibilizadas pelo Examex.
        </p>

    </div>


    {{-- VISÃO GERAL --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Visão geral
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O CMS (Content Management System) é utilizado para gerenciar
            conteúdos institucionais e informativos apresentados no sistema.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Através dessa área, o administrador pode consultar e editar as
            páginas disponíveis sem precisar realizar alterações diretamente
            no código do sistema.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/cms/listagem.png') }}"
                alt="Gerenciamento de páginas do Examex"
                class="w-full"
            >

        </div>

    </div>


    {{-- LISTAGEM --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Lista de páginas
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A tela apresenta as páginas de conteúdo cadastradas no sistema.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A partir da listagem é possível localizar uma página e acessar
            suas informações para consulta ou edição.
        </p>

    </div>


    {{-- EDIÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Edição de conteúdo
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Para alterar uma página, localize o registro desejado na listagem
            e utilize a opção de edição disponibilizada pelo sistema.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Após realizar as alterações necessárias, salve o conteúdo para
            atualizar a página no sistema.
        </p>

        {{-- IMAGEM --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/cms/edicao.png') }}"
                alt="Edição de página no CMS do Examex"
                class="w-full"
            >

        </div>

    </div>


    {{-- CONTEÚDO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Conteúdo da página
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O conteúdo da página deve ser preenchido de acordo com a finalidade
            de cada página disponibilizada no sistema.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Ao editar uma página, revise o conteúdo antes de salvar para
            garantir que as informações apresentadas aos clientes estejam
            corretas e atualizadas.
        </p>

    </div>


    {{-- PUBLICAÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Atualização das páginas
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As alterações realizadas no conteúdo devem ser salvas através da
            própria tela de edição.
        </p>

        <div class="mt-6 rounded-lg border border-blumine-100 bg-blumine-50 p-5">

            <p class="text-sm leading-6 text-blumine-700">
                Antes de alterar uma página existente, recomenda-se revisar
                o conteúdo atual para evitar a remoção acidental de
                informações importantes.
            </p>

        </div>

    </div>


    {{-- PESQUISA --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Pesquisa
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Utilize os recursos de pesquisa disponíveis na listagem para
            localizar rapidamente a página que deseja consultar ou editar.
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
                    O conteúdo publicado através do CMS pode ser visualizado
                    diretamente pelos clientes. Revise sempre as informações
                    antes de salvar as alterações.
                </p>

            </div>

        </div>

    </div>

</section>
