<section>
    @if ($order['status'] == 'approved')
        @if($customer['situacao_receita'] == 'REGULAR')
        <div class="bg-green-100 p-6 rounded-lg shadow-lg text-primary-500">
        @else
        <div class="bg-red-100 p-6 rounded-lg shadow-lg text-primary-500">
        @endif
            <h2 class="text-xl font-semibold mb-4 text-blumine-700">Informações do Cliente</h2>
            <div class="mb-4">
                <span class="font-bold">Nome:</span> {{ $customer['nome_completo'] }}
            </div>
            <div class="mb-4">
                <span class="font-bold">Email:</span> {{ $customer['customer_email'] }}
            </div>
            <div class="mb-4">
                <span class="font-bold">CPF/CNPJ:</span> {{ $customer['vat_number'] }}
            </div>
            <div class="mb-4">
                <span class="font-bold">Data de Nascimento:</span> {{ \Carbon\Carbon::parse($customer['data_nascimento'])->format('d/m/Y') }}
            </div>
            <div class="mb-4">
                <span class="font-bold">Situação:</span> {{ $customer['situacao_receita'] }}
            </div>
            <div class="mb-4">
                @if($customer['consta_obito'] == 0)
                    <span class="font-bold">Consta Óbito:</span> Não
                @else
                    <span class="font-bold">Consta Óbito:</span> SIM
                @endif
            </div>
            @if($customer['pdf_url_file'] != null)
            <div class="mb-4">
                <span class="font-bold">PDF Da Receira:</span> {{ $customer['pdf_url_file'] }}
            </div>
            @endif
        </div>
    @else
        <div class="bg-gray-50 p-6 rounded-lg shadow-lg text-primary-500">
            <h2 class="text-xl font-semibold mb-4 text-blumine-700">Informações do Cliente</h2>
            <div class="mb-4">
                <span class="font-bold">Nome:</span> {{ $order['customer_name'] }}
            </div>
            <div class="mb-4">
                <span class="font-bold">Email:</span> {{ $order['customer_email'] }}
            </div>
            <div class="mb-4">
                <span class="font-bold">CPF/CNPJ:</span> {{ $order['customer_document'] }}
            </div>
        </div>
    @endif
</section>
