{{-- MARKETPLACE → CLÍNICAS --}}
<section id="marketplace-clinicas" class="scroll-mt-24">

    <div class="max-w-5xl">

        <span class="text-sm font-semibold uppercase tracking-wider text-blumine-600">
            Marketplace
        </span>

        <h1 class="mt-2 text-3xl font-bold tracking-tight text-blumine-800">
            Clínicas
        </h1>

        <p class="mt-4 text-base leading-7 text-slate-600">
            A área de Clínicas permite cadastrar e administrar as clínicas
            participantes do Marketplace Examex.
        </p>

    </div>


    {{-- LISTAGEM --}}
    <div class="mt-8 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Lista de clínicas
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Ao acessar <strong>Marketplace → Clínicas</strong>, o sistema
            apresenta a lista de clínicas cadastradas no Examex.
        </p>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A listagem permite localizar e consultar rapidamente as clínicas
            cadastradas e acessar as ações disponíveis para cada registro.
        </p>

        {{-- PRINT --}}
        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">
            <img
                src="{{ asset('images/manual/marketplace/clinicas/listagem.png') }}"
                alt="Lista de clínicas do Examex"
                class="w-full"
            >
        </div>

    </div>


    {{-- INFORMAÇÕES --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Informações apresentadas
        </h2>

        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Informação
                    </th>

                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Descrição
                    </th>
                </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 bg-white">

                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Clínica
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Nome da clínica cadastrada no sistema.
                    </td>
                </tr>

                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Razão Social
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Razão social vinculada ao cadastro da clínica.
                    </td>
                </tr>

                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        CNPJ
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Documento de identificação da clínica.
                    </td>
                </tr>

                <tr>
                    <td class="px-4 py-3 text-sm font-medium text-slate-700">
                        Data de atualização
                    </td>

                    <td class="px-4 py-3 text-sm text-slate-600">
                        Data da última alteração realizada no cadastro.
                    </td>
                </tr>

                </tbody>

            </table>

        </div>

    </div>


    {{-- PESQUISA --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Pesquisa e filtros
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            A listagem possui recursos de pesquisa e filtros que permitem
            localizar uma clínica específica sem a necessidade de percorrer
            manualmente todos os registros.
        </p>

        <div class="mt-5 rounded-lg border border-blumine-100 bg-blumine-50 p-4">

            <div class="flex gap-3">

                <svg class="mt-0.5 h-5 w-5 shrink-0 text-blumine-600"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.8"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z"/>
                </svg>

                <p class="text-sm leading-6 text-blumine-800">
                    Utilize os campos de pesquisa disponíveis na própria
                    listagem para localizar rapidamente a clínica desejada.
                </p>

            </div>

        </div>

    </div>


    {{-- CADASTRO --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Cadastro de uma clínica
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            Para cadastrar uma nova clínica, utilize a opção de criação
            disponível na tela de Clínicas.
        </p>

        <div class="mt-6 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">
            <img
                src="{{ asset('images/manual/marketplace/clinicas/cadastro.png') }}"
                alt="Lista de clínicas do Examex"
                class="w-full"
            >
        </div>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O cadastro reúne as informações necessárias para que a clínica
            possa participar do Marketplace, receber pedidos e disponibilizar
            seus exames e horários para agendamento.
        </p>

    </div>


    {{-- DADOS DA CLÍNICA --}}
    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-xl font-semibold text-blumine-800">
            Dados da clínica
        </h2>

        <p class="mt-4 text-sm leading-6 text-slate-600">
            O cadastro da clínica reúne diferentes grupos de informações.
            Esses dados são utilizados pelo Examex durante a operação do
            Marketplace.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">

            <div class="rounded-lg bg-slate-50 p-4">
                <h3 class="font-semibold text-blumine-800">
                    Dados gerais
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Informações de identificação e dados principais da clínica.
                </p>
            </div>

            <div class="rounded-lg bg-slate-50 p-4">
                <h3 class="font-semibold text-blumine-800">
                    Endereço
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Endereço utilizado para identificar a localização da clínica.
                </p>
            </div>

            <div class="rounded-lg bg-slate-50 p-4">
                <h3 class="font-semibold text-blumine-800">
                    Agenda
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Informações relacionadas à disponibilidade de horários para
                    atendimento.
                </p>
            </div>

            <div class="rounded-lg bg-slate-50 p-4">
                <h3 class="font-semibold text-blumine-800">
                    Dados financeiros
                </h3>

                <p class="mt-2 text-sm leading-6 text-slate-600">
                    Informações utilizadas para o controle dos repasses
                    financeiros destinados à clínica.
                </p>
            </div>

        </div>

    </div>


    {{-- OBSERVAÇÃO --}}
    <div class="mt-6 rounded-xl border border-amber-200 bg-amber-50 p-6">

        <div class="flex gap-3">

            <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-600"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.8"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 9v3.75m0 3.75h.008v.008H12V16.5ZM10.29 3.86 2.82 17.25A1.5 1.5 0 0 0 4.13 19.5h15.74a1.5 1.5 0 0 0 1.31-2.25L13.71 3.86a1.95 1.95 0 0 0-3.42 0Z"/>
            </svg>

            <div>

                <h3 class="font-semibold text-amber-800">
                    Importante
                </h3>

                <p class="mt-2 text-sm leading-6 text-amber-700">
                    Os dados cadastrados para a clínica devem ser mantidos
                    atualizados, especialmente as informações de endereço,
                    agenda e dados financeiros.
                </p>

            </div>

        </div>

    </div>

</section>
