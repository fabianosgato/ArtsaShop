<div class="dy-card bg-base-100 border border-gray-200 shadow-sm lg:p-4 mb-3.5">
    <div class="dy-card-body p-2">
        <div>
            <label class="block text-sm font-medium mb-1">
                <em>*</em> CPF/CNPJ
            </label>
            <input type="text"
                   id="vat_number"
                   name="register[vat_number]"
                   data-field="cpf"
                   required
                   value="{{ old('register.vat_number') }}"
                   autocomplete="off"
                   class="w-full border border-blumine-300 px-3 py-2 focus:outline-none focus:border-gray-400 focus:bg-gray-100">
            <p class="text-sm text-gray-500 mt-1">
                Informe seu CPF ou CNPJ para finalizar a compra. Ele é necessário para podermos importar o produto para você
            </p>
            <p class="text-red-500 text-sm mt-1"
               x-show="fieldErrors.cpf"
               x-text="fieldErrors.cpf"></p>
        </div>
    </div>
</div>
