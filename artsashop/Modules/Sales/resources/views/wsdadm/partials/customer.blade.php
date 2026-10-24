<section>
{{--     --}}

    <div class="p-6 rounded-lg shadow-lg text-primary-500">
        <h2 class="text-xl font-semibold mb-4 text-blumine-700">Informações do Cliente</h2>
        <div class="mb-4">
            <span class="font-bold">Nome:</span> {{ $customer->customer_name }}
        </div>
        <div class="mb-4">
            <span class="font-bold">Email:</span> {{ $customer->customer_email }}
        </div>
        <div class="mb-4">
            <span class="font-bold">CPF/CNPJ:</span> {{ $customer->vat_number }}
        </div>
        @if(!empty($customer->date_of_birth))
        <div class="mb-4">
            <span class="font-bold">Data de Nascimento:</span> {{ \Carbon\Carbon::parse($customer->date_of_birth)->format('d/m/Y') }}
        </div>
        @endif
    </div>
</section>
