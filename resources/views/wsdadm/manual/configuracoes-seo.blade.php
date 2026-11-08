<section id="configuracoes-seo" class="scroll-mt-24">

    {{-- TÍTULO --}}
    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-2xl font-semibold text-blumine-800">
            Configurações → SEO MetaTags
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O módulo de SEO MetaTags centraliza as configurações utilizadas
            pelo Examex para gerar informações de otimização para mecanismos
            de busca e para serviços externos que utilizam os dados das
            páginas do site.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            As configurações cadastradas neste módulo são utilizadas pelo
            sistema para gerar as respectivas meta tags no código HTML das
            páginas, quando aplicável.
        </p>

    </div>


    {{-- LISTAGEM --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Configurações de SEO
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A tela apresenta as MetaTags disponíveis no sistema, permitindo
            consultar suas propriedades, grupos, valores padrão e status.
        </p>

        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">

            <img
                src="{{ asset('images/manual/configuracoes/configuracoes-seo.png') }}"
                alt="Configurações de SEO MetaTags do WsdAdmin"
                class="w-full"
            >

        </div>

    </div>


    {{-- CAMPOS --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Informações das MetaTags
        </h2>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Nome
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Identifica a finalidade da MetaTag dentro do sistema.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Propriedade
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Identifica a propriedade que será utilizada na geração
                    da respectiva informação no HTML da página.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Grupo
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Organiza as MetaTags de acordo com sua finalidade,
                    como configurações relacionadas ao Twitter, Open Graph
                    e informações de artigos.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Valor padrão
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Define um valor utilizado pelo sistema quando a
                    configuração possuir um valor padrão aplicável.
                </p>

            </div>


            <div class="rounded-lg bg-slate-50 p-4">

                <h3 class="font-semibold text-blumine-800">
                    Status
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Indica se a MetaTag está habilitada ou desabilitada
                    para utilização pelo sistema.
                </p>

            </div>

        </div>

    </div>


    {{-- UTILIZAÇÃO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Utilização no site
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Quando uma MetaTag está habilitada, o sistema pode utilizá-la
            na construção do HTML das páginas do Examex, de acordo com o
            contexto da página e com as informações disponíveis.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Essas informações são importantes para mecanismos de busca,
            ferramentas de indexação e plataformas que utilizam os dados
            estruturados nas páginas do site.
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
                    As configurações deste módulo possuem finalidade
                    técnica e influenciam diretamente as informações
                    disponibilizadas no código HTML do site.
                </p>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    Recomenda-se não alterar ou desabilitar MetaTags sem
                    avaliar previamente sua finalidade e o impacto que a
                    alteração poderá causar no SEO e na apresentação das
                    páginas em serviços externos.
                </p>

            </div>

        </div>

    </div>

</section>
